<?php
// FROM HASH: 2c5a523767f6909f0aaabc92a2abd725
return array(
'macros' => array('metadata' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'siteName' => '',
		'title' => '',
		'description' => '',
		'type' => '',
		'shareUrl' => '',
		'canonicalUrl' => '',
		'imageUrl' => '',
		'twitterCard' => 'summary',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	if (!$__templater->test($__vars['siteName'], 'empty', array())) {
		$__finalCompiled .= '
		' . $__templater->callMacro(null, 'site_name', array(
			'siteName' => $__vars['siteName'],
		), $__vars) . '
	';
	}
	$__finalCompiled .= '
	';
	if (!$__templater->test($__vars['title'], 'empty', array())) {
		$__finalCompiled .= '
		' . $__templater->callMacro(null, 'title', array(
			'title' => $__vars['title'],
		), $__vars) . '
	';
	}
	$__finalCompiled .= '
	';
	if (!$__templater->test($__vars['description'], 'empty', array())) {
		$__finalCompiled .= '
		' . $__templater->callMacro(null, 'description', array(
			'description' => $__vars['description'],
		), $__vars) . '
	';
	}
	$__finalCompiled .= '
	';
	if (!$__templater->test($__vars['type'], 'empty', array())) {
		$__finalCompiled .= '
		' . $__templater->callMacro(null, 'type', array(
			'type' => $__vars['type'],
		), $__vars) . '
	';
	}
	$__finalCompiled .= '
	';
	if (!$__templater->test($__vars['shareUrl'], 'empty', array())) {
		$__finalCompiled .= '
		' . $__templater->callMacro(null, 'share_url', array(
			'shareUrl' => $__vars['shareUrl'],
		), $__vars) . '
	';
	}
	$__finalCompiled .= '
	';
	if (!$__templater->test($__vars['canonicalUrl'], 'empty', array())) {
		$__finalCompiled .= '
		' . $__templater->callMacro(null, 'canonical_url', array(
			'canonicalUrl' => $__vars['canonicalUrl'],
		), $__vars) . '
	';
	}
	$__finalCompiled .= '
	';
	if (!$__templater->test($__vars['imageUrl'], 'empty', array())) {
		$__finalCompiled .= '
		' . $__templater->callMacro(null, 'image_url', array(
			'imageUrl' => $__vars['imageUrl'],
			'twitterCard' => $__vars['twitterCard'],
		), $__vars) . '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'site_name' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'siteName' => '!',
		'output' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['meta'] = $__templater->preEscaped('<meta property="og:site_name" content="' . $__templater->filter($__vars['siteName'], array(array('for_attr', array()),), true) . '" />');
	$__finalCompiled .= '
	' . $__templater->callMacro(null, 'output', array(
		'option' => 'meta_site_name',
		'meta' => $__vars['meta'],
		'output' => $__vars['output'],
	), $__vars) . '
';
	return $__finalCompiled;
}
),
'title' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'title' => '!',
		'output' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['meta'] = $__templater->preEscaped('
		<meta property="og:title" content="' . $__templater->filter($__vars['title'], array(array('for_attr', array()),), true) . '" />
		<meta property="twitter:title" content="' . $__templater->filter($__templater->func('snippet', array($__vars['title'], 70, ), false), array(array('for_attr', array()),), true) . '" />
	');
	$__finalCompiled .= '
	' . $__templater->callMacro(null, 'output', array(
		'option' => 'meta_title',
		'meta' => $__vars['meta'],
		'output' => $__vars['output'],
	), $__vars) . '
';
	return $__finalCompiled;
}
),
'description' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'description' => '!',
		'output' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['meta'] = $__templater->preEscaped('
		<meta name="description" content="' . $__templater->filter($__templater->func('snippet', array($__templater->filter($__vars['description'], array(array('strip_tags', array()),), false), 160, ), false), array(array('for_attr', array()),), true) . '" />
		<meta property="og:description" content="' . $__templater->filter($__templater->func('snippet', array($__templater->filter($__vars['description'], array(array('strip_tags', array()),), false), 300, ), false), array(array('for_attr', array()),), true) . '" />
		<meta property="twitter:description" content="' . $__templater->filter($__templater->func('snippet', array($__templater->filter($__vars['description'], array(array('strip_tags', array()),), false), 200, ), false), array(array('for_attr', array()),), true) . '" />
	');
	$__finalCompiled .= '
	' . $__templater->callMacro(null, 'output', array(
		'option' => 'meta_description',
		'meta' => $__vars['meta'],
		'output' => $__vars['output'],
	), $__vars) . '
';
	return $__finalCompiled;
}
),
'type' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'type' => '!',
		'output' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['meta'] = $__templater->preEscaped('<meta property="og:type" content="' . $__templater->escape($__vars['type']) . '" />');
	$__finalCompiled .= '
	' . $__templater->callMacro(null, 'output', array(
		'option' => 'meta_type',
		'meta' => $__vars['meta'],
		'output' => $__vars['output'],
	), $__vars) . '
';
	return $__finalCompiled;
}
),
'share_url' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'shareUrl' => '!',
		'output' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['meta'] = $__templater->preEscaped('<meta property="og:url" content="' . $__templater->escape($__vars['shareUrl']) . '" />');
	$__finalCompiled .= '
	' . $__templater->callMacro(null, 'output', array(
		'option' => 'meta_share_url',
		'meta' => $__vars['meta'],
		'output' => $__vars['output'],
	), $__vars) . '
';
	return $__finalCompiled;
}
),
'canonical_url' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'canonicalUrl' => '!',
		'output' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['meta'] = $__templater->preEscaped('<link rel="canonical" href="' . $__templater->escape($__vars['canonicalUrl']) . '" />');
	$__finalCompiled .= '
	' . $__templater->callMacro(null, 'output', array(
		'option' => 'meta_canonical_url',
		'meta' => $__vars['meta'],
		'output' => $__vars['output'],
	), $__vars) . '
';
	return $__finalCompiled;
}
),
'image_url' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'imageUrl' => '!',
		'twitterCard' => 'summary',
		'output' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['meta'] = $__templater->preEscaped('
		<meta property="og:image" content="' . $__templater->escape($__vars['imageUrl']) . '" />
		<meta property="twitter:image" content="' . $__templater->escape($__vars['imageUrl']) . '" />
		<meta property="twitter:card" content="' . $__templater->escape($__vars['twitterCard']) . '" />
	');
	$__finalCompiled .= '
	' . $__templater->callMacro(null, 'output', array(
		'option' => 'meta_image_url',
		'meta' => $__vars['meta'],
		'output' => $__vars['output'],
	), $__vars) . '
';
	return $__finalCompiled;
}
),
'output' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'option' => '!',
		'meta' => '!',
		'output' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__vars['output']) {
		$__finalCompiled .= $__templater->filter($__vars['meta'], array(array('raw', array()),), true);
	} else {
		$__templater->setPageParam('head.' . $__vars['option'], $__templater->preEscaped($__templater->filter($__vars['meta'], array(array('raw', array()),), true)));
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

' . '

' . '

' . '

' . '

' . '

' . '

' . '

';
	return $__finalCompiled;
}
);