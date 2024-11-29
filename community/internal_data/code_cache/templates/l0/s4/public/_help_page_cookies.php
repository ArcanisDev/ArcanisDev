<?php
// FROM HASH: 1b0c6a744d19eb4af8c1e8d58f844637
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<p>This page discusses how cookies are used by this site. If you continue to use this site, you are consenting to our use of cookies.</p>

<h3 class="textHeading">What are cookies?</h3>
<p>Cookies are small text files stored on your computer by your web browser at the request of a site you\'re viewing. This allows the site you\'re viewing to remember things about you, such as your preferences and history or to keep you logged in.</p>

<p>Cookies may be stored on your computer for a short time (such as only while your browser is open) or for an extended period of time, even years. Cookies not set by this site will not be accessible to us.</p>

<h3 class="textHeading">Our cookie usage</h3>
<p>This site uses cookies for numerous things, including:</p>
<ul>
	<li>Registration and maintaining your preferences. This includes ensuring that you can stay logged in and keeping the site in the language or appearance that you requested.</li>
	<li>Analytics. This allows us to determine how people are using the site and improve it.</li>
	<li>Advertising cookies (possibly third-party). If this site displays advertising, cookies may be set by the advertisers to determine who has viewed an ad or similar things. These cookies may be set by third parties, in which case this site has no ability to read or write these cookies.</li>
	<li>Other third-party cookies for things like Facebook or Twitter sharing. These cookies will generally be set by the third-party independently, so this site will have no ability to access them.</li>
</ul>

<h3 class="textHeading">Additional cookies and those set by third parties</h3>
<p>
	Additional cookies may be set during the use of the site to remember information as certain actions are being performed, or remembering certain preferences.
</p>
<p>
	Other cookies may be set by third party service providers which may provide information such as tracking anonymously which users are visiting the site, or set by content embedded into some pages, such as YouTube or other media service providers.
</p>

<h3 class="textHeading">Removing/disabling cookies</h3>
<p>Managing your cookies and cookie preferences must be done from within your browser\'s options/preferences. Here is a list of guides on how to do this for popular browser software:</p>
<ul>
	<li><a href="https://support.microsoft.com/en-gb/help/17442/windows-internet-explorer-delete-manage-cookies" target="_blank">Microsoft Internet Explorer</a></li>
	<li><a href="https://privacy.microsoft.com/en-us/windows-10-microsoft-edge-and-privacy" target="_blank">Microsoft Edge</a></li>
	<li><a href="https://support.mozilla.org/en-US/kb/cookies-information-websites-store-on-your-computer" target="_blank">Mozilla Firefox</a></li>
	<li><a href="https://support.google.com/chrome/answer/95647?hl=en" target="_blank">Google Chrome</a></li>
	<li><a href="https://support.apple.com/en-gb/guide/safari/manage-cookies-and-website-data-sfri11471/mac" target="_blank">Safari for macOS</a></li>
	<li><a href="https://support.apple.com/en-gb/HT201265" target="_blank">Safari for iOS</a></li>
</ul>

<h3 class="textHeading">More information about cookies</h3>
<p>
	To learn more about cookies, and find more information about blocking certain types of cookies, please visit the <a href="https://ico.org.uk/for-the-public/online/cookies/" target="_blank">ICO website Cookies page</a>.
</p>' . '

<h3 class="textHeading">' . 'Standard cookies we set' . '</h3>

