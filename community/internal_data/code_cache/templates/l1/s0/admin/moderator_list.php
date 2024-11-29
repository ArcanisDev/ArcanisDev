<?php
// FROM HASH: e0e0990276c675e941164f3bb926ae1f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Moderators');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Add moderator', array(
		'href' => $__templater->func('link', array('moderators/add', ), false),
		'icon' => 'add',
	), '', array(
	)) . '
');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '

	';
	if (!$__templater->test($__vars['superModerators'], 'empty', array())) {
		$__compilerTemp1 .= '
		<div class="block">
			<div class="block-container">
				<h2 class="block-header">' . 'Super moderators' . '</h2>
				<div class="block-body">
					';
		$__compilerTemp2 = '';
		if ($__templater->isTraversable($__vars['superModerators'])) {
			foreach ($__vars['superModerators'] AS $__vars['superMod']) {
				$__compilerTemp2 .= '
							' . $__templater->dataRow(array(
				), array(array(
					'class' => 'dataList-cell--min dataList-cell--image dataList-cell--imageSmall',
					'href' => $__templater->func('link', array('moderators/super/edit', $__vars['superMod'], ), false),
					'_type' => 'cell',
					'html' => '
									' . $__templater->func('avatar', array($__vars['superMod']['User'], 's', false, array(
					'href' => '',
				))) . '
								',
				),
				array(
					'href' => $__templater->func('link', array('moderators/super/edit', $__vars['superMod'], ), false),
					'label' => $__templater->escape($__vars['superMod']['User']['username']),
					'_type' => 'main',
					'html' => '',
				),
				array(
					'href' => $__templater->func('link', array('users/edit', $__vars['superMod']['User'], ), false),
					'_type' => 'action',
					'html' => 'User info',
				),
				array(
					'href' => $__templater->func('link', array('moderators/super/delete', $__vars['superMod'], ), false),
					'overlay' => 'true',
					'_type' => 'delete',
					'html' => '',
				))) . '
						';
			}
		}
		$__compilerTemp1 .= $__templater->dataList('
						' . $__compilerTemp2 . '
					', array(
		)) . '
				</div>
			</div>
		</div>
	';
	}
	$__compilerTemp1 .= '

	';
	if (!$__templater->test($__vars['contentModerators'], 'empty', array())) {
		$__compilerTemp1 .= '
		<div class="block">
			<div class="block-outer">
				<div class="block-outer-main">
					<a class="button button--link menuTrigger"
						data-xf-click="menu"
						role="button"
						tabindex="0"
						aria-expanded="false"
						aria-haspopup="true">' . 'Filter' . $__vars['xf']['language']['label_separator'] . ' ' . ($__vars['userIdFilter'] ? $__templater->escape($__vars['users'][$__vars['userIdFilter']]['username']) : $__vars['xf']['language']['parenthesis_open'] . 'All' . $__vars['xf']['language']['parenthesis_close']) . '</a>

					<div class="menu" data-menu="menu" aria-hidden="true">
						<div class="menu-content">
							<h3 class="menu-header">' . 'Content moderators' . '</h3>
							<a href="' . $__templater->func('link', array('moderators', ), true) . '" class="menu-linkRow ' . ((!$__vars['userIdFilter']) ? 'is-selected' : '') . '">' . $__vars['xf']['language']['parenthesis_open'] . 'All' . $__vars['xf']['language']['parenthesis_close'] . '</a>
							';
		if ($__templater->isTraversable($__vars['users'])) {
			foreach ($__vars['users'] AS $__vars['user']) {
				$__compilerTemp1 .= '
								<a href="' . $__templater->func('link', array('moderators', null, array('user_id' => $__vars['user']['user_id'], ), ), true) . '"
									class="menu-linkRow ' . ((($__vars['userIdFilter'] AND ($__vars['userIdFilter'] == $__vars['user']['user_id']))) ? 'is-selected' : '') . '">
									<span>' . $__templater->escape($__vars['user']['username']) . '</span>
								</a>
							';
			}
		}
		$__compilerTemp1 .= '
						</div>
					</div>
				</div>
			</div>
			<div class="block-container">
				<h2 class="block-header">' . 'Content moderators' . '</h2>
				<div class="block-body">
					';
		$__compilerTemp3 = '';
		if ($__templater->isTraversable($__vars['users'])) {
			foreach ($__vars['users'] AS $__vars['userId'] => $__vars['user']) {
				$__compilerTemp3 .= '
							';
				if ($__vars['contentModerators'][$__vars['userId']]) {
					$__compilerTemp3 .= '
								' . $__templater->dataRow(array(
						'rowtype' => 'subsection',
						'rowclass' => 'dataList-row--noHover',
					), array(array(
						'colspan' => '2',
						'_type' => 'cell',
						'html' => $__templater->escape($__vars['user']['username']),
					))) . '
								<tbody class="js-moderatorInsert-' . $__templater->escape($__vars['userId']) . '">
									';
					if ($__templater->isTraversable($__vars['contentModerators'][$__vars['userId']])) {
						foreach ($__vars['contentModerators'][$__vars['userId']] AS $__vars['contentMod']) {
							$__compilerTemp3 .= '
										' . $__templater->dataRow(array(
							), array(array(
								'href' => $__templater->func('link', array('moderators/content/edit', $__vars['contentMod'], ), false),
								'label' => $__templater->escape($__templater->method($__vars['contentMod'], 'getContentTitle', array())),
								'_type' => 'main',
								'html' => '',
							),
							array(
								'href' => $__templater->func('link', array('moderators/content/delete', $__vars['contentMod'], ), false),
								'overlay' => 'true',
								'_type' => 'delete',
								'html' => '',
							))) . '
									';
						}
					}
					$__compilerTemp3 .= '
									';
					if ($__vars['displayLimit'] AND ($__vars['contentModeratorTotals'][$__vars['userId']] > $__vars['displayLimit'])) {
						$__compilerTemp3 .= '
										' . $__templater->dataRow(array(
						), array(array(
							'colspan' => '2',
							'class' => 'dataList-cell--link',
							'_type' => 'cell',
							'html' => '
												<a href="' . $__templater->func('link', array('moderators', null, array('user_id' => $__vars['userId'], ), ), true) . '" data-xf-click="inserter" data-replace=".js-moderatorInsert-' . $__templater->escape($__vars['userId']) . '" data-animate-replace="false">' . '... and ' . $__templater->filter(($__vars['contentModeratorTotals'][$__vars['userId']] - $__vars['displayLimit']), array(array('number', array()),), true) . ' more.' . '</a>
											',
						))) . '
									';
					}
					$__compilerTemp3 .= '
								</tbody>
							';
				}
				$__compilerTemp3 .= '
						';
			}
		}
		$__compilerTemp1 .= $__templater->dataList('
						' . $__compilerTemp3 . '
					', array(
		)) . '
				</div>
			</div>
		</div>
	';
	}
	$__compilerTemp1 .= '

	';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
	' . $__compilerTemp1 . '
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'There are currently no moderators. Use the link above to create one.' . '</div>
';
	}
	return $__finalCompiled;
}
);