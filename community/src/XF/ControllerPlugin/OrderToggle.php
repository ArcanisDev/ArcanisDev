<?php

namespace XF\ControllerPlugin;

class OrderToggle extends AbstractPlugin
{
	public function actionUpdate($identifier, $displayOrderColumn = 'display_order', $activeColumn = 'active', array $options = [])
	{
		$this->assertPostOnly();

		$this->update($identifier, $displayOrderColumn, $activeColumn, $options);

		return $this->message(\XF::phrase('your_changes_have_been_saved'));
	}

	public function update($identifier, $displayOrderColumn = 'display_order', $activeColumn = 'active', array $options = [])
	{
		$options = array_replace([
			'activeInput' => null,
			'displayOrderInput' => null,
			'preSaveCallback' => null,
			'fastOrderUpdate' => true, // TODO
		], $options);

		if (!$options['displayOrderInput'])
		{
			$options['displayOrderInput'] = $displayOrderColumn;
		}

		if (!$options['activeInput'])
		{
			$options['activeInput'] = $activeColumn;
		}

		$displayOrderInput = $this->request->filter($options['displayOrderInput'], 'array');
		$activeState = $this->request->filter($options['activeInput'], 'array-bool');

		$entities = $this->em->findByIds($identifier, $displayOrderInput);

		$orderValue = 0;
		foreach ($displayOrderInput AS $id)
		{
			if ($entity = $entities[$id] ?? null)
			{
				$orderValue += 10;

				if ($entity->getExistingValue($displayOrderColumn) != $orderValue)
				{
					$entity->$displayOrderColumn = $orderValue;
				}

				$activeState[$id] = $activeState[$id] ?? false;
				if ($entity->getExistingValue($activeColumn) != $activeState[$id])
				{
					$entity->$activeColumn = $activeState[$id];
				}

				if ($entity->isChanged([$displayOrderColumn, $activeColumn]))
				{
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