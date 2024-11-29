<?php

namespace XF\Option;

use function is_array;

class Giphy extends AbstractOption
{
	public static function verifyOption(&$value, \XF\Entity\Option $option)
	{
		if ($option->isInsert())
		{
			return true;
		}

		if (empty($value['enabled']))
		{
			if ($option->option_value['enabled'])
			{
				// just disabled
				self::removeGiphyToolbarButton();
			}

			return true;
		}

		if ($value['enabled'])
		{
			if (empty($value['api_key']))
			{
				$option->error(\XF::phrase('please_enter_value_for_required_field_x', ['field' => 'giphy[api_key]']), $option->option_id);
				return false;
			}

			if (!preg_match('/^[a-z0-9]{32}$/i', $value['api_key']))
			{
				$option->error(\XF::phrase('please_enter_a_valid_api_key'), $option->option_id);
				return false;
			}

			if (!$option->option_value['enabled'])
			{
				// just enabled
				self::insertGiphyToolbarButton();
			}
		}

		return true;
	}

	public static function insertGiphyToolbarButton()
	{
		self::updateToolbarButtons(
			function(array $buttonSet)
			{
				$insertPosition = null;
				foreach ($buttonSet AS $k => $button)
				{
					if ($button == 'xfSmilie')
					{
						$insertPosition = $k + 1;
					}
					else if ($button == 'xfInsertGif')
					{
						// already have it
						$insertPosition = null;
						break;
					}
				}

				if ($insertPosition !== null)
				{
					array_splice($buttonSet, $insertPosition, 0, ['xfInsertGif']);
				}

				return $buttonSet;
			}
		);
	}

	public static function removeGiphyToolbarButton()
	{
		self::updateToolbarButtons(
			function(array $buttonSet)
			{
				$newButtons = [];

				foreach ($buttonSet AS $button)
				{
					if ($button == 'xfInsertGif')
					{
						continue;
					}

					$newButtons[] = $button;
				}

				return $newButtons;
			}
		);
	}

	protected static function updateToolbarButtons(callable $buttonsCallback)
	{
		$toolbarButtons = \XF::options()->editorToolbarConfig;

		foreach ($toolbarButtons AS $type => &$group)
		{
			if (!is_array($group))
			{
				continue;
			}

			foreach ($group AS &$groupData)
			{
				if (!is_array($groupData) || empty($groupData['buttons']))
				{
					continue;
				}

				$groupData['buttons'] = $buttonsCallback($groupData['buttons']);
			}
		}

		\XF::repository('XF:Option')->updateOption('editorToolbarConfig', $toolbarButtons);
	}
}