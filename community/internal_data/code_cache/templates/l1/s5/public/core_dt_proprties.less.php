<?php
// FROM HASH: c81013b54a84bb1b550d8fc11e2f3f2c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '// ########################## DOHTHEME OPTION #######################

// ######## GENERAL ########
		

// #### Hide Breadcrum on Forum Home ####
';
	if ($__templater->func('property', array('dt_breadbrumb_index', ), false)) {
		$__finalCompiled .= '
.template-forum_list .p-breadcrumbs {
	display: none;
}
.template-forum_list .p-body-inner {
	padding: 20px;
}
';
	}
	$__finalCompiled .= '

';
	if ($__templater->func('property', array('dt_breadbrumb_index', ), false) AND (!$__templater->func('property', array('dt_collapsible_sidebar', ), false))) {
		$__finalCompiled .= '
.template-forum_list .p-breadcrumbs--container {
    display: none;
}
';
	}
	$__finalCompiled .= '

';
	if ($__templater->func('property', array('dt_breadbrumb_index', ), false) AND $__templater->func('property', array('dt_disable_sidebar', ), false)) {
		$__finalCompiled .= '
.template-forum_list .p-breadcrumbs--container {
    display: none;
}
';
	}
	$__finalCompiled .= '


// #### Hide Title Bar in Forum Home ####
';
	if ($__templater->func('property', array('dt_title_index', ), false)) {
		$__finalCompiled .= '
.template-forum_list .p-title-value {
	display: none;
}
.p-title-pageAction {
	margin-left: auto;
}
';
	}
	$__finalCompiled .= '


// #### Remove page actions from forum index ####
';
	if ($__templater->func('property', array('dt_pa_index', ), false)) {
		$__finalCompiled .= '
.template-forum_list .p-title-pageAction {
	display: none;
}
';
	}
	$__finalCompiled .= '


';
	if ($__templater->func('property', array('dt_title_index', ), false) AND $__templater->func('property', array('dt_pa_index', ), false)) {
		$__finalCompiled .= '
.template-forum_list .p-body-header {
	display: none;
}
';
	}
	$__finalCompiled .= '


// #### Avatar Shape ####

';
	if ($__templater->func('property', array('dt_avatar_shape', ), false) == 'option2') {
		$__finalCompiled .= '
.avatar img,
.avatar.avatar--default.avatar--default--dynamic,
.avatar.avatar--default.avatar--default--text {
	-webkit-clip-path: circle(50% at 50% 50%);
	clip-path: circle(50% at 50% 50%);
}
.avatar.avatar--separated {
	border-radius: 50%;
}
';
	} else if ($__templater->func('property', array('dt_avatar_shape', ), false) == 'option3') {
		$__finalCompiled .= '
.avatar img,
.avatar.avatar--default.avatar--default--dynamic,
.avatar.avatar--default.avatar--default--text {
	-webkit-clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);
	clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);
}
';
	} else if ($__templater->func('property', array('dt_avatar_shape', ), false) == 'option4') {
		$__finalCompiled .= '
.avatar img,
.avatar.avatar--default.avatar--default--dynamic,
.avatar.avatar--default.avatar--default--text {
	-webkit-clip-path: polygon(50% 0, 100% 38%, 80% 100%, 20% 100%, 0 38%);
	clip-path: polygon(50% 0, 100% 38%, 80% 100%, 20% 100%, 0 38%);
}
';
	} else if ($__templater->func('property', array('dt_avatar_shape', ), false) == 'option5') {
		$__finalCompiled .= '
.avatar img,
.avatar.avatar--default.avatar--default--dynamic,
.avatar.avatar--default.avatar--default--text {
	-webkit-clip-path: polygon(50% 0, 95% 25%, 95% 75%, 50% 100%, 5% 75%, 5% 25%);
	clip-path: polygon(50% 0, 95% 25%, 95% 75%, 50% 100%, 5% 75%, 5% 25%);
}
';
	} else if ($__templater->func('property', array('dt_avatar_shape', ), false) == 'option6') {
		$__finalCompiled .= '
.avatar img,
.avatar.avatar--default.avatar--default--dynamic,
.avatar.avatar--default.avatar--default--text {
	-webkit-clip-path: polygon(50% 0%, 90% 20%, 100% 60%, 75% 100%, 25% 100%, 0% 60%, 10% 20%);
	clip-path: polygon(50% 0%, 90% 20%, 100% 60%, 75% 100%, 25% 100%, 0% 60%, 10% 20%);
}
';
	} else if ($__templater->func('property', array('dt_avatar_shape', ), false) == 'option7') {
		$__finalCompiled .= '
.avatar img,
.avatar.avatar--default.avatar--default--dynamic,
.avatar.avatar--default.avatar--default--text {
	-webkit-clip-path: polygon(0 50%, 15% 15%, 50% 0, 85% 15%, 100% 50%, 85% 85%, 50% 100%, 15% 85%);
	clip-path: polygon(0 50%, 15% 15%, 50% 0, 85% 15%, 100% 50%, 85% 85%, 50% 100%, 15% 85%);
}
';
	} else if ($__templater->func('property', array('dt_avatar_shape', ), false) == 'option8') {
		$__finalCompiled .= '
.avatar img,
.avatar.avatar--default.avatar--default--dynamic,
.avatar.avatar--default.avatar--default--text {
	-webkit-clip-path: polygon(50% 0%, 83% 12%, 100% 43%, 94% 78%, 68% 100%, 32% 100%, 6% 78%, 0% 43%, 17% 12%);
	clip-path: polygon(50% 0%, 83% 12%, 100% 43%, 94% 78%, 68% 100%, 32% 100%, 6% 78%, 0% 43%, 17% 12%);
}
';
	} else if ($__templater->func('property', array('dt_avatar_shape', ), false) == 'option9') {
		$__finalCompiled .= '
.avatar
{
	border-radius: 0;
}
.avatar img,
.avatar.avatar--default.avatar--default--dynamic,
.avatar.avatar--default.avatar--default--text {
	-webkit-clip-path: polygon(20% 0%, 80% 0%, 100% 20%, 100% 80%, 80% 100%, 20% 100%, 0% 80%, 0% 20%);
	clip-path: polygon(20% 0%, 80% 0%, 100% 20%, 100% 80%, 80% 100%, 20% 100%, 0% 80%, 0% 20%);
}
';
	} else if ($__templater->func('property', array('dt_avatar_shape', ), false) == 'option10') {
		$__finalCompiled .= '
.avatar
{
	border-radius: 0;
}
.avatar img,
.avatar.avatar--default.avatar--default--dynamic,
.avatar.avatar--default.avatar--default--text {
	-webkit-clip-path: polygon(0% 15%, 15% 15%, 15% 0%, 85% 0%, 85% 15%, 100% 15%, 100% 85%, 85% 85%, 85% 100%, 15% 100%, 15% 85%, 0% 85%);
	clip-path: polygon(0% 15%, 15% 15%, 15% 0%, 85% 0%, 85% 15%, 100% 15%, 100% 85%, 85% 85%, 85% 100%, 15% 100%, 15% 85%, 0% 85%);
}
';
	}
	$__finalCompiled .= '

';
	if ($__templater->func('property', array('dt_avatar_shape', ), false) != 'option1') {
		$__finalCompiled .= '
.menu.menu--account {
	.avatar img,
	.avatar.avatar--default.avatar--default--dynamic,
	.avatar.avatar--default.avatar--default--text {
		clip-path: none;
	}
}
';
	}
	$__finalCompiled .= '

// #### Guest Message Content ####
';
	if ($__templater->func('property', array('dt_guest_message', ), false)) {
		$__finalCompiled .= '
.p-guest--message {
	.xf-dt_guest_message_css();
	
	';
		if ($__templater->func('property', array('dt_guest_message_index', ), false)) {
			$__finalCompiled .= '
	display: none;
	
	.template-forum_list & {
		display: block;
	}
	';
		}
		$__finalCompiled .= '
	
	&::before
	{
		content: \'\';
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background-color: fade(@xf-contentAccentBg, 30%);
		background-image: linear-gradient(-90deg,fade(@xf-contentAccentBg, 40%) 0%,@xf-contentAccentBg 73%);
		z-index: 1;
	}
	
	&-content
	{
		position: relative;
		z-index: 2;
	}
}
.p-guest--message h1 {
	font-size: 3.75em;
	-webkit-text-stroke: 2px currentColor;
	-webkit-text-fill-color: transparent;
	letter-spacing: 2px;
	margin-top: 0;
	margin-bottom: 0;
}
.p-guest--message p
{
	font-size: @xf-fontSizeLarge;
	font-weight: 600;	
}
';
	}
	$__finalCompiled .= '

