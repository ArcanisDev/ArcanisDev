<?php
// FROM HASH: 81033286aec59276093866f68d6051f0
return array(
'macros' => array('nav_entry' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'navId' => '!',
		'nav' => '!',
		'selected' => false,
		'shortcut' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="p-navEl ' . ($__vars['selected'] ? 'is-selected' : '') . '" ' . ($__vars['nav']['children'] ? 'data-has-children="true"' : '') . '>
		';
	if ($__vars['nav']['href']) {
		$__finalCompiled .= '

			' . $__templater->callMacro(null, 'nav_link', array(
			'navId' => $__vars['navId'],
			'nav' => $__vars['nav'],
			'class' => 'p-navEl-link ' . ($__vars['nav']['children'] ? 'p-navEl-link--splitMenu' : ''),
			'shortcut' => ($__vars['nav']['children'] ? false : $__vars['shortcut']),
		), $__vars) . '

			';
		if ($__vars['nav']['children']) {
			$__finalCompiled .= '<a data-xf-key="' . $__templater->escape($__vars['shortcut']) . '"
				data-xf-click="menu"
				data-menu-pos-ref="< .p-navEl"
				class="p-navEl-splitTrigger"
				role="button"
				tabindex="0"
				aria-label="' . $__templater->filter('Toggle expanded', array(array('for_attr', array()),), true) . '"
				aria-expanded="false"
				aria-haspopup="true"></a>';
		}
		$__finalCompiled .= '

		';
	} else if ($__vars['nav']['children']) {
		$__finalCompiled .= '<a data-xf-key="' . $__templater->escape($__vars['shortcut']) . '"
			data-xf-click="menu"
			data-menu-pos-ref="< .p-navEl"
			class="p-navEl-linkHolder"
			role="button"
			tabindex="0"
			aria-expanded="false"
			aria-haspopup="true">
			' . $__templater->callMacro(null, 'nav_link', array(
			'navId' => $__vars['navId'],
			'nav' => $__vars['nav'],
			'class' => 'p-navEl-link p-navEl-link--menuTrigger',
		), $__vars) . '
		</a>

		';
	} else {
		$__finalCompiled .= '

			' . $__templater->callMacro(null, 'nav_link', array(
			'navId' => $__vars['navId'],
			'nav' => $__vars['nav'],
			'class' => 'p-navEl-link',
			'shortcut' => $__vars['shortcut'],
		), $__vars) . '

		';
	}
	$__finalCompiled .= '
		';
	if ($__vars['nav']['children']) {
		$__finalCompiled .= '
			<div class="menu menu--structural" data-menu="menu" aria-hidden="true">
				<div class="menu-content">
					';
		if ($__templater->isTraversable($__vars['nav']['children'])) {
			foreach ($__vars['nav']['children'] AS $__vars['childNavId'] => $__vars['child']) {
				$__finalCompiled .= '
						' . $__templater->callMacro(null, 'nav_menu_entry', array(
					'navId' => $__vars['childNavId'],
					'nav' => $__vars['child'],
				), $__vars) . '
					';
			}
		}
		$__finalCompiled .= '
				</div>
			</div>
		';
	}
	$__finalCompiled .= '
	</div>
';
	return $__finalCompiled;
}
),
'nav_link' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'navId' => '!',
		'nav' => '!',
		'class' => '',
		'titleHtml' => '',
		'shortcut' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['tag'] = ($__vars['nav']['href'] ? 'a' : 'span');
	$__finalCompiled .= '
	<' . $__templater->escape($__vars['tag']) . ' ' . ($__vars['nav']['href'] ? (('href="' . $__templater->escape($__vars['nav']['href'])) . '"') : '') . '
		class="' . $__templater->func('trim', array($__vars['class'], ), true) . ' ' . $__templater->escape($__vars['nav']['attributes']['class']) . '"
		' . $__templater->func('attributes', array($__vars['nav']['attributes'], array('class', ), ), true) . '
		' . (($__vars['shortcut'] !== false) ? (('data-xf-key="' . $__templater->escape($__vars['shortcut'])) . '"') : '') . '
		data-nav-id="' . $__templater->escape($__vars['navId']) . '">';
	if ($__vars['nav']['icon']) {
		$__finalCompiled .= $__templater->fontAwesome($__templater->escape($__vars['nav']['icon']), array(
		)) . ' ';
	}
	$__finalCompiled .= ($__vars['titleHtml'] ? $__templater->filter($__vars['titleHtml'], array(array('raw', array()),), true) : $__templater->escape($__vars['nav']['title']));
	if ($__vars['nav']['counter']) {
		$__finalCompiled .= ' <span class="badge badge--highlighted">' . $__templater->filter($__vars['nav']['counter'], array(array('number', array()),), true) . '</span>';
	}
	$__finalCompiled .= '</' . $__templater->escape($__vars['tag']) . '>
';
	return $__finalCompiled;
}
),
'nav_menu_entry' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'navId' => '!',
		'nav' => '!',
		'depth' => '0',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->callMacro(null, 'nav_link', array(
		'navId' => $__vars['navId'],
		'nav' => $__vars['nav'],
		'class' => 'menu-linkRow u-indentDepth' . $__vars['depth'] . ' js-offCanvasCopy',
	), $__vars) . '
	';
	if ($__vars['nav']['children']) {
		$__finalCompiled .= '
		';
		if ($__templater->isTraversable($__vars['nav']['children'])) {
			foreach ($__vars['nav']['children'] AS $__vars['childNavId'] => $__vars['child']) {
				$__finalCompiled .= '
			' . $__templater->callMacro(null, 'nav_menu_entry', array(
					'navId' => $__vars['childNavId'],
					'nav' => $__vars['child'],
					'depth' => ($__vars['depth'] + 1),
				), $__vars) . '
		';
			}
		}
		$__finalCompiled .= '
		';
		if ($__vars['depth'] == 0) {
			$__finalCompiled .= '
			<hr class="menu-separator" />
		';
		}
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'breadcrumbs' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'breadcrumbs' => '!',
		'navTree' => '!',
		'selectedNavEntry' => null,
		'variant' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
			';
	$__vars['position'] = 0;
	$__compilerTemp1 .= '

			';
	$__vars['rootBreadcrumb'] = $__vars['navTree'][$__vars['xf']['options']['rootBreadcrumb']];
	$__compilerTemp1 .= '
			';
	$__vars['rootBreadcrumbHref'] = (($__templater->filter($__vars['rootBreadcrumb']['href'], array(array('substr', array(-1, )),), false) == '/') ? $__vars['rootBreadcrumb']['href'] : ($__vars['rootBreadcrumb']['href'] . '/'));
	$__compilerTemp1 .= '

			';
	if ($__vars['rootBreadcrumb'] AND (($__vars['rootBreadcrumbHref'] != $__vars['xf']['uri']) AND ($__vars['rootBreadcrumbHref'] != $__vars['xf']['fullUri']))) {
		$__compilerTemp1 .= '
				';
		$__vars['position'] = ($__vars['position'] + 1);
		$__compilerTemp1 .= '
				' . $__templater->callMacro(null, 'crumb', array(
			'position' => $__vars['position'],
			'href' => $__vars['rootBreadcrumb']['href'],
			'value' => $__vars['rootBreadcrumb']['title'],
		), $__vars) . '
			';
	}
	$__compilerTemp1 .= '

			';
	if ($__vars['selectedNavEntry'] AND ($__vars['selectedNavEntry']['href'] AND (($__vars['selectedNavEntry']['href'] != $__vars['xf']['uri']) AND (($__vars['selectedNavEntry']['href'] != $__vars['xf']['fullUri']) AND ($__vars['selectedNavEntry']['href'] != $__vars['rootBreadcrumbHref']))))) {
		$__compilerTemp1 .= '
				';
		$__vars['position'] = ($__vars['position'] + 1);
		$__compilerTemp1 .= '
				' . $__templater->callMacro(null, 'crumb', array(
			'position' => $__vars['position'],
			'href' => $__vars['selectedNavEntry']['href'],
			'value' => $__vars['selectedNavEntry']['title'],
		), $__vars) . '
			';
	}
	$__compilerTemp1 .= '
			';
	if ($__templater->isTraversable($__vars['breadcrumbs'])) {
		foreach ($__vars['breadcrumbs'] AS $__vars['breadcrumb']) {
			if (($__vars['breadcrumb']['href'] != $__vars['xf']['uri']) AND ($__vars['breadcrumb']['href'] != $__vars['xf']['fullUri'])) {
				$__compilerTemp1 .= '
				';
				$__vars['position'] = ($__vars['position'] + 1);
				$__compilerTemp1 .= '
				' . $__templater->callMacro(null, 'crumb', array(
					'position' => $__vars['position'],
					'href' => $__vars['breadcrumb']['href'],
					'value' => $__vars['breadcrumb']['value'],
				), $__vars) . '
			';
			}
		}
	}
	$__compilerTemp1 .= '

		';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
		<ul class="p-breadcrumbs ' . ($__vars['variant'] ? ('p-breadcrumbs--' . $__templater->escape($__vars['variant'])) : '') . '"
			itemscope itemtype="https://schema.org/BreadcrumbList">
		' . $__compilerTemp1 . '
		</ul>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'crumb' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'href' => '!',
		'value' => '!',
		'position' => 0,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
		<a href="' . $__templater->escape($__vars['href']) . '" itemprop="item">
			<span itemprop="name">' . $__templater->escape($__vars['value']) . '</span>
		</a>
		';
	if ($__vars['position']) {
		$__finalCompiled .= '<meta itemprop="position" content="' . $__templater->escape($__vars['position']) . '" />';
	}
	$__finalCompiled .= '
	</li>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<!DOCTYPE html>
