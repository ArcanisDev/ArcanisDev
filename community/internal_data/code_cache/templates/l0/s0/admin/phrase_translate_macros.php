<?php
// FROM HASH: 61d60770b2c894985191e96168dd3eb9
return array(
'macros' => array('expanded' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'phrase' => '!',
		'language' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->includeJs(array(
		'src' => 'xf/translation.js',
		'min' => '1',
	));
	$__finalCompiled .= '
	';
	$__templater->includeCss('phrase_translate.less');
	$__finalCompiled .= '

	';
	$__compilerTemp1 = '';
	if ($__vars['language']['language_id'] AND ($__templater->method($__vars['phrase'], 'isUpdate', array()) AND ($__vars['phrase']['language_id'] == $__vars['language']['language_id']))) {
		$__compilerTemp1 .= '
					' . $__templater->button('Revert', array(
			'type' => 'submit',
			'name' => 'revert',
		), '', array(
		)) . '
				';
	}
	$__finalCompiled .= $__templater->form('
		<div class="block-container">
			<div class="block-body">
				' . $__templater->formTextBoxRow(array(
		'name' => 'title',
		'value' => $__vars['phrase']['title'],
	), array(
		'rowtype' => 'fullWidth',
		'label' => 'Title',
	)) . '

				' . $__templater->formRow('
					<ul class="listPlain inputGroup-container">
						<li>
							<div class="inputGroup">
								<span class="inputGroup-label">' . 'Phrase text' . '</span>
								<span class="inputGroup-splitter"></span>
								<span class="inputGroup-label">' . 'Master value' . '</span>
							</div>
						</li>
						<li>
							<div class="inputGroup">
								' . $__templater->formTextArea(array(
		'name' => 'phrase_text',
		'rows' => '2',
		'autosize' => 'true',
		'dir' => $__vars['language']['text_direction'],
		'class' => 'input--fitHeight--short',
		'value' => $__vars['phrase']['phrase_text'],
	)) . '
								<span class="inputGroup-splitter"></span>
								' . $__templater->formTextArea(array(
		'rows' => '2',
		'autosize' => 'true',
		'readonly' => 'true',
		'dir' => $__vars['language']['text_direction'],
		'tabindex' => '-1',
		'class' => 'input--fitHeight--short',
		'value' => (($__vars['phrase']['language_id'] == 0) ? $__vars['phrase']['phrase_text'] : $__vars['phrase']['Master']['phrase_text']),
	)) . '
							</div>
						</li>
					</ul>
				', array(
		'rowtype' => 'fullWidth noLabel',
	)) . '
			</div>
			' . $__templater->formSubmitRow(array(
		'icon' => 'save',
	), array(
		'rowtype' => 'simple',
		'html' => '
				' . $__templater->button('Skip', array(
		'type' => 'submit',
		'name' => 'skip',
	), '', array(
	)) . '
				' . $__compilerTemp1 . '
			',
	)) . '
		</div>
		' . $__templater->formHiddenVal('language_id', $__vars['language']['language_id'], array(
	)) . '
		' . $__templater->formHiddenVal('addon_id', $__vars['phrase']['addon_id'], array(
	)) . '
		' . $__templater->formHiddenVal('global_cache', $__vars['phrase']['global_cache'], array(
	)) . '
	', array(
		'action' => $__templater->func('link', array('phrases/translate', $__vars['phrase'], ), false),
		'ajax' => 'true',
		'data-xf-init' => 'translate-submit',
		'class' => 'block block--phrase ' . (($__vars['phrase']['language_id'] == 0) ? '' : (($__vars['phrase']['language_id'] == $__vars['language']['language_id']) ? 'block--phrase--custom' : 'block--phrase--parentCustom')),
	)) . '
';
	return $__finalCompiled;
}
),
'collapsed' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'phrase' => '!',
		'language' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__vars['phrase']) {
		$__finalCompiled .= '
		';
		$__compilerTemp1 = '';
		if ($__vars['language']['language_id'] AND ($__templater->method($__vars['phrase'], 'isUpdate', array()) AND ($__vars['phrase']['language_id'] == $__vars['language']['language_id']))) {
			$__compilerTemp1 .= '
							' . $__templater->button('Revert', array(
				'type' => 'submit',
				'name' => 'revert',
				'class' => 'button--link',
			), '', array(
			)) . '
						';
		}
		$__finalCompiled .= $__templater->form('
			<div class="block-outer">
				<div class="block-outer-opposite">
					<div class="buttonGroup">
						' . $__templater->button('', array(
			'type' => 'submit',
			'name' => 'edit',
			'icon' => 'edit',
			'class' => 'button--link',
		), '', array(
		)) . '
						' . $__compilerTemp1 . '
					</div>
				</div>
			</div>
			<div class="block-container">
				<div class="block-body">
					' . $__templater->formRow('
						<dl class="pairs pairs--inline">
							<dt>' . 'Title' . '</dt>
							<dd>' . $__templater->escape($__vars['phrase']['title']) . '</dd>
						</dl>
					', array(
			'rowtype' => 'fullWidth',
		)) . '
					' . $__templater->formRow('
						<dl class="pairs pairs--inline">
							<dt>' . 'Phrase text' . '</dt>
							<dd>
								' . $__templater->filter($__vars['phrase']['phrase_text'], array(array('nl2br', array()),), true) . '
							</dd>
						</dl>
					', array(
			'rowtype' => 'fullWidth',
		)) . '
				</div>
			</div>
			' . $__templater->formHiddenVal('language_id', $__vars['language']['language_id'], array(
		)) . '
		', array(
			'action' => $__templater->func('link', array('phrases/translate', $__vars['phrase'], ), false),
			'ajax' => 'true',
			'data-xf-init' => 'translate-submit',
			'class' => 'block block--phrase block block--phrase ' . (($__vars['phrase']['language_id'] == 0) ? '' : (($__vars['phrase']['language_id'] == $__vars['language']['language_id']) ? 'block--phrase--custom' : 'block--phrase--parentCustom')),
		)) . '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
);