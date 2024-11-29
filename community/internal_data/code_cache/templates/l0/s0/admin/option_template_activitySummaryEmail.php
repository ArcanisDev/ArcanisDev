<?php
// FROM HASH: 90c115c6d84b0523aaffe2f6d413aaa2
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => $__vars['inputName'] . '[enabled]',
		'selected' => $__vars['option']['option_value']['enabled'],
		'label' => $__templater->escape($__vars['option']['title']),
		'_dependent' => array('
			<dl class="inputLabelPair">
				<dt><label for="' . $__templater->escape($__vars['inputName']) . '_min">' . 'Start sending summary email when user has been inactive for' . '</label></dt>
				<dd>
					<div class="inputGroup">
						' . $__templater->formNumberBox(array(
		'name' => $__vars['inputName'] . '[last_activity_min_days]',
		'min' => '1',
		'value' => ($__vars['option']['option_value']['enabled'] ? $__vars['option']['option_value']['last_activity_min_days'] : 14),
		'id' => $__vars['inputName'] . '_min',
	)) . '
						<span class="inputGroup--splitter"></span>
						<span class="inputGroup-text">' . 'Days' . '</span>
					</div>
				</dd>
			</dl>

			<dl class="inputLabelPair">
				<dt><label for="' . $__templater->escape($__vars['inputName']) . '_freq">' . 'Send summary email while user is inactive every' . '</label></dt>
				<dd>
					<div class="inputGroup">
						' . $__templater->formNumberBox(array(
		'name' => $__vars['inputName'] . '[email_frequency_days]',
		'min' => '1',
		'value' => ($__vars['option']['option_value']['enabled'] ? $__vars['option']['option_value']['email_frequency_days'] : 14),
		'id' => $__vars['inputName'] . '_freq',
	)) . '
						<span class="inputGroup--splitter"></span>
						<span class="inputGroup-text">' . 'Days' . '</span>
					</div>
				</dd>
			</dl>

			<dl class="inputLabelPair">
				<dt><label for="' . $__templater->escape($__vars['inputName']) . '_max">' . 'Stop sending summary email when user has been inactive for' . '</label></dt>
				<dd>
					<div class="inputGroup">
						' . $__templater->formNumberBox(array(
		'name' => $__vars['inputName'] . '[last_activity_max_days]',
		'min' => '0',
		'value' => ($__vars['option']['option_value']['enabled'] ? $__vars['option']['option_value']['last_activity_max_days'] : 180),
		'id' => $__vars['inputName'] . '_max',
	)) . '
						<span class="inputGroup--splitter"></span>
						<span class="inputGroup-text">' . 'Days' . '</span>
					</div>
				</dd>
			</dl>
		'),
		'_type' => 'option',
	)), array(
		'hint' => $__templater->escape($__vars['hintHtml']),
		'explain' => $__templater->escape($__vars['explainHtml']),
		'html' => $__templater->escape($__vars['listedHtml']),
		'rowclass' => $__vars['rowClass'],
	));
	return $__finalCompiled;
}
);