<html id="XF" lang="' . $__templater->escape($__vars['xf']['language']['language_code']) . '" dir="' . $__templater->escape($__vars['xf']['language']['text_direction']) . '"
	data-app="public"
	data-template="' . $__templater->escape($__vars['template']) . '"
	data-container-key="' . $__templater->escape($__vars['containerKey']) . '"
	data-content-key="' . $__templater->escape($__vars['contentKey']) . '"
	data-logged-in="' . ($__vars['xf']['visitor']['user_id'] ? 'true' : 'false') . '"
	data-cookie-prefix="' . $__templater->escape($__vars['xf']['cookie']['prefix']) . '"
	data-csrf="' . $__templater->filter($__templater->func('csrf_token', array(), false), array(array('escape', array('js', )),), true) . '"
	class="has-no-js ' . ($__vars['template'] ? ('template-' . $__templater->escape($__vars['template'])) : '') . '"
	' . ($__vars['xf']['runJobs'] ? ' data-run-jobs=""' : '') . '>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

	';
	$__vars['siteName'] = $__vars['xf']['options']['boardTitle'];
	$__finalCompiled .= '
	';
	$__vars['h1'] = $__templater->preEscaped($__templater->func('page_h1', array($__vars['siteName'])));
	$__finalCompiled .= '
	';
	$__vars['description'] = $__templater->preEscaped($__templater->func('page_description'));
	$__finalCompiled .= '

	<title>' . $__templater->func('page_title', array('%s | %s', $__vars['xf']['options']['boardTitle'], $__vars['pageNumber'])) . '</title>

	<link rel="manifest" href="' . $__templater->func('base_url', array('webmanifest.php', ), true) . '">
	';
	if ($__templater->func('property', array('metaThemeColor', ), false)) {
		$__finalCompiled .= '
		<meta name="theme-color" content="' . $__templater->func('parse_less_color', array($__templater->func('property', array('metaThemeColor', ), false), ), true) . '" />
	';
	}
	$__finalCompiled .= '

	<meta name="apple-mobile-web-app-title" content="' . ($__templater->escape($__vars['xf']['options']['boardShortTitle']) ?: $__templater->escape($__vars['xf']['options']['boardTitle'])) . '">
	';
	if ($__templater->func('property', array('publicIconUrl', ), false)) {
		$__finalCompiled .= '
		<link rel="apple-touch-icon" href="' . $__templater->func('base_url', array($__templater->func('property', array('publicIconUrl', true, ), false), ), true) . '">
	';
	} else if ($__templater->func('property', array('publicMetadataLogoUrl', ), false)) {
		$__finalCompiled .= '
		<link rel="apple-touch-icon" href="' . $__templater->func('base_url', array($__templater->func('property', array('publicMetadataLogoUrl', ), false), ), true) . '" />
	';
	}
	$__finalCompiled .= '

	';
	if ($__templater->isTraversable($__vars['head'])) {
		foreach ($__vars['head'] AS $__vars['headTag']) {
			$__finalCompiled .= '
		' . $__templater->escape($__vars['headTag']) . '
	';
		}
	}
	$__finalCompiled .= '

	';
	if ((!$__vars['head']['meta_site_name']) AND !$__templater->test($__vars['siteName'], 'empty', array())) {
		$__finalCompiled .= '
		' . $__templater->callMacro('metadata_macros', 'site_name', array(
			'siteName' => $__vars['siteName'],
			'output' => true,
		), $__vars) . '
	';
	}
	$__finalCompiled .= '
	';
	if (!$__vars['head']['meta_type']) {
		$__finalCompiled .= '
		' . $__templater->callMacro('metadata_macros', 'type', array(
			'type' => 'website',
			'output' => true,
		), $__vars) . '
	';
	}
	$__finalCompiled .= '
	';
	if (!$__vars['head']['meta_title']) {
		$__finalCompiled .= '
		' . $__templater->callMacro('metadata_macros', 'title', array(
			'title' => ($__templater->func('page_title', array(), false) ?: $__vars['siteName']),
			'output' => true,
		), $__vars) . '
	';
	}
	$__finalCompiled .= '
	';
	if ((!$__vars['head']['meta_description']) AND (!$__templater->test($__vars['description'], 'empty', array()) AND $__vars['pageDescriptionMeta'])) {
		$__finalCompiled .= '
		' . $__templater->callMacro('metadata_macros', 'description', array(
			'description' => $__vars['description'],
			'output' => true,
		), $__vars) . '
	';
	}
	$__finalCompiled .= '
	';
	if (!$__vars['head']['meta_share_url']) {
		$__finalCompiled .= '
		' . $__templater->callMacro('metadata_macros', 'share_url', array(
			'shareUrl' => $__vars['xf']['fullUri'],
			'output' => true,
		), $__vars) . '
	';
	}
	$__finalCompiled .= '
	';
	if ((!$__vars['head']['meta_image_url']) AND $__templater->func('property', array('publicMetadataLogoUrl', ), false)) {
		$__finalCompiled .= '
		' . $__templater->callMacro('metadata_macros', 'image_url', array(
			'imageUrl' => $__templater->func('base_url', array($__templater->func('property', array('publicMetadataLogoUrl', ), false), true, ), false),
			'output' => true,
		), $__vars) . '
	';
	}
	$__finalCompiled .= '

	' . $__templater->callMacro('helper_js_global', 'head', array(
		'app' => 'public',
	), $__vars) . '

	';
	if ($__templater->func('property', array('publicFaviconUrl', ), false)) {
		$__finalCompiled .= '
		<link rel="icon" type="image/png" href="' . $__templater->func('base_url', array($__templater->func('property', array('publicFaviconUrl', ), false), true, ), true) . '" sizes="32x32" />
	';
	}
	$__finalCompiled .= '
	' . $__templater->includeTemplate('google_analytics', $__vars) . '
