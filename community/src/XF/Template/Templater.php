<?php

namespace XF\Template;

use XF\App;
use XF\Language;
use XF\Mvc\Entity\AbstractCollection;
use XF\Mvc\Entity\Entity;
use XF\Mvc\Router;
use XF\Util\Arr;

use function array_key_exists, array_slice, boolval, call_user_func, call_user_func_array, count, func_get_args, get_class, gettype, in_array, intval, is_array, is_int, is_integer, is_object, is_scalar, is_string, ord, strlen, strval;

class Templater
{
	const MAX_EXECUTION_DEPTH = 50;

	const TRANSPARENT_IMG_URI = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';

	/**
	 * @var App
	 */
	protected $app;

	/**
	 * @var Router
	 */
	protected $router;
	protected $routerType;

	/**
	 * @var \Closure
	 */
	protected $pather;

	protected $jsBaseUrl = 'js';

	/**
	 * @var Language
	 */
	protected $language;

	protected $compiledPath;

	protected $styleId = 0;

	/**
	 * @var callable|null
	 */
	protected $cssValidator;

	/**
	 * @var \XF\Style|null
	 */
	protected $style;

	protected $filters = [];
	protected $functions = [];
	protected $tests = [];

	protected $defaultParams = [];

	protected $templateCache = [];

	protected $jQueryVersion;
	protected $jQuerySource = 'local';
	protected $jsVersion = '';

	protected $dynamicDefaultAvatars = true;

	protected $mediaSites = [];

	protected $groupStyles = [];
	protected $userTitleLadder = [];
	protected $userTitleLadderField = 'trophy_points';
	protected $userBanners = [];
	protected $userBannerConfig = [];

	protected $widgetPositions = [];

	/**
	 * @var WatcherInterface[]
	 */
	protected $watchers = [];

	protected $currentTemplateType;
	protected $currentTemplateName;
	protected $currentMacroName;
	protected $currentExtensionName;

	/**
	 * @var ExtensionSet|null
	 */
	protected $currentExtensionSet;

	protected $isExtensionDummyRender = false;

	protected $wrapTemplateName = null;
	protected $wrapTemplateParams = null;

	protected $executionDepth = 0;
	protected $templateErrors = [];

	protected $escapeContext = 'html';

	protected $includeCss = [];
	protected $inlineCss = [];
	protected $includeJs = [];
	protected $inlineJs = [];

	protected $sidebar = [];
	protected $sideNav = [];

	protected $uniqueIdCounter = 0;
	protected $uniqueIdPrefix;
	protected $uniqueIdFormat = '_xfUid-%s';

	protected $avatarDefaultStylingCache = [];
	protected $avatarLetterRegex = '/[^\(\)\{\}\[\]\<\>\-\.\+\:\=\*\!\|\^\/\\\\\'`"_,#~ ]/u';

	public $pageParams = [];

	protected $defaultFilters = [
		'default'          => 'filterDefault',
		'censor'           => 'filterCensor',
		'count'            => 'filterCount',
		'currency'         => 'filterCurrency',
		'emoji'            => 'filterEmoji',
		'escape'           => 'filterEscape',
		'for_attr'         => 'filterForAttr',
		'file_size'        => 'filterFileSize',
		'first'            => 'filterFirst',
		'format'           => 'filterFormat',
		'hex'              => 'filterHex',
		'host'             => 'filterHost',
		'htmlspecialchars' => 'filterHtmlspecialchars',
		'ip'               => 'filterIp',
		'join'             => 'filterJoin',
		'json'             => 'filterJson',
		'last'             => 'filterLast',
		'nl2br'            => 'filterNl2Br',
		'nl2nl'            => 'filterNl2Nl',
		'number'           => 'filterNumber',
		'number_short'     => 'filterNumberShort',
		'numeric_keys_only' => 'filterNumericKeysOnly',
		'pad'              => 'filterPad',
		'parens'           => 'filterParens',
		'pluck'            => 'filterPluck',
		'preescaped'       => 'filterPreEscaped',
		'raw'              => 'filterRaw',
		'replace'          => 'filterReplace',
		'split'            => 'filterSplit',
		'split_long'       => 'filterSplitLong',
		'strip_tags'       => 'filterStripTags',
		'to_lower'         => 'filterToLower',
		'to_upper'         => 'filterToUpper',
		'de_camel'         => 'filterDeCamel',
		'substr'           => 'filterSubstr',
		'url'              => 'filterUrl',
		'urlencode'        => 'filterUrlencode',
		'url_display'      => 'filterUrlDisplay',
		'email_display'    => 'filterEmailDisplay',
		'zerofill'         => 'filterZeroFill',
	];

	protected $defaultFunctions = [
		'anchor_target'         => 'fnAnchorTarget',
		'anon_referer'          => 'fnAnonReferer',
		'array_keys'            => 'fnArrayKeys',
		'array_merge'           => 'fnArrayMerge',
		'array_values'          => 'fnArrayValues',
		'asset'                 => 'fnAsset',
		'attributes'            => 'fnAttributes',
		'avatar'                => 'fnAvatar',
		'base_url'              => 'fnBaseUrl',
		'bb_code'               => 'fnBbCode',
		'bb_code_snippet'       => 'fnBbCodeSnippet',
		'bb_code_type'          => 'fnBbCodeType',
		'bb_code_type_snippet'  => 'fnBbCodeTypeSnippet',
		'button_icon'           => 'fnButtonIcon',
		'cache_key'             => 'fnCacheKey',
		'call_macro'            => 'fnCallMacro',
		'callable'              => 'fnCallable',
		'captcha'               => 'fnCaptcha',
		'captcha_options'       => 'fnCaptchaOptions',
		'ceil'                  => 'fnCeil',
		'contains'              => 'fnContains',
		'copyright'             => 'fnCopyright',
		'core_js'               => 'fnCoreJs',
		'count'                 => 'fnCount',
		'csrf_input'            => 'fnCsrfInput',
		'csrf_token'            => 'fnCsrfToken',
		'css_url'               => 'fnCssUrl',
		'date'                  => 'fnDate',
		'date_from_format'      => 'fnDateFromFormat',
		'date_dynamic'          => 'fnDateDynamic',
		'date_time'             => 'fnDateTime',
		'debug_url'             => 'fnDebugUrl',
		'display_totals'        => 'fnDisplayTotals',
		'dump'                  => 'fnDump',
		'dump_simple'           => 'fnDumpSimple',
		'duration'              => 'fnDuration',
		'empty'                 => 'fnEmpty',
		'fa_weight'             => 'fnFaWeight',
		'file_size'             => 'fnFileSize',
		'floor'                 => 'fnFloor',
		'gravatar_url'          => 'fnGravatarUrl',
		'highlight'             => 'fnHighlight',
		'in_array'              => 'fnInArray',
		'is_array'              => 'fnIsArray',
		'is_scalar'             => 'fnIsScalar',
		'is_addon_active'       => 'fnIsAddonActive',
		'is_editor_capable'     => 'fnIsEditorCapable',
		'is_toggled'            => 'fnIsToggled',
		'is_changed'            => 'fnIsChanged',
		'js_url'                => 'fnJsUrl',
		'key_exists'            => 'fnKeyExists',
		'last_pages'            => 'fnLastPages',
		'likes'                 => 'fnLikes',
		'likes_content'         => 'fnLikesContent',
		'link'                  => 'fnLink',
		'link_type'             => 'fnLinkType',
		'min'                   => 'fnMin',
		'max'                   => 'fnMax',
		'max_length'            => 'fnMaxLength',
		'media_sites'           => 'fnMediaSites',
		'mustache'              => 'fnMustache',
		'number'                => 'fnNumber',
		'number_short'          => 'fnNumberShort',
		'named_colors'          => 'fnNamedColors',
		'page_description'      => 'fnPageDescription',
		'page_h1'               => 'fnPageH1',
		'page_nav'              => 'fnPageNav',
		'page_param'            => 'fnPageParam',
		'page_title'            => 'fnPageTitle',
		'parens'                => 'fnParens',
		'parse_less_color'      => 'fnParseLessColor',
		'phrase_dynamic'        => 'fnPhraseDynamic',
		'prefix'                => 'fnPrefix',
		'prefix_group'          => 'fnPrefixGroup',
		'prefix_title'          => 'fnPrefixTitle',
		'prefix_description'    => 'fnPrefixDescription',
		'prefix_usage_help'     => 'fnPrefixUsageHelp',
		'profile_banner'        => 'fnProfileBanner',
		'property'              => 'fnProperty',
		'rand'                  => 'fnRand',
		'range'                 => 'fnRange',
		'react'                 => 'fnReact',
		'alert_reaction'        => 'fnAlertReaction',
		'reaction'              => 'fnReaction',
		'reaction_title'        => 'fnReactionTitle',
		'reactions'             => 'fnReactions',
		'reactions_content'     => 'fnReactionsContent',
		'reactions_summary'     => 'fnReactionsSummary',
		'redirect_input'        => 'fnRedirectInput',
		'repeat'                => 'fnRepeat',
		'repeat_raw'            => 'fnRepeatRaw',
		'short_to_emoji'        => 'fnShortToEmoji',
		'show_ignored'          => 'fnShowIgnored',
		'smilie'                => 'fnSmilie',
		'snippet'               => 'fnSnippet',
		'sprintf'               => 'fnSprintf',
		'strlen'                => 'fnStrlen',
		'structured_text'       => 'fnStructuredText',
		'templater'             => 'fnTemplater',
		'time'                  => 'fnTime',
		'transparent_img'       => 'fnTransparentImg',
		'trim'                  => 'fnTrim',
		'unique_id'             => 'fnUniqueId',
		'user_activity'         => 'fnUserActivity',
		'user_banners'          => 'fnUserBanners',
		'user_blurb'            => 'fnUserBlurb',
		'user_title'            => 'fnUserTitle',
		'username_link'         => 'fnUsernameLink',
		'username_link_email'   => 'fnUsernameLinkEmail',
		'widget_data'           => 'fnWidgetData'
	];

	protected $defaultTests = [
		'empty' => 'testEmpty'
	];

	protected $overlayClickOptions = [
		'data-cache',
		'data-overlay-config',
		'data-force-flash-message',
		'data-follow-redirects'
	];

	public function __construct(App $app, Language $language, $compiledPath)
	{
		$this->app = $app;
		$this->language = $language;
		$this->compiledPath = $compiledPath;

		$this->router = $app->router();
		$this->pather = $app->container('request.pather');
		$this->uniqueIdFormat = '_xfUid-%s-' . \XF::$time;
	}

	public function getTemplateFilePath($type, $name, $styleIdOverride = null)
	{
		return $this->compiledPath
			. '/l' . $this->language->getId()
			. '/s' . intval($styleIdOverride !== null ? $styleIdOverride : $this->styleId)
			. '/' . preg_replace('/[^a-zA-Z0-9_.-]/', '', $type)
			. '/' . preg_replace('/[^a-zA-Z0-9_.-]/', '', $name) . '.php';
	}

	protected function getTemplateDataFromSource($type, $name)
	{
		$path = $this->getTemplateFilePath($type, $name);

		try
		{
			$file = @include($path);
		}
		catch (\Throwable $e)
		{
			return false;
		}

		return $file;
	}

	public function getRouter()
	{
		if ($this->currentTemplateType && $this->currentTemplateType != $this->routerType)
		{
			$container = $this->app->container();
			$type = $this->currentTemplateType;

			// ?: use over ?? intentional due to PHP bug #71731 in < 7.0.6
			/** @var \XF\Mvc\Router|null $router */
			$router = isset($container['router.' . $type]) ? $container['router.' . $type] : null;
			if ($router)
			{
				$this->router = $router;
				$this->routerType = $type;
			}
		}

		return $this->router;
	}

	public function getCssLoadUrl(array $templates, $includeValidation = true)
	{
		$url = 'css.php?css='
			. urlencode(implode(',', $templates))
			. '&s=' . $this->styleId
			. '&l=' . $this->language->getId()
			. '&d=' . ($this->style ? $this->style->getLastModified() : \XF::$time);

		if ($includeValidation)
		{
			$validationKey = $this->getCssValidationKey($templates);
			if ($validationKey)
			{
				$url .= '&k=' . urlencode($validationKey);
			}
		}

		$pather = $this->pather;

		return $pather($url, 'base');
	}

	public function getCssValidationKey(array $templates)
	{
		if ($this->cssValidator)
		{
			$cssValidator = $this->cssValidator;

			return $cssValidator($templates);
		}
		else
		{
			return null;
		}
	}

	public function getJsUrl($js, $root = false)
	{
		if (preg_match('#^[a-z]+:#i', $js))
		{
			return $js;
		}

		$pather = $this->pather;
		$absolutePath = false;

		if ($js && $js[0] == '/')
		{
			$base = $pather('', 'base');
			if (!strpos($js, $base) === 0)
			{
				// not within the XF path
				return $js;
			}

			$absolutePath = true;
		}

		if (!strpos($js, '_v='))
		{
			$js = $js . (strpos($js, '?') ? '&' : '?') . $this->getJsCacheBuster();
		}

		if ($absolutePath)
		{
			return $js;
		}
		else if ($root)
		{
			return $pather($js, 'base');
		}
		else
		{
			return $pather("{$this->jsBaseUrl}/$js", 'base');
		}
	}

	public function getJsCacheBuster()
	{
		return '_v=' . $this->jsVersion;
	}

	public function getDevJsUrl($addOnId, $js)
	{
		$url = 'js/devjs.php?addon_id=' . urlencode($addOnId) . '&js=' . urlencode($js);

		$pather = $this->pather;

		return $pather($url, 'base');
	}

	public function setLanguage(Language $language)
	{
		$this->language = $language;
	}

	public function getLanguage()
	{
		return $this->language;
	}

	/**
	 * Gets a phrase object using the active language. (Templater language may differ from the
	 * global XF::language value.)
	 *
	 * @param string $name
	 * @param array  $params
	 * @param bool   $allowHtml
	 *
	 * @return \XF\Phrase
	 */
	public function phrase(string $name, array $params = [], bool $allowHtml = true): \XF\Phrase
	{
		return $this->language->phrase($name, $params, true, $allowHtml);
	}

	public function setStyle(\XF\Style $style)
	{
		$this->style = $style;
		$this->styleId = $style->getId();
	}

	public function getStyle()
	{
		return $this->style;
	}

	public function getStyleId()
	{
		return $this->styleId;
	}

	public function setCssValidator(callable $cssValidator)
	{
		$this->cssValidator = $cssValidator;
	}

	public function setJquerySource($version, $jQuerySource = null)
	{
		$this->jQueryVersion = $version;
		$this->jQuerySource = $jQuerySource ?: $this->app->options()->jQuerySource;
	}

	public function setJsVersion($version)
	{
		$this->jsVersion = $version;
	}

	public function setJsBaseUrl($baseUrl)
	{
		$this->jsBaseUrl = rtrim($baseUrl, '/') ?: 'js';
	}

	public function setDynamicDefaultAvatars($dynamic)
	{
		$this->dynamicDefaultAvatars = $dynamic;
	}

	public function setMediaSites(array $mediaSites)
	{
		$this->mediaSites = $mediaSites;
	}

	public function setUserTitleLadder(array $ladder, $titleField = '')
	{
		$this->userTitleLadder = $ladder;
		if ($titleField)
		{
			$this->userTitleLadderField = $titleField;
		}
	}

	public function setUserBanners(array $banners, array $config = [])
	{
		$this->userBanners = $banners;
		if ($config)
		{
			$this->userBannerConfig = $config;
		}
	}

	public function setGroupStyles(array $styles)
	{
		$this->groupStyles = $styles;
	}

	public function setWidgetPositions(array $widgetPositions)
	{
		$this->widgetPositions = $widgetPositions;
	}

	public function addDefaultHandlers()
	{
		$this->addFilters($this->defaultFilters);
		$this->addFunctions($this->defaultFunctions);
		$this->addTests($this->defaultTests);
	}

	public function addFilters(array $filters)
	{
		$this->filters = array_merge($this->filters, $filters);
	}

	public function addFilter($name, $filter)
	{
		$this->filters[$name] = $filter;
	}

	public function addFunctions(array $functions)
	{
		$this->functions = array_merge($this->functions, $functions);
	}

	public function addFunction($name, $function)
	{
		$this->functions[$name] = $function;
	}

	public function addTests(array $tests)
	{
		$this->tests = array_merge($this->tests, $tests);
	}

	public function addTest($name, $test)
	{
		$this->tests[$name] = $test;
	}

	public function addDefaultParams(array $params)
	{
		$this->defaultParams = array_merge($this->defaultParams, $params);
	}

	public function addDefaultParam($name, $value)
	{
		$this->defaultParams[$name] = $value;
	}

	public function getTemplate($name, array $params = [])
	{
		return new Template($this, $name, $params);
	}

	public function addTemplateWatcher(WatcherInterface $watcher)
	{
		$this->watchers[] = $watcher;
	}

	public function hasWatcherActionedTemplates()
	{
		foreach ($this->watchers AS $watcher)
		{
			if ($watcher->hasActionedTemplates())
			{
				return true;
			}
		}

		return false;
	}

	public function getTemplateTypeAndName($template)
	{
		$parts = explode(':', $template, 2);
		if (count($parts) == 2)
		{
			return [$parts[0], $parts[1]];
		}
		else
		{
			return [$this->currentTemplateType, $parts[0]];
		}
	}

	public function applyDefaultTemplateType($template)
	{
		list($type, $template) = $this->getTemplateTypeAndName($template);

		if ($type)
		{
			$template = "$type:$template";
		}

		return $template;
	}

	/**
	 * @param string $type
	 * @param string $template
	 *
	 * @return \Closure
	 */
	public function getTemplateCode($type, $template)
	{
		$data = $this->getTemplateData($type, $template);

		return $data['code'];
	}

	/**
	 * @param string $type
	 * @param string $template
	 * @param string $macro
	 *
	 * @return \Closure
	 */
	public function getTemplateMacro($type, $template, $macro)
	{
		$data = $this->getTemplateData($type, $template);
		if (isset($data['macros'][$macro]))
		{
			return $data['macros'][$macro];
		}

		trigger_error("Macro $type:$template:$macro is unknown", E_USER_WARNING);

		return function () {
			return '';
		};
	}

	protected function getTemplateData($type, $template, $errorOnUnknown = true)
	{
		$languageId = $this->language->getId();
		$cacheKey = "{$languageId}-{$this->styleId}-{$type}-{$template}";

		if (isset($this->templateCache[$cacheKey]))
		{
			return $this->templateCache[$cacheKey];
		}

		if (preg_match('#[^a-zA-Z0-9_.-]#', $template))
		{
			throw new \InvalidArgumentException("Template name '$template' contains invalid characters");
		}

		foreach ($this->watchers AS $watcher)
		{
			$watcher->watchTemplate($this, $type, $template);
		}

		$data = $this->getTemplateDataFromSource($type, $template);
		if (!$data || !is_array($data) || !isset($data['code']))
		{
			if ($errorOnUnknown)
			{
				trigger_error("Template $type:$template is unknown", E_USER_WARNING);
			}

			$data = [
				'code'    => function () {
					return '';
				},
				'unknown' => true
			];
		}

		$this->templateCache[$cacheKey] = $data;

		return $data;
	}

	public function callAdsMacro($position, array $arguments, array $globalVars)
	{
		$templateData = $this->getTemplateData('public', '_ads', false);
		if (!isset($templateData['macros'][$position]))
		{
			return '';
		}
		else
		{
			return $this->callMacro('public:_ads', $position, $arguments, $globalVars);
		}
	}

	public function callMacro(
		$template, $name, array $arguments, array $globalVars, MacroState $macroState = null
	)
	{
		if ($this->executionDepth >= self::MAX_EXECUTION_DEPTH)
		{
			trigger_error('Max template execution depth reached', E_USER_WARNING);
			return '';
		}

		if (!$template)
		{
			$nameParts = explode('::', $name, 2);
			if (count($nameParts) == 2)
			{
				list($type, $template) = $this->getTemplateTypeAndName($nameParts[0]);
				$name = $nameParts[1];
			}
			else
			{
				$template = $this->currentTemplateName;
				$type = $this->currentTemplateType;
			}
		}
		else
		{
			list($type, $template) = $this->getTemplateTypeAndName($template);
		}

		if (!$type)
		{
			trigger_error('No template type was provided. Provide template name in type:name format.', E_USER_WARNING);
			return '';
		}

		if (isset($globalVars['__globals']))
		{
			$globalVars = $globalVars['__globals'];
		}

		$this->app->fire(
			'templater_macro_pre_render',
			[$this, &$type, &$template, &$name, &$arguments, &$globalVars],
			"$type:$template:$name"
		);

		$postRenderCb = $this->setupRenderTemplateElement($type, $template, $name);

		$isExtensionDummyRender = $this->isExtensionDummyRender;

		try
		{
			$macro = $this->getTemplateMacro($type, $template, $name);
			if (is_array($macro))
			{
				if (!$macroState)
				{
					$macroState = new MacroState();
				}

				if (!empty($macro['extensions']))
				{
					$macroState->applyExtensionSet(
						new ExtensionSet($type, $template, $macro['extensions'], $name)
					);
				}
				if (!empty($macro['arguments']))
				{
					$macroState->addArguments(
						$macro['arguments']($this, $globalVars)
					);
				}
				if (!empty($macro['global']))
				{
					$macroState->setGlobal(true);
				}

				$extensions = $macroState->getExtensionSet();
				$macroVars = $macroState->getAvailableVars($this, $arguments, $globalVars);

				// new, extended format
				if (array_key_exists('extends', $macro))
				{
					$extendsParts = explode('::', $macro['extends'], 2);
					if (count($extendsParts) == 2)
					{
						// template::macro_name format
						$extendsTemplate = $this->applyDefaultTemplateType($extendsParts[0]);
						$extendsMacro = $extendsParts[1];
					}
					else
					{
						// Just macro_name, so default to current template
						$extendsTemplate = "$type:$template";
						$extendsMacro = $extendsParts[0];
					}

					$output = $this->callMacro($extendsTemplate, $extendsMacro, $arguments, $globalVars, $macroState);

					// Dummy render the contents of the macro to get things like page titles, etc.
					// No extensions will be rendered and the output will be thrown away.
					$this->isExtensionDummyRender = true;
					$macro['code']($this, $macroVars, $extensions);
				}
				else
				{
					$output = $macro['code']($this, $macroVars, $extensions);
				}
			}
			else
			{
				// legacy format -- still has argument/globals processing code within
				$output = $macro($this, $arguments, $globalVars);
			}
		}
		catch (\Throwable $e)
		{
			$errorPrefix = "$this->currentTemplateType:$this->currentTemplateName :: $name()";
			$output = $this->handleTemplateException($e, $errorPrefix, "Macro $errorPrefix error: ");
		}
		finally
		{
			$this->isExtensionDummyRender = $isExtensionDummyRender;
		}

		if ($this->wrapTemplateName)
		{
			$output = $this->applyWrappedTemplate($output);
		}

		$postRenderCb();

		$this->app->fire(
			'templater_macro_post_render',
			[$this, $type, $template, &$name, &$output],
			"$type:$template:$name"
		);

		return $output;
	}

	public function renderMacro($template, $name, array $arguments = [])
	{
		return $this->callMacro($template, $name, $arguments, $this->defaultParams);
	}

	public function setupBaseParamsForMacro(array $parentVars, $isGlobal = false)
	{
		if (isset($parentVars['__globals']))
		{
			$globalVars = $parentVars['__globals'];
		}
		else
		{
			$globalVars = $parentVars;
		}

		$params = $isGlobal ? $globalVars : $this->defaultParams;
		$params['__globals'] = $globalVars;

		return $params;
	}

	public function combineMacroArgumentAttributes($argsAttr, array $separateArgs)
	{
		if (is_array($argsAttr))
		{
			return array_replace($argsAttr, $separateArgs);
		}
		else
		{
			return $separateArgs;
		}
	}

	public function mergeMacroArguments(array $expected, array $provided, array $baseParams)
	{
		foreach ($expected AS $argument => $value)
		{
			if (array_key_exists($argument, $provided))
			{
				$baseParams[$argument] = $provided[$argument];
			}
			else if ($value === '!')
			{
				throw new \LogicException("Macro argument $argument is required and no value was provided");
			}
			else
			{
				$baseParams[$argument] = $value;
			}
		}

		return $baseParams;
	}

	public function renderExtension($name, array $params, ExtensionSet $extensions = null)
	{
		$extensionDef = $extensions ? $extensions->getExtension($name) : null;
		if (!$extensionDef)
		{
			trigger_error("No extension named '$name' could be found.", E_USER_WARNING);
			return '';
		}

		return $this->renderExtensionInternal($name, $extensionDef, $params, $extensions);
	}

	public function renderExtensionParent(array $params, $name = null, ExtensionSet $extensions = null)
	{
		if (!$name)
		{
			if (!$this->currentExtensionName)
			{
				trigger_error("Cannot call for an extension parent when not rendering an extension.", E_USER_WARNING);
				return '';
			}

			$name = $this->currentExtensionName;
		}

		if (!$this->currentExtensionSet)
		{
			trigger_error("No current extension set found. Cannot render extension parent.", E_USER_WARNING);
			return '';
		}

		$parentSet = $this->currentExtensionSet->getBaseSet();

		$extensionDef = $parentSet ? $parentSet->getExtension($name) : null;
		if (!$extensionDef)
		{
			trigger_error("No parent version of the extension '$name' could be found.", E_USER_WARNING);
			return '';
		}

		return $this->renderExtensionInternal($name, $extensionDef, $params, $extensions);
	}

	protected function renderExtensionInternal($name, array $extensionDef, array $params, ExtensionSet $extensions = null)
	{
		if ($this->isExtensionDummyRender)
		{
			return '';
		}

		if ($this->executionDepth >= self::MAX_EXECUTION_DEPTH)
		{
			trigger_error('Max template execution depth reached', E_USER_WARNING);
			return '';
		}

		$type = $extensionDef['type'];
		$template = $extensionDef['template'];
		$eventName = $extensionDef['macro'] ? "$extensionDef[macro]:$name" : $name;

		$this->app->fire(
			'templater_extension_pre_render',
			[$this, $type, $template, $eventName, &$params],
			"$type:$template:$eventName"
		);

		$postRenderCb = $this->setupRenderTemplateElement($type, $template, null, $name);

		$currentExtensionSet = $this->currentExtensionSet;
		$this->currentExtensionSet = $extensionDef['set'];

		try
		{
			$output = $extensionDef['code']($this, $params, $extensions);
		}
		catch (\Throwable $e)
		{
			$errorPrefix = "$this->currentTemplateType:$this->currentTemplateName :: $name()";
			$output = $this->handleTemplateException($e, $errorPrefix, "Extension $errorPrefix error: ");
		}

		if ($this->wrapTemplateName)
		{
			$output = $this->applyWrappedTemplate($output);
		}

		$postRenderCb();
		$this->currentExtensionSet = $currentExtensionSet;

		$this->app->fire(
			'templater_extension_post_render',
			[$this, $type, $template, $eventName, &$output],
			"$type:$template:$eventName"
		);

		return $output;
	}