// #### Hide Top Breadcrumb ####
';
	if ($__templater->func('property', array('dt_breadbrumb_top', ), false)) {
		$__finalCompiled .= '
.p-breadcrumbs:not(.p-breadcrumbs--bottom) {
	display: none;
}
.p-body-inner {
	padding-top: 20px;
}
';
	}
	$__finalCompiled .= '

';
	if ($__templater->func('property', array('dt_breadbrumb_top', ), false) AND $__templater->func('property', array('dt_collapsible_sidebar', ), false)) {
		$__finalCompiled .= '
.p-breadcrumbs--container:not(.p-breadcrumbs--container--side) {
    display: none;
}
';
	}
	$__finalCompiled .= '

';
	if ($__templater->func('property', array('dt_breadbrumb_top', ), false) AND (!$__templater->func('property', array('dt_collapsible_sidebar', ), false))) {
		$__finalCompiled .= '
.p-breadcrumbs--container {
    display: none;
}
';
	}
	$__finalCompiled .= '

';
	if ($__templater->func('property', array('dt_breadbrumb_top', ), false) AND $__templater->func('property', array('dt_disable_sidebar', ), false)) {
		$__finalCompiled .= '
.p-breadcrumbs--container {
    display: none;
}
';
	}
	$__finalCompiled .= '


// #### Hide Bottom Breadcrumb ####
';
	if ($__templater->func('property', array('dt_breadbrumb_bottom', ), false)) {
		$__finalCompiled .= '
.p-breadcrumbs.p-breadcrumbs--bottom {
	display: none;
}
.p-body-inner {
	padding-bottom: 20px;
}
';
	}
	$__finalCompiled .= '

// #### Home breadcrumb as icon ####
';
	if ($__templater->func('property', array('dt_homeCrumb_icon', ), false)) {
		$__finalCompiled .= '
ul.p-breadcrumbs > li:first-child::before
{
	display: none;
}
';
	}
	$__finalCompiled .= '


@media (min-width: @xf-responsiveWide)
{
	@animationSpeedValue: .15s;
	
	';
	if ($__templater->func('property', array('dt_page_animation', ), false)) {
		$__finalCompiled .= '
	
	@keyframes fade {
		from {
			opacity: 0;
		};
		to {
			opacity: 1;
		};
	}
	
	.fadeAnimation(@iteration) {
		animation: fade @animationSpeedValue ease;
		animation-delay: @iteration * @animationSpeedValue;
		animation-fill-mode: backwards;
	}
	
	.p-body-sideNavContent {.fadeAnimation(1);}
	.notices {.fadeAnimation(2);}
	.p-body-header {.fadeAnimation(3);}
	.pre-footer {.fadeAnimation(3);}
	.p-footer {.fadeAnimation(4);}
	
	';
	}
	$__finalCompiled .= '

	.itemAnimation(@iteration) {
		animation: slideUp .4s ease;
		animation-delay: (@iteration * .15s) + (@animationSpeedValue * 2);
		animation-fill-mode: backwards;
	}
	.itemLoop (@i) when (@i > 0) {
		&:nth-child(@{i}) {
			.itemAnimation(@i)
		}
		.itemLoop(@i - 1);
	}

	@keyframes slideUp {
		from {
			transform: translatey(30px);
			opacity: 0;
		};
		to {
			transform: translatey(0px);
			opacity: 1;
		};
	}
	
	';
	if ($__templater->func('property', array('dt_node_animation', ), false)) {
		$__finalCompiled .= '

	.block--category
	{
		.itemLoop(20);
	}
	
	';
	}
	$__finalCompiled .= '
	
	';
	if ($__templater->func('property', array('dt_discussion_animation', ), false)) {
		$__finalCompiled .= '

	.structItemContainer .structItem
	{
		.itemLoop(20);
	}
	
	';
	}
	$__finalCompiled .= '
	
	';
	if ($__templater->func('property', array('dt_message_animation', ), false)) {
		$__finalCompiled .= '

	.block--messages .block-body > .message--post
	{
		.itemLoop(20);
	}
	
	';
	}
	$__finalCompiled .= '
	
	';
	if ($__templater->func('property', array('dt_sidebar_widget_animation', ), false)) {
		$__finalCompiled .= '

	@sidebarItemDelay: .1s;

	@keyframes scootLeft {
		from {
			transform: translatex(30px);
			opacity: 0;
		};
		to {
			transform: translatex(0px);
			opacity: 1;
		};
	}

	.sidebarAnimation(@iteration)
	{
		animation: scootLeft .5s ease;
		animation-delay: (@iteration * @sidebarItemDelay) + (@animationSpeedValue * 3);
		animation-fill-mode: backwards;
		animation-iteration-count: 1;
	}

	.sidebarLoop (@i) when (@i > 0)
	{
		&:nth-child(@{i})
		{
			.sidebarAnimation(@i)
		}
		.sidebarLoop(@i - 1);
	}

	.p-body-sidebar .block
	{
		.sidebarLoop(15);
	}
	';
	}
	$__finalCompiled .= '
}


// ######## Header and navigation ########

// #### Sticky Staff tools ####

