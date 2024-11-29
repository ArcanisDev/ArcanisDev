<?php

namespace XF\AddOn;

use XF\AddOn\DataType\AbstractDataType;

class DataManager
{
	/**
	 * @var \XF\Mvc\Entity\Manager
	 */
	protected $em;

	/**
	 * @var DataType\AbstractDataType[]|null
	 */
	protected $types;

	public function __construct(\XF\Mvc\Entity\Manager $em)
	{
		$this->em = $em;
	}

	public function exportAddOn(AddOn $addOn, array &$containers = [], array &$emptyContainers = [])
	{
		$document = new \DOMDocument('1.0', 'utf-8');
		$document->formatOutput = true;

		$root = $document->createElement('addon');
		$document->appendChild($root);

		$addOnId = $addOn->addon_id;

		foreach ($this->getDataTypeHandlers() AS $handler)
		{
			$containerName = $handler->getContainerTag();
			$container = $document->createElement($containerName);
			$handler->exportAddOnData($addOnId, $container);
			$root->appendChild($container);
			$containers[] = $containerName;
		}

		return $document;
	}

	public function enqueueImportAddOnData(AddOn $addOn)
	{
		return \XF::app()->jobManager()->enqueueUnique($this->getImportDataJobId($addOn), 'XF:AddOnData', [
			'addon_id' => $addOn->addon_id
		]);
	}

	public function getImportDataJobId(AddOn $addOn)
	{
		return 'addOnData-' . $addOn->addon_id;
	}

	protected function checkComposerAutoloadPath(string $file, string $path, bool $allowThrow = true): bool
	{
		$path = rtrim($path, \XF::$DS) . \XF::$DS;

		if (!file_exists($path . $file))
		{
			if ($allowThrow)
			{
				if (\XF::$debugMode)
				{
					throw new \InvalidArgumentException(
						"Missing $file at " . \XF\Util\File::stripRootPathPrefix($path) . ". This may not be a valid composer directory."
					);
				}
				else
				{
					\XF::logError(
						'Error registering composer autoload directory: ' . \XF\Util\File::stripRootPathPrefix($path . $file)
					);
				}
			}
			return false;
		}

		return true;
	}

	public function rebuildActiveAddOnCache()
	{
		$activeAddOns = [];
		$addOnsComposer = [];

		// cached add-on entities can end up being saved here so clear entity cache
		$this->em->clearEntityCache('XF:AddOn');

		$addOnManager = \XF::app()->addOnManager();

		$addOns = $this->em->getFinder('XF:AddOn')->where('active', 1)->fetch();
		foreach ($addOns AS $addOn)
		{
			$activeAddOns[$addOn->addon_id] = $addOn->version_id;

			$addOnClass = $addOnManager->getById($addOn->addon_id);
			if ($addOnClass)
			{
				$addOnId = $addOn->addon_id;
				$autoloadPath = $addOnClass->composer_autoload;

				if (!$autoloadPath)
				{
					continue;
				}

				$addOnAutoload = $addOnManager->getAddOnPath($addOnId) . \XF::$DS . $autoloadPath;

				if (!$this->checkComposerAutoloadPath('installed.json', $addOnAutoload))
				{
					continue;
				}

				$data = [
					'autoload_path' => $autoloadPath . \XF::$DS,
					'namespaces' => false,
					'psr4' => false,
					'classmap' => false,
					'files' => false,
				];

				$hasData = false;

				if ($this->checkComposerAutoloadPath('autoload_namespaces.php', $addOnAutoload))
				{
					$data['namespaces'] = true;
					$hasData = true;
				}
				if ($this->checkComposerAutoloadPath('autoload_psr4.php', $addOnAutoload))
				{
					$data['psr4'] = true;
					$hasData = true;
				}
				if ($this->checkComposerAutoloadPath('autoload_classmap.php', $addOnAutoload))
				{
					$data['classmap'] = true;
					$hasData = true;
				}
				if ($this->checkComposerAutoloadPath('autoload_files.php', $addOnAutoload, false))
				{
					$data['files'] = true;
					$hasData = true;
				}

				if ($hasData)
				{
					$addOnsComposer[$addOnId] = $data;
				}
			}
		}

		\XF::registry()->set('addOns', $activeAddOns);
		\XF::registry()->set('addOnsComposer', $addOnsComposer);

		return $activeAddOns;
	}

