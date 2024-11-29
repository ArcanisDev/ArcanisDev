<?php
// FROM HASH: 6dfc90dfc53939183a4810541cd9f8b8
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Username change log entry');
	$__finalCompiled .= '

<div class="block">
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formRow('
				<div class="contentRow contentRow--alignMiddle">
					<div class="contentRow-figure">
						' . $__templater->func('avatar', array($__vars['entry']['User'], 'xs', false, array(
	))) . '
					</div>
					<div class="contentRow-main">
						<h3 class="contentRow-title">' . $__templater->func('username_link', array($__vars['entry']['User'], true, array(
	))) . '</h3>
					</div>
				</div>
			', array(
		'label' => 'Current username',
		'rowtype' => 'button',
	)) . '

			' . $__templater->formRow('
				' . $__templater->escape($__vars['entry']['old_username']) . '
			', array(
		'label' => 'Old username',
	)) . '

			' . $__templater->formRow('
				' . $__templater->escape($__vars['entry']['new_username']) . '
			', array(
		'label' => 'New username',
	)) . '

			' . $__templater->formRow('
				' . ($__vars['entry']['change_reason'] ? $__templater->filter($__vars['entry']['change_reason'], array(array('nl2br', array()),), true) : 'N/A') . '
			', array(
		'label' => 'Change reason',
	)) . '

			<hr class="formRowSep" />

			';
	$__compilerTemp1 = '';
	if ($__vars['entry']['change_state'] == 'approved') {
		$__compilerTemp1 .= '
					' . 'Approved' . '
				';
	} else if ($__vars['entry']['change_state'] == 'moderated') {
		$__compilerTemp1 .= '
					' . 'Awaiting approval' . '
				';
	} else if ($__vars['entry']['change_state'] == 'rejected') {
		$__compilerTemp1 .= '
					' . 'Rejected' . '
				';
	}
	$__finalCompiled .= $__templater->formRow('
				' . $__compilerTemp1 . '
			', array(
		'label' => 'Change state',
	)) . '

			';
	if ($__vars['entry']['change_state'] == 'rejected') {
		$__finalCompiled .= '
				';
		$__compilerTemp2 = '';
		if ($__vars['entry']['moderator_user_id'] AND $__vars['entry']['Moderator']) {
			$__compilerTemp2 .= '
						' . $__templater->func('username_link', array($__vars['entry']['Moderator'], false, array(
				'href' => $__templater->func('link', array('users/edit', $__vars['entry']['Moderator'], ), false),
			))) . '
					';
		} else {
			$__compilerTemp2 .= '
						' . 'N/A' . '
					';
		}
		$__finalCompiled .= $__templater->formRow('
					' . $__compilerTemp2 . '
				', array(
			'label' => 'Rejected by',
		)) . '

				';
		$__compilerTemp3 = '';
		if ($__vars['entry']['reject_reason']) {
			$__compilerTemp3 .= '
						' . $__templater->escape($__vars['entry']['reject_reason']) . '
					';
		} else {
			$__compilerTemp3 .= '
						' . 'N/A' . '
					';
		}
		$__finalCompiled .= $__templater->formRow('
					' . $__compilerTemp3 . '
				', array(
			'label' => 'Reason',
		)) . '
			';
	} else if ($__vars['entry']['user_id'] != $__vars['entry']['change_user_id']) {
		$__finalCompiled .= '
				';
		$__compilerTemp4 = '';
		if ($__vars['entry']['change_user_id'] AND $__vars['entry']['ChangeUser']) {
			$__compilerTemp4 .= '
						' . $__templater->func('username_link', array($__vars['entry']['ChangeUser'], false, array(
				'href' => $__templater->func('link', array('users/edit', $__vars['entry']['ChangeUser'], ), false),
			))) . '
					';
		} else {
			$__compilerTemp4 .= '
						' . 'N/A' . '
					';
		}
		$__finalCompiled .= $__templater->formRow('
					' . $__compilerTemp4 . '
				', array(
			'label' => 'Changed by',
		)) . '
			';
	} else if (($__vars['entry']['change_state'] == 'approved') AND ($__vars['entry']['moderator_user_id'] AND $__vars['entry']['Moderator'])) {
		$__finalCompiled .= '
				' . $__templater->formRow('
					' . $__templater->func('username_link', array($__vars['entry']['Moderator'], false, array(
			'href' => $__templater->func('link', array('users/edit', $__vars['entry']['Moderator'], ), false),
		))) . '
				', array(
			'label' => 'Approved by',
		)) . '
			';
	}
	$__finalCompiled .= '

			' . $__templater->formRow('
				' . $__templater->func('date_dynamic', array($__vars['entry']['change_date'], array(
	))) . '
			', array(
		'label' => 'Date',
	)) . '
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);