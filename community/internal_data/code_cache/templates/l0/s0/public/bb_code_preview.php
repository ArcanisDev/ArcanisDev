<?php
// FROM HASH: b3adff932426ddaab69625d42e75ffa5
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['message']) {
		$__finalCompiled .= '
	';
		$__templater->includeCss('bb_code_preview.less');
		$__finalCompiled .= '
	<div class="bbCodePreview">
	' . $__templater->formRow('
		<h4 class="block-textHeader">' . 'Preview' . '</h4>
		<div class="bbCodePreview-content">
			' . $__templater->func('bb_code', array($__vars['message'], $__vars['context'] . ':preview', $__vars['user'], array('attachments' => $__vars['attachments'], 'viewAttachments' => $__vars['canViewAttachments'], ), ), true) . '
		</div>
	', array(
			'rowtype' => 'fullWidth noLabel noGutter',
		)) . '
	</div>
';
	}
	return $__finalCompiled;
}
);