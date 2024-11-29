<?php
// FROM HASH: 1c6c84c39324a44a60248263498f3bbb
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => $__vars['inputName'],
		'selected' => $__vars['option']['option_value'],
		'class' => 'js-enableTrophies',
		'label' => $__templater->escape($__vars['option']['title']),
		'_type' => 'option',
	)), array(
		'hint' => $__templater->escape($__vars['hintHtml']),
		'explain' => $__templater->escape($__vars['explainHtml']),
		'html' => $__templater->escape($__vars['listedHtml']),
		'rowclass' => $__vars['rowClass'],
	)) . '

';
	$__templater->inlineJs('
	$(document).ready(function()
	{
		processCheckBox();

		$(\'.js-enableTrophies\').click(function()
		{
			processCheckBox();
		});

		function processCheckBox()
		{
			var $userTitle = $("input[name=\'options[userTitleLadderField]\']:checked"),
				$trophyOption = $(\'.js-trophy_points\'),
				$messageOption = $(\'.js-messages\');

			if ($(\'.js-enableTrophies\').is(\':checked\'))
			{
				$trophyOption.attr(\'disabled\', false);
			}
			else
			{
				$trophyOption.attr(\'disabled\', true);

				if ($userTitle.val() == \'trophy_points\')
				{
					$messageOption.prop(\'checked\', true);
				}
			}
		}
	});
');
	return $__finalCompiled;
}
);