	public function extractIntoVarContainer(array &$varContainer, $source)
	{
		if (!$this->isTraversable($source))
		{
			return;
		}

		foreach ($source AS $k => $v)
		{
			$varContainer[$k] = $v;
		}
	}

	public function wrapTemplate($template, array $params)
	{
		$template = $this->applyDefaultTemplateType($template);

		$this->wrapTemplateName = $template;
		$this->wrapTemplateParams = $params;
	}

	protected function applyWrappedTemplate($content)
	{
		if (!$this->wrapTemplateName)
		{
			return $content;
		}

		$template = $this->wrapTemplateName;
		$params = $this->wrapTemplateParams;

		$this->wrapTemplateName = null;
		$this->wrapTemplateParams = null;

		$params['innerContent'] = $this->preEscaped($content, 'html');

		return $this->renderTemplate($template, $params, false);
	}

	public function filter($value, array $filters, $escape = true)
	{
		foreach ($filters AS $filter)
		{
			list($name, $arguments) = $filter;
			$name = strtolower($name);
			if (!isset($this->filters[$name]))
			{
				trigger_error("Filter $name is unknown", E_USER_WARNING);
				continue;
			}

			$callable = $this->filters[$name];
			if (is_string($callable))
			{
				$callable = [$this, $callable];
			}

			if ($arguments)
			{
				array_unshift($arguments, null);
				array_unshift($arguments, $value);
				array_unshift($arguments, $this);
				$arguments[2] =& $escape;
			}
			else
			{
				$arguments = [$this, $value, &$escape];
			}

			$value = call_user_func_array($callable, $arguments);
		}

		return $escape ? $this->escape($value, $escape) : $value;
	}

	/**
	 * @deprecated use func() method below instead. This will be removed in the near future for PHP 7.4 compatibility.
	 *
	 * @param       $name
	 * @param array $arguments
	 * @param bool  $escape
	 *
	 * @return mixed|string|string[]|null
	 */
	public function fn($name, array $arguments = [], $escape = true)
	{
		return $this->func($name, $arguments, $escape);
	}

	public function func($name, array $arguments = [], $escape = true)
	{
		$name = strtolower($name);
		if (!isset($this->functions[$name]))
		{
			trigger_error("Function $name is unknown", E_USER_WARNING);

			return '';
		}

		$callable = $this->functions[$name];
		if (is_string($callable))
		{
			$callable = [$this, $callable];
		}

		if ($arguments)
		{
			array_unshift($arguments, null);
			array_unshift($arguments, $this);
			$arguments[1] =& $escape;
		}
		else
		{
			$arguments = [$this, &$escape];
		}

		$value = call_user_func_array($callable, $arguments);

		return $escape ? $this->escape($value) : $value;
	}

	public function test($value, $test, array $arguments = [])
	{
		if (!isset($this->tests[$test]))
		{
			trigger_error("Test $test is unknown", E_USER_WARNING);

			return false;
		}

		$callable = $this->tests[$test];
		if (is_string($callable))
		{
			$callable = [$this, $callable];
		}

		if ($arguments)
		{
			array_unshift($arguments, $value);
			array_unshift($arguments, $this);
		}
		else
		{
			$arguments = [$this, $value];
		}

		return (bool)call_user_func_array($callable, $arguments);
	}

	public function arrayKey($var, $key)
	{
		return $var[$key];
	}

	public function isA($object, $class)
	{
		return ($object instanceof $class);
	}

	public function method($var, $fn, array $arguments = [])
	{
		if (!is_object($var))
		{
			$type = gettype($var);
			trigger_error("Cannot call method $fn on a non-object ($type)", E_USER_WARNING);

			return '';
		}

		$call = [$var, $fn];

		if (!is_callable($call))
		{
			$class = get_class($var);
			trigger_error("Method $fn is not callable on the given object ($class)", E_USER_WARNING);

			return '';
		}

		return call_user_func_array($call, $arguments);
	}

	public function escape($value, $type = null)
	{
		if ($type === null || $type === true)
		{
			$type = $this->escapeContext;
		}

		return \XF::escapeString($value, $type);
	}

	public function modifySectionedHtml(array &$ref, $key, $html, $mode = 'replace')
	{
		if ($mode == 'delete')
		{
			if ($key)
			{
				unset($ref[$key]);
			}

			return;
		}

		$html = trim($html);
		if (!strlen($html))
		{
			return;
		}

		$html = $this->preEscaped($html, 'html');

		switch ($mode)
		{
			case 'prepend':
				if ($key)
				{
					$ref = [$key => $html] + $ref;
				}
				else
				{
					array_unshift($ref, $html);
				}
				break;

			case 'append':
				if ($key)
				{
					unset($ref[$key]); // unset to ensure this goes at the end
					$ref[$key] = $html;
				}
				else
				{
					$ref[] = $html;
				}
				break;

			case 'replace':
			default:
				if ($key)
				{
					$ref[$key] = $html;
				}
				else
				{
					$ref[] = $html;
				}
				break;
		}
	}

	public function modifySidebarHtml($key, $html, $mode = 'replace')
	{
		$this->modifySectionedHtml($this->sidebar, $key, $html, $mode);
	}

	public function getSidebarHtml()
	{
		return $this->sidebar;
	}

	public function modifySideNavHtml($key, $html, $mode = 'replace')
	{
		$this->modifySectionedHtml($this->sideNav, $key, $html, $mode);
	}

	public function getSideNavHtml()
	{
		return $this->sideNav;
	}

	public function includeCss($css)
	{
		list($type, $template) = $this->getTemplateTypeAndName($css);
		if (!$type)
		{
			trigger_error('No template type was provided. Provide template name in type:name format.', E_USER_WARNING);

			return;
		}

		$this->includeCss["$type:$template"] = true;
	}

	public function getIncludedCss(array $forceAppend = [])
	{
		$css = array_keys($this->includeCss);
		sort($css);

		return array_merge($css, $forceAppend);
	}

	public function inlineCss($css)
	{
		$this->inlineCss[] = $css;
	}

	public function getInlineCss()
	{
		return $this->inlineCss;
	}

	public function includeJs(array $options)
	{
		$options = array_replace([
			'src'   => null,
			'addon' => null,
			'min'   => null,
			'dev'   => null,
			'prod'  => null,
			'root'  => false,
		], $options);

		$developmentConfig = $this->app->config('development');
		$productionMode = empty($developmentConfig['fullJs']);

		$src = $this->splitJsSrc($options['src']);

		if ($productionMode)
		{
			if ($options['min'])
			{
				$src = array_map(function ($path) {
					return preg_replace('(\.js$)', '.min.js', $path, 1);
				}, $src);
			}

			$prod = $this->splitJsSrc($options['prod']);
			$src = array_merge($src, $prod);

			foreach ($src AS $path)
			{
				$url = $this->getJsUrl($path, boolval($options['root']));
				$this->includeJs[$url] = true;
			}
		}
		else
		{
			$dev = $this->splitJsSrc($options['dev']);
			$src = array_merge($src, $dev);

			if ($options['addon'])
			{
				foreach ($src AS $path)
				{
					$url = $this->getDevJsUrl($options['addon'], $path);
					$this->includeJs[$url] = true;
				}
			}
			else
			{
				foreach ($src AS $path)
				{
					$url = $this->getJsUrl($path, boolval($options['root']));
					$this->includeJs[$url] = true;
				}
			}
		}
	}

	protected function splitJsSrc($js)
	{
		if ($js)
		{
			return Arr::stringToArray($js, '/[, ]/');
		}
		else
		{
			return [];
		}
	}

	public function getIncludedJs()
	{
		return array_keys($this->includeJs);
	}

	public function inlineJs($js)
	{
		$this->inlineJs[] = $js;
	}

	public function getInlineJs()
	{
		return $this->inlineJs;
	}

	public function isTraversable($value)
	{
		return is_array($value) || ($value instanceof \Traversable);
	}

	public function isArrayAccessible($value)
	{
		return is_array($value) || ($value instanceof \ArrayAccess);
	}

	public function handleTemplateError($errorType, $errorString, $file, $line)
	{
		switch ($errorType)
		{
			case E_NOTICE:
			case E_USER_NOTICE:
				// ignore these (generally accessing an invalid variable
				return;

			case E_STRICT:
			case E_DEPRECATED:
			case E_USER_DEPRECATED:
				// these are only logged in debug mode
				if (!\XF::$debugMode)
				{
					return;
				}
				break;

			case E_WARNING:
				if (PHP_MAJOR_VERSION >= 8)
				{
					if (str_contains($errorString, 'Undefined array key')
						|| str_contains($errorString, 'Trying to access array offset on value')
					)
					{
						return;
					}
				}
				break;
		}

		if ($errorType & error_reporting())
		{
			$errorString = '[' . \XF\Util\Php::convertErrorCodeToString($errorType) . '] '. $errorString;

			$this->templateErrors[] = [
				'template' => $this->currentTemplateType . ':' . $this->currentTemplateName,
				'type'     => $errorType,
				'error'    => $errorString,
				'file'     => $file,
				'line'     => $line
			];

			$e = new \ErrorException($errorString, 0, $errorType, $file, $line);
			$this->app->logException($e, false, "Template error: ");
		}
	}

	public function handleTemplateException(\Throwable $e, $printableName, $exceptionPrefix = '')
	{
		$this->app->logException($e, false, $exceptionPrefix);

		if (\XF::$debugMode)
		{
			$message = $e->getMessage();
			$file = $e->getFile() . ':' . $e->getLine();
			$error = $e instanceof \XF\PrintableException
				? "$printableName - $message"
				: "$printableName - $message in $file";

			if (preg_match('/\.(css|less)$/i', $this->currentTemplateName))
			{
				$error = strtr($error, [
					"'"  => '',
					'\\' => '/',
					"\r" => '',
					"\n" => " "
				]);

				$output = "
					/** Error output **/
					body:before
					{
						background-color: #ccc;
						color: black;
						font-weight: bold;
						display: block;
						padding: 10px;
						margin: 10px;
						border: solid 1px #aaa;
						border-radius: 5px;
						content: 'CSS error: " . $error . "';
					}
				";
			}
			else
			{
				$output = '<div class="error"><h3>Template Compilation Error</h3>'
					. '<div>' . htmlspecialchars($error) . '</div></div>';
			}
		}
		else
		{
			$output = '';
		}

		return $output;
	}

	public function getTemplateErrors()
	{
		return $this->templateErrors;
	}

	public function setupRenderTemplateElement($type, $template, $macro = null, $extension = null)
	{
		$currentType = $this->currentTemplateType;
		$currentName = $this->currentTemplateName;
		$currentMacro = $this->currentMacroName;
		$currentExtension = $this->currentExtensionName;

		$origWrapTemplateName = $this->wrapTemplateName;
		$origWrapTemplateParams = $this->wrapTemplateParams;

		$this->currentTemplateType = $type;
		$this->currentTemplateName = $template;
		$this->currentMacroName = $macro;
		$this->currentExtensionName = $extension;

		$this->wrapTemplateName = null;
		$this->wrapTemplateParams = null;

		$this->executionDepth++;

		set_error_handler([$this, 'handleTemplateError']);

		return function() use (
			$currentType, $currentName, $currentMacro, $currentExtension,
			$origWrapTemplateName, $origWrapTemplateParams
		)
		{
			restore_error_handler();

			$this->currentTemplateType = $currentType;
			$this->currentTemplateName = $currentName;
			$this->currentMacroName = $currentMacro;
			$this->currentExtensionName = $currentExtension;

			$this->wrapTemplateName = $origWrapTemplateName;
			$this->wrapTemplateParams = $origWrapTemplateParams;

			$this->executionDepth--;
		};
	}

	public function isKnownTemplate($template)
	{
		$type = false;

		if (strpos($template, ':') !== false)
		{
			list($type, $template) = explode(':', $template, 2);
		}

		if (!$type)
		{
			return false;
		}

		$data = $this->getTemplateData($type, $template, false);

		return empty($data['unknown']) ? true : false;
	}

	/**
	 * @param string $template
	 * @param array  $params
	 * @param bool   $addDefaultParams
	 * @param ExtensionSet|null $extensionOverrides
	 *
	 * @return string
	 */
	public function renderTemplate(
		$template, array $params = [], $addDefaultParams = true, ExtensionSet $extensionOverrides = null
	)
	{
		if ($this->executionDepth >= self::MAX_EXECUTION_DEPTH)
		{
			trigger_error('Max template execution depth reached', E_USER_WARNING);
			return '';
		}

		if ($addDefaultParams)
		{
			$params = array_merge($this->defaultParams, $params);
		}

		$type = false;

		if (strpos($template, ':') !== false)
		{
			list($type, $template) = explode(':', $template, 2);
		}

		if (!$type)
		{
			trigger_error('No template type was provided. Provide template name in type:name format.', E_USER_WARNING);
			return '';
		}

		$this->app->fire('templater_template_pre_render', [$this, &$type, &$template, &$params], "$type:$template");

		$postRenderCb = $this->setupRenderTemplateElement($type, $template);

		$isExtensionDummyRender = $this->isExtensionDummyRender;

		try
		{
			$data = $this->getTemplateData($type, $template);

			if (!empty($data['extensions']))
			{
				$extensions = new ExtensionSet($type, $template, $data['extensions']);
			}
			else
			{
				$extensions = null;
			}
			if ($extensionOverrides)
			{
				if ($extensions)
				{
					$extensionOverrides->applyBaseSet($extensions);
				}
				$extensions = $extensionOverrides;
			}

			$extendsTemplate = isset($data['extends']) ? $data['extends']($this, $params) : null;
			if ($extendsTemplate)
			{
				$extendsTemplate = $this->applyDefaultTemplateType($extendsTemplate);

				$output = $this->renderTemplate($extendsTemplate, $params, $addDefaultParams, $extensions);

				// Dummy render the contents of the template to get things like page titles, etc.
				// No extensions will be rendered and the output will be thrown away.
				$this->isExtensionDummyRender = true;
				$data['code']($this, $params, $extensions);
			}
			else
			{
				$output = $data['code']($this, $params, $extensions);
			}
		}
		catch (\Throwable $e)
		{
			$errorPrefix = "$this->currentTemplateType:$this->currentTemplateName";
			$output = $this->handleTemplateException($e, $errorPrefix, "Template $errorPrefix error: ");
		}
		finally
		{
			$this->isExtensionDummyRender = $isExtensionDummyRender;
		}

		if ($this->wrapTemplateName)
		{
			$output = $this->applyWrappedTemplate($output);
		}

		$postRenderCb();

		$this->app->fire('templater_template_post_render', [$this, $type, $template, &$output], "$type:$template");

		return $output;
	}

	public function includeTemplate($template, array $params = [])
	{
		$template = $this->applyDefaultTemplateType($template);

		return $this->renderTemplate($template, $params);
	}

	public function callback($class, $method, $contents, array $params = [])
	{
		if (!\XF\Util\Php::validateCallbackPhrased($class, $method, $errorPhrase))
		{
			return $errorPhrase;
		}
		if (!\XF\Util\Php::nameIndicatesReadOnly($method))
		{
			return $this->phrase('callback_method_x_does_not_appear_to_indicate_read_only', ['method' => $method]);
		}

		ob_start();
		$output = call_user_func([$class, $method], $contents, $params, $this);
		$output .= ob_get_clean();

		return $output;
	}

	public function setPageParams(array $pageParams)
	{
		$this->pageParams = Arr::mapMerge($this->pageParams, $pageParams);
	}

	public function setPageParam($name, $value)
	{
		if (strpos($name, '.') === false)
		{
			$this->pageParams[$name] = $value;

			return;
		}

		$ref =& $this->pageParams;
		$hasValid = false;
		foreach (explode('.', $name) AS $part)
		{
			if (!strlen($part))
			{
				continue;
			}

			if (!isset($ref[$part]) || !is_array($ref[$part]))
			{
				$ref[$part] = [];
			}

			$ref =& $ref[$part];
			$hasValid = true;
		}

		if ($hasValid)
		{
			$ref = $value;
		}
	}

	public function breadcrumb($value, $href, array $config)
	{
		if (!isset($this->pageParams['breadcrumbs']) || !is_array($this->pageParams['breadcrumbs']))
		{
			$this->pageParams['breadcrumbs'] = [];
		}

		$crumb = [
			'value'      => $value,
			'href'       => $href,
			'attributes' => $config
		];

		$this->pageParams['breadcrumbs'][] = $crumb;
	}

	public function breadcrumbs(array $crumbs)
	{
		if (!$crumbs)
		{
			$this->pageParams['breadcrumbs'] = [];

			return;
		}

		foreach ($crumbs AS $key => $crumb)
		{
			if (is_string($crumb) || $crumb instanceof \XF\Phrase)
			{
				$crumb = [
					'href'  => $key,
					'value' => $crumb
				];
			}

			if (!is_array($crumb))
			{
				trigger_error("Each breadcrumb must be an array", E_USER_WARNING);
				continue;
			}
			if (!isset($crumb['value']))
			{
				trigger_error("Each breadcrumb provide a 'value' key", E_USER_WARNING);
				continue;
			}
			if (!isset($crumb['href']))
			{
				trigger_error("Each breadcrumb provide a 'href' key", E_USER_WARNING);
				continue;
			}

			$value = $crumb['value'];
			$href = $crumb['href'];
			unset($crumb['value'], $crumb['href']);

			$this->breadcrumb($value, $href, $crumb);
		}
	}

	public function button($contentHtml, array $options, $menuHtml = '', array $menuOptions = [])
	{
		$href = $this->processAttributeToRaw($options, 'href', '', true);
		if ($href)
		{
			$element = 'a';
			$type = '';
			$href = ' href="' . $href . '"';
		}
		else
		{
			$element = 'button';
			$type = $this->processAttributeToRaw($options, 'type', '', true);
			if ($type)
			{
				$type = ' type="' . $type . '"';
			}
			else
			{
				$type = ' type="button"';
			}
		}

		$overlay = $this->processAttributeToRaw($options, 'overlay', '', true);
		if ($overlay)
		{
			$overlay = " data-xf-click=\"overlay\"";
		}

		$buttonClasses = 'button';
		$icon = $this->processAttributeToRaw($options, 'icon');
		$fa = '';
		if ($icon)
		{
			$buttonClasses .= ' button--icon button--icon--' . preg_replace('#[^a-zA-Z0-9_-]#', '', $icon);
		}
		// no predefined icon, so maybe there's an 'fa' (FontAwesome) attribute to use?
		else if ($fa = $this->fontAwesome($this->processAttributeToRaw($options, 'fa')))
		{
			$buttonClasses .= ' button--icon';
		}

		if ($menuHtml)
		{
			$buttonClasses .= ' button--splitTrigger';

			$menuClass = $this->processAttributeToRaw($menuOptions, 'class', ' %s', true);
			$unhandledMenuAttrs = $this->processUnhandledAttributes($menuOptions);

			$menuHtml = "<div class=\"menu{$menuClass}\" data-menu=\"menu\" aria-hidden=\"true\"{$unhandledMenuAttrs}>{$menuHtml}</div>";
		}

		$classAttr = $this->processAttributeToHtmlAttribute($options, 'class', $buttonClasses, true);

		$button = strval($this->processAttributeToRaw($options, 'button'));
		if (!$button)
		{
			$button = $contentHtml;
		}
		if (!$button && $icon)
		{
			$button = $this->getButtonPhraseFromIcon($icon);
		}

		$unhandledControlAttrs = $this->processUnhandledAttributes($options);

		if ($menuHtml)
		{
			return "<span{$classAttr}>{$fa}<{$element}{$type}{$href}{$overlay} class=\"button-text\">{$button}</{$element}>"
				. "<a class=\"button-menu\" data-xf-click=\"menu\" aria-expanded=\"false\" aria-haspopup=\"true\"></a>"
				. $menuHtml
				. "</span>";
		}
		else
		{
			return "<{$element}{$type}{$href}{$classAttr}{$overlay}{$unhandledControlAttrs}>{$fa}<span class=\"button-text\">{$button}</span></{$element}>";
		}
	}

	public function fontAwesome($iconClasses, array $options = [])
	{
		$iconClasses = ltrim($iconClasses);

		if ($iconClasses === '')
		{
			return '';
		}

		// match the actual icon
		if (!preg_match('/^fa[a-z0-9- ]+$/i', $iconClasses))
		{
			// attempt to fix someone missing the 'fa-' prefix
			$iconClasses = 'fa-' . $iconClasses;
		}

		// match a weight/style class
		if (!preg_match('/(^|\s)fa(b|l|r|s|d)($|\s)/', $iconClasses))
		{
			$iconClasses = 'fa' . $this->fnFaWeight(\XF::app()->templater()) . " {$iconClasses}";
		}

		$class = $this->processAttributeToRaw($options, 'class');
		if ($class)
		{
			$iconClasses = "{$iconClasses} {$class}";
		}

		$unhandledAttrs = $this->processUnhandledAttributes($options);
		return "<i class=\"fa--xf {$iconClasses}\" aria-hidden=\"true\"{$unhandledAttrs}></i>";
	}

	public function fontAwesomeInputOverlay(array &$controlOptions)
	{
		if ($fa = $this->processAttributeToRaw($controlOptions, 'fa', '', true))
		{
			return $this->fontAwesome("fa--inputOverlay {$fa}");
		}

		return '';
	}

	public function widgetPosition($positionId, array $contextParams = [])
	{
		$widgetPositions = $this->widgetPositions;
		if (!isset($widgetPositions[$positionId]))
		{
			return '';
		}
		$widgetContainer = $this->app->widget();
		$widgets = $widgetContainer->position($positionId, $contextParams);

		$options = [
			'context' => $contextParams
		];

		$output = '';
		foreach ($widgets AS $widget)
		{
			$output .= $widgetContainer->getCompiledWidget($widget, $options) . "\n";
		}

		return $output;
	}

	public function renderWidget($identifier, array $options = [], array $contextParams = [])
	{
		$options['context'] = $contextParams;

		$widgetContainer = $this->app->widget();
		$widgetCache = $widgetContainer['widgetCache'];

		$widget = null;

		foreach ($widgetCache AS $positionId => $widgets)
		{
			foreach ($widgets AS $widgetId => $_widget)
			{
				if ($_widget['widget_id'] == $identifier || $_widget['widget_key'] == $identifier)
				{
					$widget = $_widget;
					break;
				}
			}
		}

		if ($widget)
		{
			return $widgetContainer->getCompiledWidget($widget, $options);
		}
		else
		{
			$widgetObj = $widgetContainer->widget($identifier, $options);
			if ($widgetObj)
			{
				return $widgetObj->render();
			}
		}

		return '';
	}

	public function preEscaped($value, $type = null)
	{
		if ($type === null)
		{
			$type = $this->escapeContext;
		}

		return new \XF\PreEscaped($value, $type);
	}

	////////////////////// FUNCTIONS ////////////////////////

	public function fnAnchorTarget($templater, &$escape, $hash)
	{
		$escape = false;

		return '<span class="u-anchorTarget" id="' . htmlspecialchars($this->app->getRedirectHash($hash)) . '"></span>';
	}

	/**
	 * @deprecated please use rel="noreferrer noopener" on your anchor tags
	 */
	public function fnAnonReferer($templater, &$escape, $url)
	{
		return $url;
	}

	public function fnArrayKeys($templater, &$escape, $array, $searchValue = null, $strict = null)
	{
		if (!is_array($array))
		{
			$array = [];
		}

		if ($searchValue !== null)
		{
			if ($strict !== null)
			{
				return array_keys($array, $searchValue, $strict);
			}
			else
			{
				return array_keys($array, $searchValue);
			}
		}
		else
		{
			return array_keys($array);
		}
	}

	public function fnArrayMerge($templater, &$escape, $array)
	{
		$arrays = func_get_args();
		unset($arrays[0]);
		unset($arrays[1]);

		return call_user_func_array('array_merge', $arrays);
	}

	public function fnArrayValues($templater, &$escape, $array)
	{
		if (!is_array($array))
		{
			$array = [];
		}

		return array_values($array);
	}

	public function fnAsset($templater, &$escape, $key, $suffix = '', $fallback = null, $withPath = true)
	{
		if (!$this->style)
		{
			return $fallback;
		}

		$asset = $this->style->getAsset($key);

		if (!$asset)
		{
			return $fallback;
		}

		if ($suffix)
		{
			$asset .= "/{$suffix}";
		}

		if (strpos($asset, 'data://') === 0)
		{
			$dataPath = substr($asset, 7); // remove data://
			return $this->app->applyExternalDataUrl($dataPath);
		}
		else
		{
			$pather = $this->pather;
			return $withPath ? $pather($asset, 'base') : $asset;
		}
	}

	public function fnAttributes($templater, &$escape, $attributes, array $skipAttrs = [])
	{
		if (is_array($attributes))
		{
			foreach ($skipAttrs AS $attr)
			{
				unset($attributes[$attr]);
			}
			$output = $this->processUnhandledAttributes($attributes);
		}
		else
		{
			$output = '';
		}

		$escape = false;

		return $output;
	}