</head>
<body data-template="' . $__templater->escape($__vars['template']) . '">

<div class="p-pageWrapper" id="top">

';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
				';
	if ($__vars['xf']['visitor']['is_moderator'] AND $__vars['xf']['session']['unapprovedCounts']['total']) {
		$__compilerTemp1 .= '
					<a href="' . $__templater->func('link', array('approval-queue', ), true) . '" class="p-staffBar-link badgeContainer badgeContainer--highlighted" data-badge="' . $__templater->filter($__vars['xf']['session']['unapprovedCounts']['total'], array(array('number', array()),), true) . '">
						' . 'Approval queue' . '
					</a>
				';
	}
	$__compilerTemp1 .= '

				';
	if ($__vars['xf']['visitor']['is_moderator'] AND ((!$__vars['xf']['options']['reportIntoForumId']) AND $__vars['xf']['session']['reportCounts']['total'])) {
		$__compilerTemp1 .= '
					<a href="' . $__templater->func('link', array('reports', ), true) . '"
						class="p-staffBar-link badgeContainer badgeContainer--visible ' . (((($__vars['xf']['session']['reportCounts']['total'] AND (($__vars['xf']['session']['reportCounts']['lastBuilt'] > $__vars['xf']['session']['reportLastRead']))) OR $__vars['xf']['session']['reportCounts']['assigned'])) ? ' badgeContainer--highlighted' : '') . '"
						data-badge="' . ($__vars['xf']['session']['reportCounts']['assigned'] ? (($__templater->filter($__vars['xf']['session']['reportCounts']['assigned'], array(array('number', array()),), true) . ' / ') . $__templater->filter($__vars['xf']['session']['reportCounts']['total'], array(array('number', array()),), true)) : $__templater->filter($__vars['xf']['session']['reportCounts']['total'], array(array('number', array()),), true)) . '"
						title="' . ($__vars['xf']['session']['reportCounts']['lastBuilt'] ? (($__templater->filter('Last report update' . $__vars['xf']['language']['label_separator'], array(array('for_attr', array()),), true) . ' ') . $__templater->func('date_time', array($__vars['xf']['session']['reportCounts']['lastBuilt'], ), true)) : '') . '">
						' . 'Reports' . '
					</a>
				';
	}
	$__compilerTemp1 .= '

				';
	$__compilerTemp2 = '';
	$__compilerTemp2 .= '
							' . '
							';
	if ($__vars['xf']['visitor']['is_moderator']) {
		$__compilerTemp2 .= '
								<a href="' . $__templater->func('link', array('approval-queue', ), true) . '" class="menu-linkRow">' . 'Approval queue' . '</a>
							';
	}
	$__compilerTemp2 .= '
							';
	if ($__vars['xf']['visitor']['is_moderator'] AND (!$__vars['xf']['options']['reportIntoForumId'])) {
		$__compilerTemp2 .= '
								<a href="' . $__templater->func('link', array('reports', ), true) . '" class="menu-linkRow" title="' . ($__vars['xf']['session']['reportCounts']['lastBuilt'] ? (($__templater->filter('Last report update' . $__vars['xf']['language']['label_separator'], array(array('for_attr', array()),), true) . ' ') . $__templater->func('date_time', array($__vars['xf']['session']['reportCounts']['lastBuilt'], ), true)) : '') . '">' . 'Reports' . '</a>
							';
	}
	$__compilerTemp2 .= '
							' . '
							';
	if (strlen(trim($__compilerTemp2)) > 0) {
		$__compilerTemp1 .= '
					<a class="p-staffBar-link menuTrigger" data-xf-click="menu" data-xf-key="alt+m" role="button" tabindex="0" aria-expanded="false" aria-haspopup="true">' . 'Moderator' . '</a>
					<div class="menu" data-menu="menu" aria-hidden="true">
						<div class="menu-content">
							<h4 class="menu-header">' . 'Moderator tools' . '</h4>
							' . $__compilerTemp2 . '
						</div>
					</div>
				';
	}
	$__compilerTemp1 .= '

				';
	if ($__vars['xf']['visitor']['is_admin']) {
		$__compilerTemp1 .= '
					<a href="' . $__templater->func('base_url', array('admin.php', ), true) . '" class="p-staffBar-link" target="_blank">' . 'Admin' . '</a>
				';
	}
	$__compilerTemp1 .= '
			';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
	<div class="p-staffBar">
		<div class="p-staffBar-inner hScroller" data-xf-init="h-scroller">
			<div class="hScroller-scroll">
			' . $__compilerTemp1 . '
			</div>
		</div>
	</div>
';
	}
	$__finalCompiled .= '

';
	$__vars['srcset'] = $__templater->preEscaped(($__templater->func('property', array('publicLogoUrl2x', ), false) ? ($__templater->func('base_url', array($__templater->func('property', array('publicLogoUrl2x', ), false), ), true) . ' 2x') : ''));
	$__finalCompiled .= '

<header class="p-header" id="header">
	<div class="p-header-inner">
		<div class="p-header-content">

			<div class="p-header-logo p-header-logo--image">
				<a href="' . ((($__vars['xf']['options']['logoLink'] AND $__vars['xf']['homePageUrl'])) ? $__templater->escape($__vars['xf']['homePageUrl']) : $__templater->func('link', array('index', ), true)) . '">
					<img src="' . $__templater->func('base_url', array($__templater->func('property', array('publicLogoUrl', ), false), ), true) . '" srcset="' . $__templater->escape($__vars['srcset']) . '" alt="' . $__templater->escape($__vars['xf']['options']['boardTitle']) . '"
						width="' . ($__templater->func('property', array('publicLogoWidth', ), true) ?: '') . '" height="' . ($__templater->func('property', array('publicLogoHeight', ), true) ?: '') . '" />
				</a>
			</div>

			' . $__templater->callAdsMacro('container_header', array(), $__vars) . '
		</div>
	</div>
</header>