	public function triggerRebuildActiveChange(\XF\Entity\AddOn $addOn)
	{
		$atomicJobs = $this->onActiveChange($addOn);

		$addOnHandler = new AddOn($addOn, \XF::app()->addOnManager());
		$addOnHandler->onActiveChange($addOn->active, $atomicJobs);

		if ($atomicJobs)
		{
			\XF::app()->jobManager()->enqueueUnique(
				'addOnActive' . $addOn->addon_id,
				'XF:Atomic', ['execute' => $atomicJobs]
			);
		}
	}

	protected function onActiveChange(\XF\Entity\AddOn $addOn): array
	{
		$atomicJobs = [];

		foreach ($this->getDataTypeHandlers() AS $handler)
		{
			$handler->rebuildActiveChange($addOn, $atomicJobs);
		}

		\XF::runOnce('rebuild_addon_active', function()
		{
			/** @var \XF\Repository\ForumType $forumTypeRepo */
			$forumTypeRepo = $this->em->getRepository('XF:ForumType');
			$forumTypeRepo->rebuildForumTypeCache();

			/** @var \XF\Repository\ThreadType $threadTypeRepo */
			$threadTypeRepo = $this->em->getRepository('XF:ThreadType');
			$threadTypeRepo->rebuildThreadTypeCache();

			/** @var \XF\Repository\Payment $paymentRepo */
			$paymentRepo = $this->em->getRepository('XF:Payment');
			$paymentRepo->rebuildPaymentProviderCache();
		});

		return $atomicJobs;
	}

	public function triggerRebuildProcessingChange(\XF\Entity\AddOn $addOn)
	{
		// Note: These rebuilds will not take effect until the next request.

		$this->em->getRepository('XF:ClassExtension')->rebuildExtensionCache();
		$this->em->getRepository('XF:CodeEventListener')->rebuildListenerCache();
		$this->em->getRepository('XF:Route')->rebuildRouteCaches();
	}

	public function updateRelatedIds(\XF\Entity\AddOn $addOn, $oldId)
	{
		if ($oldId == $addOn->addon_id)
		{
			return;
		}

		$newId = $addOn->addon_id;

		$db = $this->em->getDb();
		$db->beginTransaction();

		foreach ($this->getDataTypeHandlers() AS $handler)
		{
			$handler->updateAddOnId($oldId, $newId);
		}

		$db->commit();
	}

	public function enqueueRemoveAddOnData($id)
	{
		return \XF::app()->jobManager()->enqueueUnique($id . 'AddOnUnInstall', 'XF:AddOnUninstallData', [
			'addon_id' => $id
		]);
	}

	public function finalizeRemoveAddOnData($addOnId)
	{
		$simpleCache = \XF::app()->simpleCache();
		$simpleCache->deleteSet($addOnId);

		$this->rebuildActiveAddOnCache();
	}

	/**
	 * @return AbstractDataType
	 */
	public function getDataTypeHandler($class)
	{
		$class = \XF::stringToClass($class, '%s\AddOn\DataType\%s');
		$class = \XF::extendClass($class);

		return new $class($this->em);
	}

	/**
	 * @return AbstractDataType[]
	 */
	public function getDataTypeHandlers()
	{
		if ($this->types)
		{
			return $this->types;
		}

		$objects = [];
		foreach ($this->getDataTypeClasses() AS $typeClass)
		{
			$class = \XF::stringToClass($typeClass, '%s\AddOn\DataType\%s');
			$class = \XF::extendClass($class);
			$objects[$typeClass] = new $class($this->em);
		}

		$this->types = $objects;

		return $objects;
	}

	public function getDataTypeClasses()
	{
		return [
			'XF:ActivitySummaryDefinition',
			'XF:AdminNavigation',
			'XF:AdminPermission',
			'XF:AdvertisingPosition',
			'XF:ApiScope',
			'XF:BbCode',
			'XF:BbCodeMediaSite',
			'XF:ClassExtension',
			'XF:CodeEvent',
			'XF:CodeEventListener',
			'XF:ContentTypeField',
			'XF:CronEntry',
			'XF:HelpPage',
			'XF:MemberStat',
			'XF:Navigation',
			'XF:Option',
			'XF:OptionGroup',
			'XF:Permission',
			'XF:PermissionInterfaceGroup',
			'XF:Phrase',
			'XF:Route',
			'XF:StyleProperty',
			'XF:StylePropertyGroup',
			'XF:Template',
			'XF:TemplateModification',
			'XF:WidgetDefinition',
			'XF:WidgetPosition'
		];
	}
}