	public function fnAvatar($templater, &$escape, $user, $size, $canonical = false, $attributes = [])
	{
		$escape = false;
		$forceType = $this->processAttributeToRaw($attributes, 'forcetype', '', true);
		$noTooltip = $this->processAttributeToRaw($attributes, 'notooltip', '', false);
		$update = $this->processAttributeToRaw($attributes, 'update', '');

		$size = preg_replace('#[^a-zA-Z0-9_-]#s', '', $size);

		if ($user instanceof \XF\Entity\User)
		{
			$username = $user->username;
			if (isset($attributes['href']))
			{
				$href = $attributes['href'];
				$noTooltip = true;
			}
			else
			{
				$linkPath = $this->currentTemplateType == 'admin' ? 'users/edit' : 'members';
				$href = $this->getRouter()->buildLink(($canonical ? 'canonical:' : '') . $linkPath, $user);

				if ($this->currentTemplateType == 'admin')
				{
					$noTooltip = true;
				}
			}
			$userId = $user->user_id;
			if (!$userId)
			{
				$href = null;
				$noTooltip = true;
			}
			$hrefAttr = $href ? ' href="' . htmlspecialchars($href) . '"' : '';
			$avatarType = $forceType ?: $user->getAvatarType();

			$canUpdate = ((bool)$update && $user->user_id == \XF::visitor()->user_id && $user->canUploadAvatar());
		}
		else
		{
			if (isset($attributes['defaultname']))
			{
				$username = $attributes['defaultname'];
			}
			else
			{
				$username = null;
			}
			$hrefAttr = '';
			$noTooltip = true;
			$userId = 0;
			$avatarType = 'default';
			$canUpdate = false;
		}

		switch ($avatarType)
		{
			case 'gravatar':
			case 'custom':
				$src = $user->getAvatarUrl($size, $forceType, $canonical);
				break;

			case 'default':
			default:
				$src = null;
				break;
		}

		$actualSize = $size;
		if (!array_key_exists($size, $this->app->container('avatarSizeMap')))
		{
			$actualSize = 's';
		}

		$sizeClass = "avatar-u{$userId}-{$actualSize}";
		$innerClass = $this->processAttributeToRaw($attributes, 'innerclass', ' %s', true);
		$innerClassHtml = $sizeClass . $innerClass;

		if ($src && $forceType != 'default')
		{
			$srcSet = $user->getAvatarUrl2x($size, $forceType, $canonical);

			$itemprop = $this->processAttributeToRaw($attributes, 'itemprop', '%s', true);

			$pixels = $this->app['avatarSizeMap'][$actualSize];

			$innerContent = '<img src="' . htmlspecialchars($src) . '" '
				. (!empty($srcSet) ? 'srcset="' . htmlspecialchars($srcSet) . ' 2x"' : '')
				. ' alt="' . htmlspecialchars($username) . '"'
				. ' class="' . $innerClassHtml . '"'
				. ' width="' . $pixels . '" height="' . $pixels .  '" loading="lazy"'
				. ($itemprop ? ' itemprop="' . $itemprop . '"' : '')
				. ' />';
		}
		else
		{
			$innerContent = $this->getDynamicAvatarHtml($username, $innerClassHtml, $attributes);
		}

		$updateLink = '';
		$updateLinkClass = '';
		if ($canUpdate)
		{
			$updateLinkClass = ' avatar--updateLink';
			$updateLink = '<div class="avatar-update">
				<a href="' . htmlspecialchars($update) . '" data-xf-click="overlay">' . $this->phrase('edit_avatar') . '</a>
			</div>';
		}

		$class = $this->processAttributeToRaw($attributes, 'class', ' %s', true);
		$xfInit = $this->processAttributeToRaw($attributes, 'data-xf-init', '', true);

		if (!$noTooltip)
		{
			$xfInit = ltrim("$xfInit member-tooltip");
		}
		$xfInitAttr = $xfInit ? " data-xf-init=\"$xfInit\"" : '';

		unset($attributes['defaultname'], $attributes['href'], $attributes['itemprop']);

		if (!$hrefAttr && !isset($attributes['title']))
		{
			$attributes['title'] = $username;
		}

		$unhandledAttrs = $this->processUnhandledAttributes($attributes);

		if ($hrefAttr)
		{
			$tag = 'a';
		}
		else
		{
			$tag = 'span';
		}

		return "<{$tag}{$hrefAttr} class=\"avatar avatar--{$size}{$updateLinkClass}{$class}\" data-user-id=\"{$userId}\"{$xfInitAttr}{$unhandledAttrs}>
			$innerContent $updateLink
		</{$tag}>";
	}

	protected function getDynamicAvatarHtml($username, $innerClassHtml, array &$outerAttributes)
	{
		if ($username && $this->dynamicDefaultAvatars)
		{
			return $this->getDefaultAvatarHtml($username, $innerClassHtml, $outerAttributes);
		}
		else
		{
			return $this->getFallbackAvatarHtml($innerClassHtml, $outerAttributes);
		}
	}

	protected function getDefaultAvatarHtml($username, $innerClassHtml, array &$outerAttributes)
	{
		$styling = $this->getDefaultAvatarStyling($username);

		if (empty($outerAttributes['style']))
		{
			$outerAttributes['style'] = '';
		}
		else
		{
			$outerAttributes['style'] .= '; ';
		}
		$outerAttributes['style'] .= "background-color: $styling[bgColor]; color: $styling[color]";

		if (empty($outerAttributes['class']))
		{
			$outerAttributes['class'] = '';
		}
		else
		{
			$outerAttributes['class'] .= ' ';
		}
		$outerAttributes['class'] .= 'avatar--default avatar--default--dynamic';

		return '<span class="' . $innerClassHtml . '" role="img" aria-label="' . htmlspecialchars($username) . '">'
			. $styling['innerContent'] . '</span>';
	}

	protected function getDefaultAvatarStyling($username)
	{
		if (!isset($this->avatarDefaultStylingCache[$username]))
		{
			$bytes = md5($username, true);
			$r = dechex(round(5 * ord($bytes[0]) / 255) * 0x33);
			$g = dechex(round(5 * ord($bytes[1]) / 255) * 0x33);
			$b = dechex(round(5 * ord($bytes[2]) / 255) * 0x33);
			$hexBgColor = sprintf('%02s%02s%02s', $r, $g, $b);

			$hslBgColor = \XF\Util\Color::hexToHsl($hexBgColor);

			$bgChanged = false;
			if ($hslBgColor[1] > 60)
			{
				$hslBgColor[1] = 60;
				$bgChanged = true;
			}
			else if ($hslBgColor[1] < 15)
			{
				$hslBgColor[1] = 15;
				$bgChanged = true;
			}

			if ($hslBgColor[2] > 85)
			{
				$hslBgColor[2] = 85;
				$bgChanged = true;
			}
			else if ($hslBgColor[2] < 15)
			{
				$hslBgColor[2] = 15;
				$bgChanged = true;
			}

			if ($bgChanged)
			{
				$hexBgColor = \XF\Util\Color::hslToHex($hslBgColor);
			}

			$hslColor = \XF\Util\Color::darkenOrLightenHsl($hslBgColor, 35);
			$hexColor = \XF\Util\Color::hslToHex($hslColor);

			$bgColor = '#' . $hexBgColor;
			$color = '#' . $hexColor;

			if (preg_match($this->avatarLetterRegex, $username, $match))
			{
				$innerContent = htmlspecialchars(utf8_strtoupper($match[0]));
			}
			else
			{
				$innerContent = '?';
			}

			$this->avatarDefaultStylingCache[$username] = [
				'bgColor'      => $bgColor,
				'color'        => $color,
				'innerContent' => $innerContent
			];
		}

		return $this->avatarDefaultStylingCache[$username];
	}

	protected function getFallbackAvatarHtml($innerClassHtml, array &$outerAttributes)
	{
		if (empty($outerAttributes['class']))
		{
			$outerAttributes['class'] = '';
		}
		else
		{
			$outerAttributes['class'] .= ' ';
		}

		$fallbackType = $this->style->getProperty('avatarDefaultType', 'text');
		$outerAttributes['class'] .= 'avatar--default avatar--default--' . $fallbackType;

		return '<span class="' . $innerClassHtml . '"></span>';
	}

	public function fnBaseUrl($templater, &$escape, $url = null, $full = false)
	{
		$pather = $this->pather;

		if ($full === true)
		{
			$modifier = 'full';
		}
		else if (is_string($full))
		{
			$modifier = $full;
		}
		else
		{
			$modifier = 'base';
		}

		return $pather($url ?: '', $modifier);
	}

	public function fnBbCode($templater, &$escape, $bbCode, $context, $content, array $options = [], $type = 'html')
	{
		$escape = false;

		return $this->app->bbCode()->render($bbCode, $type, $context, $content, $options);
	}

	public function fnBbCodeSnippet($templater, &$escape, $bbCode, $context, $content, $maxLength, array $options = [], $type = 'html')
	{
		$bbCodeContainer = $this->app->bbCode();

		$parser = $bbCodeContainer->parser();
		$rules = $bbCodeContainer->rules($context);

		$cleaner = $bbCodeContainer->renderer('bbCodeClean');
		$formatter = $this->app->stringFormatter();

		$snippet = $cleaner->render($formatter->wholeWordTrimBbCode($bbCode, $maxLength), $parser, $rules);

		return $this->fnBbCode($templater, $escape, $snippet, $context, $content, $options, $type);
	}

	public function fnBbCodeType($templater, &$escape, $type, $bbCode, $context, $content, array $options = [])
	{
		return $this->fnBbCode($templater, $escape, $bbCode, $context, $content, $options, $type);
	}

	public function fnBbCodeTypeSnippet($templater, &$escape, $type, $bbCode, $context, $content, $maxLength, array $options = [])
	{
		return $this->fnBbCodeSnippet($templater, $escape, $bbCode, $context, $content, $maxLength, $options, $type);
	}

	public function fnButtonIcon($templater, &$escape, $icon)
	{
		$icon = preg_replace('#[^a-zA-Z0-9_-]#', '', strval($icon));
		if (!$icon)
		{
			return '';
		}

		$escape = false;

		return " button--icon button--icon--" . $icon;
	}

	public function fnCacheKey($templater, &$escape)
	{
		return \XF::visitor()->getClientSideCacheKey();
	}

	public function fnCallMacro($templater, &$escape, $template, $name, array $arguments = [])
	{
		if (count(func_get_args()) < 5)
		{
			$arguments = $name;
			$name = $template;
			$template = null;
		}
		$escape = false;
		return $this->renderMacro($template, $name, $arguments);
	}

	public function fnCallable($templater, &$escape, $var, $fn)
	{
		$escape = false;

		if (!\XF\Util\Php::validateCallback($var, $fn))
		{
			return false;
		}
		if (!\XF\Util\Php::nameIndicatesReadOnly($fn))
		{
			return false;
		}

		return true;
	}

	public function fnCaptcha($templater, &$escape, $force = false, $forceVisible = false)
	{
		$options = [
			'force' => boolval($force),
			'forceVisible' => boolval($forceVisible),
		];
		return $this->fnCaptchaOptions($templater, $escape, $options);
	}

	public function fnCaptchaOptions($templater, &$escape, array $options = [])
	{
		$options = array_replace([
			'force' => false,
			'force-visible' => false,
			'context' => ''
		], $options);

		if ($options['force'] === 'false' || $options['force'] === '0')
		{
			$options['force'] = false;
		}
		if ($options['force-visible'] === 'false' || $options['force-visible'] === '0')
		{
			$options['force-visible'] = false;
		}

		if (!$options['force'] && !\XF::visitor()->isShownCaptcha())
		{
			return '';
		}

		$captcha = $this->app->captcha(null);
		if ($captcha)
		{
			$escape = false;

			$captcha->setForceVisible(boolval($options['force-visible']));
			$captcha->setContext($options['context'] ?? '');
			return $captcha->render($templater);
		}

		return '';
	}

	public function fnCopyright($templater, &$escape)
	{
		$escape = false;

		return ($this->app instanceof \XF\Admin\App ? \XF::getCopyrightHtmlAcp() : \XF::getCopyrightHtml());
	}

	public function fnCoreJs($templater, &$escape)
	{
		$jqVersion = $this->jQueryVersion;
		$jqMin = '.min';
		$jqLocal = $this->getJsUrl("vendor/jquery/jquery-{$jqVersion}{$jqMin}.js");
		$jqRemote = '';

		if ($this->app['app.defaultType'] == 'public')
		{
			switch ($this->jQuerySource)
			{
				case 'jquery':
					$jqRemote = "https://code.jquery.com/jquery-{$jqVersion}{$jqMin}.js";
					break;

				case 'google':
					$jqRemote = "https://ajax.googleapis.com/ajax/libs/jquery/{$jqVersion}/jquery{$jqMin}.js";
					break;

				case 'microsoft':
					$jqRemote = "https://ajax.aspnetcdn.com/ajax/jquery/jquery-{$jqVersion}{$jqMin}.js";
					break;
			}
		}

		if ($jqRemote)
		{
			$output = '<script src="' . htmlspecialchars($jqRemote) . '"></script>'
				. '<script>window.jQuery || document.write(\'<script src="'
				. \XF::escapeString($jqLocal, 'htmljs') . '"><\\/script>\')</script>';
		}
		else
		{
			$output = '<script src="' . htmlspecialchars($jqLocal) . '"></script>';
		}

		$files = [
			'vendor/vendor-compiled.js'
		];
		if ($this->app['config']['development']['fullJs'])
		{
			$files[] = 'xf/core.js';
			foreach (glob(\XF::getRootDirectory() . '/js/xf/core/*.js') AS $file)
			{
				if (substr($file, -7) == '.min.js')
				{
					continue;
				}
				$files[] = 'xf/core/' . basename($file);
			}
		}
		else
		{
			$files[] = 'xf/core-compiled.js';
		}
		foreach ($files AS $file)
		{
			$output .= "\n\t<script src=\"" . htmlspecialchars($this->getJsUrl($file)) . '"></script>';
		}

		$escape = false;

		return $output;
	}

	public function fnCount($templater, &$escape, $value)
	{
		if (is_array($value) || $value instanceof \Countable)
		{
			return count($value);
		}

		return null;
	}

	public function fnCsrfInput($templater, &$escape)
	{
		$escape = false;

		return '<input type="hidden" name="_xfToken" value="' . htmlspecialchars($this->app['csrf.token']) . '" />';
	}

	public function fnCsrfToken($templater, &$escape)
	{
		return $this->app['csrf.token'];
	}

	public function fnCssUrl($templater, &$escape, array $templates, $includeValidation = true)
	{
		return $this->getCssLoadUrl($templates, $includeValidation);
	}

	public function fnDate($templater, &$escape, $date, $format = null)
	{
		if (is_integer($format) || $format instanceof \DateTime)
		{
			// allow date($format, $date) in templates, to match PHP date() syntax
			$tmp = $format;
			$format = $date;
			$date = $tmp;
		}

		return $this->language->date($date, $format);
	}

	public function fnDateFromFormat($templater, &$escape, $format, $dateString, $timeZone = null)
	{
		return \DateTime::createFromFormat($format, $dateString, $timeZone === null
			? $this->language->getTimezone()
			: new \DateTimeZone($timeZone));
	}

	public function fnDateDynamic($templater, &$escape, $dateTime, array $attributes = [])
	{
		if (!($dateTime instanceof \DateTime))
		{
			$ts = intval($dateTime);
			$dateTime = new \DateTime();
			$dateTime->setTimestamp($ts);
			$dateTime->setTimezone($this->language->getTimeZone());
		}
		else
		{
			$ts = $dateTime->getTimestamp();
		}

		list($date, $time) = $this->language->getDateTimeParts($ts);
		$full = $this->language->getDateTimeOutput($date, $time);
		$relative = $this->language->getRelativeDateTimeOutput($ts, $date, $time, !empty($attributes['data-full-date']));

		$class = $this->processAttributeToHtmlAttribute($attributes, 'class', 'u-dt', true);

		unset($attributes['title']);
		$unhandledAttrs = $this->processUnhandledAttributes($attributes);

		$escape = false;

		return '<time ' . $class . ' dir="auto" datetime="' . $dateTime->format(\DateTime::ISO8601)
			. '" data-time="' . $ts
			. '" data-date-string="' . htmlspecialchars($date)
			. '" data-time-string="' . htmlspecialchars($time)
			. '" title="' . htmlspecialchars($full)
			. '"' . $unhandledAttrs . '>' . htmlspecialchars($relative) . '</time>';
	}

	public function fnDateTime($templater, &$escape, $date)
	{
		return $this->language->dateTime($date);
	}

	public function fnDebugUrl($templater, &$escape, $url = null)
	{
		if (!$url)
		{
			$url = $this->app->request()->getRequestUri();
		}

		if (strpos($url, '?') === false)
		{
			$url .= '?';
		}
		else
		{
			$url .= '&';
		}

		return $url . '_debug=1';
	}

	public function fnDump($templater, &$escape, $value)
	{
		$escape = false;
		ob_start();
		\XF::dump($value);
		$dump = ob_get_clean();

		return $dump;
	}

	public function fnDumpSimple($templater, &$escape, $value)
	{
		$escape = false;

		return \XF::dumpSimple($value, false);
	}

	public function fnDuration($templater, &$escape, $number, $units)
	{
		switch ($units)
		{
			case 'years':
			case 'months':
			case 'weeks':
			case 'days':
			{
				return $this->language->phrase("x_{$units}", [$units => $number]);
			}

			case 'hours':
			case 'minutes':
			case 'seconds':
			{
				return $this->language->phrase("x_{$units}", ['count' => $number]);
			}

			default:
			{
				return "{$number} {$units}";
			}
		}
	}

	public function fnEmpty($templater, &$escape, $value)
	{
		return empty($value);
	}

	public function fnFaWeight($templater, &$escape = false)
	{
		$faWeight = $this->fnProperty($templater, $escape, 'fontAwesomeWeight', 400);

		if ($faWeight <= 300)
		{
			return 'l';
		}
		else if ($faWeight <= 400)
		{
			return 'r';
		}
		else if ($faWeight <= 900)
		{
			return 's';
		}
		else
		{
			return 'r';
		}
	}

	public function fnDisplayTotals($templater, &$escape, $count, $total = null)
	{
		if (is_array($count) || $count instanceof \Countable)
		{
			$count = count($count);
		}

		if ($total === null)
		{
			$total = $count;
		}
		else if (is_array($total) || $total instanceof \Countable)
		{
			$total = count($total);
		}

		$params = [
			'count' => $this->language->numberFormat($count),
			'total' => $this->language->numberFormat($total)
		];

		if ($count < 1)
		{
			$phrase = 'no_items_to_display';
		}
		else if ($count == $total)
		{
			$phrase = 'showing_all_items';
		}
		else
		{
			$phrase = 'showing_x_of_y_items';
		}

		$escape = false;
		return '<span class="js-displayTotals" data-count="' . $count . '" data-total="' . $total . '"'
			. ' data-xf-init="tooltip" title="' . $this->filterForAttr($this, $this->phrase('there_are_x_items_in_total', ['total' => $params['total']]), $null) . '">'
			. $this->phrase($phrase, $params) . '</span>';
	}

	public function fnFileSize($templater, &$escape, $number)
	{
		return $this->language->fileSizeFormat((float) $number);
	}

	public function fnCeil($templater, &$escape, $value)
	{
		return ceil((float) $value);
	}

	public function fnFloor($templater, &$escape, $value)
	{
		return floor((float) $value);
	}

	public function fnGravatarUrl($templater, &$escape, $user, $size)
	{
		if ($user instanceof \XF\Entity\User)
		{
			return $user->getGravatarUrl($size);
		}

		return '';
	}

	public function fnHighlight($templater, &$escape, $string, $term, $class = 'textHighlight')
	{
		$escape = false;
		return $this->app->stringFormatter()->highlightTermForHtml((string) $string, $term, $class);
	}

	public function fnKeyExists($templater, &$escape, $array, $key)
	{
		if (!is_array($array))
		{
			return false;
		}

		return array_key_exists($key, $array);
	}

	public function fnInArray($templater, &$escape, $needle, $haystack, $strict = false)
	{
		$escape = false;
		if ($haystack instanceof \Traversable)
		{
			$haystack = iterator_to_array($haystack);
		}

		if (!is_array($haystack))
		{
			return false;
		}

		return in_array($needle, $haystack, $strict);
	}

	public function fnIsArray($templater, &$escape, $array)
	{
		$escape = false;
		return is_array($array);
	}

	public function fnIsScalar($templater, &$escape, $value)
	{
		$escape = false;
		return is_scalar($value);
	}

	public function fnIsAddonActive($templater, &$escape, $addOnId, $versionId = null, $operator = '>=')
	{
		return \XF::isAddOnActive($addOnId, $versionId, $operator);
	}

