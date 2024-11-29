<?php
// FROM HASH: 2684ba82fd475acefb6c4baaf511f5cd
return array(
'macros' => array('category_page_options' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'category' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->setPageParam('searchConstraints', array('Threads' => array('search_type' => 'post', ), 'This category' => array('search_type' => 'post', 'c' => array('nodes' => array($__vars['category']['node_id'], ), 'child_nodes' => 1, ), ), ));
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';

	return $__finalCompiled;
}
);