';
	$__compilerTemp3 = '';
	$__vars['i'] = 0;
	if ($__templater->isTraversable($__vars['navTree'])) {
		foreach ($__vars['navTree'] AS $__vars['navSection'] => $__vars['navEntry']) {
			if (($__vars['navSection'] != $__vars['xf']['app']['defaultNavigationId'])) {
				$__vars['i']++;
				$__compilerTemp3 .= '
						<li>
							' . $__templater->callMacro(null, 'nav_entry', array(
					'navId' => $__vars['navSection'],
					'nav' => $__vars['navEntry'],
					'selected' => ($__vars['navSection'] == $__vars['pageSection']),
					'shortcut' => $__vars['i'],
				), $__vars) . '
						</li>
					';
			}
		}
	}
	$__compilerTemp4 = '';
	if ($__vars['xf']['visitor']['user_id']) {
		$__compilerTemp4 .= '
						';
		if (($__vars['xf']['visitor']['user_state'] == 'rejected') OR ($__vars['xf']['visitor']['user_state'] == 'disabled')) {
			$__compilerTemp4 .= '
							<a href="' . $__templater->func('link', array('account', ), true) . '"
								class="p-navgroup-link p-navgroup-link--iconic p-navgroup-link--user">
								' . $__templater->func('avatar', array($__vars['xf']['visitor'], 'xxs', false, array(
				'href' => '',
				'title' => '',
			))) . '
								<span class="p-navgroup-linkText">' . $__templater->escape($__vars['xf']['visitor']['username']) . '</span>
							</a>

							<a href="' . $__templater->func('link', array('logout', null, array('t' => $__templater->func('csrf_token', array(), false), ), ), true) . '" class="p-navgroup-link">
								<span class="p-navgroup-linkText">' . 'Log out' . '</span>
							</a>
						';
		} else {
			$__compilerTemp4 .= '
							<a href="' . $__templater->func('link', array('account', ), true) . '"
								class="p-navgroup-link p-navgroup-link--iconic p-navgroup-link--user"
								data-xf-click="menu"
								data-xf-key="' . $__templater->filter('m', array(array('for_attr', array()),), true) . '"
								data-menu-pos-ref="< .p-navgroup"
								title="' . $__templater->escape($__vars['xf']['visitor']['username']) . '"
								aria-expanded="false"
								aria-haspopup="true">
								' . $__templater->func('avatar', array($__vars['xf']['visitor'], 'xxs', false, array(
				'href' => '',
				'title' => '',
			))) . '
								<span class="p-navgroup-linkText">' . $__templater->escape($__vars['xf']['visitor']['username']) . '</span>
							</a>
							<div class="menu menu--structural menu--wide menu--account" data-menu="menu" aria-hidden="true"
								data-href="' . $__templater->func('link', array('account/visitor-menu', ), true) . '"
								data-load-target=".js-visitorMenuBody">
								<div class="menu-content js-visitorMenuBody">
									<div class="menu-row">
										' . 'Loading' . $__vars['xf']['language']['ellipsis'] . '
									</div>
								</div>
							</div>

							<a href="' . $__templater->func('link', array('conversations', ), true) . '"
								class="p-navgroup-link p-navgroup-link--iconic p-navgroup-link--conversations js-badge--conversations badgeContainer' . ($__vars['xf']['visitor']['conversations_unread'] ? ' badgeContainer--highlighted' : '') . '"
								data-badge="' . $__templater->filter($__vars['xf']['visitor']['conversations_unread'], array(array('number', array()),), true) . '"
								data-xf-click="menu"
								data-xf-key="' . $__templater->filter(',', array(array('for_attr', array()),), true) . '"
								data-menu-pos-ref="< .p-navgroup"
								title="' . $__templater->filter('Conversations', array(array('for_attr', array()),), true) . '"
								aria-label="' . $__templater->filter('Conversations', array(array('for_attr', array()),), true) . '"
								aria-expanded="false"
								aria-haspopup="true">
								<i aria-hidden="true"></i>
								<span class="p-navgroup-linkText">' . '' . '</span>
							</a>
							<div class="menu menu--structural menu--medium" data-menu="menu" aria-hidden="true"
								data-href="' . $__templater->func('link', array('conversations/popup', ), true) . '"
								data-nocache="true"
								data-load-target=".js-convMenuBody">
								<div class="menu-content">
									<h3 class="menu-header">' . 'Conversations' . '</h3>
									<div class="js-convMenuBody">
										<div class="menu-row">' . 'Loading' . $__vars['xf']['language']['ellipsis'] . '</div>
									</div>
									<div class="menu-footer menu-footer--split">
										<div class="menu-footer-main">
											<ul class="listInline listInline--bullet">
												<li><a href="' . $__templater->func('link', array('conversations', ), true) . '">' . 'Show all' . '</a></li>
												';
			if ($__templater->method($__vars['xf']['visitor'], 'canStartConversation', array())) {
				$__compilerTemp4 .= '
													<li><a href="' . $__templater->func('link', array('conversations/add', ), true) . '">' . 'Start a new conversation' . '</a></li>
												';
			}
			$__compilerTemp4 .= '
											</ul>
										</div>
									</div>
								</div>
							</div>

							<a href="' . $__templater->func('link', array('account/alerts', ), true) . '"
								class="p-navgroup-link p-navgroup-link--iconic p-navgroup-link--alerts js-badge--alerts badgeContainer' . ($__vars['xf']['visitor']['alerts_unviewed'] ? ' badgeContainer--highlighted' : '') . '"
								data-badge="' . $__templater->filter($__vars['xf']['visitor']['alerts_unviewed'], array(array('number', array()),), true) . '"
								data-xf-click="menu"
								data-xf-key="' . $__templater->filter('.', array(array('for_attr', array()),), true) . '"
								data-menu-pos-ref="< .p-navgroup"
								title="' . $__templater->filter('Alerts', array(array('for_attr', array()),), true) . '"
								aria-label="' . $__templater->filter('Alerts', array(array('for_attr', array()),), true) . '"
								aria-expanded="false"
								aria-haspopup="true">
								<i aria-hidden="true"></i>
								<span class="p-navgroup-linkText">' . '' . '</span>
							</a>
							<div class="menu menu--structural menu--medium" data-menu="menu" aria-hidden="true"
								data-href="' . $__templater->func('link', array('account/alerts-popup', ), true) . '"
								data-nocache="true"
								data-load-target=".js-alertsMenuBody">
								<div class="menu-content">
									<h3 class="menu-header">' . 'Alerts' . '</h3>
									<div class="js-alertsMenuBody">
										<div class="menu-row">' . 'Loading' . $__vars['xf']['language']['ellipsis'] . '</div>
									</div>
									<div class="menu-footer menu-footer--split">
										<div class="menu-footer-main">
											<ul class="listInline listInline--bullet">
												<li><a href="' . $__templater->func('link', array('account/alerts', ), true) . '">' . 'Show all' . '</a></li>
												<li><a href="' . $__templater->func('link', array('account/alerts/mark-read', ), true) . '" class="js-alertsMarkRead">' . 'Mark read' . '</a></li>
												<li><a href="' . $__templater->func('link', array('account/preferences', ), true) . '">' . 'Preferences' . '</a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						';
		}
		$__compilerTemp4 .= '
					';
	} else {
		$__compilerTemp4 .= '
						<a href="' . $__templater->func('link', array('login', ), true) . '" class="p-navgroup-link p-navgroup-link--textual p-navgroup-link--logIn"
							data-xf-click="overlay" data-follow-redirects="on">
							<span class="p-navgroup-linkText">' . 'Log in' . '</span>
						</a>
						';
		if ($__vars['xf']['options']['registrationSetup']['enabled']) {
			$__compilerTemp4 .= '
							<a href="' . $__templater->func('link', array('register', ), true) . '" class="p-navgroup-link p-navgroup-link--textual p-navgroup-link--register"
								data-xf-click="overlay" data-follow-redirects="on">
								<span class="p-navgroup-linkText">' . 'Register' . '</span>
							</a>
						';
		}
		$__compilerTemp4 .= '
					';
	}
	$__compilerTemp5 = '';
	if ($__templater->method($__vars['xf']['visitor'], 'canSearch', array())) {
		$__compilerTemp5 .= '
						<a href="' . $__templater->func('link', array('search', ), true) . '"
							class="p-navgroup-link p-navgroup-link--iconic p-navgroup-link--search"
							data-xf-click="menu"
							data-xf-key="' . $__templater->filter('/', array(array('for_attr', array()),), true) . '"
							aria-label="' . $__templater->filter('Search', array(array('for_attr', array()),), true) . '"
							aria-expanded="false"
							aria-haspopup="true"
							title="' . $__templater->filter('Search', array(array('for_attr', array()),), true) . '">
							<i aria-hidden="true"></i>
							<span class="p-navgroup-linkText">' . 'Search' . '</span>
						</a>
						<div class="menu menu--structural menu--wide" data-menu="menu" aria-hidden="true">
							<form action="' . $__templater->func('link', array('search/search', ), true) . '" method="post"
								class="menu-content"
								data-xf-init="quick-search">

								<h3 class="menu-header">' . 'Search' . '</h3>
								' . '
								<div class="menu-row">
									';
		if ($__vars['searchConstraints']) {
			$__compilerTemp5 .= '
										<div class="inputGroup inputGroup--joined">
											' . $__templater->formTextBox(array(
				'name' => 'keywords',
				'placeholder' => 'Search' . $__vars['xf']['language']['ellipsis'],
				'aria-label' => 'Search',
				'data-menu-autofocus' => 'true',
			)) . '
											';
			$__compilerTemp6 = array(array(
				'value' => '',
				'label' => 'Everywhere',
				'_type' => 'option',
			));
			if ($__templater->isTraversable($__vars['searchConstraints'])) {
				foreach ($__vars['searchConstraints'] AS $__vars['constraintName'] => $__vars['constraint']) {
					$__compilerTemp6[] = array(
						'value' => $__templater->filter($__vars['constraint'], array(array('json', array()),), false),
						'label' => $__templater->escape($__vars['constraintName']),
						'_type' => 'option',
					);
				}
			}
			$__compilerTemp5 .= $__templater->formSelect(array(
				'name' => 'constraints',
				'class' => 'js-quickSearch-constraint',
				'aria-label' => 'Search within',
			), $__compilerTemp6) . '
										</div>
									';
		} else {
			$__compilerTemp5 .= '
										' . $__templater->formTextBox(array(
				'name' => 'keywords',
				'placeholder' => 'Search' . $__vars['xf']['language']['ellipsis'],
				'aria-label' => 'Search',
				'data-menu-autofocus' => 'true',
			)) . '
									';
		}
		$__compilerTemp5 .= '
								</div>

								' . '
								<div class="menu-row">
									';
		$__compilerTemp7 = '';
		if ($__vars['xf']['options']['enableTagging']) {
			$__compilerTemp7 .= '
													<span tabindex="0" role="button"
														data-xf-init="tooltip" data-trigger="hover focus click" title="' . $__templater->filter('Tags will also be searched in content where tags are supported', array(array('for_attr', array()),), true) . '">

														' . $__templater->fontAwesome('far fa-question-circle', array(
				'class' => 'u-muted u-smaller',
			)) . '
													</span>
												';
		}
		$__compilerTemp5 .= $__templater->formCheckBox(array(
			'standalone' => 'true',
		), array(array(
			'name' => 'c[title_only]',
			'label' => '
												' . 'Search titles only' . '

												' . $__compilerTemp7 . '
											',
			'_type' => 'option',
		))) . '
								</div>
								' . '
								<div class="menu-row">
									<div class="inputGroup">
										<span class="inputGroup-text" id="ctrl_search_menu_by_member">' . 'By' . $__vars['xf']['language']['label_separator'] . '</span>
										<input type="text" class="input" name="c[users]" data-xf-init="auto-complete" placeholder="' . 'Member' . '" aria-labelledby="ctrl_search_menu_by_member" />
									</div>
								</div>
								<div class="menu-footer">
									<span class="menu-footer-controls">
										' . $__templater->button('', array(
			'type' => 'submit',
			'class' => 'button--primary',
			'icon' => 'search',
		), '', array(
		)) . '
										' . $__templater->button('Advanced search' . $__vars['xf']['language']['ellipsis'], array(
			'href' => $__templater->func('link', array('search', ), false),
		), '', array(
		)) . '
									</span>
								</div>

								' . $__templater->func('csrf_input') . '
							</form>
						</div>
					';
	}
	$__vars['navHtml'] = $__templater->preEscaped('
	<nav class="p-nav">
		<div class="p-nav-inner">
			' . $__templater->button('
				<i aria-hidden="true"></i>
			', array(
		'class' => 'button--plain p-nav-menuTrigger',
		'data-xf-click' => 'off-canvas',
		'data-menu' => '.js-headerOffCanvasMenu',
		'tabindex' => '0',
		'aria-label' => $__templater->filter('Menu', array(array('for_attr', array()),), false),
	), '', array(
	)) . '

			<div class="p-nav-smallLogo">
				<a href="' . ((($__vars['xf']['options']['logoLink'] AND $__vars['xf']['homePageUrl'])) ? $__templater->escape($__vars['xf']['homePageUrl']) : $__templater->func('link', array('index', ), true)) . '">
					<img src="' . $__templater->func('base_url', array($__templater->func('property', array('publicLogoUrl', ), false), ), true) . '" srcset="' . $__templater->escape($__vars['srcset']) . '" alt="' . $__templater->escape($__vars['xf']['options']['boardTitle']) . '"
						width="' . ($__templater->func('property', array('publicLogoWidth', ), true) ?: '') . '" height="' . ($__templater->func('property', array('publicLogoHeight', ), true) ?: '') . '" />
				</a>
			</div>

			<div class="p-nav-scroller hScroller" data-xf-init="h-scroller" data-auto-scroll=".p-navEl.is-selected">
				<div class="hScroller-scroll">
					<ul class="p-nav-list js-offCanvasNavSource">
					' . $__compilerTemp3 . '
					</ul>
				</div>
			</div>

			<div class="p-nav-opposite">
				<div class="p-navgroup p-account ' . ($__vars['xf']['visitor']['user_id'] ? 'p-navgroup--member' : 'p-navgroup--guest') . '">
					' . $__compilerTemp4 . '
				</div>

				<div class="p-navgroup p-discovery' . ((!$__templater->method($__vars['xf']['visitor'], 'canSearch', array())) ? ' p-discovery--noSearch' : '') . '">
					<a href="' . $__templater->func('link', array('whats-new', ), true) . '"
						class="p-navgroup-link p-navgroup-link--iconic p-navgroup-link--whatsnew"
						aria-label="' . $__templater->filter('What\'s new', array(array('for_attr', array()),), true) . '"
						title="' . $__templater->filter('What\'s new', array(array('for_attr', array()),), true) . '">
						<i aria-hidden="true"></i>
						<span class="p-navgroup-linkText">' . 'What\'s new' . '</span>
					</a>

					' . $__compilerTemp5 . '
				</div>
			</div>
		</div>
	</nav>