	public function fnIsEditorCapable($templater, &$escape)
	{
		if (!\XF::visitor()->canUseRte())
		{
			return false;
		}

		$ua = $this->app->request()->getUserAgent();
		if (!$ua)
		{
			return true;
		}

		if (preg_match('#blackberry|opera mini|opera mobi#i', $ua))
		{
			// older/limited mobile browsers
			return false;
		}

		if (preg_match('#msie (\d+)#i', $ua, $match) && intval($match[1]) < 10)
		{
			// only supported in IE10+
			return false;
		}

		if (preg_match('#android (\d+)\.#i', $ua, $match) && intval($match[1]) < 5)
		{
			// Froala only officially supports Android 6 and above.
			// However, it seems Froala actually still works on Android 5.1.1 (at least) so we'll go with that.
			// So far we've only had issues reported with Android 4.x.
			// Older Android versions do support Chrome and Firefox so if those are installed
			// They will likely be up to date and work fine with the RTE.
			if (preg_match('#(Firefox/|Chrome/)#i', $ua))
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		if (preg_match('#(iphone|ipod|ipad).+OS (\d+)_#i', $ua, $match) && intval($match[2]) < 8)
		{
			// only supported in iOS 8+
			return false;
		}

		return true;
	}

	public function fnIsToggled($templater, &$escape, $storageKey, $storageContainer = 'toggle')
	{
		$cookie = $this->app->request()->getCookie($storageContainer);
		if (!$cookie)
		{
			return false;
		}

		$cookieDecoded = @json_decode($cookie, true);
		if (!$cookieDecoded)
		{
			return false;
		}

		if (!isset($cookieDecoded[$storageKey]))
		{
			return false;
		}

		return empty($cookieDecoded[$storageKey][2]);
	}

	public function fnIsChanged($templater, &$escape, $entity, $key)
	{
		if ($entity instanceof Entity && $entity->isChanged($key))
		{
			return true;
		}

		return false;
	}

	public function fnJsUrl($templater, &$escape, $file)
	{
		return $this->getJsUrl($file);
	}

	public function fnLastPages($templater, &$escape, $total, $perPage, $max = 2)
	{
		$escape = false;

		$perPage = intval($perPage);
		if ($perPage <= 0)
		{
			return [];
		}

		$total = intval($total);
		if ($total <= $perPage)
		{
			return [];
		}

		$max = max(1, intval($max));

		$totalPages = ceil($total / $perPage);
		if ($totalPages == 2)
		{
			return [2];
		}

		// + 1 represents that range covers including the start, whereas we want only the last X, which is start + 1
		$start = max($totalPages - $max + 1, 2);
		return range($start, $totalPages);
	}

	public function fnLikes($templater, &$escape, $count, $users, $liked, $url, array $attributes = [])
	{
		$escape = false;

		$count = intval($count);
		if ($count <= 0)
		{
			return '';
		}

		if (!$users || !is_array($users))
		{
			$phrase = ($count > 1 ? 'likes.x_people' : 'likes.1_person');
			return $this->renderTemplate('public:like_list_row', [
				'url' => $url,
				'likes' => $this->phrase($phrase, ['likes' => $this->language->numberFormat($count)])
			]);
		}

		$userCount = count($users);
		if ($userCount < 5 && $count > $userCount) // indicates some users are deleted
		{
			for ($i = 0; $i < $count; $i++)
			{
				if (empty($users[$i]))
				{
					$users[$i] = [
						'user_id' => 0,
						'username' => $this->phrase('likes.deleted_user')
					];
				}
			}
		}

		if ($liked)
		{
			$visitorId = \XF::visitor()->user_id;
			foreach ($users AS $key => $user)
			{
				if ($user['user_id'] == $visitorId)
				{
					unset($users[$key]);
					break;
				}
			}

			$users = array_values($users);

			if (count($users) == 3)
			{
				unset($users[2]);
			}
		}

		$user1 = $user2 = $user3 = '';

		if (isset($users[0]))
		{
			$user1 = $this->preEscaped('<bdi>' . \XF::escapeString($users[0]['username']) . '</bdi>', 'html');
			if (isset($users[1]))
			{
				$user2 = $this->preEscaped('<bdi>' . \XF::escapeString($users[1]['username']) . '</bdi>', 'html');
				if (isset($users[2]))
				{
					$user3 = $this->preEscaped('<bdi>' . \XF::escapeString($users[2]['username']) . '</bdi>', 'html');
				}
			}
		}

		switch ($count)
		{
			case 1: $phrase = ($liked ? 'likes.you' : 'likes.user1'); break;
			case 2: $phrase = ($liked ? 'likes.you_and_user1' : 'likes.user1_and_user2'); break;
			case 3: $phrase = ($liked ? 'likes.you_user1_and_user2' : 'likes.user1_user2_and_user3'); break;
			case 4: $phrase = ($liked ? 'likes.you_user1_user2_and_1_other' : 'likes.user1_user2_user3_and_1_other'); break;
			default: $phrase = ($liked ? 'likes.you_user1_user2_and_x_others' : 'likes.user1_user2_user3_and_x_others'); break;
		}

		$params = [
			'user1' => $user1,
			'user2' => $user2,
			'user3' => $user3,
			'others' => $this->language->numberFormat($count - 3)
		];

		return $this->renderTemplate('public:like_list_row', [
			'url' => $url,
			'likes' => $this->phrase($phrase, $params)
		]);
	}

	public function fnLikesContent($templater, &$escape, $content, $url, array $attributes = [])
	{
		$escape = false;
		if (!($content instanceof \XF\Mvc\Entity\Entity))
		{
			trigger_error("Content must be an entity link likes_content (given " . gettype($content) . ")", E_USER_WARNING);
			return '';
		}

		$count = $content->likes;
		$users = $content->like_users;

		$userId = \XF::visitor()->user_id;
		$liked = $userId ? isset($content->Likes[$userId]) : false;

		return $this->func('likes', [$count, $users, $liked, $url, $attributes], false);
	}

	public function fnLink($templater, &$escape, $link, $data = null, array $params = [], $hash = null)
	{
		return $this->getRouter()->buildLink($link, $data, $params, $hash);
	}

	public function fnLinkType($templater, &$escape, $type, $link, $data = null, array $params = [], $hash = null)
	{
		$container = $this->app->container();

		/** @var \XF\Mvc\Router|null $router */
		$router = $container['router.' . $type] ?? null;
		if ($router)
		{
			return $router->buildLink($link, $data, $params, $hash);
		}
		else
		{
			return '';
		}
	}

	public function fnMin($templater, &$escape, ...$args)
	{
		return min(...$args);
	}

	public function fnMax($templater, &$escape, ...$args)
	{
		return max(...$args);
	}

	public function fnMaxLength($templater, &$escape, $entity, $column)
	{
		static $entityCache = [];

		// if $entity is not an entity, expect an entity id string like XF:Thread
		if (is_string($entity) && preg_match('/^\w+(?:\\\\\w+)?:\w+$/i', $entity))
		{
			if (!isset($entityCache[$entity]))
			{
				$entityCache[$entity] = $this->app->em()->create($entity);
			}

			$entity = $entityCache[$entity];
		}

		if ($entity instanceof \XF\Mvc\Entity\Entity)
		{
			$maxlength = $entity->getMaxLength($column);

			return $maxlength > 0 ? $maxlength : null;
		}
		else
		{
			return null;
		}
	}

	public function fnMediaSites($templater, &$escape)
	{
		$output = [];
		foreach ($this->mediaSites AS $site)
		{
			if (!$site['supported'])
			{
				continue;
			}
			if ($site['site_url'])
			{
				$output[] = '<a href="' . htmlspecialchars($site['site_url']) . '" target="_blank" rel="nofollow" dir="auto">' . htmlspecialchars($site['site_title']) . '</a>';
			}
			else
			{
				$output[] = htmlspecialchars($site['site_title']);
			}
		}
		$escape = false;
		return implode(', ', $output);
	}

	public function fnMustache($templater, &$escape, $name, $inner = null)
	{
		$escape = false;

		$var = '{{' . $name . '}}';

		if ($inner === null)
		{
			return $var;
		}
		else
		{
			$close = '{{/' . substr($name, 1) . '}}';
			return "{$var}{$inner}{$close}";
		}
	}

	public function fnNumber($templater, &$escape, $number, $precision = 0)
	{
		return $this->language->numberFormat($number, $precision);
	}

	public function fnNumberShort($templater, &$escape, $number, $precision = 0)
	{
		return $this->language->shortNumberFormat($number, $precision);
	}

	public function fnNamedColors($templater, &$escape)
	{
		return \XF\Util\Color::getNamedColors();
	}

	public function fnPageDescription($templater, &$escape)
	{
		if (isset($this->pageParams['pageDescription']))
		{
			return $this->pageParams['pageDescription'];
		}
		else
		{
			return '';
		}
	}

	public function fnPageH1($templater, &$escape, $fallback = '')
	{
		if (isset($this->pageParams['pageH1']))
		{
			return $this->pageParams['pageH1'];
		}
		else if (isset($this->pageParams['pageTitle']))
		{
			return $this->pageParams['pageTitle'];
		}
		else
		{
			return $fallback;
		}
	}

	public function fnPageNav($templater, &$escape, array $config)
	{
		$escape = false;

		$config = array_merge([
			'pageParam' => 'page',

			'page' => 0,
			'perPage' => 0,
			'total' => 0,
			'range' => 2,

			'template' => $this->applyDefaultTemplateType('page_nav'),
			'variantClass' => '',

			'link' => '',
			'data' => null,
			'params' => [],
			'hash' => null,

			'wrapper' => '',
			'wrapperclass' => '',
		], $config);

		if (!is_array($config['params']))
		{
			$config['params'] = [];
		}

		$perPage = intval($config['perPage']);
		if ($perPage <= 0)
		{
			return '';
		}

		$total = intval($config['total']);
		if ($total <= $perPage)
		{
			return '';
		}

		$totalPages = ceil($total / $perPage);

		$current = intval($config['page']);
		$current = max(1, min($current, $totalPages));

		// number of pages either side of the current page
		$range = intval($config['range']);

		$startInner = max(2, $current - $range);
		$endInner = min($current + $range, $totalPages - 1);

		if ($startInner <= $endInner)
		{
			$innerPages = range($startInner, $endInner);
		}
		else
		{
			$innerPages = [];
		}

		$wrapperClass = $this->processAttributeToRaw($config, 'wrapperclass', '', true);
		$wrapper = $this->processAttributeToRaw($config, 'wrapper');
		if ($wrapperClass && !$wrapper)
		{
			$wrapper = 'div';
		}

		if (
			$config['hash']
			&& is_string($config['hash'])
			&& preg_match('/^(>|>=|<|<=|=)(\d+):([^, ]+)$/', $config['hash'], $hashMatch)
		)
		{
			$operator = $hashMatch[1];
			$testPage = intval($hashMatch[2]);
			$outputHash = $hashMatch[3];

			$config['hash'] = function($link, $data, array $parameters) use ($operator, $testPage, $outputHash)
			{
				$page = $parameters['page'] ?? null;
				if (!$page)
				{
					$page = 1;
				}

				if ($page === '%page%')
				{
					// can't do conditional hashes with placeholders
					return '';
				}

				switch ($operator)
				{
					case '>': $matched = ($page > $testPage); break;
					case '>=': $matched = ($page >= $testPage); break;
					case '<': $matched = ($page < $testPage); break;
					case '<=': $matched = ($page <= $testPage); break;
					case '=': $matched = ($page == $testPage); break;
					default: return '';
				}

				return $matched ? $outputHash : '';
			};
		}

		$router = $this->getRouter();

		$prev = false;
		if ($current > 1)
		{
			$prevPageParam = $current - 1;
			if ($prevPageParam <= 1)
			{
				$prevPageParam = null;
			}

			$prev = $router->buildLink(
				$config['link'],
				$config['data'],
				$config['params'] + [$config['pageParam'] => $prevPageParam],
				$config['hash']
			);
			if (!isset($this->pageParams['head']['prev']))
			{
				$this->pageParams['head']['prev'] = $this->preEscaped('<link rel="prev" href="' . \XF::escapeString($prev) . '" />');
			}
		}

		$next = false;
		if ($current < $totalPages)
		{
			$next = $router->buildLink(
				$config['link'],
				$config['data'],
				$config['params'] + [$config['pageParam'] => $current + 1],
				$config['hash']
			);
			if (!isset($this->pageParams['head']['next']))
			{
				$this->pageParams['head']['next'] = $this->preEscaped('<link rel="next" href="' . \XF::escapeString($next) . '" />');
			}
		}

		$html = $this->renderTemplate($config['template'], [
			'prev' => $prev,
			'current' => $current,
			'next' => $next,
			'perPage' => $perPage,
			'total' => $total,
			'totalPages' => $totalPages,
			'innerPages' => $innerPages,
			'startInner' => $startInner,
			'endInner' => $endInner,
			'pageParam' => $config['pageParam'],
			'link' => $config['link'],
			'data' => $config['data'],
			'params' => $config['params'],
			'hash' => $config['hash'],
			'variantClass' => $config['variantClass']
		]);

		if ($wrapper)
		{
			$wrapperOpen = $wrapper . ($wrapperClass ? " class=\"$wrapperClass\"" : '');
			$html = "<{$wrapperOpen}>{$html}</{$wrapper}>";
		}

		return $html;
	}

	public function fnPageParam($templater, &$escape, string $name)
	{
		if (strpos($name, '.') === false)
		{
			return $this->pageParams[$name] ?? null;
		}

		$ref = $this->pageParams;
		$hasValid = false;
		foreach (explode('.', $name) AS $part)
		{
			if (!strlen($part))
			{
				continue;
			}

			if (!is_array($ref))
			{
				return null;
			}
			if (!isset($ref[$part]))
			{
				return null;
			}

			$ref = $ref[$part];
			$hasValid = true;
		}

		return $hasValid ? $ref : null;
	}

	public function fnPageTitle($templater, &$escape, $formatter = null, $fallback = '', $page = null)
	{
		if (isset($this->pageParams['pageTitle']) && strlen($this->pageParams['pageTitle']))
		{
			$pageTitle = $this->pageParams['pageTitle'];

			$page = intval($page);
			if ($page > 1)
			{
				$pageAppend = $this->language->phrase('title_page_x', ['page' => $page]);
				if ($pageTitle instanceof \XF\PreEscaped)
				{
					$pageTitle = clone $pageTitle;
					$pageTitle->value .= $pageAppend;
				}
				else
				{
					$pageTitle .= $pageAppend;
				}
			}

			if ($formatter)
			{
				$value = sprintf($formatter,
					$this->escape($pageTitle, $escape),
					$this->escape($fallback, $escape)
				);

				$escape = false;
				return $value;
			}
			else
			{
				return $pageTitle;
			}
		}
		else
		{
			return $fallback;
		}
	}

	public function fnParens($templater, &$escape, $value)
	{
		return $this->filterParens($templater, (string) $value, $escape);
	}

	public function fnParseLessColor($templater, &$escape, $value)
	{
		if (!is_string($value))
		{
			return $value;
		}

		// normalize color to its rgb components (TODO: support alpha channel in future)
		$rgbColor = \XF\Util\Color::colorToRgb($value);
		if ($rgbColor)
		{
			// already a valid color so convert to hex for compatibility and use as-is.
			$hex = \XF\Util\Color::rgbToHex($rgbColor);
			return '#' . $hex;
		}

		/** @var \XF\CssRenderer $renderer */
		$rendererClass = $this->app->extendClass('XF\CssRenderer');
		$renderer = new $rendererClass($this->app, $this);
		$renderer->setStyle($this->style);

		return $renderer->parseLessColorValue($value);
	}

	public function fnPhraseDynamic($templater, &$escape, $phraseName, array $params = [])
	{
		$phrase = $this->phrase($phraseName, $params);

		return $phrase->render();
	}

	public function fnPrefix($templater, &$escape, $contentType, $prefixId, $format = 'html', $append = null)
	{
		if ($prefixId instanceof Entity)
		{
			$prefixId = $prefixId->prefix_id;
		}

		if (!$prefixId)
		{
			return '';
		}

		$prefixCache = $this->app->container('prefixes.' . $contentType);
		$prefixClass = $prefixCache[$prefixId] ?? null;

		if (!$prefixClass)
		{
			return '';
		}

		$output = $this->func('prefix_title', [$contentType, $prefixId], false);

		switch ($format)
		{
			case 'html':
				$output = '<span class="' . htmlspecialchars($prefixClass) . '" dir="auto">'
					. \XF::escapeString($output, 'html') . '</span>';
				if ($append === null)
				{
					$append = '<span class="label-append">&nbsp;</span>';
				}
				break;

			case 'plain':
				if ($output instanceof \XF\Phrase)
				{
					$output = $output->render('raw');
				}
				break; // ok as is

			default:
				$output = \XF::escapeString($output, 'html'); // just be safe and escape everything else
		}

		if ($append === null)
		{
			$append = ' - ';
		}

		$escape = false;
		return $output . $append;
	}

	public function fnPrefixGroup($templater, &$escape, $contentType, $groupId)
	{
		if ($groupId == 0)
		{
			return '(' . $this->phrase('ungrouped') . ')';
		}

		return $this->phrase(sprintf('%s_prefix_%s.%d', $contentType, 'group', $groupId), [], false);
	}

	public function fnPrefixTitle($templater, &$escape, $contentType, $prefixId)
	{
		return $this->getPrefixPhrase($contentType, $prefixId, 'title');
	}

	public function fnPrefixDescription($templater, &$escape, $contentType, $prefixId)
	{
		return $this->getPrefixPhrase($contentType, $prefixId, 'desc');
	}

	public function fnPrefixUsageHelp($templater, &$escape, $contentType, $prefixId)
	{
		return $this->getPrefixPhrase($contentType, $prefixId, 'help');
	}

	protected function getPrefixPhrase($contentType, $prefixId, $phraseType)
	{
		if (!$prefixId)
		{
			return '';
		}

		$prefixCache = $this->app->container('prefixes.' . $contentType);
		$prefixClass = $prefixCache[$prefixId] ?? null;
		if (!$prefixClass)
		{
			return '';
		}

		switch ($phraseType)
		{
			case 'desc':
			case 'help':
				// these allow HTML but also fallback to empty
				$phrase = $this->phrase(sprintf('%s_prefix_%s.%d', $contentType, $phraseType, $prefixId), []);
				$phrase->fallback('');
				return $phrase;

			case 'title':
			default:
				return $this->phrase(sprintf('%s_prefix.%d', $contentType, $prefixId), [], false);

		}
	}

	public function fnProfileBanner($templater, &$escape, $user, $sizeCode, $canonical = false, $attributes = [], $contentHtml = '')
	{
		$escape = false;

		$class = $this->processAttributeToRaw($attributes, 'class', ' %s', true);
		$style = $this->processAttributeToRaw($attributes, 'style', '%s', true);
		$toggleClass = $this->processAttributeToRaw($attributes, 'toggle', '%s', true);
		$href = $this->processAttributeToRaw($attributes, 'href', '%s', true);
		$overlay = $this->processAttributeToRaw($attributes, 'overlay', '%s', true);
		$hide = $this->processAttributeToRaw($attributes, 'hideempty', '%s', true);

		$sizeCode = preg_replace('#[^a-zA-Z0-9_-]#s', '', $sizeCode);

		$bannerUrl = null;
		if ($user instanceof \XF\Entity\User)
		{
			$bannerUrl = $user->Profile->getBannerUrl($sizeCode, $canonical);

			$class .= " memberProfileBanner-u{$user->user_id}-{$sizeCode}";
		}

		if ($hide)
		{
			$hide = 'data-hide-empty="true"';

			if (!$bannerUrl)
			{
				$class .= ' memberProfileBanner--empty';
			}
		}

		$styleAttr = '';
		if ($style || $bannerUrl)
		{
			$styleAttr = 'style="';
			if ($style)
			{
				$styleAttr .= rtrim($style, ';') . '; ';
			}
			if ($bannerUrl)
			{
				$styleAttr .= 'background-image: url(' . $bannerUrl . ');';

				if ($user->Profile->banner_position_y !== null)
				{
					$styleAttr .= ' background-position-y: ' . $user->Profile->banner_position_y . '%;';
				}
			}
			$styleAttr .= '"';
		}

		$link = '';
		if ($href)
		{
			if ($overlay)
			{
				$overlay = ' data-xf-click="overlay"';
			}
			$class .= ' fauxBlockLink';
			$link = "<a href=\"$href\" class=\"fauxBlockLink-blockLink\" {$overlay}></a>";
		}

		$unhandledAttrs = $this->processUnhandledAttributes($attributes);

		return "
			<div class=\"memberProfileBanner{$class}\" data-toggle-class=\"{$toggleClass}\" {$hide} {$styleAttr}{$unhandledAttrs}>{$link}{$contentHtml}</div>
		";
	}

	public function fnProperty($templater, &$escape, $name, $fallback = null)
	{
		$escape = false;

		if (!$this->style)
		{
			return $fallback;
		}

		return $this->style->getProperty($name, $fallback);
	}

	public function fnRand($templater, &$escape, $min = 0, $max = 999)
	{
		return mt_rand($min, $max);
	}

	public function fnRange($templater, &$escape, $start, $end, $step = 1)
	{
		return range($start, $end, $step);
	}

	public function fnReact($templater, &$escape, array $config)
	{
		$escape = false;

		$config = array_merge([
			'template' => $this->applyDefaultTemplateType('react'),
			'list' => null,

			'content' => null,
			'link' => '',
			'params' => [],
			'class' => 'actionBar-action actionBar-action--reaction'
		], $config);

		/** @var \XF\Entity\ReactionTrait $content */
		$content = $config['content'];

		// note: this is quicker and easier than using class_uses which only lists traits on the direct parent
		if (!method_exists($content, 'canReact'))
		{
			trigger_error("React content must be using the XF\Entity\ReactionTrait trait.", E_USER_WARNING);
			return '';
		}

		if (!$content->canReact())
		{
			return '';
		}

		$reactionContent = $content->getReactionContent();
		$hasReaction = $reactionContent ? true : false;
		$reaction = $reactionContent ?: $this->app->container('reactionDefault');
		$config['params']['reaction_id'] = $reaction['reaction_id'];

		$html = $this->renderTemplate($config['template'], [
			'link' => $config['link'],
			'content' => $content,
			'params' => $config['params'],
			'class' => $config['class'],

			'list' => $config['list'],

			'hasReaction' => $hasReaction,
			'reaction' => $reaction
		]);

		return $html;
	}

	public function fnAlertReaction($templater, &$escape, $reactionId, $size = 'small')
	{
		return $this->func('reaction', [
			[
				'id' => $reactionId,
				'showtitle' => true,
				$size => true,
				'hasreaction' => true
			]
		], $escape);
	}

	public function fnReaction($templater, &$escape, array $config)
	{
		$escape = false;

		$baseConfig = [
			'id' => null,
			'class' => '',
			'content' => null,
			'link' => '',
			'params' => [],
			'list' => null,
			'hasreaction' => false,
			'init' => false,
			'showtitle' => false,
			'appendtitle' => '',
			'small' => false,
			'medium' => false,
			'tooltip' => false,
			'routerType' => 'public'
		];
		$config = array_replace($baseConfig, $config);

		$hasReaction = $config['hasreaction'];
		if (is_string($config['hasreaction']) && $config['hasreaction'] == 'false')
		{
			$hasReaction = false;
		}

		$reactionId = $config['id'];
		if (!is_int($reactionId))
		{
			$reactionId = $reactionId['reaction_id'];
		}

		if (!$reactionId)
		{
			return '';
		}

		$reactionCache = $this->app->container('reactions');
		if (!isset($reactionCache[$reactionId]))
		{
			return '';
		}
		$reaction = $reactionCache[$reactionId];

		$reactionTitle = htmlspecialchars($this->func('reaction_title', [$reaction]));
		$pather = $this->pather;

		$tooltip = '';
		if ($config['tooltip'])
		{
			$tooltip = ' data-xf-init="tooltip" data-extra-class="tooltip--basic tooltip--noninteractive"';
		}

		$html = '<i aria-hidden="true"></i>';
		if (empty($reaction['sprite_params']))
		{
			$url = htmlspecialchars($pather ? $pather($reaction['image_url'], 'base') : $reaction['image_url']);
			$srcSet = '';
			if (!empty($reaction['image_url_2x']))
			{
				$url2x = htmlspecialchars($pather ? $pather($reaction['image_url_2x'], 'base') : $reaction['image_url_2x']);
				$srcSet = 'srcset="' . $url2x . ' 2x"';
			}

			$html .= '<img src="' . $url . '" ' . $srcSet . ' class="reaction-image js-reaction" alt="' . $reactionTitle . '" title="' . $reactionTitle . '"' . $tooltip . ' />';
		}
		else
		{
			// embed a data URI to avoid a request that doesn't respect paths fully
			$html .= '<img src="' . self::TRANSPARENT_IMG_URI . '" class="reaction-sprite js-reaction" alt="' . $reactionTitle . '" title="' . $reactionTitle . '"' . $tooltip . ' />';
		}

		if ($config['showtitle'])
		{
			$displayTitle = '<bdi>' . $reactionTitle . '</bdi>';
			if ($config['appendtitle'])
			{
				$displayTitle .= ' ' . $config['appendtitle'];
			}
			$html .= ' <span class="reaction-text js-reactionText">' . $displayTitle . '</span>';
		}

		$init = '';
		if ($config['init'])
		{
			$init = ' data-xf-init="reaction"';
			if ($config['list'])
			{
				$init .= ' data-reaction-list="' . $config['list'] . '"';
			}
		}

		$unhandledAttrs = $this->processUnhandledAttributes(array_diff_key($config, $baseConfig));

		$tag = 'span';
		$href = '';
		if ($config['link'])
		{
			if (is_array($config['link']))
			{
				$link = $config['link'];
				$config['link'] = $link[0];
				if (!$config['params'])
				{
					$config['params'] = $link[1];
				}
			}

			$tag = 'a';
			$href = $this->app->router($config['routerType'])->buildLink(
				$config['link'], $config['content'], $config['params']
			);
		}

		if ($config['tooltip'] && !$config['link'])
		{
			$tag = 'a';
			$href = '#';
		}

		return '<' . $tag . ($href ? ' href="' . $href . '"' : '')
			. $unhandledAttrs
			. ' class="reaction' . ($config['small'] ? ' reaction--small' : '') . ($config['medium'] ? ' reaction--medium' : '') . ($config['class'] ? ' ' . $config['class'] : '') . ($hasReaction ? ' has-reaction' : '') . (!$hasReaction && $config['init'] ? ' reaction--imageHidden' : '') . ' reaction--' . $reactionId . '"'
			. ' data-reaction-id="' . $reactionId . '"' . $init . '>' . $html . '</' . $tag . '>';
	}

	public function fnReactionTitle($templater, &$escape, $reactionId)
	{
		if (is_array($reactionId))
		{
			if (isset($reactionId['reaction_id']))
			{
				$reactionId = $reactionId['reaction_id'];
			}
			else
			{
				return '';
			}
		}

		return $this->phrase('reaction_title.' . $reactionId);
	}

	/**
	 * @param $templater
	 * @param $escape
	 * @param Entity|\XF\Entity\ReactionTrait $content
	 * @param $link
	 * @param array $linkParams
	 *
	 * @return string
	 */
	public function fnReactions($templater, &$escape, $content, $link, array $linkParams = [])
	{
		if (!($content instanceof Entity))
		{
			trigger_error("Content for reactions is not an entity", E_USER_WARNING);
			return '';
		}

		$escape = false;

		$counts = $content->reactions;
		$users = $content->reaction_users;
		$reactionContent = null;

		$userId = \XF::visitor()->user_id;
		if ($userId)
		{
			$reactionContent = $content->getReactionContent();
		}

		$reacted = $reactionContent ? true : false;

		$reactionDefault = $this->app->container('reactionDefault');

		if (is_array($counts))
		{
			if (!$counts)
			{
				return '';
			}
		}
		else
		{
			// legacy format, likes only, change format pointing at default reaction
			$count = intval($counts);
			if ($count <= 0)
			{
				return '';
			}
			$counts = [
				$reactionDefault['reaction_id'] => $count
			];
		}

		if (is_array($link))
		{
			$tempLink = $link;
			$link = $tempLink[0];
			if (!$linkParams)
			{
				$linkParams = $tempLink[1];
			}
		}

		$total = array_sum($counts);
		$reactionIds = array_slice(array_keys($counts), 0, 3); // TODO: Make top x configurable?

		if (!$users || !is_array($users))
		{
			$phrase = ($total > 1 ? 'reactions.x_people' : 'reactions.1_person');
			return $this->renderTemplate('public:reaction_list_row', [
				'content' => $content,
				'link' => $link,
				'linkParams' => $linkParams,
				'reactionIds' => $reactionIds,
				'reactions' => $this->phrase($phrase, ['reactions' => $this->language->numberFormat($total)])
			]);
		}

		$userCount = count($users);
		if ($userCount < 5 && $total > $userCount) // indicates some users are deleted
		{
			for ($i = 0; $i < $total; $i++)
			{
				if (empty($users[$i]))
				{
					$users[$i] = [
						'user_id' => 0,
						'username' => $this->phrase('reactions.deleted_user')
					];
				}
			}
		}

		if ($reacted)
		{
			$visitorId = \XF::visitor()->user_id;
			foreach ($users AS $key => $user)
			{
				if ($user['user_id'] == $visitorId)
				{
					unset($users[$key]);
					break;
				}
			}

			$users = array_values($users);

			if (count($users) == 3)
			{
				unset($users[2]);
			}
		}

		$user1 = $user2 = $user3 = '';

		if (isset($users[0]))
		{
			$user1 = $this->preEscaped('<bdi>' . \XF::escapeString($users[0]['username']) . '</bdi>', 'html');
			if (isset($users[1]))
			{
				$user2 = $this->preEscaped('<bdi>' . \XF::escapeString($users[1]['username']) . '</bdi>', 'html');
				if (isset($users[2]))
				{
					$user3 = $this->preEscaped('<bdi>' . \XF::escapeString($users[2]['username']) . '</bdi>', 'html');
				}
			}
		}

		switch ($total)
		{
			case 1: $phrase = ($reacted ? 'reactions.you' : 'reactions.user1'); break;
			case 2: $phrase = ($reacted ? 'reactions.you_and_user1' : 'reactions.user1_and_user2'); break;
			case 3: $phrase = ($reacted ? 'reactions.you_user1_and_user2' : 'reactions.user1_user2_and_user3'); break;
			case 4: $phrase = ($reacted ? 'reactions.you_user1_user2_and_1_other' : 'reactions.user1_user2_user3_and_1_other'); break;
			default: $phrase = ($reacted ? 'reactions.you_user1_user2_and_x_others' : 'reactions.user1_user2_user3_and_x_others'); break;
		}

		$params = [
			'user1' => $user1,
			'user2' => $user2,
			'user3' => $user3,
			'others' => $this->language->numberFormat($total - 3)
		];

		return $this->renderTemplate('public:reaction_list_row', [
			'content' => $content,
			'link' => $link,
			'linkParams' => $linkParams,
			'reactionIds' => $reactionIds,
			'reactions' => $this->phrase($phrase, $params)
		]);
	}

	public function fnReactionsSummary($templater, &$escape, $reactions)
	{
		$escape = false;
		if (!$reactions)
		{
			return '';
		}

		$reactionsCache = $this->app->container('reactions');

		foreach ($reactions AS $reactionId => $count)
		{
			if (!isset($reactionsCache[$reactionId]) || !$reactionsCache[$reactionId]['active'])
			{
				unset($reactions[$reactionId]);
				continue;
			}
		}

		$reactionIds = array_slice(array_keys($reactions), 0, 3); // TODO: Make top x configurable?

		return $this->renderTemplate('public:reactions_summary', ['reactionIds' => $reactionIds]);
	}

	public function fnRedirectInput($templater, &$escape, $url = null, $fallbackUrl = null, $useReferrer = true)
	{
		$escape = false;

		if ($url)
		{
			$redirect = $this->app->request()->convertToAbsoluteUri($url);
		}
		else
		{
			$redirect = $this->app->getDynamicRedirect($fallbackUrl ?: null, (bool)$useReferrer);
		}
		return '<input type="hidden" name="_xfRedirect" value="' . htmlspecialchars($redirect) . '" />';
	}

	public function fnRepeat($templater, &$escape, $string, $count)
	{
		return str_repeat($string, $count);
	}

	public function fnRepeatRaw($templater, &$escape, $string, $count)
	{
		$escape = false;
		return str_repeat($string, $count);
	}

	public function fnShortToEmoji($templater, &$escape, $string, $forceStyle = null, $forceCdn = false)
	{
		$escape = false;

		$formatter = $this->app->stringFormatter();
		$emoji = $formatter->getEmojiFormatter($forceStyle, $forceCdn);

		return $emoji->formatShortnameToImage($string);
	}

	public function fnShowIgnored($templater, &$escape, array $attributes = [])
	{
		$escape = false;

		if (!\XF::visitor()->user_id)
		{
			return '';
		}

		$wrapperClass = $this->processAttributeToRaw($attributes, 'wrapperclass', '', true);
		$wrapper = $this->processAttributeToRaw($attributes, 'wrapper');
		if ($wrapperClass && !$wrapper)
		{
			$wrapper = 'div';
		}

		$class = $this->processAttributeToRaw($attributes, 'class', ' %s', true);
		$unhandledAttrs = $this->processUnhandledAttributes($attributes);

		$html = '<a href="javascript:"'
			. ' class="showIgnoredLink is-hidden js-showIgnored' . $class . '" data-xf-init="tooltip"'
			. ' title="' . $this->filterForAttr($this, $this->phrase('show_hidden_content_by_x', ['names' => '{{names}}']), $null) . '"'
			. ' ' . $unhandledAttrs . '>' .
			$this->phrase('show_ignored_content')
			. '</a>';

		if ($wrapper)
		{
			$wrapperOpen = $wrapper . ($wrapperClass ? " class=\"$wrapperClass\"" : '');
			$html = "<{$wrapperOpen}>{$html}</{$wrapper}>";
		}

		return $html;
	}

	public function fnSmilie($templater, &$escape, $smilieString)
	{
		$escape = false;

		$formatter = $this->app->stringFormatter();
		return $formatter->replaceSmiliesHtml($smilieString);
	}

	public function fnSnippet($templater, &$escape, $string, $maxLength = 0, array $options = [])
	{
		if (!$string)
		{
			return '';
		}

		// if we aren't escaping here
		$needsEscaping = ($escape ? true : false);
		$escape = false;

		$formatter = $this->app->stringFormatter();
		$string = $formatter->snippetString($string, $maxLength, $options);

		if (!empty($options['term']))
		{
			return $formatter->highlightTermForHtml(
				$string, $options['term'], $options['highlightClass'] ?? 'textHighlight'
			);
		}
		else
		{
			$returnString = $needsEscaping ? \XF::escapeString($string) : $string;

			if (!empty($options['bbWrapper']))
			{
				return '<div class="bbWrapper">' . $returnString . '</div>';
			}

			return $returnString;
		}
	}

	public function fnSprintf($templater, &$escape, $string, ...$args)
	{
		return sprintf($string, ...$args);
	}

	public function fnStrlen($templater, &$escape, $string)
	{
		return utf8_strlen($string);
	}

	public function fnContains($templater, &$escape, $haystack, $needle)
	{
		return utf8_strpos(utf8_strtolower($haystack), utf8_strtolower($needle)) !== false;
	}

	public function fnStructuredText($templater, &$escape, $string, $nl2br = true)
	{
		$escape = false;

		return $this->app->stringFormatter()->convertStructuredTextToHtml($string, $nl2br);
	}

	public function fnTemplater($templater, &$escape)
	{
		$escape = false;
		return $templater;
	}

	public function fnTime($templater, &$escape, $time, $format = null)
	{
		return $this->language->time($time, $format);
	}

	public function fnTransparentImg($templater, &$escape)
	{
		return self::TRANSPARENT_IMG_URI;
	}

	public function fnTrim($templater, &$escape, $str, $charlist = " \t\n\r\0\x0B")
	{
		return trim(strval($str), $charlist);
	}

	public function fnUniqueId($templater, &$escape, $baseValue = null)
	{
		if ($baseValue === null)
		{
			$this->uniqueIdCounter++;
			$baseValue = $this->uniqueIdCounter;
		}

		return sprintf($this->uniqueIdFormat, $baseValue);
	}

	public function fnUserActivity($templater, &$escape, $user)
	{
		if (!$user instanceof \XF\Entity\User || !$user->user_id)
		{
			return '';
		}

		if (!$user->canViewOnlineStatus())
		{
			return '';
		}

		$activityDetail = null;
		if ($user->canViewCurrentActivity() && $user->Activity)
		{
			if ($user->Activity->description)
			{
				$activityDetail = \XF::escapeString($user->Activity->description);
				if ($user->Activity->item_title)
				{
					$title = \XF::escapeString($user->Activity->item_title);
					$url = \XF::escapeString($user->Activity->item_url);

					$activityDetail .= " <em><a href=\"{$url}\" dir=\"auto\">{$title}</a></em>";
				}

				if ($user->Activity->view_state == 'error' && \XF::visitor()->canBypassUserPrivacy())
				{
					$activityDetail .= ' <span role="presentation" aria-hidden="true">&middot;</span> ';
					$activityDetail .= '<i class="fa fa-exclamation-triangle u-muted" title="' . $this->filterForAttr($this,$this->phrase('viewing_an_error'), $null) . '" aria-hidden="true"></i>';
					$activityDetail .= ' <span class="u-srOnly">' . $this->phrase('viewing_an_error') . '</span>';
				}
			}
		}

		$output = $this->fnDateDynamic($this, $escape, $user->last_activity);
		if ($activityDetail)
		{
			$output .= ' <span role="presentation" aria-hidden="true">&middot;</span> ' . $activityDetail;
		}

		$escape = false;

		return $output;
	}

	public function fnUserBanners($templater, &$escape, $user, $attributes = [])
	{
		/** @var \XF\Entity\User $user */

		$escape = false;

		if (!$user || !($user instanceof \XF\Entity\User) || !$user->user_id)
		{
			/** @var \XF\Repository\User $userRepo */
			$userRepo = $this->app->repository('XF:User');
			$user = $userRepo->getGuestUser();
		}

		$class = $this->processAttributeToRaw($attributes, 'class', ' %s', true);

		if (!empty($attributes['tag']))
		{
			$tag = htmlspecialchars($attributes['tag']);
		}
		else
		{
			$tag = 'em';
		}

		unset($attributes['tag']);

		$unhandledAttrs = $this->processUnhandledAttributes($attributes);

		$banners = [];
		$config = $this->userBannerConfig;

		if (!empty($config['showStaff']) && $user->is_staff)
		{
			$p = $this->phrase('staff_member');
			$banners['staff'] = "<{$tag} class=\"userBanner userBanner--staff{$class}\" dir=\"auto\"{$unhandledAttrs}>"
				. "<span class=\"userBanner-before\"></span><strong>{$p}</strong><span class=\"userBanner-after\"></span></{$tag}>";
		}

		$memberGroupIds = $user->secondary_group_ids;
		$memberGroupIds[] = $user->user_group_id;

		foreach ($this->userBanners AS $groupId => $banner)
		{
			if (!in_array($groupId, $memberGroupIds))
			{
				continue;
			}

			$banners[$groupId] = "<{$tag} class=\"userBanner {$banner['class']}{$class}\"{$unhandledAttrs}>"
				. "<span class=\"userBanner-before\"></span><strong>{$banner['text']}</strong><span class=\"userBanner-after\"></span></{$tag}>";
		}

		if (!$banners)
		{
			return '';
		}

		if (!empty($config['displayMultiple']))
		{
			return implode("\n", $banners);
		}
		else if (!empty($config['showStaffAndOther']) && isset($banners['staff']) && count($banners) >= 2)
		{
			$staffBanner = $banners['staff'];
			unset($banners['staff']);
			return $staffBanner . "\n" . reset($banners);
		}
		else
		{
			return reset($banners);
		}
	}

	public function fnUserBlurb($templater, &$escape, $user, $attributes = [])
	{
		if (!$user instanceof \XF\Entity\User)
		{
			return '';
		}

		$blurbParts = [];

		$userTitle = $this->fnUserTitle($this, $escape, $user);
		if ($userTitle)
		{
			$blurbParts[] = $userTitle;
		}
		if ($user->Profile->age)
		{
			$blurbParts[] = $user->Profile->age;
		}
		if ($user->Profile->location)
		{
			$location = \XF::escapeString($user->Profile->location);
			if (\XF::options()->geoLocationUrl)
			{
				$location = '<a href="' . $this->app->router('public')->buildLink('misc/location-info', null, ['location' => $location]) . '" class="u-concealed" target="_blank" rel="nofollow noreferrer">' . $location. '</a>';
			}
			$blurbParts[] = $this->phrase('from_x_location', ['location' => new \XF\PreEscaped($location)])->render();
		}

		$tag = $this->processAttributeToRaw($attributes, 'tag');
		if (!$tag)
		{
			$tag = 'div';
		}

		$class = $this->processAttributeToRaw($attributes, 'class', '%s', true);
		$unhandledAttrs = $this->processUnhandledAttributes($attributes);

		return "<{$tag} class=\"{$class}\" dir=\"auto\" {$unhandledAttrs}>"
			. implode(' <span role="presentation" aria-hidden="true">&middot;</span> ', $blurbParts)
			. "</{$tag}>";
	}

	public function fnUserTitle($templater, &$escape, $user, $withBanner = false, $attributes = [])
	{
		/** @var \XF\Entity\User $user */

		$escape = false;
		$userIsValid = ($user instanceof \XF\Entity\User);

		$userTitle = null;

		if ($userIsValid)
		{
			$customTitle = $user->custom_title;
			if ($customTitle !== '')
			{
				$userTitle = htmlspecialchars($customTitle);
			}
		}

		if ($userTitle === null)
		{
			if ($withBanner && !empty($this->userBannerConfig['hideUserTitle']))
			{
				if (!$userIsValid)
				{
					return '';
				}

				if (!empty($this->userBannerConfig['showStaff']) && $user->is_staff)
				{
					return '';
				}

				if ($user->isMemberOf(array_keys($this->userBanners)))
				{
					return '';
				}
			}

			if ($userIsValid)
			{
				$userTitle = $this->getDefaultUserTitleForUser($user);
			}
			else
			{
				$guestGroupId = \XF\Entity\User::GROUP_GUEST;
				if (empty($this->groupStyles[$guestGroupId]['user_title']))
				{
					return '';
				}

				$userTitle = $this->groupStyles[$guestGroupId]['user_title'];
			}
		}

		if ($userTitle === null || !strlen($userTitle))
		{
			return '';
		}

		$class = $this->processAttributeToRaw($attributes, 'class', ' %s', true);

		if (!empty($attributes['tag']))
		{
			$tag = htmlspecialchars($attributes['tag']);
		}
		else
		{
			$tag = 'span';
		}

		unset($attributes['tag']);

		$unhandledAttrs = $this->processUnhandledAttributes($attributes);

		return "<{$tag} class=\"userTitle{$class}\" dir=\"auto\"{$unhandledAttrs}>{$userTitle}</{$tag}>";
	}

	public function getDefaultUserTitleForUser(\XF\Entity\User $user)
	{
		$groupId = $user->display_style_group_id;
		if (!empty($this->groupStyles[$groupId]['user_title']))
		{
			return $this->groupStyles[$groupId]['user_title'];
		}
		else
		{
			foreach ($this->userTitleLadder AS $points => $title)
			{
				if ($user[$this->userTitleLadderField] >= $points)
				{
					return $title;
				}
			}
		}

		return null;
	}

	public function fnUsernameLink($templater, &$escape, $user, $rich = false, $attributes = [])
	{
		$escape = false;

		if (isset($attributes['username']))
		{
			$username = $attributes['username'];
		}
		else if (isset($user['username']) && $user['username'] !== '')
		{
			$username = $user['username'];
		}
		else if (isset($attributes['defaultname']))
		{
			$username = $attributes['defaultname'];
		}
		else
		{
			return '';
		}

		$noTooltip = !empty($attributes['notooltip']);

		if (isset($attributes['href']))
		{
			$href = $attributes['href'];
			$noTooltip = true; // custom URL so tooltip won't work and might be misleading
		}
		else
		{
			$linkPath = $this->currentTemplateType == 'admin' ? 'users/edit' : 'members';
			$href = !empty($user['user_id']) ? $this->getRouter()->buildLink($linkPath, $user) : null;
			if (!$href || $this->currentTemplateType == 'admin')
			{
				$noTooltip = true;
			}
		}
		$hrefAttr = $href ? ' href="' . htmlspecialchars($href) . '"' : '';

		$class = $this->processAttributeToRaw($attributes, 'class', ' %s', true);
		$usernameStylingClasses = $this->fnUsernameClasses($this, $null, $user, $rich);
		$usernameStylingClassesAttr = $usernameStylingClasses
			? " class=\"{$usernameStylingClasses}\""
			: '';
		$xfInit = $this->processAttributeToRaw($attributes, 'data-xf-init', '', true);

		if (!$noTooltip)
		{
			$xfInit = ltrim("$xfInit member-tooltip");
		}
		$xfInitAttr = $xfInit ? " data-xf-init=\"$xfInit\"" : '';

		$itemprop = $this->processAttributeToRaw($attributes, 'itemprop', '', true);
		$itempropAttr = $itemprop ? " itemprop=\"{$itemprop}\"" : '';

		unset($attributes['username'], $attributes['defaultname'], $attributes['href'], $attributes['notooltip']);
		$unhandledAttrs = $this->processUnhandledAttributes($attributes);

		$userId = !empty($user['user_id']) ? intval($user['user_id']) : 0;
		$username = htmlspecialchars($username);

		if ($usernameStylingClassesAttr || $itempropAttr)
		{
			$username = "<span{$usernameStylingClassesAttr}{$itempropAttr}>{$username}</span>";
		}

		if ($hrefAttr)
		{
			$tag = 'a';
		}
		else
		{
			$tag = 'span';
		}
		return "<{$tag}{$hrefAttr} class=\"username $class\" dir=\"auto\" data-user-id=\"{$userId}\"{$xfInitAttr}{$unhandledAttrs}>{$username}</{$tag}>";
	}

	public function fnUsernameLinkEmail($templater, &$escape, $user, $defaultName = '', array $attributes = [])
	{
		$escape = false;

		if (isset($attributes['username']))
		{
			$username = $attributes['username'];
		}
		else if (isset($user['username']) && $user['username'] !== '')
		{
			$username = $user['username'];
		}
		else if ($defaultName !== '')
		{
			$username = $defaultName;
		}
		else
		{
			return '';
		}

		unset($attributes['username']);

		if (isset($attributes['href']))
		{
			$href = $attributes['href'];
		}
		else
		{
			$href = !empty($user['user_id']) ? $this->getRouter()->buildLink('canonical:members', $user) : null;

		}
		$hrefAttr = $href ? ' href="' . htmlspecialchars($href) . '"' : '';
		$tag = $href ? 'a' : 'span';

		unset($attributes['username'], $attributes['href']);
		$unhandledAttrs = $this->processUnhandledAttributes($attributes);

		$username = htmlspecialchars($username);

		return "<{$tag} dir=\"auto\"{$hrefAttr}{$unhandledAttrs}>{$username}</{$tag}>";
	}

	public function fnUsernameClasses($templater, &$escape, $user, $includeGroupStyling = true)
	{
		$classes = [];

		if ($includeGroupStyling)
		{
			if (!$user || empty($user['user_id']))
			{
				$displayGroupId = \XF\Entity\User::GROUP_GUEST;
			}
			else
			{
				if (!empty($user['display_style_group_id']))
				{
					$displayGroupId = $user['display_style_group_id'];
				}
				else
				{
					$displayGroupId = 0;
				}
			}

			if ($displayGroupId && !empty($this->groupStyles[$displayGroupId]['username_css']))
			{
				$classes[] = 'username--style' . $displayGroupId;
			}
		}

		$visitor = \XF::visitor();

		if (!empty($user['is_banned']) && ($visitor->canBanUsers() || $visitor->canBypassUserPrivacy()))
		{
			$classes[] = 'username--banned';
		}

		foreach (['staff', 'moderator', 'admin'] AS $userType)
		{
			if (!empty($user["is_{$userType}"]))
			{
				$classes[] = "username--{$userType}";
			}
		}

		$escape = false; // note: not doing this explicitly, shouldn't be needed for the output format

		return implode(' ', $classes);
	}

	public function fnWidgetData($templater, &$escape, $widgetData, $asArray = false)
	{
		$output = [];

		$escape = false;

		if (isset($widgetData['id']))
		{
			if ($asArray)
			{
				$output['data-widget-id'] = $widgetData['id'];
			}
			else
			{
				$output[] = 'data-widget-id="' . $widgetData['id'] . '"';
			}
		}
		if (isset($widgetData['key']))
		{
			if ($asArray)
			{
				$output['data-widget-key'] = $widgetData['key'];
			}
			else
			{
				$output[] = 'data-widget-key="' . $widgetData['key'] . '"';
			}
		}
		if (isset($widgetData['definition']))
		{
			if ($asArray)
			{
				$output['data-widget-definition'] = $widgetData['definition'];
			}
			else
			{
				$output[] = 'data-widget-definition="' . $widgetData['definition'] . '"';
			}
		}

		if ($asArray)
		{
			return $output ? $output : [];
		}
		else
		{
			return $output ? ' ' . implode(' ', $output) : '';
		}
	}

	////////////////////// FILTERS //////////////////////////

	public function filterDefault($templater, $value, &$escape, $defaultValue)
	{
		if ($value === null)
		{
			$value = $defaultValue;
		}

		return $value;
	}

	public function filterCensor($templater, $value, &$escape, $censorChar = null)
	{
		return $this->app->stringFormatter()->censorText($value, $censorChar);
	}

	public function filterCount($templater, $value, &$escape)
	{
		return $this->fnCount($templater, $escape, $value);
	}

	public function filterCurrency($templater, $value, &$escape, $code = '', $format = null, $showZero = true)
	{
		if (!$showZero && !$value)
		{
			return '';
		}

		/** @var \XF\Data\Currency $currency */
		$currency = $this->app->data('XF:Currency');

		return $currency->languageFormat($value, $code, $this->language, $format);
	}

	public function filterEmoji($templater, $value, &$escape)
	{
		$stringFormatter = $this->app->stringFormatter();

		$value = \XF::escapeString($value, $escape);
		$value = $stringFormatter->getEmojiFormatter()->formatEmojiToImage($value);

		$escape = false;

		return $value;
	}

	public function filterEscape($templater, $value, &$escape, $type = true)
	{
		$escape = $type;
		return $value;
	}

	public function filterForAttr($templater, $value, &$escape)
	{
		// this is a sanity check to make sure even pre-escaped values are escaped and can't break out of
		// an HTML attribute
		return $this->filterHtmlspecialchars($templater, $value, $escape);
	}

	public function filterFileSize($templater, $value, &$escape)
	{
		return $this->language->fileSizeFormat((float) $value);
	}

	public function filterFirst($templater, $value, &$escape)
	{
		if (is_array($value))
		{
			return reset($value);
		}
		else if ($value instanceof AbstractCollection)
		{
			return $value->first();
		}
		else
		{
			return $value;
		}
	}

	public function filterFormat($templater, $value, &$escape, ...$args)
	{
		return sprintf((string) $value, ...$args);
	}

	public function filterHex($templater, $value, &$escape)
	{
		return bin2hex((string) $value);
	}

	public function filterHost($templater, $value, &$escape)
	{
		return \XF\Util\Ip::getHost((string) $value);
	}

	public function filterHtmlspecialchars($templater, $value, &$escape)
	{
		$escape = false;
		return htmlspecialchars(strval($value), ENT_QUOTES, 'UTF-8', false);
	}

	public function filterIp($templater, $value, &$escape)
	{
		return \XF\Util\Ip::convertIpBinaryToString((string) $value);
	}

	public function filterJoin($templater, $value, &$escape, $join = ',')
	{
		if (!$this->isTraversable($value))
		{
			return '';
		}

		$parts = [];
		foreach ($value AS $child)
		{
			$parts[] = $escape ? $this->escape($child, $escape) : $child;
		}

		$escape = false;
		return implode($join, $parts);
	}

	public function filterJson($templater, $value, &$escape, $prettyPrint = false)
	{
		if ($prettyPrint)
		{
			$output = \XF\Util\Json::jsonEncodePretty($value, false);

			// do limited slash escaping to improve readability
			$output = str_replace('</', '<\\/', $output);
		}
		else
		{
			$output = json_encode($value);
		}

		$output = str_replace('<!', '\u003C!', $output);

		return $output;
	}

	public function filterLast($templater, $value, &$escape)
	{
		if (is_array($value))
		{
			return end($value);
		}
		else if ($value instanceof AbstractCollection)
		{
			return $value->last();
		}
		else
		{
			return $value;
		}
	}

	public function filterNl2Br($templater, $value, &$escape)
	{
		if ($escape)
		{
			$value = $this->escape($value, $escape);
		}
		$escape = false;

		return nl2br($value);
	}

	public function filterNl2Nl($templater, $value, &$escape)
	{
		if ($escape)
		{
			$value = $this->escape($value, $escape);
		}
		$escape = false;

		return str_replace('\n', "\n", $value ?? '');
	}

	public function filterNumber($templater, $value, &$escape, $precision = 0)
	{
		return $this->language->numberFormat((float) $value, $precision);
	}

	public function filterNumberShort($templater, $value, &$escape, $precision = 0)
	{
		return $this->language->shortNumberFormat((float) $value, $precision);
	}

	public function filterNumericKeysOnly($templater, $value, &$escape)
	{
		$escape = false;

		if (!$this->isTraversable($value))
		{
			return $value;
		}

		$output = [];

		foreach ($value AS $k => $v)
		{
			if (is_int($k))
			{
				$output[$k] = $v;
			}
		}

		return $output;
	}

	public function filterZeroFill($templater, $value, &$escape, $length = 3)
	{
		if (is_int($value))
		{
			$length = intval($length);
			return sprintf("%0{$length}d", $value);
		}

		return $value;
	}

	public function filterPad($templater, $value, &$escape, $padChar, $length, $postPad = false)
	{
		$length = intval($length);
		$padChar = substr((string) $padChar, 0, 1);
		$postPad = $postPad ? '-' : '';

		return sprintf("%{$postPad}'{$padChar}{$length}s", $value);
	}

	public function filterParens($templater, $value, &$escape)
	{
		$value = (string) $value;
		if (strlen($value))
		{
			$value = $this->language['parenthesis_open'] . $value . $this->language['parenthesis_close'];
		}

		return $value;
	}

	public function filterPluck($templater, $value, &$escape, $valueField, $keyField = null)
	{
		if (!$this->isTraversable($value))
		{
			return [];
		}

		$parts = [];
		foreach ($value AS $key => $child)
		{
			if ($keyField !== null && isset($child[$keyField]))
			{
				$key = $child[$keyField];
			}
			$parts[$key] = $child[$valueField] ?? null;
		}

		return $parts;
	}

	public function filterPreEscaped($templater, $value, &$escape, $type = 'html')
	{
		$escape = false;

		return $this->preEscaped($value, $type);
	}

	public function filterRaw($templater, $value, &$escape)
	{
		$escape = false;
		return $value;
	}

	public function filterReplace($templater, $value, &$escape, $from, $to = null)
	{
		if ($value instanceof \XF\Mvc\Entity\AbstractCollection)
		{
			$value = $value->toArray();
		}

		if (!is_array($from))
		{
			$from = [$from => $to];
		}

		if (!is_array($from))
		{
			return $value;
		}

		if (is_array($value))
		{
			return array_replace($value, $from);
		}
		else if (is_string($value))
		{
			return str_replace(array_keys($from), $from, $value);
		}
		else
		{
			return $value;
		}
	}

    public function filterSplit($templater, $value, &$escape, $delimiter = ',', $limit = PHP_INT_MAX)
    {
		$value = (string) $value;
        switch ($delimiter)
        {
            case ',':
            	$split = Arr::stringToArray($value, '#\s*,\s*#', $limit);
                break;

            case 'nl':
				$split = Arr::stringToArray($value, '/\r?\n/', $limit);
                break;

            default:
                $split = @explode($delimiter, $value, $limit);
                break;
        }

        if (!is_array($split))
        {
            $split = [];
        }

        return $split;
    }

    public function filterSplitLong($templater, $value, &$escape, $breakLength, $inserter = null)
    {
    	return $this->app->stringFormatter()->splitLongWords($value, $breakLength, $inserter);
    }

	public function filterStripTags($templater, $value, &$escape, $allowableTags = null)
	{
		$isPhrase = $value instanceof \XF\Phrase;

		$value = strip_tags((string) $value, $allowableTags);

		if ($isPhrase)
		{
			// When rendered, values in the phrase would have already been escaped.
			// We can't render those raw as they might appear to be tags and get stripped,
			// so we need to render with escaping, strip tags and then re-escape the output
			// without double escaping in case the main phrase text had HTML characters.
			$value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
			$escape = false;
		}

		return $value;
	}

	public function filterToLower($templater, $value, &$escape, $type = 'strtolower')
	{
		$value = (string) $value;
		switch ($type)
		{
			case 'lcfirst': return lcfirst($value);
			case 'strtolower': return utf8_strtolower($value);

			default:
				trigger_error("Invalid to lower type '{$type}' provided.", E_USER_WARNING);
				return '';
		}
	}

	public function filterToUpper($templater, $value, &$escape, $type = 'strtoupper')
	{
		$value = (string) $value;
		switch ($type)
		{
			case 'ucfirst':
			case 'ucwords':
			case 'strtoupper':
				$f = 'utf8_' . $type;
				return $f($value);

			default:
				trigger_error("Invalid to upper type '{$type}' provided.", E_USER_WARNING);
				return '';
		}
	}

	public function filterDeCamel($templater, $value, &$escape, $glue = ' ')
	{
		return $this->app->stringFormatter()->fromCamelCase((string) $value, $glue);
	}

	public function filterSubstr($templater, $value, &$escape, $start = null, $length = null)
	{
		$value = (string) $value;

		if ($start === null)
		{
			return $value;
		}

		return utf8_substr($value, $start, $length);
	}

	public function filterUrl($templater, $value, &$escape, $component = null, $fallback = '')
	{
		$value = (string) $value;
		$result = @parse_url($value);
		if (!$result)
		{
			return $fallback;
		}

		if (!$component)
		{
			return $value;
		}

		return $result[$component] ?? $fallback;
	}

	public function filterUrlencode($templater, $value, &$escape)
	{
		return urlencode((string) $value);
	}

	public function filterUrlDisplay($templater, $value, &$escape, $component = null, $fallback = '')
	{
		try
		{
			$value = \XF\Util\Url::urlToUtf8((string) $value);
		}
		catch (\InvalidArgumentException $e)
		{
			return $fallback;
		}

		if ($component !== null)
		{
			$result = @parse_url($value);
			if (!$result)
			{
				return $fallback;
			}

			return $result[$component] ?? $fallback;
		}

		return $value;
	}

	public function filterEmailDisplay($templater, $value, &$escape)
	{
		return \XF\Util\Url::emailToUtf8((string) $value, false);
	}

	////////////////////// TESTS ////////////////////////

	public function testEmpty($templater, $value)
	{
		if (is_object($value) && is_callable([$value, '__toString']))
		{
			return strval($value) === '';
		}

		if ($value instanceof \Countable)
		{
			return count($value) == 0;
		}

		return ($value === '' || $value === false || $value === null || $value === []);
	}

	////////////////////// FORM ELEMENTS ////////////////////////

	public function mergeChoiceOptions($original, $additional)
	{
		if ($original instanceof \Traversable)
		{
			$original = iterator_to_array($original, false);
		}
		else if (!is_array($original))
		{
			$original = [];
		}

		if ($this->isTraversable($additional))
		{
			foreach ($additional AS $key => $option)
			{
				if (is_string($option)
					|| is_numeric($option)
					|| (is_object($option) && method_exists($option, '__toString'))
				)
				{
					$original[] = [
						'value' => $key,
						'label' => \XF::escapeString($option),
						'_type' => 'option'
					];
				}
			}
		}

		return $original;
	}

	public function processAttributeToHtmlAttribute(array &$attributes, $name, $fallbackValue = '', $appendFallback = false)
	{
		return $this->processAttributeToNamedHtmlAttribute($attributes, $name, $name, $fallbackValue, $appendFallback);
	}

	public function processAttributeToNamedHtmlAttribute(array &$attributes, $sourceName, $targetName, $fallbackValue = '', $appendFallback = false)
	{
		if (isset($attributes[$sourceName]))
		{
			$value = $attributes[$sourceName];
			if ($appendFallback && $fallbackValue)
			{
				$value .= " $fallbackValue";
			}
		}
		else
		{
			$value = $fallbackValue;
		}

		unset($attributes[$sourceName]);

		if (is_array($value))
		{
			return '';
		}

		$value = strval($value);
		if ($value === '')
		{
			return '';
		}
		else
		{
			return " $targetName=\"" . \XF::escapeString($value) . "\"";
		}
	}

	public function processCodeAttribute(array &$attributes)
	{
		if (isset($attributes['code']))
		{
			if ($attributes['code'] === 'true' || $attributes['code'] === 1)
			{
				$attributes['dir'] = 'ltr';
				$attributes['class'] = (empty($attributes['class']) ? 'input--code' : $attributes['class'] . ' input--code');
			}

			unset($attributes['code']);
		}
	}

	public function processBooleanAttributeHtml(array &$attributes, $name, $outputAttribute)
	{
		if (!isset($attributes[$name]))
		{
			return '';
		}

		$value = $attributes[$name];
		unset($attributes[$name]);

		if ($value)
		{
			return " $outputAttribute";
		}
		else
		{
			return '';
		}
	}

	/**
	 * Pulls out the named attribute from the attribute list, removes it, and returns the value.
	 * Value will always be trimmed. May be formatted using a sprintf-style formatter or closure.
	 * Formatting will only happen if the value is non-empty. If escaping is enabled, the value will be escaped
	 * before being passed to the formatter.
	 *
	 * @param array $attributes
	 * @param string $name
	 * @param string|\Closure $formatter
	 * @param bool $escapeValue
	 *
	 * @return string
	 */
	public function processAttributeToRaw(array &$attributes, $name, $formatter = '', $escapeValue = false)
	{
		if (isset($attributes[$name]))
		{
			$value = trim(strval($attributes[$name]));
			if ($value !== '')
			{
				if ($escapeValue)
				{
					$value = \XF::escapeString($value);
				}

				if ($formatter)
				{
					if ($formatter instanceof \Closure)
					{
						$value = $formatter($value);
					}
					else
					{
						$value =  sprintf($formatter, $value);
					}
				}
			}
		}
		else
		{
			$value = '';
		}

		unset($attributes[$name]);

		return $value;
	}

	/**
	 * Pulls out the named attribute if present, removes it from the attribute list, and returns the value.
	 * This does not do any trimming, escaping or formatting on the value.
	 *
	 * @param array $attributes
	 * @param string $name
	 *
	 * @return string
	 */
	public function processValueAttribute(array &$attributes, $name = 'value')
	{
		if (isset($attributes[$name]))
		{
			$value = strval($attributes[$name]);
		}
		else
		{
			$value = '';
		}

		unset($attributes[$name]);

		return $value;
	}

	public function getAttributesAsString(array $attributes): string
	{
		return $this->processUnhandledAttributes($attributes);
	}

	protected function processUnhandledAttributes(array $attributes)
	{
		$output = '';
		foreach ($attributes AS $name => $value)
		{
			if (is_array($value))
			{
				continue;
			}

			if ($value instanceof \XF\Phrase)
			{
				// strval will do escaping of the values or the whole phrase, so get the raw value and escape that here
				$value = $value->render('raw');
			}
			else
			{
				$value = strval($value);
			}

			if ($value !== '')
			{
				$output .= " $name=\"" . \XF::escapeString($value) . "\"";
			}
		}

		return $output;
	}

	protected function processDynamicAttributes(array &$attributes, array $skip = [])
	{
		if (!isset($attributes['attributes']))
		{
			return;
		}

		foreach ($attributes['attributes'] AS $key => $attribute)
		{
			if ($key == 'attributes' || isset($attributes[$key]) || isset($skip[$key]))
			{
				continue;
			}
			$attributes[$key] = $attribute;
		}
		unset($attributes['attributes']);
	}

	protected function handleChoices(array $choices, \Closure $choiceFormatter, \Closure $groupFormatter)
	{
		$html = '';

		foreach ($choices AS $choice)
		{
			if (isset($choice['_type']))
			{
				$type = $choice['_type'];
				unset($choice['_type']);
			}
			else
			{
				$type = 'option';
			}

			if ($type == 'optgroup')
			{
				$childHtml = $this->handleChoices($choice['options'], $choiceFormatter, $groupFormatter);
				unset($choice['options']);

				$html .= $groupFormatter($choice, $childHtml);
			}
			else
			{
				$dependent = !empty($choice['_dependent']) ? $choice['_dependent'] : [];
				foreach ($dependent AS $key => &$val)
				{
					$val = trim($val);
					if (!strlen($val))
					{
						unset($dependent[$key]);
					}
				}
				unset($choice['_dependent']);

				$html .= $choiceFormatter($choice, $dependent);
			}
		}

		return $html;
	}

	public function isChoiceSelected(array $choice, $inputValue, $allowMultiple = false)
	{
		if (isset($choice['selected']))
		{
			return $choice['selected'];
		}

		if ($inputValue !== null)
		{
			$choiceValue = isset($choice['value']) ? strval($choice['value']) : '';

			if (is_array($inputValue) && $allowMultiple)
			{
				return in_array($choiceValue, $inputValue);
			}
			else if (!is_array($inputValue))
			{
				return (
					($inputValue === true && $choiceValue === '1')
					|| ($inputValue === false && $choiceValue === '0')
					|| (strval($inputValue) === $choiceValue)
				);
			}
		}

		return false;
	}

	public function formHiddenVal($name, $value, array $extraAttributes = [])
	{
		$this->processDynamicAttributes($extraAttributes);

		$nameHtml = \XF::escapeString($name);
		$valueHtml = \XF::escapeString($value);
		$extraAttrs = $this->processUnhandledAttributes($extraAttributes);

		return "<input type=\"hidden\" name=\"{$nameHtml}\" value=\"{$valueHtml}\"{$extraAttrs} />";
	}

	public function formCheckBox(array $controlOptions, array $choices)
	{
		$this->processDynamicAttributes($controlOptions);

		$name = \XF::escapeString($this->processAttributeToRaw($controlOptions, 'name'));
		if ($name && substr($name, -2) != '[]')
		{
			$name .= '[]';
		}

		$readOnly = $this->processAttributeToRaw($controlOptions, 'readonly');

		$value = $controlOptions['value'] ?? null;

		$standalone = ($this->processAttributeToRaw($controlOptions, 'standalone') && count($choices) == 1);

		$choiceFormatter = function(array $choice, array $dependent) use ($name, $readOnly, $value, $standalone)
		{
			$selected = $this->isChoiceSelected($choice, $value, true);
			if (!empty($choice['name']))
			{
				$localName = \XF::escapeString($choice['name']);
			}
			else
			{
				$localName = $name;
			}
			if ($localName)
			{
				$nameAttr = ' name="' . $localName . '"';
			}
			else
			{
				$nameAttr = '';
			}

			unset($choice['selected'], $choice['name'], $choice['type']);

			$dependentHtml = '';
			if ($dependent && !$standalone)
			{
				$dependentHtmlInner = '';
				foreach ($dependent AS $child)
				{
					$dependentHtmlInner .= "\n\t\t\t\t<li class=\"inputChoices-option\">$child</li>";
				}
				$dependentHtml = "\n\t\t\t<ul class=\"inputChoices-dependencies\">{$dependentHtmlInner}\n\t\t\t</ul>\n\t\t";
			}
			if ($dependentHtml)
			{
				$this->addElementHandler($choice, 'disabler');
			}

			$label = trim($this->processAttributeToRaw($choice, 'label'));

			$labelClass = 'iconic';
			$labelClassExtra = $this->processAttributeToRaw($choice, 'labelclass', '', true);
			if ($labelClassExtra !== '')
			{
				$labelClass .= " {$labelClassExtra}";
			}
			$hiddenLabel = $this->processAttributeToRaw($choice, 'hiddenlabel');
			if ($label && $hiddenLabel != '')
			{
				$hiddenLabel = true;
			}
			else
			{
				$hiddenLabel = false;
			}
			if ($label && $hiddenLabel)
			{
				$label = '<span class="u-srOnly">' . $label . '</span>';
				$labelClass .= ' iconic--hiddenLabel';
			}
			else if ($label === '')
			{
				$labelClass .= ' iconic--noLabel';
			}

			if ($readOnly)
			{
				$labelClass .= ' is-readonly';
			}

			$titleAttr = $this->processAttributeToHtmlAttribute($choice, 'title');

			$tooltipAttr = '';
			if (array_key_exists('data-xf-init', $choice) && $choice['data-xf-init'] == 'tooltip')
			{
				$tooltipAttr = $this->processAttributeToHtmlAttribute($choice, 'data-xf-init');
			}

			$checkAll = $this->processAttributeToRaw($choice, 'check-all');
			if ($checkAll != '')
			{
				$choice['data-xf-init'] .= (empty($choice['data-xf-init']) ? '' : ' ') . 'check-all';
				$choice['data-container'] = $checkAll;
			}

			$hint = $this->processAttributeToRaw($choice, 'hint', "\n\t\t\t\t\t<dfn class=\"inputChoices-explain\">%s</dfn>");
			$extraHtml = $this->processAttributeToRaw($choice, 'html', "\n\t\t\t\t\t%s");
			$afterHint = $this->processAttributeToRaw($choice, 'afterhint', "\n\t\t\t<dfn class=\"inputChoices-explain inputChoices-explain--after\">%s</dfn>");
			$afterHtml = $this->processAttributeToRaw($choice, 'afterhtml', "\n\t\t\t%s");

			$valueAttr = $this->processAttributeToHtmlAttribute($choice, 'value');
			if (!$valueAttr)
			{
				$valueAttr = ' value="1"';
			}
			$selectedAttr = $selected ? ' checked="checked"' : '';

			if ($this->processAttributeToRaw($choice, 'readonly'))
			{
				$readOnly = true;
			}

			$readOnlyAttr = $readOnly ? ' readonly="readonly" onclick="return false"' : '';
			if ($readOnly)
			{
				$labelClass .= ' is-readonly';
			}

			if (isset($choice['defaultvalue']) && $localName && substr($localName, -2) != '[]')
			{
				// $localName is escaped
				$defaultValueInput = '<input type="hidden" name="' . $localName
					. '" value="' . \XF::escapeString($choice['defaultvalue']) . '" />';

				unset($choice['defaultvalue']);
			}
			else
			{
				$defaultValueInput = '';
			}

			$attributes = $this->processUnhandledAttributes($choice);

			if ($label !== '')
			{
				$label = "<span class=\"iconic-label\">{$label}</span>";
			}

			$checkboxHtml = $defaultValueInput . "<label class=\"{$labelClass}\"{$titleAttr}{$tooltipAttr}>"
				. "<input type=\"checkbox\" {$nameAttr}{$valueAttr}{$selectedAttr}{$readOnlyAttr}{$attributes} />"
				. "<i aria-hidden=\"true\"></i>{$label}</label>{$hint}{$extraHtml}{$dependentHtml}{$afterHint}{$afterHtml}";

			if ($standalone)
			{
				return $checkboxHtml . "\n";
			}
			else
			{
				return "<li class=\"inputChoices-choice\">{$checkboxHtml}</li>\n";
			}
		};
		$groupFormatter = function(array $group, $html)
		{
			$label = $this->processAttributeToRaw($group, 'label');
			if ($label)
			{
				$class = $this->processAttributeToRaw($group, 'class', '', true);
				$listClass = $this->processAttributeToRaw($group, 'listclass', '', true);
				$headingClass = 'inputChoices-heading';

				$checkAll = $this->processAttributeToRaw($group, 'check-all');
				if ($checkAll)
				{
					$label = '<label class="iconic">
						<input type="checkbox" data-xf-init="check-all" data-container="< .inputChoices-group" /><i aria-hidden="true"></i>'
						. $label . '</label>';

					$headingClass .= ' inputChoices-heading--checkAll';
				}

				$unhandledAttrs = $this->processUnhandledAttributes($group);

				$html = "<li class=\"inputChoices-group {$class}\" {$unhandledAttrs}>
					<div class=\"{$headingClass}\">{$label}</div>
					<ul class=\"inputChoices {$listClass}\">{$html}</ul>
				</li>";
			}

			return $html;
		};

		$choiceHtml = $this->handleChoices($choices, $choiceFormatter, $groupFormatter);

		$hideEmpty = $this->processAttributeToRaw($controlOptions, 'hideempty');
		if ($hideEmpty && !$choiceHtml)
		{
			return '';
		}

		if ($standalone)
		{
			return $choiceHtml;
		}

		$listClassAttr = $this->processAttributeToNamedHtmlAttribute($controlOptions, 'listclass', 'class', 'inputChoices', true);

		$unhandledAttrs = $this->processUnhandledAttributes($controlOptions);

		return "
			<ul{$listClassAttr}{$unhandledAttrs}>
				$choiceHtml
			</ul>
		";
	}

	public function formCheckBoxRow(array $controlOptions, array $choices, array $rowOptions)
	{
		if (
			empty($controlOptions['role'])
			&& isset($rowOptions['label'])
			&& trim(strval($rowOptions['label'])) !== ''
		)
		{
			$this->attachAriaRole('group', $controlOptions, $rowOptions);
		}

		$controlHtml = $this->formCheckBox($controlOptions, $choices);
		return $controlHtml ? $this->formRow($controlHtml, $rowOptions) : '';
	}

	public function formRadio(array $controlOptions, array $choices)
	{
		$this->processDynamicAttributes($controlOptions);

		$name = \XF::escapeString($this->processAttributeToRaw($controlOptions, 'name'));
		$readOnly = $this->processAttributeToRaw($controlOptions, 'readonly');

		$value = $controlOptions['value'] ?? null;
		unset($controlOptions['value']);

		$standalone = ($this->processAttributeToRaw($controlOptions, 'standalone') && count($choices) == 1);

		$choiceFormatter = function(array $choice, array $dependent) use ($name, $readOnly, $value, $standalone)
		{
			$selected = $this->isChoiceSelected($choice, $value, false);

			unset($choice['selected'], $choice['type']);

			$titleAttr = $this->processAttributeToHtmlAttribute($choice, 'title');
			$tooltipAttr = '';
			if ($choice['data-xf-init'] == 'tooltip')
			{
				$tooltipAttr = $this->processAttributeToHtmlAttribute($choice, 'data-xf-init');
			}

			$dependentHtml = '';
			if ($dependent)
			{
				$dependentHtmlInner = '';
				foreach ($dependent AS $child)
				{
					$dependentHtmlInner .= "\n\t\t\t\t<li class=\"inputChoices-choice\">$child</li>";
				}
				$dependentHtml = "\n\t\t\t<ul class=\"inputChoices-dependencies\">{$dependentHtmlInner}\n\t\t\t</ul>\n\t\t";
			}
			if ($dependentHtml)
			{
				$this->addElementHandler($choice, 'disabler');
			}

			$label = trim($this->processAttributeToRaw($choice, 'label'));

			$labelClass = 'iconic  iconic--radio';
			$labelClassExtra = $this->processAttributeToRaw($choice, 'labelclass', '', true);
			if ($labelClassExtra !== '')
			{
				$labelClass .= " {$labelClassExtra}";
			}
			$hiddenLabel = $this->processAttributeToRaw($choice, 'hiddenlabel');
			if ($label && $hiddenLabel != '')
			{
				$hiddenLabel = true;
			}
			else
			{
				$hiddenLabel = false;
			}
			if ($label && $hiddenLabel)
			{
				$label = '<span class="u-srOnly">' . $label . '</span>';
				$labelClass .= ' iconic--hiddenLabel';
			}
			else if ($label === '')
			{
				$labelClass .= ' iconic--noLabel';
			}

			if ($readOnly)
			{
				$labelClass .= ' is-readonly';
			}

			$hint = $this->processAttributeToRaw($choice, 'hint', "\n\t\t\t\t\t<dfn class=\"inputChoices-explain\">%s</dfn>");
			$afterHint = $this->processAttributeToRaw($choice, 'afterhint', "\n\t\t\t<dfn class=\"inputChoices-explain inputChoices-explain--after\">%s</dfn>");
			$extraHtml = $this->processAttributeToRaw($choice, 'html', "\n\t\t\t\t\t%s");
			$valueAttr = $this->processAttributeToHtmlAttribute($choice, 'value');
			if (!$valueAttr)
			{
				$valueAttr = ' value=""';
			}
			$selectedAttr = $selected ? ' checked="checked"' : '';

			if ($this->processAttributeToRaw($choice, 'readonly'))
			{
				$readOnly = true;
			}

			$readOnlyAttr = $readOnly ? ' readonly="readonly" onclick="return false"' : '';
			if ($readOnly)
			{
				$labelClass .= ' is-readonly';
			}

			$listItemClass = $this->processAttributeToNamedHtmlAttribute($choice, 'listitemclass', 'class', 'inputChoices-choice', true);
			$attributes = $this->processUnhandledAttributes($choice);

			if ($label !== '')
			{
				$label = "<span class=\"iconic-label\">{$label}</span>";
			}

			$radioHtml = "<label class=\"{$labelClass}\"{$titleAttr}{$tooltipAttr}>"
				. "<input type=\"radio\" name=\"$name\"{$valueAttr}{$selectedAttr}{$readOnlyAttr}{$attributes} />"
				. "<i aria-hidden=\"true\"></i>{$label}</label>{$hint}{$dependentHtml}{$extraHtml}{$afterHint}";

			if ($standalone)
			{
				return $radioHtml . "\n";
			}
			else
			{
				return "<li{$listItemClass}>{$radioHtml}</li>\n";
			}
		};
		$groupFormatter = function(array $group, $html)
		{
			$label = $this->processAttributeToRaw($group, 'label');
			if ($label)
			{
				$class = $this->processAttributeToRaw($group, 'class', '', true);
				$listClass = $this->processAttributeToRaw($group, 'listclass', '', true);

				$unhandledAttrs = $this->processUnhandledAttributes($group);

				$html = "<li class=\"inputChoices-group {$class}\" {$unhandledAttrs}>
					<div class=\"inputChoices-heading\">{$label}</div>
					<ul class=\"inputChoices {$listClass}\">{$html}</ul>
				</li>";
			}

			return $html;
		};

		$choiceHtml = $this->handleChoices($choices, $choiceFormatter, $groupFormatter);

		$hideEmpty = $this->processAttributeToRaw($controlOptions, 'hideempty');
		if ($hideEmpty && !$choiceHtml)
		{
			return '';
		}

		if ($standalone)
		{
			return $choiceHtml;
		}

		$listClassAttr = $this->processAttributeToNamedHtmlAttribute($controlOptions, 'listclass', 'class', 'inputChoices', true);

		$unhandledAttrs = $this->processUnhandledAttributes($controlOptions);

		return "
			<ul{$listClassAttr}{$unhandledAttrs}>
				$choiceHtml
			</ul>
		";
	}

	public function formRadioRow(array $controlOptions, array $choices, array $rowOptions)
	{
		$this->attachAriaRole('radiogroup', $controlOptions, $rowOptions);

		$controlHtml = $this->formRadio($controlOptions, $choices);
		return $controlHtml ? $this->formRow($controlHtml, $rowOptions) : '';
	}

	public function formRadioTabsRow(array $controlOptions, array $choices, array $rowOptions)
	{
		$this->attachAriaRole('radiogroup', $controlOptions, $rowOptions);

		$this->processDynamicAttributes($controlOptions);

		$name = \XF::escapeString($this->processAttributeToRaw($controlOptions, 'name'));
		$readOnly = $this->processAttributeToRaw($controlOptions, 'readonly');

		$value = $controlOptions['value'] ?? null;
		unset($controlOptions['value']);

		if (!$class = $this->processAttributeToRaw($rowOptions, 'rowclass', ' %s', true))
		{
			$class = 'block-tabHeader block-tabHeader--radio';
		}

		$clickAttr = $this->processAttributeToHtmlAttribute($controlOptions, 'data-xf-click');

		$choiceFormatter = function(array $choice) use ($name, $readOnly, $value, $clickAttr)
		{
			$selected = $this->isChoiceSelected($choice, $value, false);
			unset($choice['selected'], $choice['type']);

			// value
			if (!$valueAttr = $this->processAttributeToHtmlAttribute($choice, 'value'))
			{
				$valueAttr = ' value=""';
			}
			$selectedAttr = $selected ? ' checked="checked"' : '';

			// label
			$label = trim($this->processAttributeToRaw($choice, 'label'));
			$labelClass = 'tabs-tab tabs-tab--radio';
			$labelClassExtra = $this->processAttributeToRaw($choice, 'labelclass', '', true);
			if ($labelClassExtra !== '')
			{
				$labelClass .= " {$labelClassExtra}";
			}

			// hint
			$hint = $this->processAttributeToRaw($choice, 'hint', "<dfn class=\"inputChoices-explain\">%s</dfn>");

			// title and tooltip
			$titleAttr = $this->processAttributeToHtmlAttribute($choice, 'title');
			$tooltipAttr = '';
			if ($choice['data-xf-init'] == 'tooltip')
			{
				$tooltipAttr = $this->processAttributeToHtmlAttribute($choice, 'data-xf-init');
			}

			// readonly
			if ($this->processAttributeToRaw($choice, 'readonly'))
			{
				$readOnly = true;
			}
			$readOnlyAttr = $readOnly ? ' readonly="readonly" onclick="return false"' : '';
			if ($readOnly)
			{
				$labelClass .= ' is-readonly';
			}

			// click event
			if ($choiceClickAttr = $this->processAttributeToHtmlAttribute($choice, 'data-xf-click'))
			{
				$clickAttr = $choiceClickAttr;
			}

			$controlId = $this->assignFormControlId($choice);

			$attributes = $this->processUnhandledAttributes($choice);

			return "
				<input id=\"{$controlId}\" type=\"radio\" name=\"{$name}\"{$valueAttr}{$selectedAttr}{$readOnlyAttr}{$clickAttr}{$attributes} />
				<label for=\"{$controlId}\" class=\"{$labelClass}\"{$titleAttr}{$tooltipAttr}>{$label}{$hint}</label>";
		};

		// unused at present
		$groupFormatter = function() {};

		$initialHtml = $this->processAttributeToRaw($rowOptions, 'initialhtml', "%s");
		$finalHtml = $this->processAttributeToRaw($rowOptions, 'finalhtml', "%s");

		return "
			<h2 class=\"{$class}\"><span class=\"tabs tabs--radio\">"
			. $initialHtml
			. $this->handleChoices($choices, $choiceFormatter, $groupFormatter)
			. $finalHtml
			. '</span></h2>';
	}

	protected function attachAriaRole($role, array &$controlOptions, array $rowOptions)
	{
		if (empty($controlOptions['role']))
		{
			$controlOptions['role'] = $role;

			if (!isset($controlOptions['aria-labelledby']))
			{
				$controlOptions['aria-labelledby'] = $this->assignRowLabelId($rowOptions);
			}
		}
	}

	public function formSelect(array $controlOptions, array $choices)
	{
		$this->processDynamicAttributes($controlOptions);

		$name = \XF::escapeString($this->processAttributeToRaw($controlOptions, 'name'));

		$value = $controlOptions['value'] ?? null;
		unset($controlOptions['value']);

		$multiple = !empty($controlOptions['multiple']);
		if ($multiple)
		{
			$multipleAttr = ' multiple="multiple"';
			if ($name && substr($name, -2) != '[]')
			{
				$name .= '[]';
			}
		}
		else
		{
			$multipleAttr = '';
		}
		unset($controlOptions['multiple']);

		$choiceFormatter = function(array $choice) use ($name, $value, $multiple)
		{
			$selected = $this->isChoiceSelected($choice, $value, $multiple);
			unset($choice['selected'], $choice['explain']);

			$label = trim($this->processAttributeToRaw($choice, 'label'));
			if ($label === '')
			{
				$label = '&nbsp;';
			}
			$valueAttr = $this->processAttributeToHtmlAttribute($choice, 'value');
			if (!$valueAttr)
			{
				$valueAttr = ' value=""';
			}
			$selectedAttr = $selected ? ' selected="selected"' : '';
			$disabled = $this->processAttributeToRaw($choice, 'disabled');
			$disabledAttr = $disabled ? ' disabled="disabled"': '';
			$attributes = $this->processUnhandledAttributes($choice);

			return "<option{$valueAttr}{$selectedAttr}{$disabledAttr}{$attributes}>{$label}</option>\n";
		};
		$groupFormatter = function(array $group, $html)
		{
			if (!$html)
			{
				return '';
			}

			$attributes = $this->processUnhandledAttributes($group);
			return "<optgroup{$attributes}>\n$html</optgroup>";
		};

		$choiceHtml = $this->handleChoices($choices, $choiceFormatter, $groupFormatter);
		$hideEmpty = $this->processAttributeToRaw($controlOptions, 'hideempty');
		if ($hideEmpty && !$choiceHtml)
		{
			return '';
		}

		$readOnly = $this->processAttributeToRaw($controlOptions, 'readonly');
		$disabled = $this->processAttributeToRaw($controlOptions, 'disabled');
		if ($readOnly)
		{
			$this->addToClassAttribute($controlOptions, 'is-readonly');
			$disabled = true;
		}

		$disabledAttr = $disabled ? ' disabled="disabled"' : '';

		$classAttr = $this->processAttributeToHtmlAttribute($controlOptions, 'class', 'input', true);

		$fa = $this->fontAwesomeInputOverlay($controlOptions);

		$unhandledAttrs = $this->processUnhandledAttributes($controlOptions);

		$select = "
			{$fa}<select name=\"{$name}\"{$multipleAttr}{$classAttr}{$disabledAttr}{$unhandledAttrs}>
				$choiceHtml
			</select>
		";
		if ($readOnly)
		{
			if ($value !== null)
			{
				if ($multiple)
				{
					if (is_array($value))
					{
						foreach ($value AS $subValue)
						{
							$select .= '<input type="hidden" name="' . $name . '" value="' . \XF::escapeString($subValue) . '" />';
						}
					}
				}
				else
				{
					$select .= '<input type="hidden" name="' . $name . '" value="' . \XF::escapeString($value) . '" />';
				}
			}
			else
			{
				if (!$multiple)
				{
					// read-only single select inputs will render with the first item selected by default
					$options = array_filter($choices, function ($choice) {
						return (isset($choice['_type']) && $choice['_type'] == 'option');
					});
					$firstOption = reset($options);
					$select .= '<input type="hidden" name="' . $name . '" value="' . \XF::escapeString($firstOption['value']) . '" />';
				}
			}
		}

		return $select;
	}

	public function formSelectRow(array $controlOptions, array $choices, array $rowOptions)
	{
		$this->addToClassAttribute($rowOptions, 'formRow--input', 'rowclass');

		$controlId = $this->assignFormControlId($controlOptions);
		$controlHtml = $this->formSelect($controlOptions, $choices);
		return $controlHtml ? $this->formRow($controlHtml, $rowOptions, $controlId) : '';
	}

	public function formSubmitRow(array $controlOptions, array $rowOptions)
	{
		$this->processDynamicAttributes($controlOptions);

		$sticky = $this->processAttributeToRaw($controlOptions, 'sticky');
		$stickyContainer = $this->processAttributeToRaw($controlOptions, 'sticky-container');
		$stickyFixedChild = $this->processAttributeToRaw($controlOptions, 'sticky-fixed-child');
		$stickyClass = $this->processAttributeToRaw($controlOptions, 'sticky-class');
		$stickyTopOffset = $this->processAttributeToRaw($controlOptions, 'sticky-top-offset');
		$stickyMinWindowHeight = $this->processAttributeToRaw($controlOptions, 'sticky-min-window-height');
		if ($sticky && $sticky != 'false')
		{
			$this->addElementHandler($rowOptions, 'form-submit-row', 'rowclass');

			if ($stickyContainer)
			{
				$rowOptions['data-container'] = $stickyContainer;
			}
			else if ($sticky != 'true' && !is_numeric($sticky)) // indicates a container
			{
				$rowOptions['data-container'] = $sticky;
			}

			if ($stickyFixedChild)
			{
				$rowOptions['data-fixed-child'] = $stickyFixedChild;
			}
			if ($stickyClass)
			{
				$rowOptions['data-sticky-class'] = $stickyClass;
			}
			if ($stickyTopOffset)
			{
				$rowOptions['data-top-offset'] = $stickyTopOffset;
			}
			if ($stickyMinWindowHeight)
			{
				$rowOptions['data-min-window-height'] = $stickyMinWindowHeight;
			}
		}

		$submit = strval($this->processAttributeToRaw($controlOptions, 'submit'));
		if (!$submit && !empty($controlOptions['icon']))
		{
			$submit = $this->getButtonPhraseFromIcon($controlOptions['icon'], 'button.submit');
		}

		if (strlen($submit))
		{
			$controlOptions['type'] = 'submit';
			if (empty($controlOptions['class']))
			{
				$controlOptions['class'] = 'button--primary';
			}
			$controlHtml = $this->button($submit, $controlOptions);
		}
		else
		{
			$controlHtml = '';
		}

		$extraHtml = $this->processAttributeToRaw($rowOptions, 'html', "\n\t\t\t\t%s");

		$class = $this->processAttributeToRaw($rowOptions, 'rowclass', ' %s', true);
		if ($sticky)
		{
			$class .= ' formSubmitRow--sticky';
		}

		$rowType = $this->processAttributeToRaw($rowOptions, 'rowtype');
		if ($rowType)
		{
			$class = $this->appendClassList($class, $rowType, 'formSubmitRow--%s');
		}

		$unhandledRowAttrs = $this->processUnhandledAttributes($rowOptions);

		return "
			<dl class=\"formRow formSubmitRow{$class}\"{$unhandledRowAttrs}>
				<dt></dt>
				<dd>
					<div class=\"formSubmitRow-main\">
						<div class=\"formSubmitRow-bar\"></div>
						<div class=\"formSubmitRow-controls\">{$controlHtml}{$extraHtml}</div>
					</div>
				</dd>
			</dl>
		";
	}

	public function formTextArea(array $controlOptions)
	{
		$this->processDynamicAttributes($controlOptions);

		$this->processCodeAttribute($controlOptions);

		$autosize = $this->processAttributeToRaw($controlOptions, 'autosize');
		if ($autosize)
		{
			$this->addElementHandler($controlOptions, 'textarea-handler');
			$classAppend = ' input--fitHeight';
		}
		else
		{
			$classAppend = '';
		}

		$maxLength = $this->processAttributeToRaw($controlOptions, 'maxlength');
		if ($maxLength)
		{
			$maxlengthAttr = " maxlength=\"{$maxLength}\"";
		}
		else
		{
			$maxlengthAttr = '';
		}

		$value = \XF::escapeString($this->processValueAttribute($controlOptions));
		$readOnlyAttr = $this->processAttributeToRaw($controlOptions, 'readonly') ? ' readonly="readonly"' : '';
		$classAttr = $this->processAttributeToHtmlAttribute($controlOptions, 'class', 'input' . $classAppend, true);

		$fa = $this->fontAwesomeInputOverlay($controlOptions);

		$unhandledAttrs = $this->processUnhandledAttributes($controlOptions);

		return "{$fa}<textarea{$classAttr}{$readOnlyAttr}{$maxlengthAttr}{$unhandledAttrs}>{$value}</textarea>";
	}

	public function formTextAreaRow(array $controlOptions, array $rowOptions)
	{
		$this->addToClassAttribute($rowOptions, 'formRow--input', 'rowclass');

		$controlId = $this->assignFormControlId($controlOptions);
		$controlHtml = $this->formTextArea($controlOptions);
		return $this->formRow($controlHtml, $rowOptions, $controlId);
	}

	public function formDateInput(array $controlOptions)
	{
		$this->processDynamicAttributes($controlOptions);

		$class = $this->processAttributeToRaw($controlOptions, 'class', ' %s', true);
		$xfInit = $this->processAttributeToRaw($controlOptions, 'data-xf-init', ' %s', true);
		$weekStart = $this->processAttributeToRaw($controlOptions, 'week-start', '', true);
		if (!$weekStart)
		{
			$weekStart = $this->language['week_start'];
		}
		$readOnly = $this->processAttributeToRaw($controlOptions, 'readonly');

		if (empty($controlOptions['value']))
		{
			$controlOptions['value'] = '';
		}
		else if (is_numeric($controlOptions['value']) || $controlOptions['value'] instanceof \DateTime)
		{
			$controlOptions['value'] = $this->language->date($controlOptions['value'], 'Y-m-d');
		}

		$attrsHtml = $this->processUnhandledAttributes($controlOptions);

		return $this->renderTemplate('public:date_input', [
			'class' => $class,
			'xfInit' => $xfInit,
			'weekStart' => $weekStart,
			'readOnly' => $readOnly,
			'attrsHtml' => $attrsHtml
		]);
	}

	public function formDateInputRow(array $controlOptions, array $rowOptions)
	{
		$this->addToClassAttribute($rowOptions, 'formRow--input', 'rowclass');

		$controlId = $this->assignFormControlId($controlOptions);
		$controlHtml = $this->formDateInput($controlOptions);
		return $this->formRow($controlHtml, $rowOptions, $controlId);
	}

	public function formCodeEditor(array $controlOptions)
	{
		$this->processDynamicAttributes($controlOptions);

		$name = $this->processAttributeToRaw($controlOptions, 'name');
		$value = $this->processValueAttribute($controlOptions);
		$extraClasses = $this->processAttributeToRaw($controlOptions, 'class');

		/** @var \XF\Data\CodeLanguage $codeLanguageData */
		$codeLanguageData = $this->app->data('XF:CodeLanguage');
		$supportedLanguages = $codeLanguageData->getSupportedLanguages();

		$mode = $this->processAttributeToRaw($controlOptions, 'mode');
		if (isset($supportedLanguages[$mode]))
		{
			$modeConfig = $supportedLanguages[$mode];
		}
		else
		{
			$modeConfig = [];
		}

		$readOnly = $this->processAttributeToRaw($controlOptions, 'readonly');
		if ($readOnly)
		{
			$extraClasses .= ' is-readonly';
		}

		$rows = $this->processAttributeToRaw($controlOptions, 'rows');
		if (!$rows)
		{
			$rows = 8;
		}

		$attrsHtml = $this->processUnhandledAttributes($controlOptions);

		return $this->renderTemplate('public:code_editor', [
			'name' => $name,
			'value' => $value,
			'lang' => $mode,
			'modeConfig' => $modeConfig,
			'extraClasses' => $extraClasses,
			'readOnly' => $readOnly,
			'rows' => $rows,
			'attrsHtml' => $attrsHtml
		]);
	}

	public function formCodeEditorRow(array $controlOptions, array $rowOptions)
	{
		$this->addToClassAttribute($rowOptions, 'formRow--input', 'rowclass');

		$controlId = $this->assignFormControlId($controlOptions);
		$controlHtml = $this->formCodeEditor($controlOptions);
		return $this->formRow($controlHtml, $rowOptions, $controlId);
	}

	public function formEditor(array $controlOptions)
	{
		$this->processDynamicAttributes($controlOptions);

		$name = $this->processAttributeToRaw($controlOptions, 'name');
		$value = $this->processAttributeToRaw($controlOptions, 'value');
		$styleAttr = $this->processAttributeToRaw($controlOptions, 'style');

		if (!isset($controlOptions['previewable']))
		{
			$previewable = true;
		}
		else
		{
			$previewable = (bool)$this->processAttributeToRaw($controlOptions, 'previewable');
		}
		if (!$previewable)
		{
			$controlOptions['data-preview'] = 'false';
		}

		$attachments = $controlOptions['attachments'] ?? [];
		if (!$this->isTraversable($attachments))
		{
			$attachments = [];
		}

		unset($controlOptions['attachments']);

		$bbCodeContainer = $this->app->bbCode();
		$customIcons = [];
		foreach ($bbCodeContainer['custom'] AS $k => $custom)
		{
			if ($custom['editor_icon_type'])
			{
				$customIcons[$k] = [
					'title' => $this->phrase('custom_bb_code_title.' . $k),
					'type' => $custom['editor_icon_type'],
					'value' => $custom['editor_icon_value'],
					'option' => $custom['has_option']
				];
			}
		}

		$editorToolbars = \XF::options()->editorToolbarConfig;
		$editorDropdowns = \XF::options()->editorDropdownConfig;
		$editorToolbarSizes = $this->app['editorToolbarSizes'];

		foreach ($editorDropdowns AS $cmd => &$dropdown)
		{
			$dropdown['title'] = $this->phrase('editor_dropdown.' . $cmd);
		}

		if (substr($name, -1) == ']')
		{
			$htmlName = substr($name, 0, -1) . '_html]';
		}
		else
		{
			$htmlName = $name . '_html';
		}

		if ($value !== '')
		{
			$rendererOpts = [
				'attachments' => $attachments
			];

			if (!empty($controlOptions['rendereropts']) && is_array($controlOptions['rendereropts']))
			{
				$rendererOpts += $controlOptions['rendereropts'];
			}

			$htmlValue = $this->app->bbCode()->render($value, 'editorHtml', 'editor', null, $rendererOpts);
		}
		else
		{
			$htmlValue = '';
		}

		if (!isset($controlOptions['data-min-height']))
		{
			$controlOptions['data-min-height'] = 250;
		}
		$height = intval($controlOptions['data-min-height']);

		$removeButtons = [];
		$hasSmilies = $this->app->smilies;
		$hasEmoji = (\XF::options()->showEmojiInSmilieMenu && \XF::config('fullUnicode'));
		$hasGif = \XF::options()->giphy['enabled'];

		if (isset($controlOptions['removebuttons']))
		{
			$removeButtons = $controlOptions['removebuttons'];
		}
		if (!$hasSmilies && !$hasEmoji)
		{
			$removeButtons[] = '_smilies';
		}
		if (!$hasGif)
		{
			$removeButtons[] = 'xfInsertGif';
		}

		if (isset($controlOptions['maxlength']) && empty($controlOptions['maxlength']))
		{
			unset($controlOptions['maxlength']);
		}

		$attrsHtml = $this->processUnhandledAttributes($controlOptions);

		$config = $this->app->config();

		return $this->renderTemplate('public:editor', [
			'name' => $name,
			'htmlName' => $htmlName,
			'value' => $value,
			'attachments' => $attachments,
			'htmlValue' => $htmlValue,
			'styleAttr' => $styleAttr,
			'attrsHtml' => $attrsHtml,
			'customIcons' => $customIcons,
			'editorToolbars' => $editorToolbars,
			'editorToolbarSizes' => $editorToolbarSizes,
			'editorDropdowns' => $editorDropdowns,
			'previewable' => $previewable,
			'height' => $height,
			'removeButtons' => array_unique($removeButtons),
			'fullEditorJs' => ($config['development']['fullJs'] && $config['development']['fullEditorJs'])
		]);
	}

	public function formEditorRow(array $controlOptions, array $rowOptions)
	{
		$this->addToClassAttribute($rowOptions, 'formRow--input', 'rowclass');

		$controlId = $this->assignFormControlId($controlOptions);
		$controlHtml = $this->formEditor($controlOptions);
		return $this->formRow($controlHtml, $rowOptions, $controlId);
	}

	public function formPrefixInput($prefixes, array $controlOptions)
	{
		$this->processDynamicAttributes($controlOptions);

		$prefixType = $this->processAttributeToRaw($controlOptions, 'type');

		$prefixName = $this->processAttributeToRaw($controlOptions, 'prefix-name');
		$textboxName = $this->processAttributeToRaw($controlOptions, 'textbox-name');

		$prefixClass = $this->processAttributeToRaw($controlOptions, 'prefix-class', ' %s');
		$textboxClass = $this->processAttributeToRaw($controlOptions, 'textbox-class', ' %s');

		$prefixValue = $this->processAttributeToRaw($controlOptions, 'prefix-value');
		$textboxValue = $this->processValueAttribute($controlOptions, 'textbox-value');

		$href = $this->processAttributeToRaw($controlOptions, 'href');
		$listenTo = $this->processAttributeToRaw($controlOptions, 'listen-to');
		$rows = $this->processAttributeToRaw($controlOptions, 'rows');

		$helpHref = $this->processAttributeToRaw($controlOptions, 'help-href');
		$helpSkipInitial = (bool)$this->processAttributeToRaw($controlOptions, 'help-skip-initial');

		$xfInit = $this->processAttributeToRaw($controlOptions, 'data-xf-init');

		$attrsHtml = $this->processUnhandledAttributes($controlOptions);

		return $this->renderTemplate('public:prefix_input', [
			'prefixes' => $prefixes ?: [],
			'prefixType' => $prefixType,
			'prefixName' => $prefixName ?: 'prefix_id',
			'prefixClass' => $prefixClass,
			'textboxClass' => $textboxClass,
			'textboxName' => $textboxName ?: 'title',
			'prefixValue' => $prefixValue ?: 0,
			'textboxValue' => $textboxValue ?: $this->zeroValueValid($textboxValue),
			'href' => $href,
			'listenTo' => $listenTo,
			'rows' => $rows,
			'helpHref' => $helpHref,
			'helpSkipInitial' => $helpSkipInitial,
			'xfInit' => $xfInit,
			'attrsHtml' => $attrsHtml
		]);
	}

	protected function zeroValueValid($var)
	{
		if ($var === 0 || $var === '0')
		{
			return $var;
		}

		return '';
	}

	public function formPrefixInputRow($prefixes, array $controlOptions, array $rowOptions)
	{
		$this->addToClassAttribute($rowOptions, 'formRow--input', 'rowclass');

		$controlId = $this->assignFormControlId($controlOptions);
		$controlHtml = $this->formPrefixInput($prefixes, $controlOptions);
		return $this->formRow($controlHtml, $rowOptions, $controlId);
	}

	public function formTextBox(array $controlOptions)
	{
		$this->processDynamicAttributes($controlOptions);

		$units = null;
		if (array_key_exists('type', $controlOptions))
		{
			$units = ($controlOptions['type'] == 'number' && !empty($controlOptions['units'])
				?  $controlOptions['units']
				: '');
			unset($controlOptions['units']);
		}

		$this->processCodeAttribute($controlOptions);
		$typeAttr = $this->processAttributeToHtmlAttribute($controlOptions, 'type', 'text');

		$class = $this->processAttributeToRaw($controlOptions, 'class', '', true);
		$xfInit = $this->processAttributeToRaw($controlOptions, 'data-xf-init', '', true);

		$acSingle = '';
		$autoComplete = $this->processAttributeToRaw($controlOptions, 'ac');
		if ($autoComplete)
		{
			if ($autoComplete == 'single')
			{
				$acSingle = " data-single=\"true\"";
			}
			$xfInit = ltrim("$xfInit auto-complete");
		}

		$validationError = '';
		$validationUrlAttr = '';
		$validationUrl = $this->processAttributeToRaw($controlOptions, 'validation-url', '', true);
		if ($validationUrl)
		{
			$validationError = '<div class="inputValidationError js-validationError"></div>';
			$validationUrlAttr = " data-validation-url=\"$validationUrl\"";
			$xfInit = ltrim("$xfInit input-validator");
		}

		$xfInitAttr = $xfInit ? " data-xf-init=\"$xfInit\"" : '';
		$readOnlyAttr = $this->processAttributeToRaw($controlOptions, 'readonly') ? ' readonly="readonly"' : '';

		$fa = $this->fontAwesomeInputOverlay($controlOptions);

		$unhandledAttrs = $this->processUnhandledAttributes($controlOptions);

		$input = "{$fa}<input{$typeAttr} class=\"" . trim("input {$class}") . "\"{$xfInitAttr}{$validationUrlAttr}{$acSingle}{$readOnlyAttr}{$unhandledAttrs} />{$validationError}";

		if ($units)
		{
			return "<div class=\"inputGroup inputGroup--numbers\">$input<span class=\"inputGroup-text\">$units</span></div>";
		}
		else
		{
			return $input;
		}
	}

	public function formTextBoxRow(array $controlOptions, array $rowOptions)
	{
		$this->addToClassAttribute($rowOptions, 'formRow--input', 'rowclass');

		$controlId = $this->assignFormControlId($controlOptions);
		$controlHtml = $this->formTextBox($controlOptions);
		return $this->formRow($controlHtml, $rowOptions, $controlId);
	}

	public function formNumberBox(array $controlOptions)
	{
		$this->processDynamicAttributes($controlOptions);

		$min = $controlOptions['min'] ?? null;
		$max = $controlOptions['max'] ?? null;
		$step = $controlOptions['step'] ?? 1;

		$minAttr = '';
		$maxAttr = '';
		$stepAttr = '';
		if ($min !== null)
		{
			$minAttr = ' min="' . htmlspecialchars($min) . '"';
		}
		if ($max !== null)
		{
			$maxAttr = ' max="' . htmlspecialchars($max) . '"';
		}
		if ($step)
		{
			$stepAttr = ' step="' . htmlspecialchars($step) . '"';
		}

		$type = 'number';
		if ($typeAttr = $this->processAttributeToRaw($controlOptions, 'type', '', true))
		{
			$type = $typeAttr;
		}

		// This is mostly targeting iOS which presents a symbol + number keyboard by default for the number input.
		// If step contains a decimal point or could support negative values then don't force a pattern, otherwise
		// assume it's \d* which will force the numeric only keypad on iOS.
		if ($step == 'any' || strpos($step, '.') !== false || ($min === null || $min < 0))
		{
			$pattern = '';
		}
		else
		{
			$pattern = '\d*';
		}

		if (isset($controlOptions['value']))
		{
			$controlOptions['value'] = trim($controlOptions['value']);
			if (preg_match('/[^0-9.-]/', $controlOptions['value']))
			{
				if (preg_match('/^{{(?:\s+)?(?:.*)(?:\s+)?}}$/', $controlOptions['value']))
				{
					// not a valid number but looks like a mustache/field adder template
					$value = $controlOptions['value'];
				}
				else
				{
					// value isn't a valid number
					$value = '';
				}
			}
			else
			{
				$value = $controlOptions['value'];
			}
		}
		else if (isset($controlOptions['default']))
		{
			$value = $controlOptions['default'];
		}
		else if (isset($controlOptions['min']))
		{
			$value = $controlOptions['min'];
		}
		else
		{
			$value = '';
		}

		$hasRequired = isset($controlOptions['required']);
		$required = $this->processAttributeToRaw($controlOptions, 'required');
		if (isset($controlOptions['min']) && !$hasRequired)
		{
			$required = true;
		}
		$requiredAttr = $required ? ' required="required"' : '';

		$units = !empty($controlOptions['units']) ?  $controlOptions['units'] : '';

		unset(
			$controlOptions['min'],
			$controlOptions['max'],
			$controlOptions['step'],
			$controlOptions['value'],
			$controlOptions['units']
		);

		$class = $this->processAttributeToRaw($controlOptions, 'class', ' %s', true);
		$xfInit = $this->processAttributeToRaw($controlOptions, 'data-xf-init', '', true);
		$xfInitAttr = $xfInit ? " data-xf-init=\"$xfInit\"" : '';
		$readOnlyAttr = $this->processAttributeToRaw($controlOptions, 'readonly') ? ' readonly="readonly"' : '';

		$groupClass = $this->processAttributeToRaw($controlOptions, 'group-class', ' %s', true);

		$buttonSmaller = $this->processAttributeToRaw($controlOptions, 'data-button-smaller', '', true);
		$buttonSmallerAttr = $buttonSmaller ? " data-button-smaller=\"$buttonSmaller\"" : '';

		$stepOverride = $this->processAttributeToRaw($controlOptions, 'data-step', '', true);
		$stepOverrideAttr = $stepOverride ? " data-step=\"{$stepOverride}\"" : '';

		$fa = $this->fontAwesomeInputOverlay($controlOptions);

		$unhandledAttrs = $this->processUnhandledAttributes($controlOptions);

		$input = "<div class=\"inputGroup inputGroup--numbers inputNumber{$groupClass}\" data-xf-init=\"number-box\"{$buttonSmallerAttr}{$stepOverrideAttr}>"
			. "{$fa}<input type=\"{$type}\" pattern=\"{$pattern}\" class=\"input input--number js-numberBoxTextInput{$class}\" value=\"{$value}\" {$minAttr}{$maxAttr}{$stepAttr}{$requiredAttr}{$readOnlyAttr}{$xfInitAttr}{$unhandledAttrs} />"
			. "</div>";

		if ($units)
		{
			return "<div class=\"inputGroup\">$input<div class=\"inputGroup\"><span class='inputGroup--splitter'></span><span class=\"inputGroup-text\">$units</span></div></div>";
		}
		else
		{
			return $input;
		}
	}

	public function formNumberBoxRow(array $controlOptions, array $rowOptions)
	{
		$this->addToClassAttribute($rowOptions, 'formRow--input', 'rowclass');

		$controlId = $this->assignFormControlId($controlOptions);
		$controlHtml = $this->formNumberBox($controlOptions);
		return $this->formRow($controlHtml, $rowOptions, $controlId);
	}

	public function formTokenInput(array $controlOptions)
	{
		$this->processDynamicAttributes($controlOptions);

		$name = $this->processAttributeToRaw($controlOptions, 'name');
		$value = $this->processValueAttribute($controlOptions);
		$hrefAttr = $this->processAttributeToRaw($controlOptions, 'href');
		$styleAttr = $this->processAttributeToRaw($controlOptions, 'style');
		$inputClass = $this->processAttributeToRaw($controlOptions, 'inputclass');

		$minLength = $this->processAttributeToRaw($controlOptions, 'min-length');
		if ($minLength === '')
		{
			$minLength = 2;
		}

		$maxLength = $this->processAttributeToRaw($controlOptions, 'max-length');
		$maxTokens = $this->processAttributeToRaw($controlOptions, 'max-tokens');

		$listData = $this->processAttributeToRaw($controlOptions, 'list-data');

		$attrsHtml = $this->processUnhandledAttributes($controlOptions);

		return $this->renderTemplate('public:token_input', [
			'name' => $name,
			'value' => $value,
			'hrefAttr' => $hrefAttr,
			'styleAttr' => $styleAttr,
			'inputClass' => $inputClass,
			'minLength' => $minLength,
			'maxLength' => $maxLength,
			'maxTokens' => $maxTokens,
			'listData' => $listData,
			'attrsHtml' => $attrsHtml
		]);
	}

	public function formTokenInputRow(array $controlOptions, array $rowOptions)
	{
		$this->addToClassAttribute($rowOptions, 'formRow--input', 'rowclass');

		$controlId = $this->assignFormControlId($controlOptions);
		$controlHtml = $this->formTokenInput($controlOptions);
		return $this->formRow($controlHtml, $rowOptions, $controlId);
	}

	public function formPasswordBox(array $controlOptions)
	{
		$this->processDynamicAttributes($controlOptions);

		$name = $this->processAttributeToRaw($controlOptions, 'name');
		$value = $this->processValueAttribute($controlOptions);

		$hideShow = true;
		if (isset($controlOptions['hideshow']) && ($controlOptions['hideshow'] === 'false' || $controlOptions['hideshow'] === 0))
		{
			$hideShow = false;
		}

		$checkStrength = false;
		if (isset($controlOptions['checkstrength']) && ($controlOptions['checkstrength'] === 'true' || $controlOptions['checkstrength'] === 1))
		{
			$checkStrength = true;
		}

		$afterInputHtml = $this->processAttributeToRaw($controlOptions, 'afterinputhtml');

		$attrsHtml = $this->processUnhandledAttributes($controlOptions);

		return $this->renderTemplate('public:password_box', [
			'name' => $name,
			'value' => $value,
			'hideShow' => $hideShow,
			'checkStrength' => $checkStrength,
			'attrsHtml' => $attrsHtml,
			'afterInputHtml' => $afterInputHtml
		]);
	}

	public function formPasswordBoxRow(array $controlOptions, array $rowOptions)
	{
		$this->addToClassAttribute($rowOptions, 'formRow--input', 'rowclass');

		$controlId = $this->assignFormControlId($controlOptions);
		$controlHtml = $this->formPasswordBox($controlOptions);
		return $this->formRow($controlHtml, $rowOptions, $controlId);
	}

	public function formTelBox(array $controlOptions)
	{
		$this->processDynamicAttributes($controlOptions);

		$name = $this->processAttributeToRaw($controlOptions, 'name');
		$value = $this->processValueAttribute($controlOptions);

		$dialCodeName = $this->processAttributeToRaw($controlOptions, 'dialcodename');
		$intlNumberName = $this->processAttributeToRaw($controlOptions, 'intlnumbername');

		$attrsHtml = $this->processUnhandledAttributes($controlOptions);

		return $this->renderTemplate('public:tel_box', [
			'name' => $name,
			'value' => $value,
			'dialCodeName' => $dialCodeName,
			'intlNumberName' => $intlNumberName,
			'attrsHtml' => $attrsHtml
		]);
	}

	public function formTelBoxRow(array $controlOptions, array $rowOptions)
	{
		$this->addToClassAttribute($rowOptions, 'formRow--input', 'rowclass');

		$controlId = $this->assignFormControlId($controlOptions);
		$controlHtml = $this->formTelBox($controlOptions);
		return $this->formRow($controlHtml, $rowOptions, $controlId);
	}

	public function formUpload(array $controlOptions)
	{
		$this->processDynamicAttributes($controlOptions);

		$class = $this->processAttributeToRaw($controlOptions, 'class', '', true);

		$unhandledAttrs = $this->processUnhandledAttributes($controlOptions);

		return "<input type=\"file\" class=\"input {$class}\"{$unhandledAttrs} />";
	}

	public function formUploadRow(array $controlOptions, array $rowOptions)
	{
		$this->addToClassAttribute($rowOptions, 'formRow--input', 'rowclass');

		$controlId = $this->assignFormControlId($controlOptions);
		$controlHtml = $this->formUpload($controlOptions);
		return $this->formRow($controlHtml, $rowOptions, $controlId);
	}

	public function formAssetUpload(array $controlOptions)
	{
		$this->processDynamicAttributes($controlOptions);

		$class = $this->processAttributeToRaw($controlOptions, 'class', '', true);
		$assetType = $this->processAttributeToRaw($controlOptions, 'asset', '', true);

		$accept = $this->processAttributeToRaw($controlOptions, 'accept');
		if (!$accept)
		{
			$accept = '.' . implode(',.', \XF\Service\Asset\Upload::getValidAssetExtensions());
		}

		$unhandledAttrs = $this->processUnhandledAttributes($controlOptions);

		$uploadText = $this->filterForAttr($this, $this->phrase('upload_file'), $null);

		return "
			<div class=\"inputGroup inputGroup--joined\" data-xf-init=\"asset-upload\" data-asset=\"{$assetType}\">
				<input type=\"text\" class=\"input js-assetPath {$class}\" {$unhandledAttrs} />
				
				<label class=\"inputGroup-text inputUploadButton\" data-xf-init=\"tooltip\" title=\"{$uploadText}\">
					<input type=\"file\" class=\"js-uploadAsset\" accept=\"{$accept}\" />
				</label>
			</div>
		";
	}

	public function formAssetUploadRow(array $controlOptions, array $rowOptions)
	{
		$this->addToClassAttribute($rowOptions, 'formRow--input', 'rowclass');

		$controlId = $this->assignFormControlId($controlOptions);
		$controlHtml = $this->formAssetUpload($controlOptions);
		return $this->formRow($controlHtml, $rowOptions, $controlId);
	}

	protected function assignFormControlId(array &$controlOptions)
	{
		if (!empty($controlOptions['id']))
		{
			return $controlOptions['id'];
		}

		$controlOptions['id'] = $this->func('unique_id');
		return $controlOptions['id'];
	}

	protected function assignRowLabelId(array &$rowOptions)
	{
		if (!empty($rowOptions['labelid']))
		{
			return $rowOptions['labelid'];
		}

		$rowOptions['labelid'] = $this->func('unique_id');
		return $rowOptions['labelid'];
	}

	public function formRow($contentHtml, array $rowOptions, $controlId = null)
	{
		$class = $this->processAttributeToRaw($rowOptions, 'rowclass', ' %s', true);
		$rowType = $this->processAttributeToRaw($rowOptions, 'rowtype');
		if ($rowType)
		{
			$class = $this->appendClassList($class, $rowType, 'formRow--%s');
		}

		$id = $this->processAttributeToRaw($rowOptions, 'rowid');
		$idAttr = $id ? ' id="' . htmlspecialchars($id) . '"' : '';

		if (isset($rowOptions['controlid']))
		{
			$controlId = $rowOptions['controlid'];
			unset($rowOptions['controlid']);
		}

		$labelFor = $controlId ? ' for="' . htmlspecialchars($controlId) . '"' : '';

		$labelId = $this->processAttributeToRaw($rowOptions, 'labelid');
		$labelIdAttr = $labelId ? ' id="' . htmlspecialchars($labelId) . '"' : '';

		$label = $this->processAttributeToRaw(
			$rowOptions,
			'label',
			"\n\t\t\t\t\t<label class=\"formRow-label\"{$labelFor}{$labelIdAttr}>%s</label>"
		);
		$hint = $this->processAttributeToRaw($rowOptions, 'hint', "\n\t\t\t\t\t<dfn class=\"formRow-hint\">%s</dfn>");

		$initialHtml = $this->processAttributeToRaw($rowOptions, 'initialhtml', "\n\t\t\t\t\t%s");
		$html = $this->processAttributeToRaw($rowOptions, 'html', "\n\t\t\t\t\t%s");
		$explain = $this->processAttributeToRaw($rowOptions, 'explain', "\n\t\t\t\t\t<div class=\"formRow-explain\">%s</div>");
		$error = $this->processAttributeToRaw($rowOptions, 'error', "\n\t\t\t\t\t<div class=\"formRow-error\">%s</div>");
		$finalHtml = $this->processAttributeToRaw($rowOptions, 'finalhtml', "\n\t\t\t\t\t%s");

		$unhandledAttrs = $this->processUnhandledAttributes($rowOptions);

		return '
			<dl class="formRow' . $class . '"' . $idAttr . $unhandledAttrs . '>
				<dt>
					<div class="formRow-labelWrapper">' . $label . $hint . '</div>
				</dt>
				<dd>
					' . $initialHtml // stuff to go before the control (rarely)
					  . $contentHtml // controls etc.
					  . $html // extra HTML, dependent controls etc.
					  . $error // error message
					  . $explain // final <p.explain> that describes all the above
					  . $finalHtml // used for <input hidden> etc.
					  . '
				</dd>
			</dl>
		';
	}

	public function formRowIfContent($contentHtml, array $rowOptions, $controlId = null)
	{
		$contentHtml = trim($contentHtml);
		if (!strlen($contentHtml))
		{
			return '';
		}
		else
		{
			return $this->formRow($contentHtml, $rowOptions, $controlId);
		}
	}

	public function formInfoRow($contentHtml, array $rowOptions)
	{
		$class = $this->processAttributeToRaw($rowOptions, 'rowclass', ' %s', true);
		$rowType = $this->processAttributeToRaw($rowOptions, 'rowtype');
		if ($rowType)
		{
			$class = $this->appendClassList($class, $rowType, 'formInfoRow--%s');
		}

		$unhandledRowAttrs = $this->processUnhandledAttributes($rowOptions);

		return "
			<div class=\"formInfoRow{$class}\"{$unhandledRowAttrs}>
				{$contentHtml}
			</div>
		";
	}

	public function form($contentHtml, array $options)
	{
		$this->processDynamicAttributes($options);

		$method = $this->processAttributeToRaw($options, 'method', '', true);
		if (!$method)
		{
			$method = 'post';
		}

		$getFormParams = '';
		$action = $this->processAttributeToRaw($options, 'action', '', true);
		if ($action && strtolower($method) == 'get')
		{
			$qStart = strpos($action, '?');
			if ($qStart !== false)
			{
				$qString = htmlspecialchars_decode(substr($action, $qStart + 1));
				$action = substr($action, 0, $qStart);

				if (preg_match('/^([^=&]*)(&|$)/', $qString, $qStringUrl))
				{
					$route = $qStringUrl[1];
					$qString = substr($qString, strlen($qStringUrl[0]));
				}
				else
				{
					$route = '';
				}


				if ($route !== '')
				{
					$getFormParams .= $this->formHiddenVal('_xfRoute', $route);
				}

				if ($qString)
				{
					$params = \XF\Util\Arr::parseQueryString($qString);
					foreach ($params AS $name => $value)
					{
						$getFormParams .= "\n\t" . $this->formHiddenVal($name, $value);
					}
				}
			}
		}

		$ajax = $this->processAttributeToRaw($options, 'ajax');
		$class = $this->processAttributeToRaw($options, 'class', '', true);
		$upload = $this->processAttributeToRaw($options, 'upload', '', true);
		$encType = $this->processAttributeToRaw($options, 'enctype', '', true);
		$preview = $this->processAttributeToRaw($options, 'preview', '', true);
		$xfInit = $this->processAttributeToRaw($options, 'data-xf-init', '', true);
		if ($ajax)
		{
			$xfInit = ltrim("$xfInit ajax-submit");
		}

		$encTypeAttr = '';
		if ($encType)
		{
			$encTypeAttr = " enctype=\"$encType\"";
		}
		else if ($upload)
		{
			$encTypeAttr = " enctype=\"multipart/form-data\"";
		}

		$previewUrlAttr = '';
		if ($preview)
		{
			$xfInit = ltrim("$xfInit preview");
			$previewUrlAttr = " data-preview-url=\"$preview\"";
		}

		$draftAttrs = $this->handleDraftAttribute($options, $class, $xfInit);

		$xfInitAttr = $xfInit ? " data-xf-init=\"$xfInit\"" : '';
		$unhandledAttrs = $this->processUnhandledAttributes($options);

		if (strtolower($method) == 'post')
		{
			$csrfInput = $this->func('csrf_input');
		}
		else
		{
			$csrfInput = '';
		}

		return "
			<form action=\"{$action}\" method=\"{$method}\" class=\"{$class}\"
				{$xfInitAttr}{$encTypeAttr}{$previewUrlAttr}{$draftAttrs}{$unhandledAttrs}
			>
				{$csrfInput}
				{$contentHtml}
				{$getFormParams}
			</form>
		";
	}

	protected function handleDraftAttribute(array &$options, &$class, &$xfInit)
	{
		$draftOptions = $this->app->options()->saveDrafts;
		if (!empty($draftOptions['enabled']))
		{
			$draft = $this->processAttributeToRaw($options, 'draft', '', true);
			if ($draft)
			{
				$xfInit = ltrim("$xfInit draft");

				return " data-draft-url=\"$draft\" data-draft-autosave=\"$draftOptions[saveFrequency]\"";
			}
		}

		unset($options['draft']);
		return '';
	}

	public function dataList($contentHtml, array $options)
	{
		$this->processDynamicAttributes($options);

		$class = $this->processAttributeToRaw($options, 'class', '', true);
		$unhandledAttrs = $this->processUnhandledAttributes($options);

		return "
			<div class=\"dataList {$class}\"{$unhandledAttrs}>
			<table class=\"dataList-table\">
				{$contentHtml}
			</table>
			</div>
		";
	}

	public function dataRow(array $options, array $cells = [])
	{
		if (!empty($options['rowtype']))
		{
			$rowType = $options['rowtype'];
		}
		else
		{
			$rowType = 'row';
		}

		if ($rowType == 'header')
		{
			if (!isset($options['rowclass']))
			{
				$options['rowclass'] = '';
			}

			$options['rowclass'] = trim($options['rowclass'] . ' dataList-row--header dataList-row--noHover');
		}
		else if ($rowType == 'subsection' || $rowType == 'subSection')
		{
			$rowType = 'subSection';

			if (!isset($options['rowclass']))
			{
				$options['rowclass'] = '';
			}

			$options['rowclass'] = trim($options['rowclass'] . ' dataList-row--subSection');
		}

		$label = (isset($options['label']) && strlen($options['label'])) ? $options['label'] : null;
		if ($label !== null)
		{
			$cell = [
				'_type' => 'main',
				'href' => !empty($options['href']) ? $options['href'] : null,
				'target' => !empty($options['target']) ? $options['target'] : null,
				'rel' => !empty($options['rel']) ? $options['rel'] : null,
				'label' => $label,
				'hint' => (isset($options['hint']) && strlen(trim($options['hint']))) ? $options['hint'] : null,
				'explain' => (isset($options['explain']) && strlen(trim($options['explain']))) ? $options['explain'] : null,
				'hash' => (isset($options['hash']) && strlen(trim($options['hash']))) ? $options['hash'] : null,
				'colspan' => !empty($options['colspan']) ? $options['colspan'] : null,
				'html' => ''
			];
			if (!empty($options['dir']))
			{
				$cell['dir'] = $options['dir'];
			}
			if (!empty($options['href']) && !empty($options['overlay']))
			{
				$cell['overlay'] = $options['overlay'];

				foreach ($this->overlayClickOptions AS $attributeName)
				{
					if (isset($options[$attributeName]))
					{
						$cell[$attributeName] = $options[$attributeName];
					}
				}
			}
			array_unshift($cells, $cell);
		}

		$icon = (isset($options['icon']) && strlen($options['icon'])) ? $options['icon'] : null;
		if ($icon !== null)
		{
			if ($icon == 'none')
			{
				$iconHtml = '';
			}
			else
			{
				$iconHtml = $this->fontAwesome($options['icon'] . ' fa-lg fa-fw');
			}

			$cell = [
				'class' => 'dataList-cell--min dataList-cell--iconic',
				'href' => !empty($options['href']) ? $options['href'] : null,
				'html' => $iconHtml
			];
			array_unshift($cells, $cell);
		}

		$delete = (isset($options['delete']) && $options['delete']) ? $options['delete'] : null;
		if ($delete)
		{
			$cells[] = [
				'_type' => 'delete',
				'href' => $delete,
				'html' => ''
			];
		}

		$rowClass = $this->processAttributeToRaw($options, 'rowclass', ' %s', true);

		$cellsHtml = [];
		foreach ($cells AS $cell)
		{
			$cellHtml = $this->getDataRowCell($rowType, $cell, $rowClass);
			if ($cellHtml)
			{
				$cellsHtml[] = $cellHtml;
			}
		}

		$html = implode("\n", $cellsHtml);

		$knownParts = [
			'colspan',
			'delete',
			'dir',
			'explain',
			'hash',
			'hint',
			'href',
			'rel',
			'icon',
			'label',
			'overlay',
			'rowtype',
			'target',
		];
		$knownParts += $this->overlayClickOptions;
		foreach ($knownParts AS $known)
		{
			unset($options[$known]);
		}

		$unhandledAttrs = $this->processUnhandledAttributes($options);

		return "
			<tr class=\"dataList-row{$rowClass}\"{$unhandledAttrs}>
				{$html}
			</tr>
		";
	}

	/**
	 * @param string $rowType Type of row; currently header or row
	 * @param array  $cell Array of attributes for the cell itself
	 * @param string $rowClass Allows cells to affect the appearance of the parent row
	 *
	 * @return string
	 */
	protected function getDataRowCell($rowType, array $cell, &$rowClass = '')
	{
		$type = $cell['_type'] ?? 'cell';
		unset($cell['_type']);

		$html = $cell['html'] ?? '';
		unset($cell['html']);

		$selected = !empty($cell['selected']);
		unset($cell['selected']);

		$class = $this->processAttributeToRaw($cell, 'class', ' %s', true);

		if ($type == 'delete')
		{
			$html = ''; // ignored
		}
		else if ($type == 'toggle')
		{
			$name = $this->processAttributeToRaw($cell, 'name', '', true);
			$inputType = $this->processAttributeToRaw($cell, 'type', '', true);
			$class .= ' dataList-cell--iconic';
			$labelClass = 'iconic';

			if ($inputClass = $this->processAttributeToRaw($cell, 'inputclass', '', true))
			{
				$inputClassAttr = " class=\"{$inputClass}\"";
			}
			else
			{
				$inputClassAttr = '';
			}

			if (!$inputType)
			{
				$inputType = 'checkbox';
			}

			$hiddenHtml = '';

			if (isset($cell['value']))
			{
				$value = $this->processAttributeToRaw($cell, 'value', '', true);
			}
			else
			{
				$value = '1';
				if ($inputType == 'checkbox')
				{
					$hiddenHtml = "<input type=\"hidden\" name=\"{$name}\" value=\"0\" />";
				}
			}

			$checkedHtml = $selected ? ' checked="checked"' : '';

			$disabled = !empty($cell['disabled']);
			unset($cell['disabled']);
			$disabledHtml = $disabled ? ' disabled="disabled"' : '';

			$tooltip = $this->processAttributeToRaw($cell, 'tooltip', '', true);
			if ($tooltip)
			{
				$tooltipHtml = " data-xf-init=\"tooltip\" title=\"{$tooltip}\"";
			}
			else
			{
				$tooltipHtml = '';
			}

			$submit = $this->processAttributeToRaw($cell, 'submit', '', true);
			if ($submit)
			{
				$submitHtml = ' data-xf-click="submit"';
				if ($submit != 'true')
				{
					$submitHtml .= ' data-target="' . $submit . '"';
				}

				if ($inputType == 'checkbox')
				{
					$labelClass .= ' iconic--toggle';

					if (!$selected)
					{
						$rowClass = $rowClass . ' dataList-row--disabled';
					}
				}

			}
			else
			{
				$submitHtml = '';
			}

			$html = $hiddenHtml
				. "<label class=\"{$labelClass}\"{$tooltipHtml}{$submitHtml}>"
				. "<input type=\"{$inputType}\" name=\"{$name}\" value=\"{$value}\"{$inputClassAttr}{$checkedHtml}{$disabledHtml} /><i aria-hidden=\"true\"></i>"
				. "</label>";
		}
		else if ($type == 'popup')
		{
			$label = (isset($cell['label']) && strlen(trim($cell['label']))) ? $cell['label'] : $this->phrase('actions');

			$outerHtml = '<a data-xf-click="menu" class="menuTrigger" role="button" tabindex="0" aria-expanded="false" aria-haspopup="true">' . $label . '</a>'
				. $html;

			$html = $outerHtml;
		}
		else if ($type == 'main')
		{
			$label = (isset($cell['label']) && strlen(trim($cell['label']))) ? $cell['label'] : null;
			if ($label !== null)
			{
				$hint = (isset($cell['hint']) && strlen(trim($cell['hint']))) ? $cell['hint'] : null;
				$explain = (isset($cell['explain']) && strlen(trim($cell['explain']))) ? $cell['explain'] : null;

				if (!empty($cell['dir']))
				{
					$label = '<span dir="' . htmlspecialchars($cell['dir']) . '">' . $label . '</span>';
					$explainDirAttr = ' dir="' . htmlspecialchars($cell['dir']) . '"';
				}
				else
				{
					$explainDirAttr = '';
				}

				$html = '<div class="dataList-mainRow">'
					. $label
					. ($hint !== null ? " <span class=\"dataList-hint\" dir=\"auto\">{$hint}</span>" : '') . '</div>'
					. ($explain !== null ? "\n<div class=\"dataList-subRow\"{$explainDirAttr}>{$explain}</div>" : '');
			}

			unset($cell['dir']);
		}

		if (isset($cell['hash']) && strlen(trim($cell['hash'])))
		{
			$html = '<span class="u-anchorTarget" id="'
				. htmlspecialchars($this->app->getRedirectHash($cell['hash']))
				. '"></span>'
				. $html;
		}
		unset($cell['hash']);

		if (!strlen($html))
		{
			$html = '&nbsp;';
		}

		$isAction = ($type == 'action' || $type == 'delete');
		$href = isset($cell['href']) ? htmlspecialchars($cell['href']) : '';

		if ($href)
		{
			$rel = $this->processAttributeToRaw($cell, 'rel', '', true);
			if ($rel)
			{
				$rel = " rel=\"{$rel}\"";
			}

			$target = $this->processAttributeToRaw($cell, 'target', '', true);
			if ($target)
			{
				$target = " target=\"{$target}\"";
			}

			if ($type == 'delete')
			{
				$class .= ' dataList-cell--iconic dataList-cell--alt';

				$tooltip = $this->processAttributeToRaw($cell, 'tooltip', '');
				if (!$tooltip)
				{
					$tooltip = $this->phrase('delete');
				}
				$tooltip = $this->filterForAttr($this, $tooltip, $null);
				$html = "<a href=\"{$href}\" class=\"iconic iconic--delete dataList-delete\" data-xf-init=\"tooltip\" title=\"{$tooltip}\" data-xf-click=\"overlay\"{$rel}{$target}><i aria-hidden=\"true\"></i></a>";
			}
			else
			{
				if (!$isAction)
				{
					$class .= ' dataList-cell--link';
				}

				$overlay = $this->processAttributeToRaw($cell, 'overlay', '', true);
				if ($overlay)
				{
					$overlay = " data-xf-click=\"overlay\"";

					foreach ($this->overlayClickOptions AS $attributeName)
					{
						if (isset($cell[$attributeName]))
						{
							$attributeValue = $this->processAttributeToRaw($cell, $attributeName, '', true);
							$overlay .= " $attributeName=\"{$attributeValue}\"";
						}
					}

					if (isset($cell['overlaycache']))
					{
						$overlayCache = $this->processAttributeToRaw($cell, 'overlaycache', '', true);
						$overlay .= " data-cache=\"{$overlayCache}\"";
					}
				}
				$html = "<a href=\"{$href}\" {$overlay}{$rel}{$target}>{$html}</a>";
			}
		}

		if ($isAction)
		{
			$class .= ' dataList-cell--action';
		}

		if ($type == 'popup')
		{
			$class .= ' dataList-cell--alt dataList-cell--link dataList-cell--min';
		}
		else if ($type == 'main')
		{
			$class .= ' dataList-cell--main';
		}

		unset($cell['href'], $cell['label'], $cell['explain'], $cell['hint']);

		$unhandledAttrs = $this->processUnhandledAttributes($cell);

		$tag = ($rowType == 'header' ? 'th' : 'td');

		return "<{$tag} class=\"dataList-cell{$class}\"{$unhandledAttrs}>{$html}</{$tag}>";
	}

	protected function addToClassAttribute(array &$options, $class, $key = 'class')
	{
		if (!isset($options[$key]))
		{
			$options[$key] = '';
		}

		if (strlen($options[$key]))
		{
			$options[$key] .= " $class";
		}
		else
		{
			$options[$key] = $class;
		}
	}

	protected function appendClassList($existingClasses, $classList, $formatter = '')
	{
		if (!$classList)
		{
			return $existingClasses;
		}

		$classList = preg_replace('#[^a-z0-9_ -]#i', '', $classList);

		foreach (Arr::stringToArray($classList, '#\s+#') AS $class)
		{
			if ($formatter)
			{
				$class = sprintf($formatter, $class);
			}

			$existingClasses .= ' ' . $class;
		}

		return $existingClasses;
	}

	protected function addElementHandler(array &$attributes, $handler, $classAttr = 'class')
	{
		if (!isset($attributes['data-xf-init']))
		{
			$attributes['data-xf-init'] = '';
		}
		if (!preg_match('/(^|\s)' . $handler . '($|\s)/', $attributes['data-xf-init']))
		{
			if (strlen($attributes['data-xf-init']))
			{
				$attributes['data-xf-init'] .= ' ' . $handler;
			}
			else
			{
				$attributes['data-xf-init'] = $handler;
			}
		}
	}

	protected function getButtonPhraseFromIcon($icon, $fallback = '')
	{
		switch ($icon)
		{
			case 'attach':
			case 'cancel':
			case 'confirm':
			case 'copy':
			case 'delete':
			case 'edit':
			case 'export':
			case 'import':
			case 'login':
			case 'merge':
			case 'move':
			case 'preview':
			case 'purchase':
			case 'save':
			case 'search':
			case 'sort':
			case 'submit':
			case 'translate':
			case 'show':
			case 'hide':
				$phrase = 'button.' . $icon;
				break;

			default:
				$phrase = $fallback;
		}

		return $phrase ? $this->phrase($phrase) : '';
	}

	public function renderNavigationClosure(\Closure $navHandler, $selectedNav = '', array $params = [], $addDefaultParams = true)
	{
		if ($addDefaultParams)
		{
			$params = array_merge($this->defaultParams, $params);
		}

		set_error_handler([$this, 'handleTemplateError']);

		try
		{
			$output = $navHandler($this, $selectedNav, $params);
		}
		catch (\Throwable $e)
		{
			if (\XF::$debugMode)
			{
				throw $e;
			}

			$this->app->logException($e, false, 'Error rendering navigation: ');
			$output = null;
		}

		restore_error_handler();

		return $output;
	}

	public function renderWidgetClosure(\Closure $widgetHandler, array $options = [])
	{
		set_error_handler([$this, 'handleTemplateError']);

		try
		{
			$vars = $this->defaultParams;
			$vars['context'] = $options['context'] ?? [];

			$output = $widgetHandler($this, $vars, $options);
		}
		catch (\Throwable $e)
		{
			if (\XF::$debugMode)
			{
				throw $e;
			}

			$this->app->logException($e, false, 'Error rendering widget: ');
			$output = null;
		}

		restore_error_handler();

		return $output;
	}

	public function renderUnfurl(\XF\Entity\UnfurlResult $result, array $options = [])
	{
		$options = array_replace([
			'noFollowUrl' => true,
			'noProxy' => false,
			'simpleUnfurl' => false
		], $options);

		$formatter = $this->app->stringFormatter();

		$linkInfo = $formatter->getLinkClassTarget($result->url);
		$rels = [];

		if (!$linkInfo['trusted'] && $options['noFollowUrl'])
		{
			$rels[] = 'nofollow';
			$rels[] = 'ugc';
		}

		if ($linkInfo['target'])
		{
			$rels[] = 'noopener';
		}

		$proxyUrl = '';
		$imageUrl = $result->image_url;
		$iconUrl = $result->favicon_url;

		if (!$options['noProxy'])
		{
			$proxyUrl = $formatter->getProxiedUrlIfActive('link', $result->url);

			if ($imageUrl)
			{
				$linkInfo = $formatter->getLinkClassTarget($imageUrl);
				if (!$linkInfo['local'])
				{
					$imageUrl = $formatter->getProxiedUrlIfActiveExtended('image', $imageUrl, ['return_error' => 1]);
					if (!$imageUrl)
					{
						$imageUrl = $result->image_url;
					}
				}
			}

			if ($iconUrl)
			{
				$linkInfo = $formatter->getLinkClassTarget($iconUrl);
				if (!$linkInfo['local'])
				{
					$iconUrl = $formatter->getProxiedUrlIfActiveExtended('image', $iconUrl, ['return_error' => 1]);
					if (!$iconUrl)
					{
						$iconUrl = $result->favicon_url;
					}
				}
			}
		}

		$viewParams = [
			'linkInfo' => $linkInfo,
			'rels' => $rels,
			'proxyUrl' => $proxyUrl,
			'result' => $result,
			'imageUrl' => $imageUrl,
			'faviconUrl' => $iconUrl,
			'simple' => $options['simpleUnfurl']
		];
		return $this->renderTemplate('public:bb_code_tag_url_unfurl', $viewParams);
	}
}
