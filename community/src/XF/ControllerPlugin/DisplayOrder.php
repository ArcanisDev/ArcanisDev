<?php

namespace XF\ControllerPlugin;

class DisplayOrder extends AbstractPlugin
{
	public function actionOrder($identifier, $displayOrderColumn = 'display_order', array $options = [])
	{
		$this->assertPostOnly();

		$this->order($identifier, $displayOrderColumn, $options);

		return $this->message(\XF::phrase('your_changes_have_been_saved'));
	}

	public function order($identifier, $displayOrderColumn = 'display_order', array $options = [])
	{
		$options = array_replace([
			'input' => null,
			'fastUpdate' => true,
			'preSaveCallback' => null,
		], $options);

		if (!$options['input'])
		{
			$options['input'] = $displayOrderColumn;
		}

		$displayOrderInput = $this->request->filter($options['input'], 'array');
		$entities = $this->em->findByIds($identifier, $displayOrderInput);

		$orderValue = 0;
		foreach ($displayOrderInput AS $id)
		{
			if ($entity = $entities[$id] ?? null)
			{
				$orderValue += 10;

				if ($entity->getExistingValue($displayOrderColumn) != $orderValue)
				{
					if ($options['fastUpdate'] && !$options['preSaveCallback'])
					{
						$entity->fastUpdate($displayOrderColumn, $orderValue);
					}
					else
					{
						$entity->$displayOrderColumn = $orderValue;
						if ($options['preSaveCallback'])
						{
							$cb = $options['preSaveCallback'];
							$cb($entity);
						}
						$entity->save();
					}
				}
			}
		}
	}
}