';
	if ($__templater->func('property', array('dt_sticky_staff_tools', ), false)) {
		$__finalCompiled .= '
.p-staffBar {
	position: -webkit-sticky;
	position: sticky;
	top: 0;
	z-index: @zIndex-4;
}
	';
		if ($__templater->func('property', array('publicNavSticky', ), false) != 'none') {
			$__finalCompiled .= '
	.p-navSticky.p-staffSticky
	{
		top: 35px;
	}
	';
		}
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

// #### Logo Text ####
';
	if ($__templater->func('property', array('dt_text_logo', ), false)) {
		$__finalCompiled .= '
.p-header-content .p-header-logo
{
	&.p-header-logo--text
	{
		.xf-dt_text_logo_css();
	}
}
';
	}
	$__finalCompiled .= '

// #### Hide Selected Tab Sub-Links bar ####
';
	if ($__templater->func('property', array('dt_disable_tab_links', ), false)) {
		$__finalCompiled .= '
.p-sectionLinks {
	display: none;
}
';
	}
	$__finalCompiled .= '

// #### Login triggers style ####
';
	if ($__templater->func('property', array('dt_triggers_style', ), false) == 'option2') {
		$__finalCompiled .= '
.menu 
{
	&[data-nav-id="userLogin"] .blocks
	{
		background: @xf-menu--background-color;
	}
	.formRow > dt, .formRow > dd 
	{
		display: block;
		width: 100%;
		text-align: left;
	}
	.formRow > dt:empty,
	.formRow > dd:empty {
		display: none;
	}
	.formRow
	{
		dt {
			padding: 0;
		}
	}
	.formRow.formRow--input
	{
		dt {
			padding: 15px 10px 15px 10px;
		}
	}
	.block-outer.block-outer--after
	{
		background: @xf-blockFooter--background-color;
		padding-bottom: 6px;
	}
}
';
	}
	$__finalCompiled .= '

// #### Condense Visitor Tabs ####
';
	if ($__templater->func('property', array('dt_condense_visito_tabs', ), false)) {
		$__finalCompiled .= '
.p-navgroup-link--user.badgeContainer::after {
	display: none;
}
.p-navgroup-link--user.badgeContainer.badgeContainer--highlighted::after {
	display: block;
}
@media (min-width: @xf-responsiveNarrow) {
	.p-navgroup-link--conversations,
	.p-navgroup-link--alerts {
		display: none;
	}
}
.menu--account .badgeContainer.badgeContainer--highlighted::after {
	margin-left: 6px;
}
';
	} else {
		$__finalCompiled .= '
.p-navgroup-link--user.badgeContainer::after {
	display: none;
}
';
	}
	$__finalCompiled .= '

// #### Inline Alert Ballons ####
';
	if ($__templater->func('property', array('dt_inline_ballons', ), false)) {
		$__finalCompiled .= '
.p-navgroup .p-navgroup-link.badgeContainer::after {
	position: relative;
	top: -2px;
	left: 2px;
}
';
		if ($__templater->func('property', array('dt_condense_visito_tabs', ), false)) {
			$__finalCompiled .= '
.p-navgroup .p-navgroup-link.p-navgroup-link--user {
	text-overflow: initial;
}
.p-navgroup .p-navgroup-link.badgeContainer::after {
	display: inline-block;
}
';
		}
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

// #### Remove user avatar from navigation ####
';
	if ($__templater->func('property', array('dt_nav_avatar', ), false)) {
		$__finalCompiled .= '
@media (min-width: @xf-responsiveWide)
{
	.p-navgroup-link.p-navgroup-link--user .avatar
	{
		display: none;
	}
}
';
	}
	$__finalCompiled .= '

// #### Remove user text from navigation ####
';
	if ($__templater->func('property', array('dt_nav_user_text', ), false) AND (!$__templater->func('property', array('dt_nav_avatar', ), false))) {
		$__finalCompiled .= '
.p-navgroup-link.p-navgroup-link--user .p-navgroup-linkText
{
	display: none;
}
';
	}
	$__finalCompiled .= '

// #### Remove search tab text ####
';
	if ($__templater->func('property', array('dt_login_text', ), false)) {
		$__finalCompiled .= '
.p-navgroup-link--logIn,
.p-navgroup-link--register
{
	.p-navgroup-linkText
	{
		display: none;
	}
}
';
	}
	$__finalCompiled .= '

// #### Remove search tab text ####
';
	if ($__templater->func('property', array('dt_search_text', ), false)) {
		$__finalCompiled .= '
.p-navgroup-link--search,
.p-navgroup-link--whatsnew
{
	.p-navgroup-linkText
	{
		display: none;
	}
}
';
	}
	$__finalCompiled .= '

// ######## Forum / Node List ########

// #### Collapsible Categories ####
';
	if ($__templater->func('property', array('dt_collapsible_categories', ), false)) {
		$__finalCompiled .= '
.block--category
{
	.block-header {
		position: relative;
	}
	
    .collapseTrigger:not(.button)
    {
		position: absolute;
		top: 50%;
		right: 10px;
		cursor: pointer;
		transform: translateY(-50%);
		
		&:before
        {
            content: ' . $__templater->func('property', array('dt_node_on_icon', ), true) . ';
			width: 100%;
            font-size: 80%;
			margin: 0;
        }
		
        &.is-active:before
        {
            content: ' . $__templater->func('property', array('dt_node_off_icon', ), true) . ';
        }
    }
}
.block-body.block-body--collapsible
{
    transition: all 0.75s cubic-bezier(0.68, -0.55, 0.27, 1.55);
    -webkit-transition-property: all, -xf-opacity;
    transition-property: all, -xf-opacity;
    overflow-y: hidden;
    height: 0;
    -webkit-transition-property: all, -xf-height;
    transition-property: all, -xf-height;
}
';
	}
	$__finalCompiled .= '

// #### Sticky Category Strips ####
';
	if ($__templater->func('property', array('dt_sticky_catstrips', ), false)) {
		$__finalCompiled .= '
.block--category .block-header {
	position: -webkit-sticky;
	position: sticky;
	';
		if ($__templater->func('property', array('publicNavSticky', ), false) == 'primary') {
			$__finalCompiled .= '
	top: (@xf-publicNavPaddingV * 2) + 22px;
	';
		} else if ($__templater->func('property', array('publicNavSticky', ), false) == 'all') {
			$__finalCompiled .= '
	top: (@xf-publicNavPaddingV * 2) + 53px;
	';
		} else {
			$__finalCompiled .= '
	top: 0;
	';
		}
		$__finalCompiled .= '
	z-index: 100;
}
';
	}
	$__finalCompiled .= '

// #### Simplified Node Statics ####
';
	if ($__templater->func('property', array('dt_nodestat_simple', ), false)) {
		$__finalCompiled .= '
.node-stats
{
	max-width: 100px;
}
.node-stats .pairs.pairs--rows > dd
{
	font-size: 1.35em;
}
';
	}
	$__finalCompiled .= '

// #### Show Node Stats on Hover ####
';
	if ($__templater->func('property', array('dt_node_stats', ), false)) {
		$__finalCompiled .= '
.node-stats {
	opacity: 0;
	transform: scale(0.75);
	.m-transition(all, 0.3s);
}
.block-body .node:hover .node-stats {
	opacity: 1;
	transform: scale(1);
}
';
	}
	$__finalCompiled .= '

// #### Last poster avatar on the forum list ####
';
	if (!$__templater->func('property', array('dt_last_avatar_forum', ), false)) {
		$__finalCompiled .= '
.node-extra-icon
{
	display: none;
}
';
	}
	$__finalCompiled .= '

// #### New Indicator Label ####
';
	if ($__templater->func('property', array('dt_new_indicator', ), false)) {
		$__finalCompiled .= '
.node--newIndicator {
	.xf-dt_new_indicator_css();
}
.node--forum .node--newIndicator {
	display: none;
}
.node--forum.node--unread .node--newIndicator {
	display: inline-block;
}
';
	}
	$__finalCompiled .= '

// #### Alternative Node Background ####
';
	if ($__templater->func('property', array('dt_alternative_nodes', ), false)) {
		$__finalCompiled .= '
.block-body .node:nth-of-type(2n+2) {
	background: ' . $__templater->func('property', array('dt_alternative_nodes', ), true) . ';
}
';
	}
	$__finalCompiled .= '

// #### Hover Background on Nodes ####
';
	if ($__templater->func('property', array('dt_hb_nodes', ), false)) {
		$__finalCompiled .= '
.block-body .node {
	.m-transition(all, 0.3s);
}

.block-body .node:hover {
	background: ' . $__templater->func('property', array('dt_hb_nodes', ), true) . ';
}
';
	}
	$__finalCompiled .= '

// #### Hover Effect on Nodes ####
';
	if ($__templater->func('property', array('dt_he_nodes', ), false)) {
		$__finalCompiled .= '
.block-body .node {
	.m-transition(all, 0.3s);
}

.block-body .node:hover {
	transform: scale(1.015);
}
';
	}
	$__finalCompiled .= '

// #### Category Description ####
';
	if ($__templater->func('property', array('dt_cat_description', ), false) == 'option2') {
		$__finalCompiled .= '
.block-header .block-desc {
	display: inline-block;
	opacity: 0;
	margin-left: 4px;
	.m-transition(all, 0.3s);
}
.block--category .block-container:hover .block-desc {
	opacity: 1;
}
';
	}
	$__finalCompiled .= '

// ######## Sidebar ########

// #### Disable Sidebar ####
';
	if ($__templater->func('property', array('dt_disable_sidebar', ), false)) {
		$__finalCompiled .= '
.p-body-main .p-body-sidebar {
	display: none;
}
.p-body-main.p-body-main--withSidebar .p-body-content {
	width: 100%;
	max-width: 100%;
	padding-right: 0;
}
';
	}
	$__finalCompiled .= '

// #### Sidebar Position ####
';
	if ($__templater->func('property', array('dt_sidebar_position', ), false) == 'option2') {
		$__finalCompiled .= '
@media (min-width: @xf-responsiveWide) {
	.p-body-main--withSidebar .p-body-content {
		order: 2;
		padding-left: @xf-sidebarSpacer;
		padding-right: 0 !important;
	}
	.p-body-sidebar {
		order: 1;
	}
}
';
	}
	$__finalCompiled .= '
';
	if ($__templater->func('property', array('dt_sidebar_position', ), false) == 'option3') {
		$__finalCompiled .= '
@media (min-width: @xf-responsiveWide)
{
	.p-body .p-body-main,
	.p-body .p-body-content
	{
		display: block;
	}
	.p-body .p-body-main--withSideNav .p-body-content,
	.p-body .p-body-main--withSidebar .p-body-content
	{
		padding: 0;
	}
	.p-body .p-body-sidebar
	{
		display: flex;
		flex-wrap: wrap;
		align-items: stretch;
		margin: 20px -5px 0;
		width: auto;

		&::after
		{
			display: block;
			content: \'\';
			height: 0;
			margin: 0 5px;
			min-width: @xf-sidebarWidth;
			flex: 1 1 @xf-sidebarWidth;
		}
	}
	
	.p-body .p-body-sidebar > *
	{
		margin: 0 ((@xf-pageEdgeSpacer) / 2) @xf-elementSpacer;
		min-width: @xf-sidebarWidth;
		flex: 1 1  @xf-sidebarWidth;
	}
}
';
	}
	$__finalCompiled .= '

// #### Sticky Sidebar ####
';
	if ($__templater->func('property', array('dt_sticky_sidebar', ), false) AND (!$__templater->func('property', array('dt_disable_sidebar', ), false))) {
		$__finalCompiled .= '
.p-body-sidebar {
	position: -webkit-sticky;
	position: sticky;
	top: (@xf-publicNavPaddingV * 2) + 25px;
}
';
	}
	$__finalCompiled .= '

// #### Collapsible Sidebar ####
';
	if ($__templater->func('property', array('dt_collapsible_sidebar', ), false) AND (!$__templater->func('property', array('dt_disable_sidebar', ), false))) {
		$__finalCompiled .= '
.p-breadcrumbs--container {
	display: flex;
	align-items: center;
	
	.collapseTrigger:not(.button)
	{
		margin-left: auto;
		
		&:before
        {
            content: ' . $__templater->func('property', array('dt_collpse_off_icon', ), true) . ';
			width: 100%;
			margin-left: 0;
        }
		
		&.is-active:before
        {
            content: ' . $__templater->func('property', array('dt_collpse_on_icon', ), true) . ';
        }

		@media (max-width: @xf-responsiveWide)
		{
			display: none;
		}
	}
}

.p-body-content {
    transition: all .55s cubic-bezier(0.68, -0.55, 0.27, 1.55);
}
.p-body-sidebar {
	transition: all .45s cubic-bezier(0.68, -0.55, 0.27, 1.55);
}
.p-body-main--withSidebar .p-body-content:not(.is-active) {
	width: 100%;
	max-width: 100%;
}
.p-body-main--withSidebar .p-body-sidebar:not(.is-active) {
	width: 0;
	height: 0;
	transform: scale(0);
	opacity: 0;
}

';
	}
	$__finalCompiled .= '

// #### Collapsible Sidebar Block ####
';
	if ($__templater->func('property', array('dt_collapsible_sidebar_block', ), false) AND (!$__templater->func('property', array('dt_disable_sidebar', ), false))) {
		$__finalCompiled .= '
.p-body-sidebar .block-minorHeader {
	position: relative;
}
.p-body-sidebar .block-minorHeader .block-control {
	position: absolute;
	top: 50%;
	right: 10px;
	font-size: 80%;
	cursor: pointer;
	transform: translateY(-50%);
}
';
	}
	$__finalCompiled .= '

// #### Sidebar login ####

';
	if ($__templater->func('property', array('dt_sidebar_login', ), false)) {
		$__finalCompiled .= '
.p-body-sidebar
{
	.blocks.blocks--login
	{
		.formRow 
		{
			> dt, > dd
			{
				width: auto;
				display: block;
				text-align: left;
				padding: 0px;
				background-color: transparent;
				border-width: 0;
			}
			> dt
			{
				padding: 5px 0px;
			}
			&:first-child
			{
				> dt
				{
					padding-top: 0;
				}
			}
			&.formSubmitRow dt
			{
				display: none;
			}
			.formSubmitRow-bar
			{
				background-color: transparent;
				border-width: 0;
			}
			.formSubmitRow-controls
			{
				padding-left: 0;
				text-align: right;
				margin-right: 8px;

			}
		}
		.block-outer--register
		{
			.xf-blockFooter();
			
			padding: @xf-paddingLarge;
			margin: 0 -@xf-blockPaddingH -@xf-blockPaddingV;
			text-align: right;
			
			a.button
			{
				margin-left: 5px;
			}
		}
	}
}
';
	}
	$__finalCompiled .= '


// ######## Discussion List ########

// #### Discussion minor header ####

';
	if ($__templater->func('property', array('dt_disc_minor_header', ), false)) {
		$__finalCompiled .= '
.discu-minorHeader
{
	display: table;
	table-layout: fixed;
	width: 100%;
	.xf-dt_disc_minor_header_css();

	span
	{
		display: table-cell;
		vertical-align: middle;

		&.discu-minorHeader--main
		{
			padding: 10px 8px 10px 58px;
		}
		&.discu-minorHeader--stats
		{
			width: 70px;
			text-align: center;
			padding: 10px 8px;
			
			';
		if ($__templater->func('property', array('dt_reactions_column', ), false)) {
			$__finalCompiled .= '
				width: 75px;
			';
		}
		$__finalCompiled .= '
		}
		&.discu-minorHeader--last
		{
			width: 230px;
			text-align: center;
			padding: 10px 8px;
		}
	}
}

.structItemContainer-group
{
	.structItem-cell.structItem-cell--meta
	{
		width: 70px;
		text-align: center;
		
		@media (max-width: @xf-responsiveWide)
		{
			width: 58px;
		}
	}
}

.structItemContainer-group
{
	.structItem-cell
	{
		vertical-align: middle;
	}
}

@media (max-width: @xf-responsiveWide)
{
	.discu-minorHeader
	{
		font-size: @xf-fontSizeSmallest;
	}
	
	.discu-minorHeader span.discu-minorHeader--stats
	{
		width: 58px;
	}

	.discu-minorHeader span.discu-minorHeader--last
	{
		width: 180px;
		
	}
}

@media (max-width: @xf-responsiveMedium)
{
	.discu-minorHeader
	{
		display: none;
	}
	
	.structItemContainer-group .structItem-cell.structItem-cell--meta
	{
		display: none;
	}
	
	.structItem-cell.structItem-cell--latest::before
	{
		display: none;
	}
}
';
	}
	$__finalCompiled .= '

// #### Collapsible sticky threads ####

';
	if ($__templater->func('property', array('dt_collaps_sticky_threads', ), false)) {
		$__finalCompiled .= '
.block-stickyHeader
{
	display: flex;
	align-items: center;
	
	.collapseTrigger
	{
		margin-left: auto;
		
		&:before
		{
			content: ' . $__templater->func('property', array('dt_node_on_icon', ), true) . ';
			font-size: 100%;
		}
		
		&.is-active:before
		{
			content: ' . $__templater->func('property', array('dt_node_off_icon', ), true) . ';
		}
	}
}
.structItemContainer-group--sticky
{
	opacity: 0;
    transition: all 0.75s cubic-bezier(0.68, -0.55, 0.27, 1.55);
    -webkit-transition-property: all, -xf-opacity;
    transition-property: all, -xf-opacity;
    overflow-y: hidden;
    height: 0;
    -webkit-transition-property: all, -xf-height;
    transition-property: all, -xf-height;
	
	&.is-active
	{
		height: auto;
		opacity: 1;
		overflow-y: visible;
	}
}
';
	}
	$__finalCompiled .= '

// #### Seperate Sticky Threads ####

';
	if ($__templater->func('property', array('dt_seperate_sticky_threads', ), false)) {
		$__finalCompiled .= '
.block-stickyHeader {
	.xf-dt_seperate_sticky_threads_css();
}
';
	}
	$__finalCompiled .= '


// #### Unique background to sticky thread ####

';
	if ($__templater->func('property', array('dt_background_sticky_thread_css', ), false)) {
		$__finalCompiled .= '
.structItemContainer-group--sticky .structItem--thread {
	.xf-dt_background_sticky_thread_css();
}
';
	}
	$__finalCompiled .= '

// #### Last poster avatar on the discussion list ####

';
	if (!$__templater->func('property', array('dt_last_avatar_discussion', ), false)) {
		$__finalCompiled .= '
.structItem-cell.structItem-cell--iconEnd
{
	display: none;
}
';
	}
	$__finalCompiled .= '

// #### Locked Threads Opacity ####

';
	if ($__templater->func('property', array('dt_opacity_thread_lock', ), false)) {
		$__finalCompiled .= '
.structItem--thread.is-locked {
	opacity: 0.6;
}
.structItemContainer-group--sticky .structItem--thread.is-locked {
	opacity: 1;
}
';
	}
	$__finalCompiled .= '

// #### Remove Mini-me Avatar ####

';
	if ($__templater->func('property', array('dt_minime_avatar', ), false)) {
		$__finalCompiled .= '
.structItem-iconContainer .structItem-secondaryIcon
{
	display: none;
}
';
	}
	$__finalCompiled .= '

// #### New Indicator Label ####

';
	if ($__templater->func('property', array('dt_disc_new_indicator', ), false)) {
		$__finalCompiled .= '
.structItem.is-unread .structItem-title a:not(.labelLink):after {
    content: "' . 'New' . '";
    .xf-dt_new_indicator_css();
	margin-left: @xf-paddingMedium;
}
';
	}
	$__finalCompiled .= '

// #### Reactions column in meta box ####

';
	if ($__templater->func('property', array('dt_reactions_column', ), false)) {
		$__finalCompiled .= '
.structItem .structItem-cell
{
    vertical-align: middle;
}
';
	}
	$__finalCompiled .= '

// #### Alternative Thread Background ####

';
	if ($__templater->func('property', array('dt_alternative_threads', ), false)) {
		$__finalCompiled .= '
.structItemContainer-group:not(.structItemContainer-group--sticky) .structItem.structItem--thread:nth-of-type(2n+1) {
	background: ' . $__templater->func('property', array('dt_alternative_threads', ), true) . ';
}
';
	}
	$__finalCompiled .= '

// #### Hover Background on Threads ####

';
	if ($__templater->func('property', array('dt_hb_threads', ), false)) {
		$__finalCompiled .= '
.structItem.structItem--thread {
	.m-transition(all, 0.3s);
}
.structItem.structItem--thread:hover {
	background: ' . $__templater->func('property', array('dt_hb_threads', ), true) . ';
}
';
	}
	$__finalCompiled .= '

// #### Hover Effect on Threads ####

';
	if ($__templater->func('property', array('dt_he_threads', ), false)) {
		$__finalCompiled .= '
.structItem.structItem--thread {
	.m-transition(all, 0.3s);
}
.structItem.structItem--thread:hover {
	transform: scale(1.015);
}
';
	}
	$__finalCompiled .= '


// ######## Message Layout ########


// #### Messages Layout ####
';
	if ($__templater->func('property', array('dt_messages_layout', ), false) == 'option2') {
		$__finalCompiled .= '
.block--messages .message:not(.message--simple) {
	.message-inner {
		flex-direction: column;
	}
	.message-inner .message-cell.message-cell--user,
	.message-inner .message-cell.message-cell--action {
		border-right: none;
		border-bottom: @xf-messageUserBlock--border-width solid @xf-messageUserBlock--border-color;
	}
	.message-inner .message-cell.message-cell--user {
		flex: 0 0 100%;
	}
	.message-cell.message-cell--user .message-user {
		display: flex;
		align-items: center;

		.message-userExtras {
			margin-top: 0;
			margin-left: auto;
		}

		.message-userDetails {
			margin-left: 20px;
		}

		.message-avatar {
			margin-bottom: 0;
		}

		@media (min-width: @xf-messageSingleColumnWidth) {
			.message-userArrow {
				position: absolute;
				bottom: 0;
				left: 50px;
				top: initial;
				right: initial;

				.m-triangleUp(xf-default(@xf-messageUserBlock--border-color, transparent), @xf-messagePadding);

				&:after
				{
					position: absolute;
					top: 2px;
					right: -@xf-messagePadding + 1;
					content: "";

					.m-triangleUp(@xf-contentBg, @xf-messagePadding - 1px);
				}
			}
		}
	}
	.message--quickReply {
		.message-cell.message-cell--user {
			display: none;
		}
	}
}
';
	}
	$__finalCompiled .= '

';
	if ($__templater->func('property', array('dt_messages_layout', ), false) == 'option3') {
		$__finalCompiled .= '
.message.is-first {
	
	.message-inner {
		flex-direction: column;
	}
	.message-inner .message-cell.message-cell--user,
	.message-inner .message-cell.message-cell--action {
		border-right: none;
		border-bottom: @xf-messageUserBlock--border-width solid @xf-messageUserBlock--border-color;
	}
	.message-inner .message-cell.message-cell--user {
		flex: 0 0 100%;
	}
	.message-cell.message-cell--user .message-user {
		display: flex;
		align-items: center;

		.message-userExtras {
			margin-top: 0;
			margin-left: auto;
		}

		.message-userDetails {
			margin-left: 20px;
		}

		.message-avatar {
			margin-bottom: 0;
		}

		@media (min-width: @xf-messageSingleColumnWidth) {
			.message-userArrow {
				position: absolute;
				bottom: 0;
				left: 50px;
				top: initial;
				right: initial;

				.m-triangleUp(xf-default(@xf-messageUserBlock--border-color, transparent), @xf-messagePadding);

				&:after
				{
					position: absolute;
					top: 2px;
					right: -@xf-messagePadding + 1;
					content: "";

					.m-triangleUp(@xf-contentBg, @xf-messagePadding - 1px);
				}
			}
		}
	}
}
';
	}
	$__finalCompiled .= '

// #### Center Thread Title ####

';
	if ($__templater->func('property', array('dt_thread_title_center', ), false)) {
		$__finalCompiled .= '
.template-thread_view .p-body-header {
	text-align: center;
}
.template-thread_view .p-body-header .p-title-value {
	margin-left: auto;
}
';
	}
	$__finalCompiled .= '

// #### Hide Avatar Beside Editor ####

';
	if ($__templater->func('property', array('dt_editor_avatar', ), false)) {
		$__finalCompiled .= '
.message.message--quickReply .message-cell--user {
	display: none;
}
.message.message--quickReply .message-cell.message-cell--main {
	padding-left: 10px;
	margin-left: 0;
}

';
	}
	$__finalCompiled .= '

// #### Show Extra User Info On Hover ####

';
	if ($__templater->func('property', array('dt_euicss', ), false) AND (!$__templater->func('property', array('dt_collapsible_extras', ), false))) {
		$__finalCompiled .= '
.message-userExtras {
	max-height: 0px;
	opacity: 0;
	overflow: hidden;
	.m-transition(all, 0.3s);
}
.message-cell--user:hover .message-userExtras {
	max-height: 300px;
	opacity: 1;
}
';
	}
	$__finalCompiled .= '

// #### Collapsible User Extras ####
';
	if ($__templater->func('property', array('dt_collapsible_extras', ), false) AND ($__templater->func('property', array('dt_messages_layout', ), false) == 'option1')) {
		$__finalCompiled .= '
.message-userExtras-body
{
    .m-listPlain();

    &.message-userExtras--collapsible
    {
        .has-no-js & { display: block; }

        .m-transitionFadeDown();
    }
}

.message-cell
{
    .collapseTrigger:not(.button)
    {
        text-align: center;
		padding: @xf-paddingMedium 0;
		
        &:before
        {
            content: "\\f062";
			background: @xf-contentAltBg;
            color: @xf-linkColor;
			width: 24px;
			height: 24px;
			line-height: 24px;
			font-size: @xf-fontSizeSmaller;
			text-align: center;
			border-radius: 50%;
            transition: ease-in transform .3s;
        }
		
		&.is-active:before
        {
            transform: rotate(-180deg);
        }
		
		&:hover
		{
			&:before
			{
				background: @xf-contentAccentBg;
				color: @xf-textColorAccentContent;
				transform: rotate(-180deg);
			}
		}
		
        &.collapseTrigger--block:before
        {
            float: none;
        }
		
		@media (max-width: @xf-messageSingleColumnWidth)
		{
			display: none;
		}
    }
}
';
	}
	$__finalCompiled .= '

// #### First Post Uniuqe Background ####
';
	if ($__templater->func('property', array('dt_firstpost_customization', ), false)) {
		$__finalCompiled .= '
.message--post.is-first .message-inner
{
	.xf-dt_firstpost_customization();
}
';
	}
	$__finalCompiled .= '

// #### Thread owner indicator ####
';
	if ($__templater->func('property', array('dt_thread_owner', ), false) == 'userbanner') {
		$__finalCompiled .= '
.messageOwner-Indicator
{
	font-size: 90%;
	background: @xf-contentHighlightBg;
	color: @xf-contentHighlightBase--color;
	padding: 1px 4px;
	border-radius: @xf-borderRadiusSmall;
	white-space: nowrap;
	
	@media (max-width: @xf-responsiveNarrow)
	{
		display: none;
	}
}
';
	}
	$__finalCompiled .= '
';
	if ($__templater->func('property', array('dt_thread_owner', ), false) == 'icon') {
		$__finalCompiled .= '
.message-avatar-owner
{
	position: absolute;

	// center bottom position
	left: 50%;
	margin-left: -.615em;
	bottom: -.615em;
	
	width: 23px;
	height: 23px;
	line-height: 16px;
	background: @xf-contentAccentBg;
	color: @xf-textColorAccentContent;
	font-size: 10px;
	text-align: center;
	border: 3px solid @xf-contentBg;
	border-radius: 50%;
	z-index: 3;
	
	@media (max-width: @xf-messageSingleColumnWidth)
	{
		display: none;
	}
}
';
	}
	$__finalCompiled .= '

// #### EXTRA FOOTER ####
';
	if ($__templater->func('property', array('dt_extra_footer', ), false)) {
		$__finalCompiled .= '
.pre-footer
{
	.xf-dt_extra_footer_css();
	
	';
		if ($__templater->func('property', array('dt_extra_footer_index', ), false)) {
			$__finalCompiled .= '
	display: none;
	
	.template-forum_list & {
		display: block;
	}
	';
		}
		$__finalCompiled .= '
	
	&-inner
	{
		width: 100%;
		max-width: @xf-pageWidthMax;
		margin: 0 auto;

		@media (min-width: @xf-responsiveMedium)
		{
			padding: 0 @xf-paddingLarge;
		}
	}
	
	&--container
	{
		display: flex;
		flex-wrap: wrap;

		@media (min-width: @xf-responsiveWide)
		{
			margin: 0 -15px;
		}
	}
	
	&--column
	{
		flex: 0 0 25%;
		max-width: 25%;

		@media (min-width: @xf-responsiveMedium)
		{
			padding: 0 15px;
		}
	}
}

.pre-footer h3
{
	.xf-dt_extra_footer_title_css();
	
	&::after
	{
		content: \'\';
		height: 5px;
		width: 55px;
		background-color: @xf-paletteColor1;
		display: block;
		clip-path: polygon(0 0, calc(100% - 5px) 0, 100% 100%, 100% 100%, 0 100%);
		margin-top: .75rem;
	}
}

.pre-footer--content,
.pre-footer .block-container
{
	.xf-dt_extra_footer_content_css();
}

.pre-footer--links {
	
	li {
		list-style: none;
		
		a {
			display: block;
			.xf-dt_extra_footer_link_css();
		}
	}
}

.pre-footer .contentRow-main a,
.pre-footer .block-body .username
{
	.xf-dt_extra_footer_link_css();
}

.social__icons,
.pre-footer--links,
.pre-footer-html--content,
.pre-footer .block-row
{
	.xf-dt_extra_footer_widgcont_css();
}

.pre-footer .block-footer
{
	.xf-dt_extra_footer_widgfoot_css();
}

.social__icons
{
	li
	{
		display: inline-block;
		list-style: none;
		
		a 
		{
			display: block;
			width: 35px;
			height: 35px;
			line-height: 35px;
			background: @xf-contentAccentBg;
			color: @xf-textColorAccentContent;
			text-align: center;
			border-radius: @xf-blockBorderRadius;
			margin-right: 4px;
			
			&.-facebook {
				background: #3b5998;
			}
			
			&.-twitter {
				background: #55acee;
			}
			
			&.-instagram {
				background: #d6249f;
  				background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%,#d6249f 60%,#285AEB 90%);
			}
			
			&.-youtube {
				background: #ff0000;
			}
		}
	}
}

@media (max-width: @xf-responsiveWide)
{
	.pre-footer--column
	{
		flex: 0 0 50%;
		max-width: 50%;
	}
}
@media (max-width: @xf-responsiveMedium)
{
	.pre-footer--column
	{
		flex: 0 0 100%;
		max-width: 100%;
	}
}
';
	}
	$__finalCompiled .= '


// ######## GLYPHS ########

// #### Navigation Glyphs ####

';
	if ($__templater->func('property', array('dt_navigation_glyphs', ), false)) {
		$__finalCompiled .= '

.p-navEl-link::before {
	.m-faBase();
	padding-right: @xf-paddingMedium;
}
.p-navEl-link[data-nav-id="home"]::before {
	.m-faContent(@fa-var-home, 1em);
}
.p-navEl-link[data-nav-id="forums"]::before {
	.m-faContent(@fa-var-comments, 1em);
}
.p-navEl-link[data-nav-id="whatsNew"]::before {
	.m-faContent(@fa-var-bolt, 1em);
}
.p-navEl-link[data-nav-id="members"]::before {
	.m-faContent(@fa-var-users, 1em);
}
.p-navEl-link[data-nav-id="xfmg"]::before {
	.m-faContent(@fa-var-picture-o, 1em);
}
.p-navEl-link[data-nav-id="xfrm"]::before {
	.m-faContent(@fa-var-download, 1em);
}

';
	}
	$__finalCompiled .= '

// #### Sub-navigation Glyphs ####

';
	if ($__templater->func('property', array('dt_sub_navigation_glyphs', ), false)) {
		$__finalCompiled .= '
.p-sectionLinks .p-navEl-link::before {
	.m-faBase();
	padding-right: 4px;
}
.p-navEl-link[data-nav-id="newPosts"]::before {
	.m-faContent(@fa-var-fire, 1em);
}
.p-navEl-link[data-nav-id="findThreads"]::before {
	.m-faContent(@fa-var-comment, 1em);
}
.p-navEl-link[data-nav-id="watched"]::before {
	.m-faContent(@fa-var-bell, 1em);
}
.p-navEl-link[data-nav-id="searchForums"]::before {
	.m-faContent(@fa-var-search, 1em);
}
.p-navEl-link[data-nav-id="markForumsRead"]::before {
	.m-faContent(@fa-var-eye-slash, 1em);
}
.p-navEl-link[data-nav-id="whatsNewPosts"]::before {
	.m-faContent(@fa-var-file-text-o, 1em);
}
.p-navEl-link[data-nav-id="xfmgWhatsNewNewMedia"]::before {
	.m-faContent(@fa-var-picture-o, 1em);
}
.p-navEl-link[data-nav-id="xfmgWhatsNewMediaComments"]::before {
	.m-faContent(@fa-var-comments-o, 1em);
}
.p-navEl-link[data-nav-id="xfrmNewResources"]::before {
	.m-faContent(@fa-var-download, 1em);
}
.p-navEl-link[data-nav-id="whatsNewProfilePosts"]::before {
	.m-faContent(@fa-var-pencil, 1em);
}
.p-navEl-link[data-nav-id="whatsNewNewsFeed"]::before {
	.m-faContent(@fa-var-rss, 1em);
}
.p-navEl-link[data-nav-id="latestActivity"]::before {
	.m-faContent(@fa-var-clock-o, 1em);
}
.p-navEl-link[data-nav-id="xfmgNewMedia"]::before {
	.m-faContent(@fa-var-bolt, 1em);
}
.p-navEl-link[data-nav-id="xfmgNewComments"]::before {
	.m-faContent(@fa-var-comments-o, 1em);
}
.p-navEl-link[data-nav-id="xfmgAddMedia"]::before {
	.m-faContent(@fa-var-plus-square, 1em);
}
.p-navEl-link[data-nav-id="xfmgYourContent"]::before {
	.m-faContent(@fa-var-file-image-o, 1em);
}
.p-navEl-link[data-nav-id="xfmgWatchedContent"]::before {
	.m-faContent(@fa-var-bell, 1em);
}
.p-navEl-link[data-nav-id="xfmgSearchMedia"]::before {
	.m-faContent(@fa-var-search, 1em);
}
.p-navEl-link[data-nav-id="xfmgMarkViewed"]::before {
	.m-faContent(@fa-var-eye-slash, 1em);
}
.p-navEl-link[data-nav-id="xfrmLatestReviews"]::before {
	.m-faContent(@fa-var-star, 1em);
}
.p-navEl-link[data-nav-id="xfrmYourResources"]::before {
	.m-faContent(@fa-var-cloud-download, 1em);
}
.p-navEl-link[data-nav-id="xfrmWatched"]::before {
	.m-faContent(@fa-var-bell, 1em);
}
.p-navEl-link[data-nav-id="xfrmSearchResources"]::before {
	.m-faContent(@fa-var-search, 1em);
}
.p-navEl-link[data-nav-id="currentVisitors"]::before {
	.m-faContent(@fa-var-users, 1em);
}
.p-navEl-link[data-nav-id="newProfilePosts"]::before {
	.m-faContent(@fa-var-pencil, 1em);
}
.p-navEl-link[data-nav-id="searchProfilePosts"]::before {
	.m-faContent(@fa-var-commenting, 1em);
}
';
	}
	$__finalCompiled .= '


// #### offCanvasMenu LinkHolders Icons ####

';
	if ($__templater->func('property', array('dt_offcanvasmenu_linkholder_glyphs', ), false)) {
		$__finalCompiled .= '

.offCanvasMenu-link::before {
	.m-faBase();
	padding-right: 6px;
}
.offCanvasMenu-link[href*="login"]::before {
	.m-faContent(@fa-var-sign-in, 1em);
}
.offCanvasMenu-link[href*="register"]::before {
	.m-faContent(@fa-var-user-circle, 1em);
}
.offCanvasMenu-link[data-nav-id="home"]::before {
	.m-faContent(@fa-var-home, 1em);
}
.offCanvasMenu-link[data-nav-id="forums"]::before {
	.m-faContent(@fa-var-comments, 1em);
}
.offCanvasMenu-link[data-nav-id="whatsNew"]::before {
	.m-faContent(@fa-var-bolt, 1em);
}
.offCanvasMenu-link[data-nav-id="members"]::before {
	.m-faContent(@fa-var-users, 1em);
}
.offCanvasMenu-link[data-nav-id="xfmg"]::before {
	.m-faContent(@fa-var-picture-o, 1em);
}
.offCanvasMenu-link[data-nav-id="xfrm"]::before {
	.m-faContent(@fa-var-download, 1em);
}
';
	}
	$__finalCompiled .= '

// #### offCanvasMenu Links Icons ####

';
	if ($__templater->func('property', array('dt_offcanvasmenu_links_glyphs', ), false)) {
		$__finalCompiled .= '
.offCanvasMenu-link::before {
	.m-faBase();
}
.offCanvasMenu-link[data-nav-id="newPosts"]::before {
	.m-faContent(@fa-var-fire, 2em);
}
.offCanvasMenu-link[data-nav-id="findThreads"]::before {
	.m-faContent(@fa-var-comment, 2em);
}
.offCanvasMenu-link[data-nav-id="yourThreads"]::before {
	.m-faContent(@fa-var-comments, 2em);
}
.offCanvasMenu-link[data-nav-id="contributedThreads"]::before {
	.m-faContent(@fa-var-comments-o, 2em);
}
.offCanvasMenu-link[data-nav-id="unansweredThreads"]::before {
	.m-faContent(@fa-var-comment-o, 2em);
}
.offCanvasMenu-link[data-nav-id="watched"]::before {
	.m-faContent(@fa-var-bell, 2em);
}
.offCanvasMenu-link[data-nav-id="watchedThreads"]::before {
	.m-faContent(@fa-var-globe, 2em);
}
.offCanvasMenu-link[data-nav-id="watchedForums"]::before {
	.m-faContent(@fa-var-flag, 2em);
}
.offCanvasMenu-link[data-nav-id="searchForums"]::before {
	.m-faContent(@fa-var-search, 2em);
}
.offCanvasMenu-link[data-nav-id="markForumsRead"]::before {
	.m-faContent(@fa-var-eye-slash, 2em);
}
.offCanvasMenu-link[data-nav-id="whatsNewPosts"]::before {
	.m-faContent(@fa-var-file-text-o, 2em);
}
.offCanvasMenu-link[data-nav-id="xfmgWhatsNewNewMedia"]::before {
	.m-faContent(@fa-var-picture-o, 2em);
}
.offCanvasMenu-link[data-nav-id="xfmgWhatsNewMediaComments"]::before {
	.m-faContent(@fa-var-comments-o, 2em);
}
.offCanvasMenu-link[data-nav-id="xfrmNewResources"]::before {
	.m-faContent(@fa-var-download, 2em);
}
.offCanvasMenu-link[data-nav-id="whatsNewProfilePosts"]::before {
	.m-faContent(@fa-var-pencil, 2em);
}
.offCanvasMenu-link[data-nav-id="whatsNewNewsFeed"]::before {
	.m-faContent(@fa-var-rss, 2em);
}
.offCanvasMenu-link[data-nav-id="latestActivity"]::before {
	.m-faContent(@fa-var-clock-o, 2em);
}
.offCanvasMenu-link[data-nav-id="xfmgNewMedia"]::before {
	.m-faContent(@fa-var-bolt, 2em);
}
.offCanvasMenu-link[data-nav-id="xfmgNewComments"]::before {
	.m-faContent(@fa-var-comments-o, 2em);
}
.offCanvasMenu-link[data-nav-id="xfmgAddMedia"]::before {
	.m-faContent(@fa-var-plus-square, 2em);
}
.offCanvasMenu-link[data-nav-id="xfmgYourContent"]::before {
	.m-faContent(@fa-var-file-image-o, 2em);
}
.offCanvasMenu-link[data-nav-id="xfmgYourMedia"]::before {
	.m-faContent(@fa-var-file-picture-o, 2em);
}
.offCanvasMenu-link[data-nav-id="xfmgYourAlbums"]::before {
	.m-faContent(@fa-var-file-picture-o, 2em);
}
.offCanvasMenu-link[data-nav-id="xfmgWatchedContent"]::before {
	.m-faContent(@fa-var-bell, 2em);
}
.offCanvasMenu-link[data-nav-id="xfmgWatchedMedia"]::before {
	.m-faContent(@fa-var-bell, 2em);
}
.offCanvasMenu-link[data-nav-id="xfmgWatchedAlbums"]::before {
	.m-faContent(@fa-var-globe, 2em);
}
.offCanvasMenu-link[data-nav-id="xfmgWatchedCategories"]::before {
	.m-faContent(@fa-var-flag, 2em);
}
.offCanvasMenu-link[data-nav-id="xfmgSearchMedia"]::before {
	.m-faContent(@fa-var-search, 2em);
}
.offCanvasMenu-link[data-nav-id="xfmgMarkViewed"]::before {
	.m-faContent(@fa-var-eye-slash, 2em);
}
.offCanvasMenu-link[data-nav-id="xfrmLatestReviews"]::before {
	.m-faContent(@fa-var-star, 2em);
}
.offCanvasMenu-link[data-nav-id="xfrmYourResources"]::before {
	.m-faContent(@fa-var-cloud-download, 2em);
}
.offCanvasMenu-link[data-nav-id="xfrmWatched"]::before {
	.m-faContent(@fa-var-bell, 2em);
}
.offCanvasMenu-link[data-nav-id="xfrmWatchedResources"]::before {
	.m-faContent(@fa-var-bell, 2em);
}
.offCanvasMenu-link[data-nav-id="xfrmWatchedCategories"]::before {
	.m-faContent(@fa-var-globe, 2em);
}
.offCanvasMenu-link[data-nav-id="xfrmSearchResources"]::before {
	.m-faContent(@fa-var-search, 2em);
}
.offCanvasMenu-link[data-nav-id="currentVisitors"]::before {
	.m-faContent(@fa-var-users, 2em);
}
.offCanvasMenu-link[data-nav-id="newProfilePosts"]::before {
	.m-faContent(@fa-var-pencil, 2em);
}
.offCanvasMenu-link[data-nav-id="searchProfilePosts"]::before {
	.m-faContent(@fa-var-commenting, 2em);
}
';
	}
	$__finalCompiled .= '

// #### Visitor Menu Icons ####

';
	if ($__templater->func('property', array('dt_visitor_menu_glyphs', ), false)) {
		$__finalCompiled .= '
.menu--account {
	.menu-linkRow::after {
		.m-faBase();
		float: left;
		padding-right: 4px;
	}
	.menu-linkRow[href*="news-feed"]::after {
		.m-faContent(@fa-var-rss, 1em);
	}
	.menu-linkRow[href*="reactions"]::after {
		.m-faContent(@fa-var-thumbs-up, 1em);
	}
	.menu-linkRow[href*="search/member"]::after {
		.m-faContent(@fa-var-comments, 1em);
	}
	.menu-linkRow[href*="account-details"]::after {
		.m-faContent(@fa-var-user, 1em);
	}
	.menu-linkRow[href*="preferences"]::after {
		.m-faContent(@fa-var-cog, 1em);
	}
	.menu-linkRow[href*="signature"]::after {
		.m-faContent(@fa-var-pencil, 1em);
	}
	.menu-linkRow[href*="security"]::after {
		.m-faContent(@fa-var-lock, 1em);
	}
	.menu-linkRow[href*="upgrades"]::after {
		.m-faContent(@fa-var-star, 1em);
	}
	.menu-linkRow[href*="connected-accounts"]::after {
		.m-faContent(@fa-var-user-plus, 1em);
	}
	.menu-linkRow[href*="following"]::after {
		.m-faContent(@fa-var-users, 1em);
	}
	.menu-linkRow[href*="privacy"]::after {
		.m-faContent(@fa-var-user-secret, 1em);
	}
	.menu-linkRow[href*="ignored"]::after {
		.m-faContent(@fa-var-user-times, 1em);
	}
	.menu-linkRow[href*="logout"]::after {
		.m-faContent(@fa-var-sign-out, 1em);
	}
	.menu-linkRow[href*="conversations"]::after {
		.m-faContent(@fa-var-envelope, 1em);
	}
	.menu-linkRow[href*="alerts"]::after {
		.m-faContent(@fa-var-bell, 1em);
	}
}
';
	}
	$__finalCompiled .= '

// #### Sidebar Glyphs ####

';
	if ($__templater->func('property', array('dt_sidebar_glyphs', ), false)) {
		$__finalCompiled .= '

.p-body-sidebar .block[data-widget-id] .block-minorHeader::before {
	.m-faBase();
	padding-right: @xf-paddingMedium;
}
.p-body-sidebar .block[data-widget-section="staffMembers"] .block-minorHeader::before {
	.m-faContent(@fa-var-user, 1em);
}
.p-body-sidebar .block[data-widget-section="onlineNow"] .block-minorHeader::before {
	.m-faContent(@fa-var-users, 1.4em);
}
.p-body-sidebar .block[data-widget-definition="new_threads"] .block-minorHeader::before,
.p-body-sidebar .block[data-widget-definition="new_posts"] .block-minorHeader::before {
	.m-faContent(@fa-var-comments, 1em);
}
.p-body-sidebar .block[data-widget-definition="new_profile_posts"] .block-minorHeader::before {
	.m-faContent(@fa-var-commenting, 1em);
}
.p-body-sidebar .block[data-widget-definition="board_totals"] .block-minorHeader::before,
.p-body-sidebar .block[data-widget-definition="online_statistics"] .block-minorHeader::before,
.p-body-sidebar .block[data-widget-definition="forum_statistics"] .block-minorHeader::before,
.p-body-sidebar .block[data-widget-definition="xfmg_gallery_statistics"] .block-minorHeader::before{
	.m-faContent(@fa-var-bar-chart, 1em);
}
.p-body-sidebar .block[data-widget-definition="share_page"] .block-minorHeader::before {
	.m-faContent(@fa-var-share-alt, 1em);
}
.p-body-sidebar .block[data-widget-definition="find_member"] .block-minorHeader::before {
	.m-faContent(@fa-var-search, 1em);
}
.p-body-sidebar .block[data-widget-definition="newest_members"] .block-minorHeader::before {
	.m-faContent(@fa-var-user-circle-o, 1em);
}
.p-body-sidebar .block[data-widget-definition="xfrm_top_resources"] .block-minorHeader::before {
	.m-faContent(@fa-var-bolt, 1em);
}
.p-body-sidebar .block[data-widget-definition="xfrm_latest_reviews"] .block-minorHeader::before {
	.m-faContent(@fa-var-star, 1em);
}
.p-body-sidebar .block[data-widget-key="xfrm_overview_top_authors"] .block-minorHeader::before {
	.m-faContent(@fa-var-user, 1em);
}
.p-body-sidebar .block[data-widget-definition="xfrm_new_resources"] .block-minorHeader::before {
	.m-faContent(@fa-var-download, 1em);
}
.p-body-sidebar .block[data-widget-definition="xfmg_media_slider"] .block-minorHeader::before {
	.m-faContent(@fa-var-picture-o, 1em);
}

';
	}
	$__finalCompiled .= '

';
	if ($__templater->func('property', array('dt_prefooter_heading_icons', ), false)) {
		$__finalCompiled .= '

.pre-footer--column .block[data-widget-id] .block-minorHeader::before {
	.m-faBase();
	padding-right: 4px;
}
.pre-footer--column .block[data-widget-section="staffMembers"] .block-minorHeader::before {
	.m-faContent(@fa-var-user, 1em);
}
.pre-footer--column .block[data-widget-section="onlineNow"] .block-minorHeader::before {
	.m-faContent(@fa-var-users, 1.4em);
}
.pre-footer--column .block[data-widget-definition="new_threads"] .block-minorHeader::before,
.pre-footer--column .block[data-widget-definition="new_posts"] .block-minorHeader::before {
	.m-faContent(@fa-var-comments, 1em);
}
.pre-footer--column .block[data-widget-definition="new_profile_posts"] .block-minorHeader::before {
	.m-faContent(@fa-var-commenting, 1em);
}
.pre-footer--column .block[data-widget-definition="board_totals"] .block-minorHeader::before,
.pre-footer--column .block[data-widget-definition="online_statistics"] .block-minorHeader::before,
.pre-footer--column .block[data-widget-definition="forum_statistics"] .block-minorHeader::before,
.pre-footer--column .block[data-widget-definition="xfmg_gallery_statistics"] .block-minorHeader::before{
	.m-faContent(@fa-var-bar-chart, 1em);
}
.pre-footer--column .block[data-widget-definition="share_page"] .block-minorHeader::before {
	.m-faContent(@fa-var-share-alt, 1em);
}
.pre-footer--column .block[data-widget-definition="find_member"] .block-minorHeader::before {
	.m-faContent(@fa-var-search, 1em);
}
.pre-footer--column .block[data-widget-definition="newest_members"] .block-minorHeader::before {
	.m-faContent(@fa-var-user-circle-o, 1em);
}
.pre-footer--column .block[data-widget-definition="xfrm_top_resources"] .block-minorHeader::before {
	.m-faContent(@fa-var-bolt, 1em);
}
.pre-footer--column .block[data-widget-definition="xfrm_latest_reviews"] .block-minorHeader::before {
	.m-faContent(@fa-var-star, 1em);
}
.pre-footer--column .block[data-widget-key="xfrm_overview_top_authors"] .block-minorHeader::before {
	.m-faContent(@fa-var-user, 1em);
}
.pre-footer--column .block[data-widget-definition="xfrm_new_resources"] .block-minorHeader::before {
	.m-faContent(@fa-var-download, 1em);
}
.pre-footer--column .block[data-widget-definition="xfmg_media_slider"] .block-minorHeader::before {
	.m-faContent(@fa-var-picture-o, 1em);
}
.pre-footer--content.-social h3::before
{
	.m-faBase();
	.m-faContent(@fa-var-retweet, 1em);
	padding-right: @xf-paddingMedium;
}

.pre-footer--content.-links h3::before
{
	.m-faBase();
	.m-faContent(@fa-var-link, 1em);
	padding-right: 4px;
}

';
	}
	$__finalCompiled .= '

// #### Message Glyphs ####

';
	if ($__templater->func('property', array('dt_messages_glyphs', ), false)) {
		$__finalCompiled .= '

.actionBar-action::before
{
	font-weight: 300;
	padding-right: @xf-paddingSmall;
}
.actionBar-action.actionBar-action--report::before {
    .m-faContent("@{fa-var-exclamation-triangle}\\20");
}
.actionBar-action.actionBar-action--history::before {
    .m-faContent("@{fa-var-history}\\20");
}
.actionBar-action.actionBar-action--edit::before {
    .m-faContent("@{fa-var-pencil-square}\\20");
}
.actionBar-action.actionBar-action--delete::before {
    .m-faContent("@{fa-var-trash}\\20");
}
.actionBar-action.actionBar-action--spam::before {
    .m-faContent("@{fa-var-exclamation-circle}\\20");
}
.actionBar-action.actionBar-action--ip::before {
    .m-faContent("@{fa-var-user}\\20");
}
.actionBar-action.actionBar-action--warn::before {
    .m-faContent("@{fa-var-exclamation}\\20");
}

';
	}
	$__finalCompiled .= '


// #### Discussion List Icons ####

';
	if ($__templater->func('property', array('dt_discussion_glyphs', ), false)) {
		$__finalCompiled .= '

.structItem-parts a.username::before,
.structItem-cell--latest .username::before {
	.m-faBase();
	.m-faContent(@fa-var-user, 1em);
	padding-right: 2px;
}
.structItem-parts .structItem-startDate a::before,
.structItem-cell--latest .structItem-latestDate::before {
	.m-faBase();
	.m-faContent(@fa-var-clock-o, 1em);
	padding-right: 2px;
}

';
	}
	$__finalCompiled .= '

// #### Member Profiles Tabs Icons ####

';
	if ($__templater->func('property', array('dt_profile_tabs_glyphs', ), false)) {
		$__finalCompiled .= '

.block-tabHeader.block-tabHeader--memberTabs .tabs-tab::before {
	.m-faBase();
	padding-right: 4px;
}
.block-tabHeader.block-tabHeader--memberTabs .tabs-tab[aria-controls="profile-posts"]::before {
	.m-faContent(@fa-var-comments-o, 1em);
}
.block-tabHeader.block-tabHeader--memberTabs .tabs-tab[id="latest-activity"]::before {
	.m-faContent(@fa-var-clock-o, 1em);
}
.block-tabHeader.block-tabHeader--memberTabs .tabs-tab[id="recent-content"]::before {
	.m-faContent(@fa-var-pencil-square-o, 1em);
}
.block-tabHeader.block-tabHeader--memberTabs .tabs-tab[id="about"]::before {
	.m-faContent(@fa-var-info-circle, 1em);
}
.block-tabHeader.block-tabHeader--memberTabs .tabs-tab[id="resources"]::before {
	.m-faContent(@fa-var-download, 1em);
}
.block-tabHeader.block-tabHeader--memberTabs .tabs-tab[id="xfmgMedia"]::before {
	.m-faContent(@fa-var-picture-o, 1em);
}
';
	}
	$__finalCompiled .= '

// #### Member Profiles Tabs Icons ####

';
	if ($__templater->func('property', array('dt_account_wrapper_glyphs', ), false)) {
		$__finalCompiled .= '
.template-account_details,
.template-account_alerts,
.template-account_reactions,
.template-account_bookmarks,
.template-account_security,
.template-account_privacy,
.template-account_preferences,
.template-account_signature,
.template-account_following,
.template-account_ignored
{
	.p-body-sideNav {
		.block-container {
			.blockLink::before {
				.m-faBase();
				padding-right: 4px;
			}
			.blockLink[href*="members"]::before {
				.m-faContent(@fa-var-user-circle, 1em);
			}
			.blockLink[href*="alerts"]::before {
				.m-faContent(@fa-var-bell, 1em);
			}
			.blockLink[href*="reactions"]::before {
				.m-faContent(@fa-var-thumbs-up, 1em);
			}
			.blockLink[href*="bookmarks"]::before {
				.m-faContent(@fa-var-bookmark, 1em);
			}
			.blockLink[href*="account-details"]::before {
				.m-faContent(@fa-var-user, 1em);
			}
			.blockLink[href*="security"]::before {
				.m-faContent(@fa-var-lock, 1em);
			}
			.blockLink[href*="privacy"]::before {
				.m-faContent(@fa-var-user-secret, 1em);
			}
			.blockLink[href*="preferences"]::before {
				.m-faContent(@fa-var-cog, 1em);
			}
			.blockLink[href*="signature"]::before {
				.m-faContent(@fa-var-pencil, 1em);
			}
			.blockLink[href*="connected-accounts"]::before {
				.m-faContent(@fa-var-network-wired, 1em);
			}
			.blockLink[href*="following"]::before {
				.m-faContent(@fa-var-users, 1em);
			}
			.blockLink[href*="ignored"]::before {
				.m-faContent(@fa-var-user-times, 1em);
			}
			.blockLink[href*="logout"]::before {
				.m-faContent(@fa-var-sign-out, 1em);
			}
		}
	}
}
';
	}
	return $__finalCompiled;
}
);