');
	$__finalCompiled .= '
';
	$__compilerTemp8 = '';
	if (!$__templater->test($__vars['selectedNavChildren'], 'empty', array())) {
		$__compilerTemp8 .= '
		<div class="p-sectionLinks">
			<div class="p-sectionLinks-inner hScroller" data-xf-init="h-scroller">
				<div class="hScroller-scroll">
					<ul class="p-sectionLinks-list">
					';
		$__vars['i'] = 0;
		if ($__templater->isTraversable($__vars['selectedNavChildren'])) {
			foreach ($__vars['selectedNavChildren'] AS $__vars['navId'] => $__vars['navEntry']) {
				$__vars['i']++;
				$__compilerTemp8 .= '
						<li>
							' . $__templater->callMacro(null, 'nav_entry', array(
					'navId' => $__vars['navId'],
					'nav' => $__vars['navEntry'],
					'shortcut' => 'alt+' . $__vars['i'],
				), $__vars) . '
						</li>
					';
			}
		}
		$__compilerTemp8 .= '
					</ul>
				</div>
			</div>
		</div>
	';
	} else if ($__vars['selectedNavEntry']) {
		$__compilerTemp8 .= '
		<div class="p-sectionLinks p-sectionLinks--empty"></div>
	';
	}
	$__vars['subNavHtml'] = $__templater->preEscaped('
	' . $__compilerTemp8 . '
');
	$__finalCompiled .= '

';
	if ($__templater->func('property', array('publicNavSticky', ), false) == 'primary') {
		$__finalCompiled .= '
	<div class="p-navSticky p-navSticky--primary" data-xf-init="sticky-header">
		' . $__templater->filter($__vars['navHtml'], array(array('raw', array()),), true) . '
	</div>
	' . $__templater->filter($__vars['subNavHtml'], array(array('raw', array()),), true) . '
';
	} else if ($__templater->func('property', array('publicNavSticky', ), false) == 'all') {
		$__finalCompiled .= '
	<div class="p-navSticky p-navSticky--all" data-xf-init="sticky-header">
		' . $__templater->filter($__vars['navHtml'], array(array('raw', array()),), true) . '
		' . $__templater->filter($__vars['subNavHtml'], array(array('raw', array()),), true) . '
	</div>
';
	} else {
		$__finalCompiled .= '
	' . $__templater->filter($__vars['navHtml'], array(array('raw', array()),), true) . '
	' . $__templater->filter($__vars['subNavHtml'], array(array('raw', array()),), true) . '
';
	}
	$__finalCompiled .= '

<div class="offCanvasMenu offCanvasMenu--nav js-headerOffCanvasMenu" data-menu="menu" aria-hidden="true" data-ocm-builder="navigation">
	<div class="offCanvasMenu-backdrop" data-menu-close="true"></div>
	<div class="offCanvasMenu-content">
		<div class="offCanvasMenu-header">
			' . 'Menu' . '
			<a class="offCanvasMenu-closer" data-menu-close="true" role="button" tabindex="0" aria-label="' . $__templater->filter('Close', array(array('for_attr', array()),), true) . '"></a>
		</div>
		';
	if ($__vars['xf']['visitor']['user_id']) {
		$__finalCompiled .= '
			<div class="p-offCanvasAccountLink">
				<div class="offCanvasMenu-linkHolder">
					<a href="' . $__templater->func('link', array('account', ), true) . '" class="offCanvasMenu-link">
						' . $__templater->func('avatar', array($__vars['xf']['visitor'], 'xxs', false, array(
			'href' => '',
		))) . '
						' . $__templater->escape($__vars['xf']['visitor']['username']) . '
					</a>
				</div>
				<hr class="offCanvasMenu-separator" />
			</div>
		';
	} else {
		$__finalCompiled .= '
			<div class="p-offCanvasRegisterLink">
				<div class="offCanvasMenu-linkHolder">
					<a href="' . $__templater->func('link', array('login', ), true) . '" class="offCanvasMenu-link" data-xf-click="overlay" data-menu-close="true">
						' . 'Log in' . '
					</a>
				</div>
				<hr class="offCanvasMenu-separator" />
				';
		if ($__vars['xf']['options']['registrationSetup']['enabled']) {
			$__finalCompiled .= '
					<div class="offCanvasMenu-linkHolder">
						<a href="' . $__templater->func('link', array('register', ), true) . '" class="offCanvasMenu-link" data-xf-click="overlay" data-menu-close="true">
							' . 'Register' . '
						</a>
					</div>
					<hr class="offCanvasMenu-separator" />
				';
		}
		$__finalCompiled .= '
			</div>
		';
	}
	$__finalCompiled .= '
		<div class="js-offCanvasNavTarget"></div>
		<div class="offCanvasMenu-installBanner js-installPromptContainer" style="display: none;" data-xf-init="install-prompt">
			<div class="offCanvasMenu-installBanner-header">' . 'Install the app' . '</div>
			' . $__templater->button('Install', array(
		'class' => 'js-installPromptButton',
	), '', array(
	)) . '
			<template class="js-installTemplateIOS">
				<div class="overlay-title">' . 'How to install the app on iOS' . '</div>
				<div class="block-body">
					<div class="block-row">
						<p>
							' . 'Follow along with the video below to see how to install our site as a web app on your home screen.' . '
						</p>
						<p style="text-align: center">
							<img src="' . $__templater->func('base_url', array('styles/default/xenforo/add_to_home.gif', ), true) . '" width="222" height="480" />
						</p>
						<p>
							<small><strong>' . 'Note' . $__vars['xf']['language']['label_separator'] . '</strong> ' . 'This feature currently requires accessing the site using the built-in Safari browser.' . '</small>
						</p>
					</div>
				</div>
			</template>
		</div>
	</div>
