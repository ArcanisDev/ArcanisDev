<?php
// FROM HASH: ef32406ecdacc6b9ee53d25aca6c6cce
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Attachment browser');
	$__finalCompiled .= '

';
	$__templater->inlineCss('
	.attachment-tooltip-image
	{
		display: block;
	}
');
	$__finalCompiled .= '

';
	$__compilerTemp1 = array(array(
		'label' => $__vars['xf']['language']['parenthesis_open'] . 'All content types' . $__vars['xf']['language']['parenthesis_close'],
		'_type' => 'option',
	));
	if ($__templater->isTraversable($__vars['handlers'])) {
		foreach ($__vars['handlers'] AS $__vars['contentType'] => $__vars['handler']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['contentType'],
				'label' => $__templater->escape($__templater->method($__vars['handler'], 'getContentTypePhrase', array())),
				'_type' => 'option',
			);
		}
	}
	$__compilerTemp2 = array(array(
		'label' => 'Date presets' . $__vars['xf']['language']['label_separator'],
		'value' => '-1',
		'_type' => 'option',
	));
	$__compilerTemp2[] = array(
		'_type' => 'optgroup',
		'options' => array(),
	);
	end($__compilerTemp2); $__compilerTemp3 = key($__compilerTemp2);
	$__compilerTemp2[$__compilerTemp3]['options'] = $__templater->mergeChoiceOptions($__compilerTemp2[$__compilerTemp3]['options'], $__vars['datePresets']);
	$__compilerTemp2[$__compilerTemp3]['options'][] = array(
		'value' => '1995-01-01',
		'label' => 'All time',
		'_type' => 'option',
	);
	$__compilerTemp4 = '';
	if (!$__templater->test($__vars['attachments'], 'empty', array())) {
		$__compilerTemp4 .= '
			' . $__templater->formRadioTabsRow(array(
			'name' => 'mode',
			'value' => ($__vars['linkFilters']['mode'] ?: ''),
			'data-xf-click' => 'submit',
		), array(array(
			'value' => '',
			'label' => 'All',
			'_type' => 'option',
		),
		array(
			'value' => 'recent',
			'label' => 'Most recent',
			'_type' => 'option',
		),
		array(
			'value' => 'size',
			'label' => 'Largest',
			'_type' => 'option',
		)), array(
		)) . '
			</h2>
			<div class="block-body">
				';
		$__compilerTemp5 = '';
		if ($__templater->isTraversable($__vars['attachments'])) {
			foreach ($__vars['attachments'] AS $__vars['attachment']) {
				$__compilerTemp5 .= '
						';
				$__compilerTemp6 = array(array(
					'name' => 'attachment_ids[]',
					'value' => $__vars['attachment']['attachment_id'],
					'_type' => 'toggle',
					'html' => '',
				));
				if ($__vars['attachment']['has_thumbnail']) {
					$__compilerTemp6[] = array(
						'class' => 'dataList-cell--attachment',
						'href' => $__templater->func('link', array('attachments/view', $__vars['attachment'], ), false),
						'style' => 'background-image: url(' . $__vars['attachment']['thumbnail_url'] . ')',
						'alt' => $__vars['attachment']['filename'],
						'data-xf-init' => 'element-tooltip',
						'data-element' => '| .tooltip-element',
						'_type' => 'cell',
						'html' => '
									<span class="tooltip-element"><img src="' . $__templater->escape($__vars['attachment']['thumbnail_url']) . '" class="attachment-tooltip-image" /></span>
								',
					);
				} else {
					$__compilerTemp6[] = array(
						'class' => 'dataList-cell--attachment',
						'href' => $__templater->func('link', array('attachments/view', $__vars['attachment'], ), false),
						'_type' => 'cell',
						'html' => '
									' . $__templater->fontAwesome('fa-file fa-2x', array(
					)) . '
								',
					);
				}
				$__compilerTemp6[] = array(
					'href' => $__templater->func('link', array('attachments/view', $__vars['attachment'], ), false),
					'class' => 'dataList-cell--main',
					'_type' => 'cell',
					'html' => '
								<div class="dataList-mainRow">' . $__templater->escape($__vars['attachment']['filename']) . '</div>
								<div class="dataList-subRow">
									<ul class="listInline listInline--bullet">
										<li>' . $__templater->func('date_dynamic', array($__vars['attachment']['Data']['upload_date'], array(
				))) . '</li>
										<li>' . ($__templater->escape($__vars['attachment']['Data']['User']['username']) ?: 'Unknown user') . '</li>
										<li>' . $__templater->filter($__vars['attachment']['file_size'], array(array('file_size', array()),), true) . '</li>
									</ul>
								</div>
							',
				);
				$__compilerTemp7 = '';
				if (!$__vars['attachment']['unassociated']) {
					$__compilerTemp7 .= '
									' . 'View host content' . '
									<span class="dataList-secondRow">' . $__templater->filter($__templater->method($__vars['attachment'], 'getContentTypePhrase', array()), array(array('parens', array()),), true) . '</span>
								';
				} else {
					$__compilerTemp7 .= '
									' . 'Unassociated' . '
								';
				}
				$__compilerTemp6[] = array(
					'href' => ((((!$__vars['attachment']['unassociated']) AND $__templater->method($__vars['attachment'], 'getContainerLink', array()))) ? $__templater->method($__vars['attachment'], 'getContainerLink', array()) : $__templater->func('link', array('attachments/view', $__vars['attachment'], ), false)),
					'target' => ((!$__vars['attachment']['unassociated']) ? '_blank' : ''),
					'class' => 'dataList-cell--action',
					'_type' => 'cell',
					'html' => '
								' . $__compilerTemp7 . '
							',
				);
				$__compilerTemp6[] = array(
					'href' => $__templater->func('link', array('attachments/delete', $__vars['attachment'], $__vars['linkFilters'], ), false),
					'_type' => 'delete',
					'html' => '',
				);
				$__compilerTemp5 .= $__templater->dataRow(array(
				), $__compilerTemp6) . '
					';
			}
		}
		$__compilerTemp4 .= $__templater->dataList('
					' . $__compilerTemp5 . '
				', array(
		)) . '
			</div>
			<div class="block-footer block-footer--split">
				<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['attachments'], $__vars['total'], ), true) . '</span>
				<span class="block-footer-select">' . $__templater->formCheckBox(array(
			'standalone' => 'true',
		), array(array(
			'check-all' => '< .block-container',
			'label' => 'Select all',
			'_type' => 'option',
		))) . '</span>
				<span class="block-footer-controls">
					' . $__templater->button('', array(
			'type' => 'submit',
			'name' => 'delete_attachments',
			'icon' => 'delete',
		), '', array(
		)) . '
				</span>
			</div>
		';
	} else {
		$__compilerTemp4 .= '
			<div class="block-body block-row">' . 'No results found.' . '</div>
		';
	}
	$__finalCompiled .= $__templater->form('

	<div class="block-outer">
		<div class="filterBlock">
			<ul class="listInline">
				<li>
					' . $__templater->formSelect(array(
		'name' => 'content_type',
		'class' => 'filterBlock-input',
		'value' => $__vars['linkFilters']['content_type'],
	), $__compilerTemp1) . '
				</li>
				<li>
					' . $__templater->formTextBox(array(
		'name' => 'username',
		'value' => $__vars['linkFilters']['username'],
		'ac' => 'single',
		'class' => 'input filterBlock-input',
		'placeholder' => 'Username',
	)) . '
				</li>
				<li style="display: inline-block; vertical-align: bottom">
					<!-- inline style is to workaround Safari alignment issue -->
					<div class="inputGroup inputGroup--auto">
						' . $__templater->formDateInput(array(
		'name' => 'start',
		'value' => ($__vars['linkFilters']['start'] ? $__templater->func('date', array($__vars['linkFilters']['start'], 'Y-m-d', ), false) : ''),
		'class' => 'filterBlock-input filterBlock-input--small',
	)) . '
						<span class="inputGroup-text">-</span>
						' . $__templater->formDateInput(array(
		'name' => 'end',
		'value' => ($__vars['linkFilters']['end'] ? $__templater->func('date', array($__vars['linkFilters']['end'], 'Y-m-d', ), false) : ''),
		'class' => 'filterBlock-input filterBlock-input--small',
	)) . '
						<span class="inputGroup-splitter"></span>
					</div>
				</li>
				<li>
					' . $__templater->formSelect(array(
		'name' => 'date_preset',
		'class' => 'js-presetChange filterBlock-input',
	), $__compilerTemp2) . '
				</li>
				<li>
					' . $__templater->button('Go', array(
		'type' => 'submit',
		'class' => 'button--small',
	), '', array(
	)) . '
				</li>
			</ul>
		</div>
	</div>
	<div class="block-container">
		' . $__compilerTemp4 . '
	</div>
	' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'attachments',
		'params' => $__vars['linkFilters'],
		'wrapperclass' => 'block-outer block-outer--after',
		'perPage' => $__vars['perPage'],
	))) . '

', array(
		'action' => $__templater->func('link', array('attachments', ), false),
		'class' => 'block',
		'ajax' => 'true',
		'data-xf-init' => 'select-plus',
		'data-sp-checkbox' => 'input[name=\'attachment_ids[]\']',
		'data-sp-container' => '.dataList-row',
	)) . '

';
	$__templater->inlineJs('
	$(function()
	{
		$(\'.js-presetChange\').change(function(e)
		{
			var $ctrl = $(this),
			value = $ctrl.val(),
			$form = $ctrl.closest(\'form\');

			if (value == -1)
			{
				return;
			}

			$form.find($ctrl.data(\'start\') || \'input[name=start]\').val(value);
			$form.find($ctrl.data(\'end\') || \'input[name=end]\').val(\'\');
			$form.submit();
		});
	});
');
	return $__finalCompiled;
}
);