';
	$__compilerTemp1 = '';
	$__compilerTemp2 = $__templater->func('array_keys', array($__templater->method($__vars['xf']['cookieConsent'], 'getCookiesInGroup', array('_required', )), ), false);
	if ($__templater->isTraversable($__compilerTemp2)) {
		foreach ($__compilerTemp2 AS $__vars['name']) {
			$__compilerTemp1 .= '
		' . $__templater->dataRow(array(
				'rowclass' => 'dataList-row--noHover',
			), array(array(
				'class' => 'dataList-cell--min dataList-cell--alt',
				'_type' => 'cell',
				'html' => $__templater->escape($__templater->method($__vars['xf']['cookieConsent'], 'getCookieLabel', array($__vars['name'], ))),
			),
			array(
				'_type' => 'cell',
				'html' => $__templater->escape($__templater->method($__vars['xf']['cookieConsent'], 'getCookieDescription', array($__vars['name'], ))),
			))) . '
	';
		}
	}
	$__compilerTemp3 = '';
	$__compilerTemp4 = $__templater->method($__vars['xf']['cookieConsent'], 'getGroups', array(false, false, ));
	if ($__templater->isTraversable($__compilerTemp4)) {
		foreach ($__compilerTemp4 AS $__vars['group']) {
			$__compilerTemp3 .= '
		' . $__templater->dataRow(array(
				'rowclass' => 'dataList-row--subSection dataList-row--noHover',
			), array(array(
				'colspan' => '2',
				'_type' => 'cell',
				'html' => $__templater->escape($__templater->method($__vars['xf']['cookieConsent'], 'getGroupLabel', array($__vars['group'], ))),
			))) . '

		' . $__templater->dataRow(array(
				'rowclass' => 'dataList-row--noHover',
			), array(array(
				'colspan' => '2',
				'_type' => 'cell',
				'html' => $__templater->escape($__templater->method($__vars['xf']['cookieConsent'], 'getGroupDescription', array($__vars['group'], ))),
			))) . '

		';
			$__compilerTemp5 = $__templater->func('array_keys', array($__templater->method($__vars['xf']['cookieConsent'], 'getCookiesInGroup', array($__vars['group'], )), ), false);
			if ($__templater->isTraversable($__compilerTemp5)) {
				foreach ($__compilerTemp5 AS $__vars['name']) {
					$__compilerTemp3 .= '
				' . $__templater->dataRow(array(
						'rowclass' => 'dataList-row--noHover',
					), array(array(
						'class' => 'dataList-cell--min dataList-cell--alt',
						'_type' => 'cell',
						'html' => $__templater->escape($__templater->method($__vars['xf']['cookieConsent'], 'getCookieLabel', array($__vars['name'], ))),
					),
					array(
						'_type' => 'cell',
						'html' => $__templater->escape($__templater->method($__vars['xf']['cookieConsent'], 'getCookieDescription', array($__vars['name'], ))),
					))) . '
		';
				}
			}
			$__compilerTemp3 .= '
	';
		}
	}
	$__compilerTemp6 = '';
	$__compilerTemp7 = $__templater->method($__vars['xf']['cookieConsent'], 'getThirdParties', array());
	if ($__templater->isTraversable($__compilerTemp7)) {
		foreach ($__compilerTemp7 AS $__vars['name']) {
			$__compilerTemp6 .= '
		' . $__templater->dataRow(array(
				'rowclass' => 'dataList-row--noHover',
			), array(array(
				'class' => 'dataList-cell--min dataList-cell--alt',
				'_type' => 'cell',
				'html' => $__templater->escape($__templater->method($__vars['xf']['cookieConsent'], 'getThirdPartyLabel', array($__vars['name'], ))),
			),
			array(
				'_type' => 'cell',
				'html' => $__templater->escape($__templater->method($__vars['xf']['cookieConsent'], 'getThirdPartyDescription', array($__vars['name'], ))),
			))) . '
	';
		}
	}
	$__finalCompiled .= $__templater->dataList('
	' . $__templater->dataRow(array(
		'rowtype' => 'header',
	), array(array(
		'class' => 'dataList-cell--min',
		'_type' => 'cell',
		'html' => 'Name',
	),
	array(
		'_type' => 'cell',
		'html' => 'Purpose',
	))) . '

	' . $__templater->dataRow(array(
		'rowclass' => 'dataList-row--subSection dataList-row--noHover',
	), array(array(
		'colspan' => '2',
		'_type' => 'cell',
		'html' => $__templater->escape($__templater->method($__vars['xf']['cookieConsent'], 'getGroupLabel', array('_required', ))),
	))) . '

	' . $__templater->dataRow(array(
		'rowclass' => 'dataList-row--noHover',
	), array(array(
		'colspan' => '2',
		'_type' => 'cell',
		'html' => $__templater->escape($__templater->method($__vars['xf']['cookieConsent'], 'getGroupDescription', array('_required', ))),
	))) . '

	' . $__compilerTemp1 . '

	' . $__compilerTemp3 . '

	' . $__templater->dataRow(array(
		'rowclass' => 'dataList-row--subSection dataList-row--noHover',
	), array(array(
		'colspan' => '2',
		'_type' => 'cell',
		'html' => $__templater->escape($__templater->method($__vars['xf']['cookieConsent'], 'getGroupLabel', array('_third_party', ))),
	))) . '

	' . $__templater->dataRow(array(
		'rowclass' => 'dataList-row--noHover',
	), array(array(
		'colspan' => '2',
		'_type' => 'cell',
		'html' => $__templater->escape($__templater->method($__vars['xf']['cookieConsent'], 'getGroupDescription', array('_third_party', ))),
	))) . '

	' . $__compilerTemp6 . '
', array(
		'data-xf-init' => 'responsive-data-list',
	));
	return $__finalCompiled;
}
);