</div>

<div class="p-body">
	<div class="p-body-inner">
		<!--XF:EXTRA_OUTPUT-->

		';
	if ($__vars['notices']['block']) {
		$__finalCompiled .= '
			' . $__templater->callMacro('notice_macros', 'notice_list', array(
			'type' => 'block',
			'notices' => $__vars['notices']['block'],
		), $__vars) . '
		';
	}
	$__finalCompiled .= '

		';
	if ($__vars['notices']['scrolling']) {
		$__finalCompiled .= '
			' . $__templater->callMacro('notice_macros', 'notice_list', array(
			'type' => 'scrolling',
			'notices' => $__vars['notices']['scrolling'],
		), $__vars) . '
		';
	}
	$__finalCompiled .= '

		' . $__templater->callAdsMacro('container_breadcrumb_top_above', array(), $__vars) . '
		' . $__templater->callMacro(null, 'breadcrumbs', array(
		'breadcrumbs' => $__vars['breadcrumbs'],
		'navTree' => $__vars['navTree'],
		'selectedNavEntry' => $__vars['selectedNavEntry'],
	), $__vars) . '
		' . $__templater->callAdsMacro('container_breadcrumb_top_below', array(), $__vars) . '

		' . $__templater->callMacro('browser_warning_macros', 'javascript', array(), $__vars) . '
		' . $__templater->callMacro('browser_warning_macros', 'browser', array(), $__vars) . '

		';
	$__compilerTemp9 = '';
	$__compilerTemp9 .= '
				';
	$__compilerTemp10 = '';
	$__compilerTemp10 .= '
						';
	if (!$__vars['noH1']) {
		$__compilerTemp10 .= '
							<h1 class="p-title-value">' . $__templater->escape($__vars['h1']) . '</h1>
						';
	}
	$__compilerTemp10 .= '
						';
	$__compilerTemp11 = '';
	$__compilerTemp11 .= (isset($__templater->pageParams['pageAction']) ? $__templater->pageParams['pageAction'] : '');
	if (strlen(trim($__compilerTemp11)) > 0) {
		$__compilerTemp10 .= '
							<div class="p-title-pageAction">' . $__compilerTemp11 . '</div>
						';
	}
	$__compilerTemp10 .= '
					';
	if (strlen(trim($__compilerTemp10)) > 0) {
		$__compilerTemp9 .= '
					<div class="p-title ' . ($__vars['noH1'] ? 'p-title--noH1' : '') . '">
					' . $__compilerTemp10 . '
					</div>
				';
	}
	$__compilerTemp9 .= '

				';
	if (!$__templater->test($__vars['description'], 'empty', array())) {
		$__compilerTemp9 .= '
					<div class="p-description">' . $__templater->escape($__vars['description']) . '</div>
				';
	}
	$__compilerTemp9 .= '
			';
	if (!$__templater->test($__vars['headerHtml'], 'empty', array())) {
		$__finalCompiled .= '
			<div class="p-body-header">
				' . $__templater->filter($__vars['headerHtml'], array(array('raw', array()),), true) . '
			</div>
		';
	} else if (strlen(trim($__compilerTemp9)) > 0) {
		$__finalCompiled .= '
			<div class="p-body-header">
			' . $__compilerTemp9 . '
			</div>
		';
	}
	$__finalCompiled .= '

		<div class="p-body-main ' . ($__vars['sidebar'] ? 'p-body-main--withSidebar' : '') . ' ' . ($__vars['sideNav'] ? 'p-body-main--withSideNav' : '') . '">
			';
	if ($__vars['sideNav']) {
		$__finalCompiled .= '
				<div class="p-body-sideNavCol"></div>
			';
	}
	$__finalCompiled .= '
			<div class="p-body-contentCol"></div>
			';
	if ($__vars['sidebar']) {
		$__finalCompiled .= '
				<div class="p-body-sidebarCol"></div>
			';
	}
	$__finalCompiled .= '

			';
	if ($__vars['sideNav']) {
		$__finalCompiled .= '
				<div class="p-body-sideNav">
					<div class="p-body-sideNavTrigger">
						' . $__templater->button('
							' . ($__templater->escape($__vars['sideNavTitle']) ?: 'Navigation') . '
						', array(
			'class' => 'button--link',
			'data-xf-click' => 'off-canvas',
			'data-menu' => '#js-SideNavOcm',
		), '', array(
		)) . '
					</div>
					<div class="p-body-sideNavInner" data-ocm-class="offCanvasMenu offCanvasMenu--blocks" id="js-SideNavOcm" data-ocm-builder="sideNav">
						<div data-ocm-class="offCanvasMenu-backdrop" data-menu-close="true"></div>
						<div data-ocm-class="offCanvasMenu-content">
							<div class="p-body-sideNavContent">
								' . $__templater->callAdsMacro('container_sidenav_above', array(), $__vars) . '
								';
		if ($__templater->isTraversable($__vars['sideNav'])) {
			foreach ($__vars['sideNav'] AS $__vars['sideNavHtml']) {
				$__finalCompiled .= '
									' . $__templater->escape($__vars['sideNavHtml']) . '
								';
			}
		}
		$__finalCompiled .= '
								' . $__templater->callAdsMacro('container_sidenav_below', array(), $__vars) . '
							</div>
						</div>
					</div>
				</div>
			';
	}
	$__finalCompiled .= '

			<div class="p-body-content">
				' . $__templater->callAdsMacro('container_content_above', array(), $__vars) . '
				<div class="p-body-pageContent">' . $__templater->filter($__vars['content'], array(array('raw', array()),), true) . '</div>
				' . $__templater->callAdsMacro('container_content_below', array(), $__vars) . '
			</div>

			';
	if ($__vars['sidebar']) {
		$__finalCompiled .= '
				<div class="p-body-sidebar">
					' . $__templater->callAdsMacro('container_sidebar_above', array(), $__vars) . '
					';
		if ($__templater->isTraversable($__vars['sidebar'])) {
			foreach ($__vars['sidebar'] AS $__vars['sidebarHtml']) {
				$__finalCompiled .= '
						' . $__templater->escape($__vars['sidebarHtml']) . '
					';
			}
		}
		$__finalCompiled .= '
					' . $__templater->callAdsMacro('container_sidebar_below', array(), $__vars) . '
				</div>
			';
	}
	$__finalCompiled .= '
		</div>

		' . $__templater->callAdsMacro('container_breadcrumb_bottom_above', array(), $__vars) . '
		' . $__templater->callMacro(null, 'breadcrumbs', array(
		'breadcrumbs' => $__vars['breadcrumbs'],
		'navTree' => $__vars['navTree'],
		'selectedNavEntry' => $__vars['selectedNavEntry'],
		'variant' => 'bottom',
	), $__vars) . '
		' . $__templater->callAdsMacro('container_breadcrumb_bottom_below', array(), $__vars) . '
	</div>
</div>

<footer class="p-footer" id="footer">
	<div class="p-footer-inner">

		<div class="p-footer-row">
			';
	$__compilerTemp12 = '';
	$__compilerTemp12 .= '
						';
	if ($__templater->method($__vars['xf']['cookieConsent'], 'getMode', array()) == 'advanced') {
		$__compilerTemp12 .= '
							<li><a href="' . $__templater->func('link', array('misc/cookies', ), true) . '" rel="nofollow"
								data-xf-init="tooltip" title="' . $__templater->filter('Cookie consent', array(array('for_attr', array()),), true) . '"
								data-xf-click="cookie-consent-toggle">
								' . $__templater->fontAwesome('fa-cookie', array(
		)) . ' ' . 'Cookies' . '
							</a></li>
						';
	}
	$__compilerTemp12 .= '
						';
	if ($__templater->method($__vars['xf']['visitor'], 'canChangeStyle', array())) {
		$__compilerTemp12 .= '
							<li><a href="' . $__templater->func('link', array('misc/style', ), true) . '" data-xf-click="overlay"
								data-xf-init="tooltip" title="' . $__templater->filter('Style chooser', array(array('for_attr', array()),), true) . '" rel="nofollow">
								' . $__templater->fontAwesome('fa-paint-brush', array(
		)) . ' ' . $__templater->escape($__vars['xf']['style']['title']) . '
							</a></li>
						';
	}
	$__compilerTemp12 .= '
						';
	if ($__templater->method($__vars['xf']['visitor'], 'canChangeLanguage', array())) {
		$__compilerTemp12 .= '
							<li><a href="' . $__templater->func('link', array('misc/language', ), true) . '" data-xf-click="overlay"
								data-xf-init="tooltip" title="' . $__templater->filter('Language chooser', array(array('for_attr', array()),), true) . '" rel="nofollow">
								' . $__templater->fontAwesome('fa-globe', array(
		)) . ' ' . $__templater->escape($__vars['xf']['language']['title']) . '</a></li>
						';
	}
	$__compilerTemp12 .= '
					';
	if (strlen(trim($__compilerTemp12)) > 0) {
		$__finalCompiled .= '
				<div class="p-footer-row-main">
					<ul class="p-footer-linkList">
					' . $__compilerTemp12 . '
					</ul>
				</div>
			';
	}
	$__finalCompiled .= '
			<div class="p-footer-row-opposite">
				<ul class="p-footer-linkList">
					';
	if ($__templater->method($__vars['xf']['visitor'], 'canUseContactForm', array())) {
		$__finalCompiled .= '
						';
		if ($__vars['xf']['contactUrl']) {
			$__finalCompiled .= '
							<li><a href="' . $__templater->escape($__vars['xf']['contactUrl']) . '" data-xf-click="' . ((($__vars['xf']['options']['contactUrl']['overlay'] OR ($__vars['xf']['options']['contactUrl']['type'] == 'default'))) ? 'overlay' : '') . '">' . 'Contact us' . '</a></li>
						';
		}
		$__finalCompiled .= '
					';
	}
	$__finalCompiled .= '

					';
	if ($__vars['xf']['tosUrl']) {
		$__finalCompiled .= '
						<li><a href="' . $__templater->escape($__vars['xf']['tosUrl']) . '">' . 'Terms and rules' . '</a></li>
					';
	}
	$__finalCompiled .= '

					';
	if ($__vars['xf']['privacyPolicyUrl']) {
		$__finalCompiled .= '
						<li><a href="' . $__templater->escape($__vars['xf']['privacyPolicyUrl']) . '">' . 'Privacy policy' . '</a></li>
					';
	}
	$__finalCompiled .= '

					';
	if ($__vars['xf']['helpPageCount']) {
		$__finalCompiled .= '
						<li><a href="' . $__templater->func('link', array('help', ), true) . '">' . 'Help' . '</a></li>
					';
	}
	$__finalCompiled .= '

					';
	if ($__vars['xf']['homePageUrl']) {
		$__finalCompiled .= '
						<li><a href="' . $__templater->escape($__vars['xf']['homePageUrl']) . '">' . 'Home' . '</a></li>
					';
	}
	$__finalCompiled .= '

					<li><a href="' . $__templater->func('link', array('forums/index.rss', '-', ), true) . '" target="_blank" class="p-footer-rssLink" title="' . $__templater->filter('RSS', array(array('for_attr', array()),), true) . '"><span aria-hidden="true">' . $__templater->fontAwesome('fa-rss', array(
	)) . '<span class="u-srOnly">' . 'RSS' . '</span></span></a></li>
				</ul>
			</div>
		</div>

		';
	$__compilerTemp13 = '';
	$__compilerTemp13 .= '
				' . $__templater->func('copyright') . '
				' . '' . '
			';
	if (strlen(trim($__compilerTemp13)) > 0) {
		$__finalCompiled .= '
			<div class="p-footer-copyright">
			' . $__compilerTemp13 . '
			</div>
		';
	}
	$__finalCompiled .= '

		';
	$__compilerTemp14 = '';
	$__compilerTemp14 .= '
				' . $__templater->callMacro('debug_macros', 'debug', array(
		'controller' => $__vars['controller'],
		'action' => $__vars['actionMethod'],
		'template' => $__vars['template'],
	), $__vars) . '
			';
	if (strlen(trim($__compilerTemp14)) > 0) {
		$__finalCompiled .= '
			<div class="p-footer-debug">
			' . $__compilerTemp14 . '
			</div>
		';
	}
	$__finalCompiled .= '
	</div>
</footer>

</div> <!-- closing p-pageWrapper -->

<div class="u-bottomFixer js-bottomFixTarget">
	';
	if ($__vars['notices']['floating']) {
		$__finalCompiled .= '
		' . $__templater->callMacro('notice_macros', 'notice_list', array(
			'type' => 'floating',
			'notices' => $__vars['notices']['floating'],
		), $__vars) . '
	';
	}
	$__finalCompiled .= '
	';
	if ($__vars['notices']['bottom_fixer']) {
		$__finalCompiled .= '
		' . $__templater->callMacro('notice_macros', 'notice_list', array(
			'type' => 'bottom_fixer',
			'notices' => $__vars['notices']['bottom_fixer'],
		), $__vars) . '
	';
	}
	$__finalCompiled .= '
</div>

<div class="u-navButtons js-navButtons" data-trigger-type="' . $__templater->func('property', array('scrollJumpButtons', ), true) . '">
	' . $__templater->button($__templater->fontAwesome('fa-arrow-left', array(
	)) . '<span class="u-srOnly">' . 'Back' . '</span>', array(
		'href' => 'javascript:',
		'class' => 'button--scroll',
	), '', array(
	)) . '
</div>

';
	if ($__templater->func('property', array('scrollJumpButtons', ), false)) {
		$__finalCompiled .= '
	<div class="u-scrollButtons js-scrollButtons" data-trigger-type="' . $__templater->func('property', array('scrollJumpButtons', ), true) . '">
		' . $__templater->button($__templater->fontAwesome('fa-arrow-up', array(
		)) . '<span class="u-srOnly">' . 'Top' . '</span>', array(
			'href' => '#top',
			'class' => 'button--scroll',
			'data-xf-click' => 'scroll-to',
		), '', array(
		)) . '
		';
		if ($__templater->func('property', array('scrollJumpButtons', ), false) != 'up') {
			$__finalCompiled .= '
			' . $__templater->button($__templater->fontAwesome('fa-arrow-down', array(
			)) . '<span class="u-srOnly">' . 'Bottom' . '</span>', array(
				'href' => '#footer',
				'class' => 'button--scroll',
				'data-xf-click' => 'scroll-to',
			), '', array(
			)) . '
		';
		}
		$__finalCompiled .= '
	</div>
';
	}
	$__finalCompiled .= '

' . $__templater->callMacro('helper_js_global', 'body', array(
		'app' => 'public',
		'jsState' => $__vars['jsState'],
	), $__vars) . '

';
	if (($__templater->func('count', array($__vars['xf']['reactionsActive'], ), false) > 1) AND $__vars['xf']['visitor']['user_id']) {
		$__finalCompiled .= '
	<script type="text/template" id="xfReactTooltipTemplate">
		<div class="tooltip-content-inner">
			<div class="reactTooltip">
				';
		if ($__templater->isTraversable($__vars['xf']['reactionsActive'])) {
			foreach ($__vars['xf']['reactionsActive'] AS $__vars['reactionId'] => $__vars['reaction']) {
				$__finalCompiled .= '
					' . $__templater->func('reaction', array(array(
					'id' => $__vars['reactionId'],
					'tooltip' => 'true',
				))) . '
				';
			}
		}
		$__finalCompiled .= '
			</div>
		</div>
	</script>
';
	}
	$__finalCompiled .= '

' . $__templater->filter($__vars['ldJsonHtml'], array(array('raw', array()),), true) . '

</body>
</html>

' . '

' . '

' . '

' . '

';
	return $__finalCompiled;
}
);