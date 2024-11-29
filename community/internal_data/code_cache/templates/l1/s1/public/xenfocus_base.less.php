<?php
// FROM HASH: 4b0aadfeea74625622c6c921e4fa284e
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '/*
	----------------
	
	xenfocus styles
	
	----------------
*/

/*

	Global
	Flexbox
	Header
	Logo
	Navigation
	User links
	Search bar
	xenfocus Editor
	Breadcrumbs
	Social icons
	Background picker
	Content wrapper
	Nodes
	Node icons
	Node NEW badge
	Guest message
	Footer
	Mega footer
	Grid layout for nodes
	Blocks
	Topic List
	Topic View
	Editor
	Profiles
	Sidebar
	Sticky Sidebar
	Animated snow
	Holidays
	Animated blocks onload
	Pagination
	Mobile footer bar
	Post thread pop up
	Other
	Bug fixes

*/

// Body
@focus-wallpaper: true;
@body-padding-top: 0px;
@body-padding-bottom: 0px;
//@focus-fluid-width: 96;
@focus-fluid-margin: 100px;

// Content width
@focus-width: ~"calc(100vw - (@xf-pageEdgeSpacer * 2))";
@content-padding: 15px;


// Header
';
	if ($__templater->func('property', array('publicHeader--background-color', ), false)) {
		$__finalCompiled .= '
	@header-padding: 20px;
';
	} else {
		$__finalCompiled .= '
	@header-padding: 0px;
';
	}
	$__finalCompiled .= '
@p-header-content--max-width: ~"calc(100vw - 30px)";



// Logo
@logo-image-height: @xf-xenfocus_logoHeight*1px;
@logo-reduce-image-height-by: 0px;

@mobile-logo-image-height: @xf-xenfocus_logoHeightMobile*1px;
@mobile-logo-reduce-image-height-by: 0px;
@focus-logo-image--margin: 20px;
@logo-slogan-opacity: 0.75;
@logo-slogan-size: 0.5em;
@logo-slogan-margin: 0.7em;
@focus-mobile-logo-color: contrast(@xf-publicNav--background-color, xf-intensify(@xf-publicNav--color, 30%), xf-diminish(@xf-publicNav--color, 20%));



// Navigation
@nav-icon-size: 14px;

// Dropdown menus
@focus-dropdown-nav: true;

// Navigation scrollers
@navigation-arrow-size: 20px;
@navigation-arrow-color: @xf-publicNavTab--color;
@navigation-arrow-gradient: @xf-publicNav--background-color;



// User links
';
	if ($__templater->func('property', array('xenfocus_userStyles--background-color', ), false)) {
		$__finalCompiled .= '
	@user-hover: fade(darken(@xf-xenfocus_userStyles--background-color, 30%), 15%);
';
	} else if ($__templater->func('property', array('xenfocus_userStyles--color', ), false)) {
		$__finalCompiled .= '
	@user-hover: fade(@xf-xenfocus_userStyles--color, 10%);
';
	} else {
		$__finalCompiled .= '
	@user-hover: rgba(255,255,255,0.1);
';
	}
	$__finalCompiled .= '

';
	if ($__templater->func('property', array('xenfocus_userStyles--border-color', ), false)) {
		$__finalCompiled .= '
	@user-border-color: @xf-xenfocus_userStyles--border-color;
';
	} else if ($__templater->func('property', array('xenfocus_userStyles--color', ), false)) {
		$__finalCompiled .= '
	@user-border-color: fade(@xf-xenfocus_userStyles--color, 15%);
';
	} else {
		$__finalCompiled .= '
	@user-border-color: transparent;
';
	}
	$__finalCompiled .= '

@user-border-width: ';
	if ($__templater->func('property', array('xenfocus_userStyles--border-width', ), false)) {
		$__finalCompiled .= '@xf-xenfocus_userStyles--border-width';
	} else {
		$__finalCompiled .= '0px';
	}
	$__finalCompiled .= ';
@user-border-radius: ';
	if ($__templater->func('property', array('xenfocus_userStyles--border-radius', ), false)) {
		$__finalCompiled .= '@xf-xenfocus_userStyles--border-radius';
	} else {
		$__finalCompiled .= '0px';
	}
	$__finalCompiled .= ';

@user-links-sep: 1px;
//@user-links-color-mobile: @xf-publicNav--color;
@user-links-radius-mobile: 4px;
@remove-userlink-text: false;
@register-offset-v: ';
	if ($__templater->func('property', array('xenfocus_userStyles--background-color', ), false)) {
		$__finalCompiled .= '3px';
	} else {
		$__finalCompiled .= '0px';
	}
	$__finalCompiled .= ';
@register-offset-h: ';
	if ($__templater->func('property', array('xenfocus_userSep', ), false)) {
		$__finalCompiled .= '3px';
	} else {
		$__finalCompiled .= '0px';
	}
	$__finalCompiled .= ';
@user-links-icon: 14px;



// Search
@search-width: xf-default(@xf-xenfocus_searchWidth, 240)*1px;
@search-height: xf-default(@xf-xenfocus_searchHeight, 34)*1px;
@search-background-color: xf-default(@xf-xenfocus_searchStyles--background-color, transparent);
@search-background-image: xf-default(@xf-xenfocus_searchStyles--background-image, none);
@search-color: xf-default(@xf-xenfocus_searchStyles--color, inherit);
@search-border: xf-default(@xf-xenfocus_searchStyles--border-width, 0px) solid xf-default(@xf-xenfocus_searchStyles--border-color, transparent);
@search-border-left: xf-default(@xf-xenfocus_searchStyles--border-width, 0px);
@search-border-right: xf-default(@xf-xenfocus_searchStyles--border-width, 0px);
@search-radius: xf-default(@xf-xenfocus_searchStyles--border-radius, 0);
@focus-search-arrow: 7px;
@focus-search-dropdown: @xf-contentBg;
';
	if ($__templater->func('property', array('styleType', ), false) == 'light') {
		$__finalCompiled .= '
	@focus-search-dropdown-border: rgba(0,0,0,0.1);
';
	} else {
		$__finalCompiled .= '
	@focus-search-dropdown-border: rgba(255,255,255,0.1);
';
	}
	$__finalCompiled .= '



// Mobile navigation menu
@mobile-navigation-bar--background: @xf-publicNav--background-color;
@mobile-navigation-bar--color: @xf-publicNav--color;
';
	if ($__templater->func('property', array('styleType', ), false) == 'light') {
		$__finalCompiled .= '
	@mobile-navigation-background: @xf-paletteColor5;
	@mobile-navigation-color: @xf-paletteColor1;
';
	} else {
		$__finalCompiled .= '
	@mobile-navigation-background: @xf-paletteColor2;
	@mobile-navigation-color: @xf-paletteColor5;
';
	}
	$__finalCompiled .= '
@mobile-sticky-top: 0px;



// Breadcrumb
@focus-breadcrumbs: true;
@focus-breadcrumbs-mobile: true;
@breadcrumb-height: xf-default(@xf-xenfocus_breadcrumbHeight, 38)*1px;
@breadcrumb-border-width: ';
	if ($__templater->func('property', array('xenfocus_breadcrumb--border-color', ), false)) {
		$__finalCompiled .= '1px';
	} else {
		$__finalCompiled .= '0px';
	}
	$__finalCompiled .= ';
@breadcrumb-border-color: xf-default(@xf-xenfocus_breadcrumb--border-color, transparent);
@breadcrumb-color: xf-default(@xf-xenfocus_breadcrumb--color, transparent);
@breadcrumb-background-hex: xf-default(@xf-xenfocus_breadcrumb--background-color, transparent);
@breadcrumb-background-image: xf-default(@xf-xenfocus_breadcrumb--background-image, none);
@breadcrumb-radius: xf-default(@xf-xenfocus_breadcrumb--border-radius, 0px);

@breadcrumb-highlight: ';
	if ($__templater->func('property', array('xenfocus_breadcrumbHover--background-color', ), false)) {
		$__finalCompiled .= 'fadein(@xf-xenfocus_breadcrumbHover--background-color, 30%)';
	} else {
		$__finalCompiled .= 'rgba(255,255,255,0.5)';
	}
	$__finalCompiled .= ';
@breadcrumb-shadow: ';
	if ($__templater->func('property', array('xenfocus_breadcrumb--background-color', ), false)) {
		$__finalCompiled .= 'fade(darken(@xf-xenfocus_breadcrumb--background-color, 20%), 80%)';
	} else {
		$__finalCompiled .= 'rgba(0,0,0,0.2)';
	}
	$__finalCompiled .= ';
@breadcrumb-hover: xf-default(@xf-xenfocus_breadcrumbHover--background-color, rgba(255,255,255,0.3));
@breadcrumb-active: ';
	if ($__templater->func('property', array('xenfocus_breadcrumb--background-color', ), false)) {
		$__finalCompiled .= 'fade(darken(@xf-xenfocus_breadcrumb--background-color, 20%), 15%)';
	} else {
		$__finalCompiled .= 'rgba(0,0,0,0.05)';
	}
	$__finalCompiled .= ';



// Social icons
@social-border: 1px;
@social-height: @breadcrumb-height;
@social-footer-basic: true;



// Blocks
// Move the block wrap from the container to the body
@block-container-shift: false;
@block-container: ~\'.block-container, .block--messages .message\';
@block-header: ~\'.block-header\';
@block-body: ~\'.block-body\';
@block-minor-header: ~\'#XF .block-minorHeader\';
// When a wallpaper design is used, these blocks will be wrapped with the normal block styles
@focus-wallpaper-elements: ~\'.p-body-header\';
@sticky-top: @xf-xenfocus_navHeight;




// NEW badge
@new-badge-color: #fff;
@new-badge-background: #ed7a16;



// Nodes
@node-icon-read-filter: grayscale(1);
@node-icon-read-opacity: 0.4;
@node-extra-padding: 4px;
@node-grid-padding: 15px;
@node-bold-title: true;
@subforum-grid: true;
@node-alt-stats: true;
@node-zebra: true;
@node-zebra-color: xf-intensify(@xf-contentBg, 2%);
@subforum-width: 150px;
@grid-node-width: 380px;
@grid-node-gap: 5px;
@grid-node-wrapper: @xf-contentAltBg;
@grid-hover-inset: 0px;
@hide-node-statsMeta-mobile: true;
// Assign a background and border to grid wrapper?
';
	if ($__templater->func('property', array('xenfocus_wrapperStyles--background-color', ), false)) {
		$__finalCompiled .= '
	@reset-grid-wrapper:true;
';
	} else {
		$__finalCompiled .= '
	@reset-grid-wrapper:false;
';
	}
	$__finalCompiled .= '
@grid-wallpaper-folder: \'styles/xenfocus/global/node-wallpapers\';



// Sidebar
@focus-sidebar-icons: true;
@minorHeader-icon: \'\\f141\';


// Topic view
@focus-post-buttons: true;
@editor-bg: xf-intensify(@xf-contentBg, 1.5%);
@editor-text: @xf-textColor;
// This resets coloured reaction text to inherit when button style is enabled
';
	if ($__templater->func('property', array('xenfocus_postButton', ), false) == 'button') {
		$__finalCompiled .= '
	@reset-reaction-text: true;
';
	} else {
		$__finalCompiled .= '
	@reset-reaction-text: false;
';
	}
	$__finalCompiled .= '
@post-meta-opacity: 0.4;



// Footer
@mega-footer-copyright: darken(@xf-publicFooter--background-color, 5%);



// Pagination
@focus-pagination: true;
@pagination-radius: @xf-buttonBase--border-radius;
@pagination-active: @xf-paletteColor4;
@pagination-minor: @xf-textColorMuted;
@pagination-gap: 5px;
';
	if ($__templater->func('property', array('styleType', ), false) == 'light') {
		$__finalCompiled .= '
@pagination-page: @xf-contentBg;
@pagination-shadow: rgba(0,0,0,0.12) 0px 1px 1px, rgba(0,0,0,0.05) 0px 1px 2px;
@pagination-shadow-active: inset rgba(0,0,0,0.2) 0px 1px 3px;
';
	} else {
		$__finalCompiled .= '
@pagination-page: lighten(@xf-contentBg, 3.5%);
@pagination-shadow: inset rgba(255,255,255,0.1) 0px 1px 0px;
@pagination-shadow-active: @pagination-shadow;
';
	}
	$__finalCompiled .= '
@pagination-page-hover: lighten(@pagination-page, 3%);


// Inputs
@input--placeholder: 0.4;
@input--placeholder-active: 0.5;



/*
	----------------
	- Translate
	----------------
*/

[data-focus-text]::after{ content: attr(data-focus-text); }

.node--unread .node-title::before{
	content: "NEW"
}

.focus-editor-wrap{
	content: "Theme Editor"
}

.focus-guest .focus-guest-header::before{
	content: "Welcome to "
}

.structItemContainer-group--sticky::before{
	content: "Sticky threads"
}
.structItemContainer-group--sticky::after{
	content: "Regular threads"
}

// German
';
	if ($__vars['xf']['language']['language_code'] === 'de-DE') {
		$__finalCompiled .= '

	.node--unread .node-title::before{
		content: "NEU"
	}

	.focus-editor-wrap{
		content: "Themeneditor"
	}

	.focus-guest .focus-guest-header::before{
		content: "Willkommen auf "
	}

	.structItemContainer-group--sticky::before{
		content: "Wichtige Themen"
	}
	.structItemContainer-group--sticky::after{
		content: "Normale Themen"
	}

	[data-focus-text="Background Picker"]::after{
		content: "Hintergrundauswahl"
	}

	[data-focus-text="Customize layout"]::after{
		content: "Layout anpassen"
	}

	[data-focus-text="Save"]::after{
		content: "Speichern"
	}

	[data-focus-text="Choose color"]::after{
		content: "Wahle eine Farbe"
	}

	[data-setting="focus-mobile-navigation-bar"] .focus-editor-text{
		&::before{	content: "Mobile Navigationsleiste?" }
		&::after{	content: "Eine Navigationsleiste am unteren Rand der Site anzeigen, wenn Sie ein mobiles Gerät verwenden?" }
	}

	[data-setting="focus-fluid"] .focus-editor-text{
		&::before{	content: "Flexible Breite?" }
		&::after{	content: "Wenn Sie dies aktivieren, wird die Breite der Website angepasst, sodass sie die Breite Ihres Browsers einnimmt. Nützlich für größere Bildschirme." }
	}

	[data-setting="focus-grid"] .focus-editor-text{
		&::before{	content: "Gitterstruktur?" }
		&::after{	content: "Wenn diese Option aktiviert ist, werden die Foren als Gitteransicht anstelle einer Listenansicht angezeigt." }
	}

	[data-setting="focus-sidebar-sticky"] .focus-editor-text{
		&::before{	content: "Fixierte Seitenleiste?" }
		&::after{	content: "Wenn diese Option aktiviert ist, bewegt sich die Seitenleiste mit dem Seitenlauf mit." }
	}

	[data-setting="focus-sidebar-flip"] .focus-editor-text{
		&::before{	content: "Position Seitenleiste wechseln?" }
		&::after{	content: "Wechselt die Position der Seitenleiste zwischen den links und rechts." }
	}

	[data-setting="focus-snow"] .focus-editor-text{
        &::before{    content: "Schnee aktivieren?" }
        &::after{    content: "Wenn aktiviert, fällt animierter Schnee über Ihren Browser." }
    }

    [data-setting="focus-confetti"] .focus-editor-text{
        &::before{    content: "Konfetti aktivieren?" }
        &::after{    content: "Wenn diese Option aktiviert ist, werden animierte Konfetti in Ihrem Browser angezeigt." }
    }

    [data-setting="focus-countdown"] .focus-editor-text{
        &::before{    content: "Countdown anzeigen?" }
        &::after{    content: "Wenn diese Option aktiviert ist, wird oben auf Ihrer Seite ein Countdown angezeigt." }
    }

	[data-setting="focus-dimension-parallax"] .focus-editor-text{
		&::before{	content: "Parallaxeffekt aktivieren?" }
		&::after{	content: "Wenn aktiviert, wird ein Parallax-Effekt auf den Header angewendet." }
	}

	[data-setting="focus-aperture-background"] .focus-editor-text{
		&::before{	content: "Parallaxe Hintergrund?" }
		&::after{	content: "Wenn aktiviert, wird das Hintergrundbild animiert und verwischt, wenn die Seite gescrollt wird." }
	}

	.focus-timer [data-countdown-text="week,"]::before{
		content: "woche,";
	}

	.focus-timer [data-countdown-text="weeks,"]::before{
		content: "wochen,";
	}

	.focus-timer [data-countdown-text="days and"]::before{
		content: "tage und";
	}

	.focus-timer [data-countdown-text="day and"]::before{
		content: "tag und";
	}

';
	}
	$__finalCompiled .= '


// French
';
	if ($__vars['xf']['language']['language_code'] === 'fr-FR') {
		$__finalCompiled .= '
	.node--unread .node-title::before{
        content: "NOUVEAU"
    }

    .focus-editor-wrap{
        content: "Éditeur de thème"
    }

    .focus-guest .focus-guest-header::before{
        content: "Bienvenue sur "
    }

    .structItemContainer-group--sticky::before{
        content: "Sujets importants"
    }
    .structItemContainer-group--sticky::after{
        content: "Discussions"
    }

    [data-focus-text="Background Picker"]::after{
        content: "Sélecteur de fond"
    }

    [data-focus-text="Customize layout"]::after{
        content: "Personnaliser la mise en page"
    }

    [data-focus-text="Save"]::after{
        content: "Sauvegarder"
    }

    [data-focus-text="Choose color"]::after{
        content: "Choisissez la couleur"
    }

    [data-setting="focus-mobile-navigation-bar"] .focus-editor-text{
		&::before{	content: "Barre de navigation mobile?" }
		&::after{	content: "Afficher une barre de navigation en bas du site lors de l\'utilisation d\'un appareil mobile?" }
	}

    [data-setting="focus-fluid"] .focus-editor-text{
        &::before{    content: "Largeur du site" }
        &::after{    content: "Activer cette option augmentera la largeur du site afin qu\'il occupe toute la largeur de votre navigateur. Utile pour les grands écrans." }
    }

    [data-setting="focus-grid"] .focus-editor-text{
        &::before{    content: "Disposition des forums" }
        &::after{    content: "Si activé, les forums seront affichés sous forme de grille plutôt que par rangées." }
    }

    [data-setting="focus-sidebar-sticky"] .focus-editor-text{
        &::before{    content: "Barre latérale intelligente" }
        &::after{    content: "Si activé, la barre latérale défilera intelligement pour un accès facile." }
    }

    [data-setting="focus-sidebar-flip"] .focus-editor-text{
        &::before{    content: "Basculer la barre latérale ?" }
        &::after{    content: "Basculez la barre latérale entre les côtés gauche et droit de la page d\'accueil." }
    }

    [data-setting="focus-snow"] .focus-editor-text{
        &::before{    content: "Effet de neige" }
        &::after{    content: "Si activé, de la neige tombera sur votre écran." }
    }

    [data-setting="focus-confetti"] .focus-editor-text{
        &::before{    content: "Effet confettis" }
        &::after{    content: "Si activé, des confettis tomberont sur votre écran." }
    }

    [data-setting="focus-countdown"] .focus-editor-text{
        &::before{    content: "Affichage du compte à rebours" }
        &::after{    content: "Si activé, un compte à rebours s\'affichera en haut de chaque page." }
    }

    [data-setting="focus-dimension-parallax"] .focus-editor-text{
        &::before{    content: "Activer l\'effet de parallaxe ?" }
        &::after{    content: "Si activé, un effet de parallaxe sera appliqué à l\'en-tête." }
    }

    [data-setting="focus-aperture-background"] .focus-editor-text{
        &::before{    content: "Fond de parallaxe ?" }
        &::after{    content: "Si activé, l\'image d\'arrière-plan s\'anime et s\'estompe lorsque la page défile." }
    }

    .focus-timer [data-countdown-text="week,"]::before{
        content: "semaine,";
    }

    .focus-timer [data-countdown-text="weeks,"]::before{
        content: "semaines,";
    }

    .focus-timer [data-countdown-text="days and"]::before{
        content: "jours et";
    }

    .focus-timer [data-countdown-text="day and"]::before{
        content: "jour et";
    }
';
	}
	$__finalCompiled .= '

// Spanish
';
	if ($__vars['xf']['language']['language_code'] === 'es-ES') {
		$__finalCompiled .= '
	.node--unread .node-title::before{
        content: "RECIENTE"
    }

    .focus-editor-wrap{
        content: "Editor de temas"
    }

    .focus-guest .focus-guest-header::before{
        content: "Bienvenido a "
    }

    .structItemContainer-group--sticky::before{
        content: "Hilos Pegajosos"
    }
    .structItemContainer-group--sticky::after{
        content: "Hilos Normales"
    }

    [data-focus-text="Background Picker"]::after{
        content: "Selector de fondo"
    }

    [data-focus-text="Customize layout"]::after{
        content: "Personalizar diseño"
    }

    [data-focus-text="Save"]::after{
        content: "Salvar"
    }

    [data-focus-text="Choose color"]::after{
        content: "Elegir color"
    }

    [data-setting="focus-mobile-navigation-bar"] .focus-editor-text{
		&::before{	content: "Barra de navegación móvil?" }
		&::after{	content: "¿Mostrar una barra de navegación en la parte inferior del sitio al usar un dispositivo móvil?" }
	}

    [data-setting="focus-fluid"] .focus-editor-text{
        &::before{    content: "¿Ancho de fluido?" }
        &::after{    content: "Habilitar esto aumentará el ancho del sitio para que ocupe el ancho de su navegador. Útil para pantallas más grandes." }
    }

    [data-setting="focus-grid"] .focus-editor-text{
        &::before{    content: "¿Diseño de cuadrícula?" }
        &::after{    content: "Si está habilitado, los foros se mostrarán como una cuadrícula en lugar de una tabla." }
    }

    [data-setting="focus-sidebar-sticky"] .focus-editor-text{
        &::before{    content: "Barra lateral pegajosa?" }
        &::after{    content: "Si está habilitado, la barra lateral se pegará a la parte superior de la pantalla para facilitar el acceso." }
    }

    [data-setting="focus-dimension-parallax"] .focus-editor-text{
        &::before{    content: "¿Habilitar el efecto de paralaje?" }
        &::after{    content: "Si está habilitado, se aplicará un efecto de paralaje al encabezado." }
    }

    [data-setting="focus-sidebar-flip"] .focus-editor-text{
        &::before{    content: "Voltear la barra lateral?" }
        &::after{    content: "Gira la barra lateral entre los lados izquierdo y derecho." }
    }

    [data-setting="focus-snow"] .focus-editor-text{
        &::before{    content: "¿Habilitar efecto de nieve?" }
        &::after{    content: "Si está habilitado, la nieve animada caerá en tu navegador." }
    }

    [data-setting="focus-confetti"] .focus-editor-text{
        &::before{    content: "Habilitar confeti?" }
        &::after{    content: "Si está habilitado, el confeti animado caerá en tu navegador." }
    }

    [data-setting="focus-countdown"] .focus-editor-text{
        &::before{    content: "Mostrar cuenta regresiva?" }
        &::after{    content: "Si está habilitado, aparecerá una cuenta regresiva en la parte superior de la página." }
    }

    [data-setting="focus-aperture-background"] .focus-editor-text{
        &::before{    content: "Fondo de paralaje?" }
        &::after{    content: "Si está habilitada, la imagen de fondo se animará y se desenfocará cuando la página se desplace." }
    }

    .focus-timer [data-countdown-text="week,"]::before{
        content: "semana,";
    }

    .focus-timer [data-countdown-text="weeks,"]::before{
        content: "semanas,";
    }

    .focus-timer [data-countdown-text="days and"]::before{
        content: "días y";
    }

    .focus-timer [data-countdown-text="day and"]::before{
        content: "día y";
    }

';
	}
	$__finalCompiled .= '

// Italian
';
	if (($__vars['xf']['language']['language_code'] === 'it-IT') OR ($__vars['xf']['language']['language_code'] === 'it')) {
		$__finalCompiled .= '
	.node--unread .node-title::before{
        content: "NUOVO"
    }

    .focus-editor-wrap{
        content: "Editor di temi"
    }

    .focus-guest .focus-guest-header::before{
        content: "Benvenuto a "
    }

    .structItemContainer-group--sticky::before{
        content: "In Evidenza"
    }
    .structItemContainer-group--sticky::after{
        content: "Discussioni normali"
    }

    [data-focus-text="Background Picker"]::after{
        content: "Selezione sfondo"
    }

    [data-focus-text="Customize layout"]::after{
        content: "Personalizza il layout"
    }

    [data-focus-text="Save"]::after{
        content: "Salvare"
    }

    [data-focus-text="Choose color"]::after{
        content: "Scegli il colore"
    }

    [data-setting="focus-mobile-navigation-bar"] .focus-editor-text{
		&::before{	content: "Barra di navigazione mobile?" }
		&::after{	content: "Visualizzare una barra di navigazione nella parte inferiore del sito quando si utilizza un dispositivo mobile?" }
	}

    [data-setting="focus-fluid"] .focus-editor-text{
        &::before{    content: "Larghezza del fluido?" }
        &::after{    content: "Abilitare questo aumenterà la larghezza del sito in modo che occupi la larghezza del tuo browser. Utile per schermi più grandi." }
    }

    [data-setting="focus-grid"] .focus-editor-text{
        &::before{    content: "Layout della griglia?" }
        &::after{    content: "Se abilitato, i forum verranno visualizzati come una griglia invece di una tabella." }
    }

    [data-setting="focus-sidebar-sticky"] .focus-editor-text{
        &::before{    content: "Barra laterale appiccicosa?" }
        &::after{    content: "Se abilitato, la barra laterale resterà nella parte superiore dello schermo per un facile accesso." }
    }

    [data-setting="focus-sidebar-flip"] .focus-editor-text{
        &::before{    content: "Flip sidebar?" }
        &::after{    content: "Capovolgi la barra laterale tra i lati sinistro e destro." }
    }

    [data-setting="focus-snow"] .focus-editor-text{
        &::before{    content: "Abilitare l\'effetto neve?" }
        &::after{    content: "Se abilitato, la neve animata cadrà nel tuo browser." }
    }

    [data-setting="focus-confetti"] .focus-editor-text{
        &::before{    content: "Abilita i coriandoli?" }
        &::after{    content: "Se abilitato, i coriandoli animati cadranno sul tuo browser." }
    }

    [data-setting="focus-countdown"] .focus-editor-text{
        &::before{    content: "Mostra il conto alla rovescia?" }
        &::after{    content: "Se abilitato, un conto alla rovescia sarà visibile nella parte superiore della pagina." }
    }

    [data-setting="focus-dimension-parallax"] .focus-editor-text{
        &::before{    content: "Abilita l\'effetto di parallasse?" }
        &::after{    content: "Se abilitato, all\'intestazione verrà applicato un effetto di parallasse." }
    }

    [data-setting="focus-aperture-background"] .focus-editor-text{
        &::before{    content: "Sfondo parallasse?" }
        &::after{    content: "Se abilitato, l\'immagine di sfondo si animerà e verrà sfocata quando si scorre la pagina." }
    }

    .focus-timer [data-countdown-text="week,"]::before{
        content: "settimana,";
    }

    .focus-timer [data-countdown-text="weeks,"]::before{
        content: "settimane,";
    }

    .focus-timer [data-countdown-text="days and"]::before{
        content: "giorni e";
    }

    .focus-timer [data-countdown-text="day and"]::before{
        content: "giorno e";
    }

';
	}
	$__finalCompiled .= '

// Turkish
';
	if ($__vars['xf']['language']['language_code'] === 'tr-TR') {
		$__finalCompiled .= '
	.node--unread .node-title::before{
        content: "YENİ"
    }

    .focus-editor-wrap{
        content: "Tema Editörü"
    }



	.focus-guest .focus-guest-header::before {
		content: none;
	}

	.focus-guest .focus-guest-header::after{
		content: "\'a hoşgeldiniz";
	}

    .structItemContainer-group--sticky::before{
        content: "Sabit Konular"
    }
    .structItemContainer-group--sticky::after{
        content: "Normal Konular"
    }

    [data-focus-text="Background Picker"]::after{
        content: "Arkaplan Seçici"
    }

    [data-focus-text="Customize layout"]::after{
        content: "Düzeni özelleştir"
    }

    [data-focus-text="Save"]::after{
        content: "Kaydet"
    }

    [data-focus-text="Choose color"]::after{
        content: "Renk seçin"
    }

    [data-setting="focus-mobile-navigation-bar"] .focus-editor-text{
		&::before{	content: "Mobil gezinme çubuğu?" }
		&::after{	content: "Bir mobil cihaz kullanırken sitenin altında bir gezinme çubuğu görüntülensin mi?" }
	}

    [data-setting="focus-fluid"] .focus-editor-text{
        &::before{    content: "Sıvı genişliği?" }
        &::after{    content: "Bunu etkinleştirmek sitenin genişliğini artıracak, böylece tarayıcınızın tam genişliğini kaplayacak. Daha büyük ekranlar için kullanışlıdır." }
    }

    [data-setting="focus-grid"] .focus-editor-text{
        &::before{    content: "Izgara düzeni?" }
        &::after{    content: "Etkinleştirilirse, forumlar tablo yerine kılavuz olarak görüntülenir." }
    }

    [data-setting="focus-sidebar-sticky"] .focus-editor-text{
        &::before{    content: "Sabit yan çubuk?" }
        &::after{    content: "Etkinleştirilirse, kolay erişim için kenar çubuğu ekranın üstüne yapışır." }
    }

    [data-setting="focus-sidebar-flip"] .focus-editor-text{
        &::before{    content: "Yan çubuğu çevir?" }
        &::after{    content: "Kenar çubuğunu sol ve sağ taraf arasında değiştirin." }
    }

    [data-setting="focus-snow"] .focus-editor-text{
        &::before{    content: "Kar efekti etkinleştirilsin mi?" }
        &::after{    content: "Etkinleştirilirse, hareketli kar yağışı tarayıcıda çalışır." }
    }

    [data-setting="focus-confetti"] .focus-editor-text{
        &::before{    content: "Konfeti etkinleştirilsin mi?" }
        &::after{    content: "Etkinleştirilirse, animasyonlu konfeti tarayıcınızın üst kısmından aşağı doğru iner." }
    }

    [data-setting="focus-countdown"] .focus-editor-text{
        &::before{    content: "Geri sayım gösterilsin mi!" }
        &::after{    content: "Etkinleştirilirse, sayfanızın üstünde bir geri sayım sayacı görünür." }
    }

    [data-setting="focus-dimension-parallax"] .focus-editor-text{
        &::before{    content: "Paralaks efektini etkinleştir?" }
        &::after{    content: "Etkinleştirilirse, başlık kısmına paralaks efekti uygulanır." }
    }

    [data-setting="focus-aperture-background"] .focus-editor-text{
        &::before{    content: "Arkaplan Paralaksı?" }
        &::after{    content: "Etkinleştirilirse, arka plan görüntüsü, sayfa kaydırıldığında hateketlenir ve bulanıklaşır." }
    }

    .focus-timer [data-countdown-text="week,"]::before{
        content: "hafta,";
    }

    .focus-timer [data-countdown-text="weeks,"]::before{
        content: "haftalar,";
    }

    .focus-timer [data-countdown-text="days and"]::before{
        content: "günler ve";
    }

    .focus-timer [data-countdown-text="day and"]::before{
        content: "gün ve";
    }
';
	}
	$__finalCompiled .= '

// Russian
';
	if ($__vars['xf']['language']['language_code'] === 'ru-RU') {
		$__finalCompiled .= '

	.node--unread .node-title::before{
		content: "НОВЫЙ"
	}

	.focus-editor-wrap{
		content: "Настройки темы"
	}

	.focus-guest .focus-guest-header::before{
		content: "Добро пожаловать в "
	}

	.structItemContainer-group--sticky::before{
		content: "Закрепленные темы"
	}
	.structItemContainer-group--sticky::after{
		content: "Обычные темы"
	}

	[data-focus-text="Background Picker"]::after{
		content: "Выбор фона"
	}

	[data-focus-text="Customize layout"]::after{
		content: "Настройки макета"
	}

	[data-focus-text="Save"]::after{
		content: "Сохранить"
	}

	[data-focus-text="Choose color"]::after{
		content: "Выберите цвет"
	}

	[data-setting="focus-mobile-navigation-bar"] .focus-editor-text{
		&::before{	content: "Включить панель навигации?" }
		&::after{	content: "Отображение панели навигации внизу сайта при использовании мобильного устройства." }
	}

	[data-setting="focus-fluid"] .focus-editor-text{
		&::before{	content: "Расширить отображение?" }
		&::after{	content: "Включение увеличит ширину сайта, чтобы он занимал всю ширину вашего браузера. Полезно для больших экранов." }
	}

	[data-setting="focus-grid"] .focus-editor-text{
		&::before{	content: "Отображать в виде плиток?" }
		&::after{	content: "При включении форум будет отображаться в виде плиток, а не таблицы." }
	}

	[data-setting="focus-sidebar-sticky"] .focus-editor-text{
		&::before{	content: "Прикрепить боковую панель?" }
		&::after{	content: "При включении боковая панель будет прикреплена к верхней части экрана для быстрого доступа." }
	}

	[data-setting="focus-sidebar-flip"] .focus-editor-text{
		&::before{	content: "Переместить боковую панель?" }
		&::after{	content: "Перемещение боковой панели между левой и правой сторонами." }
	}

	[data-setting="focus-snow"] .focus-editor-text{
        &::before{    content: "Включить эффект снега?" }
        &::after{    content: "При включении анимированный снег будет кружиться сквозь страницы вашего браузера." }
    }

    [data-setting="focus-confetti"] .focus-editor-text{
        &::before{    content: "Включить эффект конфетти?" }
        &::after{    content: "При включении анимированные конфетти будут кружиться сквозь страницы вашего браузера." }
    }

    [data-setting="focus-countdown"] .focus-editor-text{
        &::before{    content: "Отображать обратный отсчет?" }
        &::after{    content: "При включении обратный отсчет будет виден в верхней части вашей страницы." }
    }

	[data-setting="focus-dimension-parallax"] .focus-editor-text{
		&::before{	content: "Включить эффект параллакса?" }
		&::after{	content: "При включении к шапке-заголовку будет применён эффект параллакса." }
	}

	[data-setting="focus-aperture-background"] .focus-editor-text{
		&::before{	content: "Включить эффект параллакса для фона?" }
		&::after{	content: "При включении и прокрутке страницы обои будут анимированы и размыты." }
	}

	.focus-timer [data-countdown-text="week,"]::before{
		content: "неделя,";
	}

	.focus-timer [data-countdown-text="weeks,"]::before{
		content: "недель,";
	}

	.focus-timer [data-countdown-text="days and"]::before{
		content: "дней и";
	}

	.focus-timer [data-countdown-text="day and"]::before{
		content: "день и";
	}

';
	}
	$__finalCompiled .= '

// Polish
';
	if ($__vars['xf']['language']['language_code'] === 'pl-PL') {
		$__finalCompiled .= '

	.node--unread .node-title::before{
		content: "Nowe"
	}

	.focus-editor-wrap{
		content: "Edytor stylu"
	}

	.focus-guest .focus-guest-header::before{
		content: "Witamy w "
	}

	.structItemContainer-group--sticky::before{
		content: "Przyklejone temat"
	}
	.structItemContainer-group--sticky::after{
		content: "Normalne tematy"
	}

	[data-focus-text="Background Picker"]::after{
		content: "Wybór tła"
	}

	[data-focus-text="Customize layout"]::after{
		content: "Wybór układu strony "
	}

	[data-focus-text="Save"]::after{
		content: "Zapisz"
	}

	[data-focus-text="Choose color"]::after{
		content: "Wybierz kolor"
	}

	[data-setting="focus-fluid"] .focus-editor-text{
		&::before{ content: "Elastyczna szerokść?" }
		&::after{ content: "Jeśli włączysz tą opcję, szerokość strony zostanie dopasowana do szerokości przeglądarki. Przydatne w przypadku większych ekranów." }
	}

	[data-setting="focus-grid"] .focus-editor-text{
		&::before{ content: "Układ kafelkowy?" }
		&::after{ content: "Jeśli włączysz tą opcję, strona główna będzie ułożona w kształcie kafelkow zamiast listy tematów." }
	}

	[data-setting="focus-sidebar-sticky"] .focus-editor-text{
		&::before{ content: "Przyklejony pasek boczny?" }
		&::after{ content: "Jeśli włączysz tą opcję, pasek boczny będzie przesuwał się w górę i dół wraz z przewijaniem storny." }
	}

	[data-setting="focus-sidebar-flip"] .focus-editor-text{
		&::before{ content: "Po której stronie pasek boczny?" }
		&::after{ content: "Jeśli włączysz tą opcję, pasek boczny zmieni pozycje z prawej na lewą."}
	}

	[data-setting="focus-snow"] .focus-editor-text{
		&::before{ content: "Aktywować śnieg?" }
		&::after{ content: "Po aktywacji animowany śnieg spada na twoją przeglądarkę." }
	}

	[data-setting="focus-confetti"] .focus-editor-text{
		&::before{ content: "Aktywować konfeti?" }
		&::after{ content: "Jeśli ta opcja jest włączona, animowane konfetti będą wyświetlane w przeglądarce." }
	}

	[data-setting="focus-countdown"] .focus-editor-text{
		&::before{ content: "Pokaż odliczanie?" }
		&::after{ content: "Jeśli ta opcja jest włączona, odliczanie będzie wyświetlane u góry strony." }
	}

	[data-setting="focus-dimension-parallax"] .focus-editor-text{
		&::before{ content: "Aktywuj efekt paralaksy?" }
		&::after{ content: "Po włączeniu do nagłówka stosowany jest efekt paralaksy." }
	}

	[data-setting="focus-aperture-background"] .focus-editor-text{
		&::before{ content: "Tło Paralaksy?" }
		&::after{ content: "Po włączeniu tapeta będzie animowana i zamazana w miarę przewijania strony." }
	}

	.focus-timer [data-countdown-text="week,"]::before{
		content: "tydzień,";
	}

	.focus-timer [data-countdown-text="weeks,"]::before{
		content: "tygodnie,";
	}

	.focus-timer [data-countdown-text="days and"]::before{
		content: "dni i";
	}

	.focus-timer [data-countdown-text="day and"]::before{
		content: "dzień i";
	}

';
	}
	$__finalCompiled .= '




// Brazilian Portuguese
';
	if ($__vars['xf']['language']['language_code'] === 'pt-BR') {
		$__finalCompiled .= '

    .node--unread .node-title:before{
        content: \'NOVO\'
    }

    .focus-editor-wrap{
        content: "Editor do tema"
    }

    .focus-guest .focus-guest-header:before{
        content: \'Bem-vindo(a) \'
    }

    .structItemContainer-group--sticky:before{
        content: \'Tópicos fixos\'
    }
    .structItemContainer-group--sticky:after{
        content: \'Tópicos normais\'
    }

    [data-focus-text=\'Background Picker\']:after{
        content: \'Selecionador de fundo\'
    }

    [data-focus-text=\'Customize layout\']:after{
        content: \'Personalizar layout\'
    }

    [data-focus-text=\'Save\']:after{
        content: \'Salvar\'
    }

    [data-focus-text=\'Choose color\']:after{
        content: \'Escolher cor\'
    }

    [data-setting=\'focus-fluid\'] .focus-editor-text{
        &:before{    content: \'Largura fluido?\' }
        &:after{    content: \'Habilitando isso aumentará a largura do site para que ocupe a largura do seu navegador. Útil para telas maiores.\' }
    }

    [data-setting=\'focus-grid\'] .focus-editor-text{
        &:before{    content: \'Layout de grade?\' }
        &:after{    content: \'Se habilitado, os fóruns serão exibidos como uma grade em vez de uma tabela.\' }
    }

    [data-setting=\'focus-sidebar-sticky\'] .focus-editor-text{
        &:before{    content: \'Barra lateral pegajosa?\' }
        &:after{    content: \'Se ativada, a barra lateral ficará na parte superior da tela para facilitar o acesso.\' }
    }

    [data-setting=\'focus-dimension-parallax\'] .focus-editor-text{
        &:before{    content: \'Ativar efeito de paralaxe?\' }
        &:after{    content: \'Se habilitado, um efeito de paralaxe será aplicado ao cabeçalho.\' }
    }

    [data-setting=\'focus-sidebar-flip\'] .focus-editor-text{
        &:before{    content: \'Virar a barra lateral?\' }
        &:after{    content: \'Vire a barra lateral entre os lados esquerdo e direito.\' }
    }

    [data-setting=\'focus-snow\'] .focus-editor-text{
        &:before{    content: \'Enable snow effect?\' }
        &:after{    content: \'If enabled, animated snow will fall across your browser.\' }
    }

    [data-setting=\'focus-confetti\'] .focus-editor-text{
        &:before{    content: \'Ativar confete?\' }
        &:after{    content: \'Se habilitado, confetes animados cairão em seu navegador.\' }
    }

    [data-setting=\'focus-countdown\'] .focus-editor-text{
        &:before{    content: \'Mostrar contagem regressiva?\' }
        &:after{    content: \'Se ativado, uma contagem regressiva ficará visível na parte superior da página.\' }
    }

    [data-setting=\'focus-dimension-parallax\'] .focus-editor-text{
        &::before{    content: \'Ativar efeito de paralaxe?\' }
        &::after{    content: \'Se habilitado, um efeito de paralaxe será aplicado ao cabeçalho.\' }
    }

    [data-setting=\'focus-aperture-background\'] .focus-editor-text{
        &::before{    content: \'Paralaxe no fundo?\' }
        &::after{    content: \'Se ativado, a imagem de fundo será animada e desfocada quando a página for rolada.\' }
    }

    [data-setting=\'focus-mobile-navigation-bar\'] .focus-editor-text{
        &::before{    content: \'Barra de navegação no móvel?\' }
        &::after{    content: \'Exibir uma barra de navegação na parte inferior do site ao usar um dispositivo móvel?\' }
    }

    .focus-timer-numbers span{

        &[data-countdown-text="week,"]::before{
            content: \'semana,\';
        }

        &[data-countdown-text="weeks,"]::before{
            content: \'semanas,\';
        }

        &[data-countdown-text="days and"]::before{
            content: \'dias e\';
        }

        &[data-countdown-text="day and"]::before{
            content: \'dia e\';
        }
    }

';
	}
	$__finalCompiled .= '




/*
	----------------
	- Global
	----------------
*/

// Set variables to allow easier debugging
:root{
	--node-grid-padding: @node-grid-padding;
	--grid-node-width: @grid-node-width;
	--mobile-sticky-top: @mobile-sticky-top;
}

.p-pageWrapper{
	// Localize z-index
	z-index: 1;
	// Remove default
	background: none;

	@media (min-width: (@xf-responsiveMedium + 1px)){
	   	padding-top: @body-padding-top;
	    padding-bottom: @body-padding-bottom;
	}
}

@media (min-width: (@xf-responsiveMedium + 1px)){

	.focus-width{
		margin: 0 auto;
		width: @focus-width; // 100vw - 20px
		max-width: @xf-pageWidthMax;
	}

}

// Apply fluid width to screen sizes only when the fluid width will actually be wider than the fixed width
@media (min-width: (@xf-pageWidthMax + @focus-fluid-margin + 1px)){
	.focus-fluid{
		.focus-width,
		.p-header-inner,
		.p-nav-inner,
		.p-sectionLinks-inner,
		.p-body-inner,
		.p-footer-inner{
			max-width: ~"calc(100vw - @{focus-fluid-margin})";
		}
	}
}

@media (min-width: (@xf-responsiveMedium + 1px)){
	// Reset widths of elements if they\'re wrapped with focus-width
	.focus-width{
		.focus-width,
		.p-header-inner,
	    .p-staffBar-inner,
		.p-nav-inner,
		.p-sectionLinks-inner,
		.p-body-inner,
		.p-footer-inner{
			max-width: none;
			// 100% is used instead of auto to fix an IE 11 bug
			width: 100%;
		}
	}
}

';
	if ($__templater->func('property', array('xenfocus_themeEditor', ), false) OR $__templater->func('property', array('xenfocus_picker', ), false)) {
		$__finalCompiled .= '
	.focus-editor-open{

		.focus-width,
		.p-staffBar-inner,
		.p-header-inner,
		.p-nav-inner,
		.p-sectionLinks-inner,
		.p-body-inner,
		.p-footer-inner{
			transition: max-width 0.3s linear;
		}
	}
';
	}
	$__finalCompiled .= '

// Make placeholder text more visible
.input
{
	&::placeholder{
		color: inherit;
		opacity: @input--placeholder;
	}

	&:focus,
	&.is-focused
	{
		&::placeholder{
			color: inherit;
			opacity: @input--placeholder-active;
		}
	}
}

// Make sure search fields aren\'t black
input[type="search"]{
	color: inherit;
}


/*
	----------------
	- Header
	----------------
*/

// Make header show on all devices
#header{
	display: block;
}

// If a header ad exists, hide the search bar
#header .focus-ad:empty,
#header .focus-ad:not(:empty) + .focus-wrap-search{
	display: none;
}

// Remove default
.p-header-inner{
    padding: 0;
}

.p-header-content{
    padding: 0;
    flex-wrap: nowrap;
    max-width: @p-header-content--max-width;
    margin: 0 auto;
}

/*
	----------------
	- Logo
	----------------
*/

.p-header-logo{
    // Remove defaults
    margin: 0;
    max-width: none;
    flex: 0 1 auto;
    
    a{
        height: @xf-xenfocus_logoHeight*1px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        vertical-align: top;
		color: xf-default(@xf-xenfocus_logoColor, inherit);
		font-family: xf-default(@xf-xenfocus_logoFont, inherit);
    	font-size: @xf-xenfocus_logoSize*1px;

        @media (max-width: @xf-responsiveMedium){
            font-size: @xf-xenfocus_logoSizeMobile*1px;
        }
        
        // Mobile logo height
        @media (max-width: @xf-responsiveMedium){
            height: @xf-xenfocus_logoHeightMobile*1px;
        }
    }
    
    // Space out images and text
    .focus-logo > * + *{
    	margin-left: @focus-logo-image--margin;
    }
    
    ';
	if ($__templater->func('property', array('xenfocus_logoType', ), false) != 'image') {
		$__finalCompiled .= '
	    // Text logo
	    .focus-logo--name,
	    .focus-logo--slogan{
	    	line-height: 1;
	    	display: block;
	    }
	    .focus-logo--slogan{
	    	opacity: @logo-slogan-opacity;
	    	font-size: @logo-slogan-size;
	    	margin-top: @logo-slogan-margin;
	    }
	';
	}
	$__finalCompiled .= '
    
    // Restrict logo image
    &.p-header-logo--image img{
    	font-size: 1px;
		width: auto; // Incase the "logo width" setting is filled out
        max-height: @logo-image-height - @logo-reduce-image-height-by;
        @media (max-width: @xf-responsiveMedium){
            // max-width: ~"calc(100vw - (@xf-pageEdgeSpacer * 2))";
            max-height: @mobile-logo-image-height - @mobile-logo-reduce-image-height-by;
        }
    }

    // Stretch so we can center logo on mobiles
    @media (max-width: @xf-responsiveMedium){
        width: 100%;
        text-align: center;

        ';
	if ($__templater->func('property', array('xenfocus_logoType', ), false) != 'text') {
		$__finalCompiled .= '
        	* ~ .focus-logo--text{
        		text-align: left;
        	}
        ';
	}
	$__finalCompiled .= '
        
    }

}


// Mini logo on mobiles
.focus-mobile-navigation{
	flex: 1 1 auto;
	display: flex;
	align-self: stretch;

	@media (min-width: (@xf-responsiveMedium+1px)){
		display: none;
	}
}

// Show header on mobile, otherwise hide it and use inline logo
';
	if ($__templater->func('property', array('xenfocus_headerOnMobile', ), false)) {
		$__finalCompiled .= '

	.focus-mobile-logo{
		display: none;
	}

';
	} else {
		$__finalCompiled .= '

	.focus-mobile-logo{
		display: flex;
		flex: 1 1 auto;
		color: @focus-mobile-logo-color;
		font-weight: bold;
		position: relative;
		overflow: hidden;

		a{
			display: flex;
			align-items: center;
			overflow: hidden;
			text-decoration: none;
			position: absolute;
			top: 0; left: 0; bottom: 0;
		}

		img{
			max-height: 44px;
		}
	}


	@media (max-width: @xf-responsiveMedium){
		#header{
			display: none;
		}
	}

';
	}
	$__finalCompiled .= '




/*
	----------------
	- Navigation
	----------------
*/

// The logo shrink value is set to 1
.focus-wrap-nav{
	flex: 0 2 auto;
	overflow: hidden;
}

// Hide header elements on mobiles depending on location
@media (max-width: @xf-responsiveMedium){
	.p-header{
		.focus-wrap-nav,
		.focus-wrap-search,
		.focus-wrap-user{
			display: none;
		}
	}

	.p-nav{
		.focus-wrap-nav,
		.focus-wrap-search{
			display: none;
		}
	}
}

// Make sure the logo and navigation don\'t squash into each other
.p-header{
	.focus-wrap-nav{
		margin-left: 10px;
	}
}

.p-nav{
	z-index: 2;
	position: relative;

	.focus-wrap-nav{
		overflow: hidden;
	}
}

.p-nav(){}
.p-nav-mobile(){}
@media (min-width: (@xf-responsiveMedium + 1px)){
	.p-nav{
		.p-nav();
	}
}

@media (max-width: @xf-responsiveMedium){
	.p-nav{
		background: @mobile-navigation-bar--background;
		color: @mobile-navigation-bar--color;
		position: -webkit-sticky;
		position: sticky;
		top: @mobile-sticky-top;
		top: var(--mobile-sticky-top, @mobile-sticky-top);
		z-index: 400;
		.p-nav-mobile();
	}
	.p-navSticky .p-nav{
		position: relative;
		top: auto;
	}
}

// Secondary navigation bar
.p-sectionLinks-list .p-navEl{
	position: relative;
	border-radius: 4px;
}

// Align arrow on sub-navigation links
#XF .p-sectionLinks-list .p-navEl-link.p-navEl-link--splitMenu {
    padding-right: 22px;
}

.p-sectionLinks-list .p-navEl-splitTrigger{
	position: absolute;
	right: 0;
	border-top-left-radius: 0 !important;
	border-bottom-left-radius: 0 !important;
}



// Remove box-shadow from sticky nav
.p-navSticky.is-sticky{
	box-shadow: none;
}

// Align items into presumably intended layout
.p-nav-inner{
	align-items: center;
	justify-content: space-between;
    
    // Not necessary for flex layout
	&::before,
	&::after{
		display: none;
	}
}

@media (max-width: @xf-responsiveMedium){
	.has-js .p-nav-inner{
		min-height: 44px;
	}
}
	
// Remove default
.p-nav-scroller{
    margin: 0;
}

.p-nav-list{
    // Set navigation height using line-height instead of padding
	line-height: @xf-xenfocus_navHeight*1px;
	
    .p-navEl-link,
    .p-navEl-splitTrigger{
        padding-top: 0;
        padding-bottom: 0;
    }
   
    
    // Inherit link colour
    a{
        color: inherit;
    }
    
    
    // Remove spacers at start and end. Testing required
    &::before,
    &::after{ width: 0; }

    // Assign font-size
	> li{
		font-size: xf-default(@xf-publicNavTab--font-size, @xf-fontSizeNormal);

		// If margins exists, remove them from the first and last children since they\'re likely unnecessary
		&:first-child .p-navEl{
            margin-left: 0;
        }
        &:last-child .p-navEl{
            margin-right: 0;
        }
	}
}


// Flex layout for links instead of floats
.p-navEl{
	display: flex;
	
	&::before,
	&::after{
		display: none;
	}
}

.p-navEl-link{
	flex: 1 1 auto;
}

// Inherit border-radius
.focus-content .p-navSticky:not(.is-sticky),
.focus-content .p-nav{
	border-top-left-radius: inherit;
	border-top-right-radius: inherit;
}

// Ensure border-radius works even after the sticky class is applied
.p-navSticky.is-sticky .p-nav .p-nav-list .p-navEl.is-selected,
.p-navSticky.is-sticky .p-nav .p-account,
// Remove defaults
.p-navEl,
.p-navEl-link,
.p-navEl-splitTrigger,
.p-nav-list .p-navEl.is-menuOpen{
	border-radius: inherit;
}
	
	.p-navEl-splitTrigger{
		border-top-left-radius: 0;
		border-bottom-left-radius: 0;
	}

// Remove transition effect
.p-nav-list .p-navEl,
.p-navEl-link,
.p-navEl-splitTrigger{
	transition: none;
}

// Assign tab trigger background to a pseudo element for easy inherit
.p-navEl-splitTrigger{
	position: relative;

	&::before{
		content: \'\';
		position: absolute; top: 0; left: 0; right: 0; bottom: 0;
		background: currentcolor;
		border-radius: inherit;
		opacity: 0;
	}
	
		&.is-menuOpen:before,
		&:hover:before{
			opacity: 0.07;
		}
}

// Remove hover effect from link sections
.p-nav-list .p-navEl:not(.is-selected):not(.is-menuOpen){
    .p-navEl-link:hover,
    .p-navEl-splitTrigger:hover{
        background: none;
    }
}
    // Remove the line which separates the text and arrow, when the menu is sticky
    .p-navSticky--primary.is-sticky .p-nav-list .p-navEl.is-selected .p-navEl-splitTrigger::before{
    	display: none;
    }



// Always show the dropdown arrow, which also prevents the jolt after scrolling
.p-navEl-splitTrigger{
	margin-left: -((@xf-publicNavPaddingH) / 1.5);

	.p-nav-list .p-navEl.is-selected & {
		display: block;
	}
}

#XF .p-navEl-link.p-navEl-link--splitMenu{
	padding-right: @xf-publicNavPaddingH;
}


// Remove sub-navigation menu
.focus-dropdown-nav(@debug) when (@debug = true) {
    .p-sectionLinks{
        display: none;
    }
}
.focus-dropdown-nav(@focus-dropdown-nav);



// Navigation icons
.navigation-icons(){}

';
	if ($__templater->func('property', array('xenfocus_navIcons', ), false)) {
		$__finalCompiled .= '
.focus-wrap-nav .p-navEl-link,
.offCanvasMenu-linkHolder .offCanvasMenu-link[data-nav-id]{

	&::before{
		.m-faBase();
        .m-faContent(@fa-var-tag);
		font-size: @nav-icon-size;
		display: inline-block;
		-webkit-font-smoothing: antialiased;
		-moz-osx-font-smoothing: grayscale;
		margin-right: 6px;
		.navigation-icons();
	}

	&[data-nav-id="home"]::before{
		.m-faContent(@fa-var-home);
	}
	&[data-nav-id="xenfocus_styles"]::before{
		.m-faContent(@fa-var-th);
	}
	&[data-nav-id="forums"]::before,
	&[data-nav-id="siropuChat"]::before{
		.m-faContent(@fa-var-comments);
	}
	&[data-nav-id="whatsNew"]::before{
		.m-faContent(@fa-var-star);
	}
	&[data-nav-id="members"]::before{
		.m-faContent(@fa-var-user);
	}
	&[data-nav-id="xfmg"]::before{
		.m-faContent(@fa-var-image);
	}
	&[data-nav-id="xfrm"]::before{
		.m-faContent(@fa-var-download);
	}
}
// Remove icon added by 3rd party addon
[data-nav-id="siropuChat"] > i{
	display: none;
}
';
	}
	$__finalCompiled .= '



// Navigation scrollers: Force the buttons to use the same colours as navigation links
.p-nav-scroller .hScroller-action{

	color: @navigation-arrow-color;
	padding: 0;

	html[dir=\'ltr\'] &.hScroller-action--start,
	html[dir=\'rtl\'] &.hScroller-action--end{
		background-image: linear-gradient(to left, fade(@navigation-arrow-gradient, 0%) 0%, @navigation-arrow-gradient 60%);
	}

	html[dir=\'ltr\'] &.hScroller-action--end,
	html[dir=\'rtl\'] &.hScroller-action--start{
		background-image: linear-gradient(to right, fade(@navigation-arrow-gradient, 0%) 0%, @navigation-arrow-gradient 60%);
	}

	&:hover{
		color: lighten(@navigation-arrow-color, 20%);
	}

	&::after{
		font-size: 10px;
		border-radius: 4px;
		background: fade(@navigation-arrow-color, 25%);
		width: @navigation-arrow-size;
		line-height: @navigation-arrow-size;
		text-align: center;
		-webkit-backdrop-filter: blur(5px);
		backdrop-filter: blur(5px);
	}

		&:hover:after{
			background: fade(@navigation-arrow-color, 40%);
		}
}

// If the navigation is placed inside the header, change the fade gradient of the navigation scrollers
';
	if ($__templater->func('property', array('publicHeader--background-color', ), false)) {
		$__finalCompiled .= '

	.p-header .p-nav-scroller .hScroller-action{

		html[dir=\'ltr\'] &.hScroller-action--start,
		html[dir=\'rtl\'] &.hScroller-action--end{
			background-image: linear-gradient(to left, fade(@xf-publicHeader--background-color, 0%) 0%, @xf-publicHeader--background-color 60%);
		}

		html[dir=\'ltr\'] &.hScroller-action--end,
		html[dir=\'rtl\'] &.hScroller-action--start{
			background-image: linear-gradient(to right, fade(@xf-publicHeader--background-color, 0%) 0%, @xf-publicHeader--background-color 60%);
		}
	}

';
	}
	$__finalCompiled .= '



// Place the scroller arrows outside of the navigation
.focus-nav-arrows{

	.p-nav-scroller{
		display: flex;
		align-items: center;
	}

	.hScroller-scroll{
		order: 2;
		flex: 1 1 auto;
	}

	.hScroller-action{
		position: relative;
		display: block;
		flex: 0 0 auto;
	}

	.hScroller-action:not(.is-active){
		opacity: 0.5;
		pointer-events: none;
	}

	.hScroller-action--start{
		order: 1;
	}

	.hScroller-action--end{
		order: 3;
	}

}


/*
	----------------
	- User links
	----------------
*/


.focus-wrap-user{
	flex: 0 0 auto;

	// Style the user links wrapper on desktop
	@media (min-width: (@xf-responsiveMedium + 1px)){
		// Possibly helpful when assigning border-radius since the search link may be shown
		';
	if ($__templater->func('property', array('xenfocus_userlinksRadius', ), false) === 'parent') {
		$__finalCompiled .= '
			overflow: hidden;
		';
	}
	$__finalCompiled .= '
		.xf-xenfocus_userStyles();
	}

	// Change colour and radius for mobile user links
	@media (max-width: @xf-responsiveMedium){
		.p-nav-inner &{
			border-radius: 3px;
			color: @mobile-navigation-bar--color;
		}
	}
}

	// Reset default styles and inherit border-radius
	.p-nav-opposite{
		@media (min-width: (@xf-responsiveMedium + 1px)){
			margin: 0;
		}
	}


	// Set defaults
	.p-navgroup{
		display: flex;
		background: transparent;

		> *{
			flex: 0 0 auto;
		}
	}

.p-navgroup-link{
	align-items: center;
	background-clip: padding-box !important;
	// Remove borders from default code if they aren\'t removed in the next code block
	';
	if (!$__templater->func('property', array('xenfocus_userSep', ), false)) {
		$__finalCompiled .= '
		border: 0;
	';
	}
	$__finalCompiled .= '
	color: inherit;
	display: flex;
	height: @xf-xenfocus_userHeight*1px;
	justify-content: center;
	padding-top: 0;
	padding-bottom: 0;
	
	// Remove width restriction on icons
	&.p-navgroup-link--iconic i::after{
		width: auto;
		min-width: 0px;
	}
	
	// User panel buttons are sometimes truncated. Fixed with:
	&.p-navgroup-link--textual{
		max-width: none;
	}
	
	@media (min-width: (@xf-responsiveMedium + 1px)){

		// Keep a neat ratio with links
		min-width: @xf-xenfocus_userHeight*1px;
		
		#XF &{

			// Assign border-radius based on parent/children setting
			';
	if ($__templater->func('property', array('xenfocus_userlinksRadius', ), false) === 'children') {
		$__finalCompiled .= '
				border-radius: @user-border-radius;
			';
	} else {
		$__finalCompiled .= '
				border-radius: 0;
			';
	}
	$__finalCompiled .= '

			// Add border separator to user links
			';
	if ($__templater->func('property', array('xenfocus_userSep', ), false)) {
		$__finalCompiled .= '
				border-left: @user-links-sep solid @user-border-color;
			';
	}
	$__finalCompiled .= '
		}

		// Make sure first account link has no left border
		';
	if ($__templater->func('property', array('xenfocus_userSep', ), false)) {
		$__finalCompiled .= '
			#XF .p-account &:first-of-type{
				border-left-width: 0px;
			}
		';
	}
	$__finalCompiled .= '

		// Desktops: Hover and active effects
		&.is-menuOpen,
		&:hover{
			';
	if ($__templater->func('property', array('xenfocus_userStyles--color', ), false)) {
		$__finalCompiled .= '
	        	color: lighten(@xf-xenfocus_userStyles--color, 5%);
	        ';
	}
	$__finalCompiled .= '
			background-color: @user-hover;
		}
	}




	@media (max-width: @xf-responsiveMedium){
		// Set height to 40px on mobiles to match hamburger
		height: 40px;

		#XF &{
			border-radius: @user-links-radius-mobile;
		}

		// Mobiles: Hover and active effects
		&.is-menuOpen,
		&:hover{
	        color: @mobile-navigation-bar--color;
	        background-color: fade(@mobile-navigation-bar--color, 15%);
		}
	}


}

// Remove default gap from user links and search link
.p-navgroup.p-discovery{
	margin: 0;
}

// User links alignment
.p-navgroup-link--user{
	// Required to make sure avatar shows on mobiles
	&.p-navgroup-link{
		display: flex;
	}

	> *{
		flex: 0 0 auto;
	}
    
    @media (min-width: (@xf-responsiveWide + 1px)){

    	.avatar{

    		#XF &{
	    		height: (@xf-xenfocus_userHeight * 1px - 14px);
	    		width: (@xf-xenfocus_userHeight * 1px - 14px);
	    		margin-left: -3px;
	    		margin-right: @xf-paddingLarge;
	    	}
    		
            &.avatar--default--dynamic{
            	font-size: inherit;
            	display: inline-flex;
            	justify-content: center;
            	align-items: center;
            }
        }
    }

    ';
	if ($__templater->func('property', array('xenfocus_userStyles--color', ), false)) {
		$__finalCompiled .= '
	.avatar::after{
		border-color: fade(@xf-xenfocus_userStyles--color, 15%);
	}
	';
	}
	$__finalCompiled .= '

    // Rearrange coding for truncated usernames
    &.p-navgroup-link{
    	max-width: none;
    }
}

// Notifications alignment
.p-navgroup-link--conversations,
.p-navgroup-link--alerts{

	&.badgeContainer::after{
		left: auto;
		right: 4px;
	}

}

// Hide whats new link since the flex property shows it
@media (min-width: (@xf-responsiveMedium + 1px)){
	.p-navgroup-link--whatsnew{ display: none; }
}

// Add icons to guest links
.p-navgroup-link--logIn,
.p-navgroup-link--register{

	.p-navgroup-linkText::before{
		.m-faBase();
        .m-faContent(@fa-var-sign-in);
		margin-right: 8px;
	}
}

.p-navgroup-link--register .p-navgroup-linkText::before{
	.m-faContent(@fa-var-plus-square);
}

// Register button
';
	if ($__templater->func('property', array('xenfocus_userRegister', ), false)) {
		$__finalCompiled .= '
	.p-navgroup--guest .p-navgroup-link--register{
		position: relative;
		background-color: transparent !important;
		color: contrast(@xf-xenfocus_userRegister, rgba(0,0,0,0.7), #fff);
		text-shadow: none;
		font-weight: bold;

		&::before{
			content: \'\';
			position: absolute;
			top: @register-offset-v;
			left: @register-offset-h;
			right: @register-offset-h;
			bottom: @register-offset-v;
			background: @xf-xenfocus_userRegister;
			border-radius: 3px;

			@media (max-width: @xf-responsiveMedium){
				top: 3px;
				bottom: 3px;
			}
		}

		&:hover::before{
			background: lighten(@xf-xenfocus_userRegister, 5%);
		}

		.p-navgroup-linkText{
			position: relative;
		}
	}
';
	}
	$__finalCompiled .= '

// Change icon of New Content
.p-navgroup-link.p-navgroup-link--whatsnew i::after,
.button.button--icon--bolt > .button-text::before,
a.button.button--icon--bolt > .button-text::before{
	.m-faContent(@fa-var-file-alt);
}

	.button.button--icon--bolt > .button-text::before,
	a.button.button--icon--bolt > .button-text::before{
		width: auto;
	}

// Remove box-shadow from active links
.p-nav-list .p-navEl.is-menuOpen,
.p-navgroup-link.is-menuOpen{
	box-shadow: none;
}

// Bug fix: Restore full opacity since separator borders are also faint
.p-navgroup-link.badgeContainer{
	opacity: 1;
}

// Alter colours of user drop-down menu
.js-visitorMenuBody .menu-row--highlighted{
	background: @xf-contentAltBg;
}

// Hide search link
';
	if (!$__templater->func('property', array('xenfocus_searchLink', ), false)) {
		$__finalCompiled .= '
    @media (min-width: (@xf-responsiveMedium + 1px)){
        .p-discovery{
            display: none;
        }
    }
';
	}
	$__finalCompiled .= '


';
	if ($__templater->func('property', array('xenfocus_searchBar', ), false)) {
		$__finalCompiled .= '
	/*
		----------------
		- Search bar
		----------------
	*/

	.focus-wrap-search{
		flex: 0 0 auto;
		margin-left: 10px;
		position: relative;
	}

	.focus-search{
		line-height: @search-height;
		width: @search-width;
		.xf-xenfocus_searchStyles();
		border-left-width: @search-border-left;
		border-right-width: @search-border-right;

	    // Hide search on medium width
	    @media (max-width: @xf-responsiveMedium){
	        display: none;
	    }
	}

	.focus-search-flex{
		align-items: center;
		display: flex;
		position: relative;
	}

		.focus-search-prefix{
			flex: 0 0 auto;
			opacity: 0.7;
			order: 1;
			text-align: center;
			transition: opacity 0.2s linear;
			width: @search-height;

			.focus-search input:focus ~ &{
				opacity: 1;
			}		
		}

		.focus-search input{
			background: none;
			border: 0;
			color: inherit;
			display: block;
			flex: 1 1 auto;
			min-width: 0;
			order: 2;
			outline: none;
			padding: 0;
			width: 100%;
			
			// IE 11
			height: @search-height;
			line-height: @search-height;
			
			&::placeholder {
				color: inherit;
				opacity: 0.7;
			}
		}

	.focus-search-menu{
		position: absolute;
		top: 100%;
		z-index: 200;
		margin-top: @focus-search-arrow+4px;
		left: 0;
		width: 100%;
		max-width: 300px;
		min-width: 200px;
		color: @xf-textColor;
		background: @focus-search-dropdown;
		box-shadow: 0px 10px 20px rgba(0,0,0,0.15), @focus-search-dropdown-border 0px 0px 0px 1px;
		border-radius: @xf-blockBorderRadius;

		transform: translateY(-12px);
		opacity: 0;
		pointer-events: none;
		visibility: hidden;
		transition: all linear 0.2s;

		.focus-search-menu-active &{
			transform: translateY(0);
			opacity: 1;
			pointer-events: auto;
			visibility: visible;
		}

		&::before,
		&::after{
			content: \'\';
			position: absolute;
			top: @focus-search-arrow*-2;
			left: 10px;
			width: @focus-search-arrow*2;
			height: @focus-search-arrow*2;
			border: @focus-search-arrow solid transparent;
			border-bottom-color: @focus-search-dropdown-border;
			box-sizing: border-box;
		}

		&::before{
			margin-top: -1px;
		}

		&::after{
			border-bottom-color: @focus-search-dropdown;
		}

		.menu-row{
			padding: 10px;
			border-top: 1px solid fade(@xf-textColor, 8%);

			&:first-of-type{
				border-top-width: 0;
			}
		}

		.menu-footer{
			background: xf-intensify(@xf-contentAltBg, 3%);
			border-bottom-left-radius: inherit;
			border-bottom-right-radius: inherit;
			padding: 7px;
		}

		.menu-footer-controls{
			float: none !important;
			display: flex;
			justify-content: flex-end;
			align-items: center;
			flex-wrap: wrap;

			> *{
				flex: 0 0 auto;
				margin: 3px;
			}
		}

		a.button{
			color: @xf-buttonDefault--color;
		}

		// Button icons
		@focus-search-button-height: 30px;
		.button{
			padding: 0 10px;
			line-height: @focus-search-button-height;
		}

		.button-text{
			display: block;
			position: relative;
		}

		.menu-footer .button-text:before{
			font-size: 14px;
			line-height: inherit;
			margin-right: 5px;
		}

		.menu-footer a .button-text:before{
			.m-faBase();
        	.m-faContent(@fa-var-sliders-h);
		}
	}
';
	}
	$__finalCompiled .= '

/*
	----------------
	- xenfocus Editor
	----------------
*/

@focus-editor-icon: "\\f205";
@focus-editor-save: #2aad55;
@focus-editor-width: 1000px;
';
	if ($__templater->func('property', array('styleType', ), false) == 'light') {
		$__finalCompiled .= '
	@focus-editor-overlay: rgba(0,0,0,0.4);
';
	} else {
		$__finalCompiled .= '
	@focus-editor-overlay: rgba(0,0,0,0.88);
';
	}
	$__finalCompiled .= '
@focus-editor-transition: 0.25s;

[data-xenfocus-editor] .fa-toggle-on::before{
	content: @focus-editor-icon;
}

	.p-footer .xenfocus-footer-icon{
		a{
			min-width: 40px;
			text-align: center;
		}

		i{
			margin: 0;
		}
	}

';
	if ($__templater->func('property', array('xenfocus_themeEditor', ), false) OR $__templater->func('property', array('xenfocus_picker', ), false)) {
		$__finalCompiled .= '

[data-xenfocus-editor]{
	cursor: pointer;
}

.focus-editor-wrap{
	display: flex;
	position: fixed;
	top: 0; left: 0; width: 100%; height: 100%;
	z-index: 910;
	align-items: center;
	justify-content: center;
	visibility: hidden;
	opacity: 0;
	transition: all @focus-editor-transition ease-in-out;

	.focus-editor-open &{
		visibility: visible;
		opacity: 1;
	}
}

	.focus-editor-overlay{
		background: @focus-editor-overlay;
		-webkit-backdrop-filter: blur(5px);
		backdrop-filter: blur(5px);
		position: absolute;
		top: 0; left: 0; right: 0; bottom: 0;
		cursor: auto;
	}

.focus-editor{
	box-shadow: rgba(0,0,0,0.3) 0px 10px 10px, rgba(0,0,0,0.4) 0px 15px 50px;
	border-radius: 4px;
	background: fadein(@xf-contentBg, 100%);
	position: relative;
	width: 98%;
	max-width: @focus-editor-width;
	transition: all @focus-editor-transition ease-in-out;
	transform: translateY(-50px);

	.focus-editor-open &{
		transform: translateY(0);
	}
}

.focus-editor-panel{
	padding: 20px;
	display: flex;
	align-items: center;
	justify-content: flex-start;
	cursor: pointer;
	// Remove tap background from iOS
	-webkit-tap-highlight-color: transparent;

	@media (hover:hover){
		&:hover{
			background: fade(@xf-contentAltBg, 80%);
		}
	}
}

.focus-editor__title{
	font-weight: bold;
	background: @xf-contentAltBg;
	border: 1px solid xf-intensify(@xf-contentAltBg, 10%);
	border-width: 1px 0;
	padding: 20px;
	position: sticky;
	top: 0px;
	z-index: 10;

	&:only-child{
		display: none;
	}

	.focus-editor-scroll > :first-child > &{
		border-top-width: 0px;
	}
}

.focus-editor-save{
	padding: 20px;
	text-align: right;
	background: @xf-contentAltBg;
	border-top: 1px solid xf-intensify(@xf-contentAltBg, 10%);
	border-bottom-left-radius: inherit;
	border-bottom-right-radius: inherit;

	button{
		display: inline-flex;
		';
		if ($__templater->func('property', array('styleType', ), false) == 'light') {
			$__finalCompiled .= '
			border: 1px solid rgba(0,0,0,0.2);
		';
		} else {
			$__finalCompiled .= '
			border: 0;
		';
		}
		$__finalCompiled .= '
		box-shadow: inset rgba(255,255,255,0.16) 0px 1px 0px;
		border-radius: 3px;
		background-color: @focus-editor-save;
		color: #fff;
		font-weight: bold;
		padding: 0;
		line-height: 44px;
		position: relative;
		transition: background-color 0.2s linear;

		&::before{
			flex: 0 0 auto;
			.m-faBase();
    		.m-faContent(@fa-var-check);
			font-size: 14px;
			padding: 0 12px;
			background: rgba(255,255,255,0.18);
			background-clip: padding-box;
			border-top-left-radius: inherit;
			border-bottom-left-radius: inherit;
			border: 1px solid rgba(0,0,0,0.12);
			border-width: 0 1px 0 0;
		}
		&::after{
			flex: 0 0 auto;
			padding: 0 18px;
		}

		&:hover{
			background-color: lighten(@focus-editor-save, 5%);
		}

		&:active{
			top: 1px;
		}
	}
}

.focus-editor-scroll{
	max-height: ~"calc(100vh - 200px)";
	overflow: auto;
	border-radius: inherit;

	> div:first-of-type h4{
		border-top: 0;
	}
}


// Hide certain settings from mobiles
@media (max-width: @xf-responsiveWide){
	.focus-editor-panel[data-setting="focus-sidebar-sticky"],
	.focus-editor-panel[data-setting="focus-sidebar-flip"]{
		display: none;
	}
}

@media (max-width: (@xf-pageWidthMax + @focus-fluid-margin)){
	.focus-editor-panel[data-setting="focus-fluid"]{
		display: none;
	}
}

@focus-toggle-height: 30px;
@focus-toggle-width: 50px;
@focus-toggle-transform: @focus-toggle-width - @focus-toggle-height;
@focus-toggle-goo: 10px;
@focus-toggle-border: 2px;

.focus-editor-toggle{
	position: relative;
	flex: 0 0 auto;
	margin-right: 20px;
}

	.focus-toggle{
		background: xf-intensify(@xf-contentBg, 10%);
		display: block;
		border-radius: 15px;
		position: relative;
		z-index: 0;
		width: @focus-toggle-width;
		height: @focus-toggle-height;

		// Background
		&::before{
			content: \'\';
			position: absolute; top: 0; left: 0; right: 0; bottom: 0;
			background: @focus-editor-save;
			border-radius: inherit;
			opacity: 0;
			transition: opacity 0.25s linear;
		}

		i{
			position: absolute;
			border-radius: inherit;
			overflow: hidden;
			// Fix iOS glitchy animation
			transform: translate3d(0,0,0);
			';
		if ($__templater->func('property', array('styleType', ), false) == 'light') {
			$__finalCompiled .= '
				top: @focus-toggle-border;
				right: @focus-toggle-border;
				bottom: @focus-toggle-border;
				left: @focus-toggle-border;
			';
		} else {
			$__finalCompiled .= '
				top: @focus-toggle-border + 2px;
				right: @focus-toggle-border + 2px;
				bottom: @focus-toggle-border + 2px;
				left: @focus-toggle-border + 2px;
			';
		}
		$__finalCompiled .= '

			&::before{
				content: \'\';
				';
		if ($__templater->func('property', array('styleType', ), false) == 'dark') {
			$__finalCompiled .= '
				background: rgba(255,255,255,0.5);
				';
		} else {
			$__finalCompiled .= '
				background: lighten(@xf-contentBg, 20%);
				';
		}
		$__finalCompiled .= '
				box-shadow: rgba(0,0,0,0.25) 0px 3px 6px;
				border-radius: inherit;
				display: block;
				height: 100%;
				';
		if ($__templater->func('property', array('styleType', ), false) == 'light') {
			$__finalCompiled .= '
					width: @focus-toggle-height + @focus-toggle-goo - @focus-toggle-border - @focus-toggle-border;
				';
		} else {
			$__finalCompiled .= '
					width: @focus-toggle-height + @focus-toggle-goo - @focus-toggle-border - @focus-toggle-border - 4px;
				';
		}
		$__finalCompiled .= '
				transition: transform 0.25s ease-in-out;
				transform: translateX(@focus-toggle-goo * -1);
			}
		}

		&::after{
			content: \'\';
			position: absolute; top: 0; left: 0; right: 0; bottom: 0;
			border-radius: inherit;
			border: 2px solid rgba(0,0,0,0.15);
			';
		if ($__templater->func('property', array('styleType', ), false) == 'dark') {
			$__finalCompiled .= '
			border-color: rgba(255,255,255,0.2);
			';
		}
		$__finalCompiled .= '
		}

		[data-setting-status=\'on\'] &{
			&::before{
				opacity: 1;
			}
			i::before{
				transform: translateX(@focus-toggle-transform);
			}
		}
	}

.focus-editor-text{
	flex: 1 1 auto;

	&::before{
		content: attr(data-setting-title);
		display: block;
		font-weight: bold;
		margin-bottom: 4px;
	}

	&::after{
		content: attr(data-setting-desc);
		opacity: 0.6;
		display: block;
	}
}

';
	}
	$__finalCompiled .= '


/*
	----------------
	- Breadcrumbs
	----------------
*/

// Align breadcrumbs and social icons
.focus-breadcrumb{
    display: flex;
    
    @media (max-width: @xf-responsiveMedium){
        flex-direction: column;
        align-items: center;
    }

    .p-breadcrumbs-wrap{
        flex: 1 1 auto;
        width: 100%;
    }
}

.xenfocus_breadcrumb(){} 

.focus-breadcrumbs(@debug) when (@debug = true) {

	.p-breadcrumbs-wrap{
        color: @breadcrumb-color;
        background-color: @breadcrumb-background-hex;
        background-image: @breadcrumb-background-image;
        border-radius: @breadcrumb-radius;
        font-size: @xf-fontSizeSmall;
        line-height: @breadcrumb-height;
        margin-bottom: 10px;
        position: relative;
        z-index: 0;
        display: flex;
        @media (min-width: (@xf-responsiveEdgeSpacerRemoval + 1px)){
        	margin-bottom: @content-padding;
        }

        .xenfocus_breadcrumb();

        &::before{
        	content: \'\';
        	display: block;
        	position: absolute; top: 0; left: 0; right: 0; bottom: 0;
        	border-width: @breadcrumb-border-width;
	        border-style: solid;
	        border-color: @breadcrumb-border-color;
	        border-radius: inherit;
	        pointer-events: none;
	        z-index: 2;
        }

        &.p-breadcrumbs-wrap--bottom{
        	margin-top: @content-padding;
        	margin-bottom: 0;
        }
    }

    // Remove default margins
    .p-breadcrumbs.p-breadcrumbs--bottom{
    	margin: 0;
    }

    .p-breadcrumbs{
        overflow: hidden;
        margin: 0;
        width: 100%;
        line-height: inherit;
        display: flex;
		flex-wrap: wrap;

        &::before,
        &::after{
        	display: none;
        }

        > li{
        	margin: 0;
            font-size: inherit;
            padding-left: 15px;

        	&:first-child{
	            border-top-left-radius: inherit;
	            border-bottom-left-radius: inherit;
	        }

	        &::before,
            &::after{
                display: none;
            }

            a{
                padding: 0 15px;
                position: relative;
                z-index: 1;
                display: block;
                overflow: visible;
                max-width: none;
                text-decoration: none;
                color: inherit;
				margin-left: -15px;
               
                &:hover{
			    	color: xf-default(@xf-xenfocus_breadcrumbHover--color, inherit);
			    }

                &::before,
	            &::after {
	                border-style: solid;
	                border-width: 0;
	                border-right-width: 1px;
	                border-color: @breadcrumb-shadow;
	                color: @breadcrumb-highlight;
	                box-shadow: inset currentColor -1px 0px 0px 0px;
	                content: \'\';
	                position: absolute;
	                height: 50%;
	                width: 100%;
	                right: 0;
	                z-index: -1;
	                box-sizing: border-box;
	                transform-origin: 100% 50%;
	            }

	            html[dir=\'rtl\'] &::before,
				html[dir=\'rtl\'] &::after{
					box-shadow: inset currentColor 1px 0px 0px 0px;
				}

                &::before {
	                top: 0;
	                transform: skewX(30deg);
	            }

	            &::after {
	                top: 50%;
	                transform: skewX(-30deg);
	            }

			    html[dir=\'rtl\'] &::before{
			    	transform: skewX(-30deg);
			    }
			    
			    html[dir=\'rtl\'] &::after{
			    	transform: skewX(30deg);
			    }

			    /* Hover */
			    &:hover::before,
                &:hover::after{
                    background: @breadcrumb-hover;
                }

                /* Active */
                &:active::before,
                &:active::after{
                    background: @breadcrumb-active;
                    color: rgba(0,0,0,0.05);
                    box-shadow: inset currentColor -2px 1px 1px;
                }

                &:active::after{
                    box-shadow: inset currentColor -2px -1px 1px;
                }
            }

            &:first-of-type a::before,
            &:first-of-type a::after {
                width: ~"calc(100% + 20px)";
            }
        }

        
        @media (max-width: @xf-responsiveNarrow){

        	.focus-breadcrumbs-mobile(@debug) when (@debug = true) {
	        	overflow: auto;
				flex-wrap: nowrap;

	        	> li{
	        		display: block;
	        	}

		        > li a{
		            padding: 0 11px;
		            -webkit-tap-highlight-color: transparent;
		            -webkit-overflow-scrolling: touch;
				}
		    }
			.focus-breadcrumbs-mobile(@focus-breadcrumbs-mobile);

			.focus-breadcrumbs-mobile-disabled(@debug) when (@debug = false) {

				> li{
					a{
						padding-right: 15px;

						&::before {
			                transform: skewX(-30deg);
			            }

			            &::after {
			                transform: skewX(30deg);
			            }
					}
				}

			}
			.focus-breadcrumbs-mobile-disabled(@focus-breadcrumbs-mobile);

	    }
		
    }
}
.focus-breadcrumbs(@focus-breadcrumbs);


// Remove the bottom breadcrumb bar on the forum index
[data-template="forum_list"] .p-breadcrumbs-wrap--bottom{
	display: none;
}



/*
	----------------
	- Social icons
	----------------
*/

';
	if ($__templater->func('property', array('xenfocus_socialEnable', ), false) OR $__templater->func('property', array('xenfocus_socialFooter', ), false)) {
		$__finalCompiled .= '

.xenfocus-social{
	color: #fff;
	border-radius: @xf-xenfocus_breadcrumb--border-radius;
	display: flex;
	align-items: center;
	justify-content: flex-start;
	flex: 0 0 auto;
	margin: 0;
    margin-bottom: 10px;
	padding: 0;
	list-style: none;
	text-align: center;
	text-shadow: rgba(0,0,0,0.3) 0px -1px 0px;
	@media (min-width: (@xf-responsiveEdgeSpacerRemoval + 1px)){
		margin-bottom: @content-padding;
	}
    
    li{
	    line-height: @social-height;
	    display: block;
	    flex: 0 0 auto;
	    margin: 0;
		padding: 0;
		border-radius: inherit;
		list-style: none;
	    padding-left: 4px;
	}
    
    a{
		color: inherit;
		box-shadow: rgba(0,0,0,0.1) 0px 1px 3px;
	    border-radius: inherit;
	    display: flex;
        align-items: center;
	    text-decoration: none;
	    outline: none;
	    position: relative;
        font-size: @xf-fontSizeSmall;
        padding-right: 12px;

            &:active{
                box-shadow: inset rgba(0,0,0,0.4) 0px 1px 3px;
                top: 1px;
            }
        
            // Icon
        	&::before{
        		.m-faBase(\'Brands\');
        		.m-faContent(@fa-var-diaspora);
                background-color: rgba(255,255,255,0.12);
                border-radius: inherit;
                width: @social-height !important;
                height: @social-height;
				flex: 0 0 auto;
                text-align: center;
                font-size: 16px !important;
                pointer-events: none;
                border-top-right-radius: 0;
            	border-bottom-right-radius: 0;
            	margin-right: 12px;

                html[dir=\'ltr\'] &{               	
                	box-shadow: inset rgba(255,255,255,0.12) -1px 0px 0px 0px, rgba(0,0,0,0.1) 1px 0px 0px 0px;
                }
                html[dir=\'rtl\'] &{
                	box-shadow: inset rgba(255,255,255,0.12) 1px 0px 0px 0px, rgba(0,0,0,0.1) -1px 0px 0px 0px;
                }
            }
        
            // Border and hover
            &::after{
                border: @social-border solid rgba(0,0,0,0.2);
                ';
		if ($__templater->func('property', array('styleType', ), false) == 'dark') {
			$__finalCompiled .= '
                border-width: 0px;
                ';
		}
		$__finalCompiled .= '
                box-shadow: inset rgba(255,255,255,0.15) 0px 1px 0px;
                content: \'\';
                position: absolute;
                top: 0; left: 0; right: 0; bottom: 0;
                pointer-events: none;
                border-radius: inherit;
            }

                &:hover:after{
                    background: rgba(255,255,255,0.2);
                }

                &:active:after{
                    background: rgba(0,0,0,0.1);
                }
        
        // Icon only
        #XF &:empty{
            padding: 0;
            
            &::before{
                border-radius: inherit;
                margin: 0;
                box-shadow: none;
                background-color: transparent;
            }
        }
	}
 
	a{
	    background: #999;

		&[href*=\'deviantart\']{
		    background: #475c4d;
		    &::before{ .m-faContent(@fa-var-deviantart); }
		}
	    
	    &[href*=\'discordapp\'],
	    &[href*=\'discord\']{
	        background: #7289da;
	        &::before{ .m-faContent(@fa-var-discord); }
	    }
	    
	    &[href*=\'dropbox\']{
	        background: #007fe5;
	        &::before{ .m-faContent(@fa-var-dropbox); }
	    }
	    
	    &[href*=\'mailto:\']{
	        background: #444444;
	        &::before{
	        	.m-faBase();
	        	.m-faContent(@fa-var-envelope);
	        }
	    }
	    
	    &[href*=\'facebook\']{
	        background: #304c87;
	        &::before{ .m-faContent(@fa-var-facebook-f); }
	    }
	    
	    &[href*=\'flickr\']{
	        background: #fe2997;
	        &::before{ .m-faContent(@fa-var-flickr); }
	    }
	    
	    &[href*=\'google\']{
	        background: #df6b39;
	        &::before{ .m-faContent(@fa-var-google); }
	    }

	    &[href*=\'guilded\']{
	        background: #f5c400;
	        &::before{ .m-faContent(@fa-var-guilded); }
	    }
	    
	    &[href*=\'instagram\']{
	        background: #de416a;
	        &::before{ .m-faContent(@fa-var-instagram); }
	    }
	    
	    &[href*=\'linkedin\']{
	        background: #0073b2;
	        &::before{ .m-faContent(@fa-var-linkedin-in); }
	    }
	    
	    &[href*=\'paypal\']{
	        background: #253b80;
	        &::before{ .m-faContent(@fa-var-paypal);}
	    }
	    
	    &[href*=\'pinterest\']{
	        background: #cd1d1f;
	        &::before{ .m-faContent(@fa-var-pinterest-p); }
	    }
	    
	    &[href*=\'reddit\']{
	        background: #609acf;
	        &::before{ .m-faContent(@fa-var-reddit-alien); }
	    }
	    
	    &[href$=\'.rss\']{
	        background: #ff9641;
	        &::before{
	        	.m-faBase();
	        	.m-faContent(@fa-var-rss);
	        }
	    }
	    
	    &[href*=\'skype\']{
	        background: #00b0f0;
	        &::before{ .m-faContent(@fa-var-skype); }
	    }
	    
	    &[href*=\'soundcloud\']{
	        background: #ff6900;
	        &::before{ .m-faContent(@fa-var-soundcloud); }
	    }
	    
	    &[href*=\'spotify\']{
	        background: #84b301;
	        &::before{ .m-faContent(@fa-var-spotify); }
	    }
	    
	    &[href*=\'steampowered\'],
	    &[href*=\'steamcommunity\']{
	        background: #457498;
	        &::before{ .m-faContent(@fa-var-steam); }
	    }
	    
	    &[href*=\'stripe.\']{
	        background: #58aada;
	        &::before{ .m-faContent(@fa-var-stripe); }
	    }
	    
	    &[href*=\'teamspeak.\'],
		&[href*=\'ts3server://\']{
	        background: #8190b1;
	        &::before{ .m-faContent(@fa-var-teamspeak); }
	    }

	    &[href*=\'/t.me/\'],
	    &[href*=\'telegram.\']{
	        background: #0d86d7;
	        &::before{ .m-faContent(@fa-var-telegram-plane); }
	    }
	    
	    &[href*=\'tumblr.\']{
	        background: #539fcc;
	        &::before{ .m-faContent(@fa-var-tumblr); }
	    }
	    
	    &[href*=\'twitch.tv\']{
	        background: #6441a5;
	        &::before{ .m-faContent(@fa-var-twitch); }
	    }
	    
	    &[href*=\'twitter.com\']{
	        background: #0097d3;
	        &::before{ .m-faContent(@fa-var-twitter); }
	    }
	    
	    &[href*=\'vimeo.com\']{
	        background: #1bb5ea;
	        &::before{ .m-faContent(@fa-var-vimeo-v); }
	    }

	    &[href*=\'/vk.com\']{
	        background: #5181b8;
	        &::before{ .m-faContent(@fa-var-vk); }
	    }
	    
	    &[href*=\'youtube.com\']{
	        background: #cc332d;
	        &::before{ .m-faContent(@fa-var-youtube); }
	    }
	    
	}
}

#footer .xenfocus-social{
	margin: 0;
	margin-top: 10px;

	li:first-child{
		padding: 0;
	}

	.social-footer-basic(@debug) when (@debug = true) {
		color: inherit;
		text-shadow: none;

		a{
			box-shadow: none;
			background: none;

			&::before{
				box-shadow: none;
				background-color: rgba(255,255,255,0.05);
			}

			&::after{
				border-width: 0;
				box-shadow: none;
				opacity: 0.2;
				background: currentcolor;
			}

			&:hover:after{
                opacity: 0.3;
            }

            &:active:after{
                opacity: 0.4;
            }
		}
	}
	.social-footer-basic(@social-footer-basic);
}


';
	}
	$__finalCompiled .= '



/*
	----------------
	- Background Picker
	----------------
*/

.focus-background-1(){
    ';
	if ($__templater->func('property', array('xenfocus_bg1_hex', ), false)) {
		$__finalCompiled .= '
		background-color: @xf-xenfocus_bg1_hex;
    ';
	}
	$__finalCompiled .= '
    ';
	if ($__templater->func('property', array('xenfocus_bg1_image', ), false)) {
		$__finalCompiled .= '
		background-image: url(@xf-xenfocus_bg1_image?v=@xf-xenfocus_cache);
		';
		if ($__templater->func('property', array('xenfocus_bg1_size', ), false)) {
			$__finalCompiled .= '
			background-size: @xf-xenfocus_bg1_size;
	    ';
		}
		$__finalCompiled .= '
	    ';
		if ($__templater->func('property', array('xenfocus_bg1_position', ), false)) {
			$__finalCompiled .= '
			background-position: @xf-xenfocus_bg1_position;
	    ';
		}
		$__finalCompiled .= '
	    background-repeat: @xf-xenfocus_bg1_repeat;
	    background-attachment: @xf-xenfocus_bg1_attachment;
    ';
	}
	$__finalCompiled .= '
}

.focus-background-2(){
    ';
	if ($__templater->func('property', array('xenfocus_bg2_hex', ), false)) {
		$__finalCompiled .= '
		background-color: @xf-xenfocus_bg2_hex;
    ';
	}
	$__finalCompiled .= '
    ';
	if ($__templater->func('property', array('xenfocus_bg2_image', ), false)) {
		$__finalCompiled .= '
		background-image: url(@xf-xenfocus_bg2_image?v=@xf-xenfocus_cache);
		';
		if ($__templater->func('property', array('xenfocus_bg2_size', ), false)) {
			$__finalCompiled .= '
			background-size: @xf-xenfocus_bg2_size;
	    ';
		}
		$__finalCompiled .= '
	    ';
		if ($__templater->func('property', array('xenfocus_bg2_position', ), false)) {
			$__finalCompiled .= '
			background-position: @xf-xenfocus_bg2_position;
	    ';
		}
		$__finalCompiled .= '
	    background-repeat: @xf-xenfocus_bg2_repeat;
	    background-attachment: @xf-xenfocus_bg2_attachment;
    ';
	}
	$__finalCompiled .= '
}

.focus-background-3(){
    ';
	if ($__templater->func('property', array('xenfocus_bg3_hex', ), false)) {
		$__finalCompiled .= '
		background-color: @xf-xenfocus_bg3_hex;
    ';
	}
	$__finalCompiled .= '
    ';
	if ($__templater->func('property', array('xenfocus_bg3_image', ), false)) {
		$__finalCompiled .= '
		background-image: url(@xf-xenfocus_bg3_image?v=@xf-xenfocus_cache);
		';
		if ($__templater->func('property', array('xenfocus_bg3_size', ), false)) {
			$__finalCompiled .= '
			background-size: @xf-xenfocus_bg3_size;
	    ';
		}
		$__finalCompiled .= '
	    ';
		if ($__templater->func('property', array('xenfocus_bg3_position', ), false)) {
			$__finalCompiled .= '
			background-position: @xf-xenfocus_bg3_position;
	    ';
		}
		$__finalCompiled .= '
	    background-repeat: @xf-xenfocus_bg3_repeat;
	    background-attachment: @xf-xenfocus_bg3_attachment;
    ';
	}
	$__finalCompiled .= '
}

.focus-background-4(){
    ';
	if ($__templater->func('property', array('xenfocus_bg4_hex', ), false)) {
		$__finalCompiled .= '
		background-color: @xf-xenfocus_bg4_hex;
    ';
	}
	$__finalCompiled .= '
    ';
	if ($__templater->func('property', array('xenfocus_bg4_image', ), false)) {
		$__finalCompiled .= '
		background-image: url(@xf-xenfocus_bg4_image?v=@xf-xenfocus_cache);
		';
		if ($__templater->func('property', array('xenfocus_bg4_size', ), false)) {
			$__finalCompiled .= '
			background-size: @xf-xenfocus_bg4_size;
	    ';
		}
		$__finalCompiled .= '
	    ';
		if ($__templater->func('property', array('xenfocus_bg4_position', ), false)) {
			$__finalCompiled .= '
			background-position: @xf-xenfocus_bg4_position;
	    ';
		}
		$__finalCompiled .= '
	    background-repeat: @xf-xenfocus_bg4_repeat;
	    background-attachment: @xf-xenfocus_bg4_attachment;
    ';
	}
	$__finalCompiled .= '
}

.focus-background-5(){
    ';
	if ($__templater->func('property', array('xenfocus_bg5_hex', ), false)) {
		$__finalCompiled .= '
		background-color: @xf-xenfocus_bg5_hex;
    ';
	}
	$__finalCompiled .= '
    ';
	if ($__templater->func('property', array('xenfocus_bg5_image', ), false)) {
		$__finalCompiled .= '
		background-image: url(@xf-xenfocus_bg5_image?v=@xf-xenfocus_cache);
		';
		if ($__templater->func('property', array('xenfocus_bg5_size', ), false)) {
			$__finalCompiled .= '
			background-size: @xf-xenfocus_bg5_size;
	    ';
		}
		$__finalCompiled .= '
	    ';
		if ($__templater->func('property', array('xenfocus_bg5_position', ), false)) {
			$__finalCompiled .= '
			background-position: @xf-xenfocus_bg5_position;
	    ';
		}
		$__finalCompiled .= '
	    background-repeat: @xf-xenfocus_bg5_repeat;
	    background-attachment: @xf-xenfocus_bg5_attachment;
    ';
	}
	$__finalCompiled .= '
}

.focus-background-6(){
    ';
	if ($__templater->func('property', array('xenfocus_bg6_hex', ), false)) {
		$__finalCompiled .= '
		background-color: @xf-xenfocus_bg6_hex;
    ';
	}
	$__finalCompiled .= '
    ';
	if ($__templater->func('property', array('xenfocus_bg6_image', ), false)) {
		$__finalCompiled .= '
		background-image: url(@xf-xenfocus_bg6_image?v=@xf-xenfocus_cache);
		';
		if ($__templater->func('property', array('xenfocus_bg6_size', ), false)) {
			$__finalCompiled .= '
			background-size: @xf-xenfocus_bg6_size;
	    ';
		}
		$__finalCompiled .= '
	    ';
		if ($__templater->func('property', array('xenfocus_bg6_position', ), false)) {
			$__finalCompiled .= '
			background-position: @xf-xenfocus_bg6_position;
	    ';
		}
		$__finalCompiled .= '
	    background-repeat: @xf-xenfocus_bg6_repeat;
	    background-attachment: @xf-xenfocus_bg6_attachment;
    ';
	}
	$__finalCompiled .= '
}

.focus-background-7(){
    ';
	if ($__templater->func('property', array('xenfocus_bg7_hex', ), false)) {
		$__finalCompiled .= '
		background-color: @xf-xenfocus_bg7_hex;
    ';
	}
	$__finalCompiled .= '
    ';
	if ($__templater->func('property', array('xenfocus_bg7_image', ), false)) {
		$__finalCompiled .= '
		background-image: url(@xf-xenfocus_bg7_image?v=@xf-xenfocus_cache);
		';
		if ($__templater->func('property', array('xenfocus_bg7_size', ), false)) {
			$__finalCompiled .= '
			background-size: @xf-xenfocus_bg7_size;
	    ';
		}
		$__finalCompiled .= '
	    ';
		if ($__templater->func('property', array('xenfocus_bg7_position', ), false)) {
			$__finalCompiled .= '
			background-position: @xf-xenfocus_bg7_position;
	    ';
		}
		$__finalCompiled .= '
	    background-repeat: @xf-xenfocus_bg7_repeat;
	    background-attachment: @xf-xenfocus_bg7_attachment;
    ';
	}
	$__finalCompiled .= '
}

.focus-background-8(){
    ';
	if ($__templater->func('property', array('xenfocus_bg8_hex', ), false)) {
		$__finalCompiled .= '
		background-color: @xf-xenfocus_bg8_hex;
    ';
	}
	$__finalCompiled .= '
    ';
	if ($__templater->func('property', array('xenfocus_bg8_image', ), false)) {
		$__finalCompiled .= '
		background-image: url(@xf-xenfocus_bg8_image?v=@xf-xenfocus_cache);
		';
		if ($__templater->func('property', array('xenfocus_bg8_size', ), false)) {
			$__finalCompiled .= '
			background-size: @xf-xenfocus_bg8_size;
	    ';
		}
		$__finalCompiled .= '
	    ';
		if ($__templater->func('property', array('xenfocus_bg8_position', ), false)) {
			$__finalCompiled .= '
			background-position: @xf-xenfocus_bg8_position;
	    ';
		}
		$__finalCompiled .= '
	    background-repeat: @xf-xenfocus_bg8_repeat;
	    background-attachment: @xf-xenfocus_bg8_attachment;
    ';
	}
	$__finalCompiled .= '
}

.focus-background-9(){
    ';
	if ($__templater->func('property', array('xenfocus_bg9_hex', ), false)) {
		$__finalCompiled .= '
		background-color: @xf-xenfocus_bg9_hex;
    ';
	}
	$__finalCompiled .= '
    ';
	if ($__templater->func('property', array('xenfocus_bg9_image', ), false)) {
		$__finalCompiled .= '
		background-image: url(@xf-xenfocus_bg9_image?v=@xf-xenfocus_cache);
		';
		if ($__templater->func('property', array('xenfocus_bg9_size', ), false)) {
			$__finalCompiled .= '
			background-size: @xf-xenfocus_bg9_size;
	    ';
		}
		$__finalCompiled .= '
	    ';
		if ($__templater->func('property', array('xenfocus_bg9_position', ), false)) {
			$__finalCompiled .= '
			background-position: @xf-xenfocus_bg9_position;
	    ';
		}
		$__finalCompiled .= '
	    background-repeat: @xf-xenfocus_bg9_repeat;
	    background-attachment: @xf-xenfocus_bg9_attachment;
    ';
	}
	$__finalCompiled .= '
}

.focus-background-10(){
    ';
	if ($__templater->func('property', array('xenfocus_bg10_hex', ), false)) {
		$__finalCompiled .= '
		background-color: @xf-xenfocus_bg10_hex;
    ';
	}
	$__finalCompiled .= '
    ';
	if ($__templater->func('property', array('xenfocus_bg10_image', ), false)) {
		$__finalCompiled .= '
		background-image: url(@xf-xenfocus_bg10_image?v=@xf-xenfocus_cache);
		';
		if ($__templater->func('property', array('xenfocus_bg10_size', ), false)) {
			$__finalCompiled .= '
			background-size: @xf-xenfocus_bg10_size;
	    ';
		}
		$__finalCompiled .= '
	    ';
		if ($__templater->func('property', array('xenfocus_bg10_position', ), false)) {
			$__finalCompiled .= '
			background-position: @xf-xenfocus_bg10_position;
	    ';
		}
		$__finalCompiled .= '
	    background-repeat: @xf-xenfocus_bg10_repeat;
	    background-attachment: @xf-xenfocus_bg10_attachment;
    ';
	}
	$__finalCompiled .= '
}


';
	if ($__templater->func('property', array('xenfocus_picker', ), false)) {
		$__finalCompiled .= '

.focus-picker{
    display: flex;
	align-items: center;
	justify-content: space-between;
	padding: 15px;
	
	span{
		flex: 1 1 auto;
		display: block;
		position: relative;
        background-color: @xf-pageBg;
		background-size: cover;
		background-position: 50% 50% ;
		border-radius: 4px;
		box-shadow: rgba(0,0,0,0.08) 0px 5px 10px;
		color: #fff;
		font-size: 1.45rem;
		text-shadow: rgba(0,0,0,0.3) 0px 2px 3px;
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
		user-select: none;
		max-height: 140px;
		margin: 5px;
		text-align: center;
		cursor: pointer;
		overflow: hidden;
		transition: transform 0.1s ease-in-out;

		&:active{
			//transform:scale(0.95);
			//transform-origin: 50% 50%;
			//transform: translateY(2px);
		}

		// Hide thumbnails when editor is hidden to prevent the images from loading
		html:not(.focus-picker--loaded) &{
			background-image: none !important;
		}

		// Size
		&::before{
			content: \'\';
			display: block;
			padding-bottom: 100%;
		}

		// Border
		&::after{
			content: \'\';
			position: absolute; top: 0; left: 0; right: 0; bottom: 0;
			border: 1px solid fade(@xf-textColor, 15%);
			border-radius: inherit;
			';
		if ($__templater->func('property', array('styleType', ), false) == 'light') {
			$__finalCompiled .= '
				box-shadow: inset rgba(255,255,255,0.15) 0px 1px 0px;
			';
		}
		$__finalCompiled .= '
		}

		i{
			position: absolute; top: 0; left: 0; right: 0; bottom: 0;
			border-radius: inherit;
			overflow: hidden;
		
			&::before{
				display: block;
				/*
				display: flex;
				align-items: center;
				justify-content: center;
				.m-faBase();
        		.m-faContent(@fa-var-check);
				font-size: 36px;
				line-height: 1;
				-webkit-font-smoothing: antialiased;
				-moz-osx-font-smoothing: grayscale;
				*/
				content: \'\';
				position: absolute;
				left: 0; right: 0;
				top: 0; bottom: 0;
				// top: -20px; bottom: -20px;
				// transform: translateY(20px);
				transition: all 0.1s ease-in-out;
				opacity: 0;
				background: rgba(255,255,255,0.2);
				pointer-events: none;
			}
		}
		@media screen and (min-width: 980px){
			&:hover i::before{
				// transform: translateY(0);
				opacity: 0.8;
			}
		}
	}
	
    // Apply border to selected thumbnail
    ';
		if ($__templater->func('property', array('xenfocus_bg1_enable', ), false)) {
			$__finalCompiled .= 'html[data-focus-bg="1"] & [data-focus-bg="1"]::after,';
		}
		$__finalCompiled .= '
	';
		if ($__templater->func('property', array('xenfocus_bg2_enable', ), false)) {
			$__finalCompiled .= 'html[data-focus-bg="2"] & [data-focus-bg="2"]::after,';
		}
		$__finalCompiled .= '
	';
		if ($__templater->func('property', array('xenfocus_bg3_enable', ), false)) {
			$__finalCompiled .= 'html[data-focus-bg="3"] & [data-focus-bg="3"]::after,';
		}
		$__finalCompiled .= '
	';
		if ($__templater->func('property', array('xenfocus_bg4_enable', ), false)) {
			$__finalCompiled .= 'html[data-focus-bg="4"] & [data-focus-bg="4"]::after,';
		}
		$__finalCompiled .= '
	';
		if ($__templater->func('property', array('xenfocus_bg5_enable', ), false)) {
			$__finalCompiled .= 'html[data-focus-bg="5"] & [data-focus-bg="5"]::after,';
		}
		$__finalCompiled .= '
	';
		if ($__templater->func('property', array('xenfocus_bg6_enable', ), false)) {
			$__finalCompiled .= 'html[data-focus-bg="6"] & [data-focus-bg="6"]::after,';
		}
		$__finalCompiled .= '
	';
		if ($__templater->func('property', array('xenfocus_bg7_enable', ), false)) {
			$__finalCompiled .= 'html[data-focus-bg="7"] & [data-focus-bg="7"]::after,';
		}
		$__finalCompiled .= '
	';
		if ($__templater->func('property', array('xenfocus_bg8_enable', ), false)) {
			$__finalCompiled .= 'html[data-focus-bg="8"] & [data-focus-bg="8"]::after,';
		}
		$__finalCompiled .= '
	';
		if ($__templater->func('property', array('xenfocus_bg9_enable', ), false)) {
			$__finalCompiled .= 'html[data-focus-bg="9"] & [data-focus-bg="9"]::after,';
		}
		$__finalCompiled .= '
	';
		if ($__templater->func('property', array('xenfocus_bg10_enable', ), false)) {
			$__finalCompiled .= 'html[data-focus-bg="10"] & [data-focus-bg="10"]::after,';
		}
		$__finalCompiled .= '
	.focus-null{
		border-width: 7px;
		border-color: fade(@xf-textColor, 40%);
		';
		if ($__templater->func('property', array('styleType', ), false) == 'dark') {
			$__finalCompiled .= '
			box-shadow: inset rgba(0,0,0,0.3) 0px 0px 0px 1px;
		';
		} else {
			$__finalCompiled .= '
			box-shadow: inset rgba(255,255,255,0.2) 0px 0px 0px 1px;
		';
		}
		$__finalCompiled .= '
	}
}

@supports(display:grid){
	.focus-picker{
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(60px, 1fr));
		grid-gap: 10px;
		gap: 10px;

		span{
			margin: 0;
		}
	}
}

';
		if ($__templater->func('property', array('xenfocus_bg1_enable', ), false)) {
			$__finalCompiled .= '
.focus-picker [data-focus-bg=\'1\']{
    .focus-background-1();
}
';
		}
		$__finalCompiled .= '

';
		if ($__templater->func('property', array('xenfocus_bg2_enable', ), false)) {
			$__finalCompiled .= '
	.focus-picker [data-focus-bg=\'2\']{
	    .focus-background-2();
	}
';
		}
		$__finalCompiled .= '

';
		if ($__templater->func('property', array('xenfocus_bg3_enable', ), false)) {
			$__finalCompiled .= '
	.focus-picker [data-focus-bg=\'3\']{
		.focus-background-3();
	}
';
		}
		$__finalCompiled .= '

';
		if ($__templater->func('property', array('xenfocus_bg4_enable', ), false)) {
			$__finalCompiled .= '
	.focus-picker [data-focus-bg=\'4\']{
		.focus-background-4();
	}
';
		}
		$__finalCompiled .= '

';
		if ($__templater->func('property', array('xenfocus_bg5_enable', ), false)) {
			$__finalCompiled .= '
	.focus-picker [data-focus-bg=\'5\']{
		.focus-background-5();
	}
';
		}
		$__finalCompiled .= '

';
		if ($__templater->func('property', array('xenfocus_bg6_enable', ), false)) {
			$__finalCompiled .= '
	.focus-picker [data-focus-bg=\'6\']{
		.focus-background-6();
	}
';
		}
		$__finalCompiled .= '

';
		if ($__templater->func('property', array('xenfocus_bg7_enable', ), false)) {
			$__finalCompiled .= '
	.focus-picker [data-focus-bg=\'7\']{
		.focus-background-7();
	}
';
		}
		$__finalCompiled .= '

';
		if ($__templater->func('property', array('xenfocus_bg8_enable', ), false)) {
			$__finalCompiled .= '
	.focus-picker [data-focus-bg=\'8\']{
		.focus-background-8();
	}
';
		}
		$__finalCompiled .= '

';
		if ($__templater->func('property', array('xenfocus_bg9_enable', ), false)) {
			$__finalCompiled .= '
	.focus-picker [data-focus-bg=\'9\']{
		.focus-background-9();
	}
';
		}
		$__finalCompiled .= '

';
		if ($__templater->func('property', array('xenfocus_bg10_enable', ), false)) {
			$__finalCompiled .= '
	.focus-picker [data-focus-bg=\'10\']{
		.focus-background-10();
	}
';
		}
		$__finalCompiled .= '

// Make sure thumbnail images aren\'t fixed
.focus-picker span[data-focus-bg]{
	background-attachment: scroll;
}


';
	}
	$__finalCompiled .= '
	


/*
	----------------
	- Content wrapper
	----------------
*/

// Wrap all content
.focus-wrapper(){}

.focus-wrapper{

	@media (min-width: (@xf-responsiveMedium + 1px)){
		flex: 1 1 auto;
		display: flex;
		flex-direction: column;
		> *{
			flex: 0 0 auto;
		}
	}

	.focus-wrapper();
}

.focus-content(){}
.focus-content{

	@media (min-width: (@xf-responsiveMedium + 1px)){
		flex-grow: 1;
		display: flex;
		flex-direction: column;
		position: relative;

		// If the content is wrapped, a margin is presumably required
		';
	if ($__templater->func('property', array('xenfocus_wrapperStyles--background-color', ), false)) {
		$__finalCompiled .= '
			.focus-width &{
				margin-bottom: 10px;
			}	
		';
	}
	$__finalCompiled .= '
	}

	.focus-content();
}

// Remove borders and border-radius for mobiles
@media (max-width: @xf-responsiveMedium){
	.focus-wrapper,
	.focus-content{
		border-radius: 0;
		border-width: 0;
	}
}

.p-body-inner{
	padding: 10px;

	@media (min-width: (@xf-responsiveEdgeSpacerRemoval + 1px)){
		padding: @content-padding 0;
		// Ensure content doesn\'t touch the edges of the browser when in desktop view
		width: ~"calc(100vw - (@xf-pageEdgeSpacer * 2))";

		';
	if ($__templater->func('property', array('xenfocus_wrapperStyles--background-color', ), false)) {
		$__finalCompiled .= '
	    	.focus-width &{
			    padding-left: @content-padding;
			    padding-right: @content-padding;
		   }		
		';
	}
	$__finalCompiled .= '
	}
}

// Inherit border-radius on child elements, just because..
.p-body, .p-body-inner{ border-radius: inherit; }



/*
	----------------
	- Nodes
	----------------
*/

// Make subforum icons inherit link colour when they\'re displayed in a list
.subNodeLink::before,
.subNodeLink.subNodeLink--unread::before,
.subNodeLink .subNodeLink-icon{
	text-shadow: none;
	color: inherit;
}

.subNodeLink::before{
	width: 1.5em;
	padding-right: 0px;
}

// Subforum grid
.subforum-grid(@debug) when (@debug = true) {

    @supports (display: grid){
		.node-subNodeFlatList{
			display: grid;
			grid-gap: 10px;
			grid-template-columns: repeat(auto-fill, minmax(@subforum-width, 1fr));

			&::before,
			&::after{
				display: none;
			}

			> li{
				margin: 0;
			}

			a{
				display: block;
				overflow: hidden;
				text-overflow: ellipsis;
				white-space: nowrap;
			}
		}
	}

}
.subforum-grid(@subforum-grid);

// Add spacer between stats on smaller screens, when not using grid
@media (max-width: 1000px){
	
	.node-statsMeta{
		margin-right: 20px;

		dl:not(:last-child):after{
			content: \'/\';
			margin: 0 10px;
			opacity: 0.2;
		}
	}

}

.node-title{
	font-size: (@xf-fontSizeNormal+1);
}

.node-bold-title(@debug) when (@debug = true) {

    .node-title a{
		font-weight: bold;
	}

}
.node-bold-title(@node-bold-title);

// Bold topic title
.node-extra-title{
	font-weight: 600;
}


//@media (min-width: (@xf-responsiveMedium + 1px)){

	.node-extra .node-extra-row .listInline{
		overflow: hidden;
		text-overflow: ellipsis;
	}

//}

// Inherit colour for latest username
.node-extra-user a{
	color: inherit;
}

// Add small margin between last topic title and username
@media (min-width: (@xf-responsiveMedium + 1px)){
	.node-extra-row + .node-extra-row{
		margin-top: 3px;
	}
}

@media (max-width: @xf-responsiveMedium){
	.node-extra-row:not(:last-child){
		margin-right: 4px;
	}
}

// Larger topic and post stats
.node-alt-stats(@debug) when (@debug = true) {

    .node-stats .pairs{
		display: flex;
		flex-direction: column;

		dd{
			font-size: 16px;
			line-height: 1.2;
		}
		dt{
			order: 2;
		}
	}

}
.node-alt-stats(@node-alt-stats);


';
	if ($__templater->func('property', array('xenfocus_zebra', ), false)) {
		$__finalCompiled .= '
    .block-body > .node:nth-of-type(even),
    .structItemContainer-group > .structItem--thread:not(.is-highlighted):not(.is-moderated):not(.is-mod-selected):nth-of-type(even){
		background-color: @node-zebra-color;
	}
';
	}
	$__finalCompiled .= '

// Round off last topic to prevent square corner. Visible when zebra striping is enabled.
.structItem:last-child{
	border-bottom-left-radius: @xf-blockBorderRadius;
	border-bottom-right-radius: @xf-blockBorderRadius;
}




/*
	----------------
	- Node cell spacing
	----------------
*/

.node-body{
	padding: @node-extra-padding;
}

/*
	----------------
	- Node icons
	----------------
*/

';
	if ($__templater->func('property', array('xenfocus_iconStyles--color', ), false)) {
		$__finalCompiled .= '
	@node-icon-unread-color: @xf-xenfocus_iconStyles--color;
';
	} else {
		$__finalCompiled .= '
	@node-icon-unread-color: inherit;
';
	}
	$__finalCompiled .= '

';
	if ($__templater->func('property', array('xenfocus_iconStyles--background-color', ), false)) {
		$__finalCompiled .= '
	@node-icon-unread-background: @xf-xenfocus_iconStyles--background-color;
';
	} else {
		$__finalCompiled .= '
	@node-icon-unread-background: transparent;
';
	}
	$__finalCompiled .= '

.node-icon{
    width: @xf-xenfocus_iconWidth*1px;
    box-sizing: content-box;
    padding-right: @node-extra-padding;
    
    i{
        line-height: 1;
        height: @xf-xenfocus_iconHeight*1px;
        width: @xf-xenfocus_iconWidth*1px;
        display: flex;
        align-items: center;
        justify-content: center;  
        ';
	if ($__templater->func('property', array('xenfocus_iconStyles--font-size', ), false)) {
		$__finalCompiled .= '
        	font-size: @xf-xenfocus_iconStyles--font-size;
        ';
	}
	$__finalCompiled .= '
        ';
	if ($__templater->func('property', array('xenfocus_iconStyles--color', ), false)) {
		$__finalCompiled .= '
        	color: @xf-xenfocus_iconStyles--color;
        ';
	}
	$__finalCompiled .= '
        ';
	if ($__templater->func('property', array('xenfocus_iconStyles--border-radius', ), false)) {
		$__finalCompiled .= '
        	border-radius: @xf-xenfocus_iconStyles--border-radius;
        ';
	}
	$__finalCompiled .= '
        ';
	if ($__templater->func('property', array('xenfocus_iconStyles--background-color', ), false)) {
		$__finalCompiled .= '
        	background-color: @xf-xenfocus_iconStyles--background-color;
        ';
	}
	$__finalCompiled .= '
        ';
	if ($__templater->func('property', array('xenfocus_iconStyles--extra', ), false)) {
		$__finalCompiled .= '
        	@xf-xenfocus_iconStyles--extra;
        ';
	}
	$__finalCompiled .= '
        // .xf-xenfocus_iconStyles();

        html[data-logged-in="true"] .node--read &,
    	html[data-logged-in="true"] .node--link &,
    	html[data-logged-in="true"] .node--page &{
    		';
	if ($__templater->func('property', array('xenfocus_iconRead--font-size', ), false)) {
		$__finalCompiled .= '
	        	font-size: @xf-xenfocus_iconRead--font-size;
	        ';
	}
	$__finalCompiled .= '
	        ';
	if ($__templater->func('property', array('xenfocus_iconRead--color', ), false)) {
		$__finalCompiled .= '
	        	color: @xf-xenfocus_iconRead--color;
	        ';
	}
	$__finalCompiled .= '
	        ';
	if ($__templater->func('property', array('xenfocus_iconRead--border-radius', ), false)) {
		$__finalCompiled .= '
	        	border-radius: @xf-xenfocus_iconRead--border-radius;
	        ';
	}
	$__finalCompiled .= '
	        ';
	if ($__templater->func('property', array('xenfocus_iconRead--background-color', ), false)) {
		$__finalCompiled .= '
	        	background-color: @xf-xenfocus_iconRead--background-color;
	        ';
	}
	$__finalCompiled .= '
	        ';
	if ($__templater->func('property', array('xenfocus_iconRead--extra', ), false)) {
		$__finalCompiled .= '
	        	@xf-xenfocus_iconRead--extra;
	        ';
	}
	$__finalCompiled .= '
    		// .xf-xenfocus_iconRead();
        }
        
        .p-body &::before{
            text-shadow: inherit;
            color: inherit;
            display: block;
            text-align: center;
            width: auto;
            line-height: inherit;
        }
    } 

    /* On mobiles.. */
	';
	if ($__templater->func('property', array('xenfocus_iconMobile', ), false)) {
		$__finalCompiled .= '
	@media (max-width: @xf-responsiveNarrow){

		width: @xf-xenfocus_iconWidth*@xf-xenfocus_iconMobile*1px;

		& i{
			transform: scale(@xf-xenfocus_iconMobile);
			transform-origin: 0 50%;
		}

	}
	';
	}
	$__finalCompiled .= '
}


/* Assign FontAwesome icon to nodes */
';
	if ($__templater->func('property', array('xenfocus_iconFA', ), false)) {
		$__finalCompiled .= '
	.node--forum .fa-comments::before,
	.node--category .fa-comments::before{
		content: \'\\@xf-xenfocus_iconFA\';
	}
	.node--unread .node-icon .far::before{
		font-weight: @xf-xenfocus_iconWeight;
	}
';
	}
	$__finalCompiled .= '

';
	if ($__templater->func('property', array('xenfocus_iconFAold', ), false)) {
		$__finalCompiled .= '
	html[data-logged-in="true"] .node--read .fa-comments::before{
		content: \'\\@xf-xenfocus_iconFAold\';
	}
	.node--read .node-icon .far::before{
		font-weight: @xf-xenfocus_iconWeightOld;
	}
';
	}
	$__finalCompiled .= '


/* If an image is uploaded, apply it and remove potential other styles */
';
	if ($__templater->func('property', array('xenfocus_iconStyles--background-image', ), false)) {
		$__finalCompiled .= '
#XF{

	.node-icon i{
		background-color: transparent;
		background-image: @xf-xenfocus_iconStyles--background-image;
		background-repeat: no-repeat;
		background-position: 50% 50%;
		background-size: contain;
		border-radius: 0;
		box-shadow: none;

		&::before{
			display: none;
		}
	}

	html[data-logged-in=\'true\']& .node--read .node-icon i{
		';
		if ($__templater->func('property', array('xenfocus_iconRead--background-image', ), false)) {
			$__finalCompiled .= '
			background-image: url(\'@xf-xenfocus_iconRead--background-image\');
		';
		} else {
			$__finalCompiled .= '
			filter: @node-icon-read-filter;
			opacity: @node-icon-read-opacity;
		';
		}
		$__finalCompiled .= '
	}

}
';
	}
	$__finalCompiled .= '


/*
	----------------
	- Node NEW badge
	----------------
*/

.node--unread .node-title::before{
	display: none;
}

';
	if ($__templater->func('property', array('xenfocus_new_badge', ), false)) {
		$__finalCompiled .= '
    .node-title a{
		vertical-align: middle;
	}

		html[data-logged-in=\'true\'] .node--unread .node-title::before{
			color: @new-badge-color;
			color: var(--new-badge-color, @new-badge-color);
			background: @new-badge-background;
			background: var(--new-badge-background, @new-badge-background);
			display: inline-block;
			font-size: 9px;
			line-height: 2;
			border-radius: 3px;
			padding: 0 4px;
			margin-right: 4px;
			vertical-align: middle;
		}

';
	}
	$__finalCompiled .= '


/*
	----------------
	- Minimal nodes and topic lists, with hover
	----------------
*/

// Minimal layout with hover rows
@nodeHover-padding: 0px;
@nodeHover-opacity: 0.06;
@nodeHover-background: @xf-linkColor;

';
	if ($__templater->func('property', array('xenfocus_tableLayout', ), false) != 'standard') {
		$__finalCompiled .= '

@media (min-width: (@xf-responsiveMedium + 1px)){

	/* .block--category{

		';
		if ($__templater->func('property', array('xenfocus_tableLayout', ), false) == 'minimal') {
			$__finalCompiled .= '
			// Increase padding of index boxes
			.block-body{
				padding: @nodeHover-padding 0;
			}
		';
		}
		$__finalCompiled .= '

		// Add background hover effect
		.node{
			position: relative;
			';
		if ($__templater->func('property', array('xenfocus_tableLayout', ), false) == 'minimal') {
			$__finalCompiled .= '
				border-radius: @xf-blockBorderRadius;
				border: 0;
			';
		}
		$__finalCompiled .= '

			&::before{
				content: \'\';
				position: absolute;
				top: 0; bottom: 0;
				';
		if ($__templater->func('property', array('xenfocus_tableLayout', ), false) == 'minimal') {
			$__finalCompiled .= '
				left: @nodeHover-padding; right: @nodeHover-padding;
				';
		} else {
			$__finalCompiled .= '
				left: 0; right: 0;
				';
		}
		$__finalCompiled .= '
				border-radius: inherit;
				background: @nodeHover-background;
				opacity: 0;
			}

			&:hover::before{
				opacity: @nodeHover-opacity;
			}
		}

		.node-body{
			position: relative;
		}

		
		// Clickable rows
		';
		if ($__templater->func('property', array('nodeListDescriptionDisplay', ), false) != 'tooltip') {
			$__finalCompiled .= '
			.node a{
				position: relative;
				z-index: 2;
			}

			.node-title a{
				position: static;
				&::after{
					content: \'\';
					top: 0; left: 0; right: 0; bottom: 0;
					position: absolute;
					z-index: 1;
					// Potentially helps with Safari bug but not sure
					transform: translate(0,0);
				}
			}	
		';
		}
		$__finalCompiled .= '

	} */

	.node{

		position: relative;
		';
		if ($__templater->func('property', array('xenfocus_tableLayout', ), false) == 'minimal') {
			$__finalCompiled .= '
			border-radius: @xf-blockBorderRadius;
			// The inline-block style prevents margins from collapsing
			display: inline-block;
			width: 100%;
			vertical-align: top;

			& + .node{
				border-width: 0;
			}

			&:first-child{
				margin-top: @nodeHover-padding;
			}
			&:last-child{
				margin-bottom: @nodeHover-padding;
			}
		';
		}
		$__finalCompiled .= '

		&::before{
			content: \'\';
			position: absolute;
			top: 0; bottom: 0;
			';
		if ($__templater->func('property', array('xenfocus_tableLayout', ), false) == 'minimal') {
			$__finalCompiled .= '
				left: @nodeHover-padding; right: @nodeHover-padding;
			';
		} else {
			$__finalCompiled .= '
				left: 0; right: 0;
			';
		}
		$__finalCompiled .= '
			border-radius: inherit;
			background: @nodeHover-background;
			opacity: 0;
		}

		&:hover::before{
			opacity: @nodeHover-opacity;
		}

		.node-body{
			position: relative;
		}

		
		// Clickable rows
		';
		if ($__templater->func('property', array('nodeListDescriptionDisplay', ), false) != 'tooltip') {
			$__finalCompiled .= '
			a{
				position: relative;
				z-index: 2;
			}

			.node-title a{
				position: static;
				&::after{
					content: \'\';
					top: 0; left: 0; right: 0; bottom: 0;
					position: absolute;
					z-index: 1;
					// Potentially helps with Safari bug but not sure
					transform: translate(0,0);
				}
			}
		
			.iconic{
				z-index: 10;
			}
		';
		}
		$__finalCompiled .= '

	}



	';
		if ($__templater->func('property', array('xenfocus_tableLayout', ), false) == 'minimal') {
			$__finalCompiled .= '
		html .structItemContainer-group--sticky{
			&::before,
			&::after{
				margin: @nodeHover-padding -@nodeHover-padding;
				border-width: 1px 0;
			}

			&::before{
				margin-top: -@nodeHover-padding;
			}
			&::after{
				margin-bottom: -@nodeHover-padding;
			}
		}

		.structItemContainer-group,
		form.structItem{
			padding: @nodeHover-padding;
		}
	';
		}
		$__finalCompiled .= '

	.structItem{
		';
		if ($__templater->func('property', array('xenfocus_tableLayout', ), false) == 'minimal') {
			$__finalCompiled .= '
			border-width: 0;
			border-radius: @xf-blockBorderRadius;
		';
		}
		$__finalCompiled .= '
		display: flex;
		align-items: center;
		position: relative;

		> *{
			flex: 0 0 auto;
			position: relative;
			display: block;
			min-width: 0;
		}

		.structItem-cell--main,
		.structItem-cell--newThread{
			flex: 1 1 auto;
		}

		.structItemContainer-group &{	

			&::before{
				content: \'\';
				position: absolute;
				top: 0; left: 0; right: 0; bottom: 0;
				border-radius: inherit;
				background: @nodeHover-background;
				opacity: 0;
			}

			&:hover::before{
				opacity: @nodeHover-opacity;
			}
		}
	}
}
';
	}
	$__finalCompiled .= '


/*
	----------------
	- Guest message
	----------------
*/

.xenfocus_guestStyle(){};
.xenfocus_guestInternalStyle(){};
.xenfocus_guestWallpaper(){};

';
	if ($__templater->func('property', array('xenfocus_guestEnable', ), false)) {
		$__finalCompiled .= '

.focus-guest{
	border-radius: @xf-borderRadiusMedium;
	margin-bottom: 10px;
	padding: 5px;
	padding-bottom: 0;
	// Hide message on certain pages
	.template-login &,
	.template-register_form &,
	.template-lost_password{
		display: none;
	}

	a{
		color: inherit;
	}

	.focus-guest-content{
		padding: 15px;
		flex: 1 1 auto;

		p{
			margin: 0.6em 0;
		}

		& p:first-child{
			margin-top: 0;
		}

		& p:last-child{
			margin-bottom: 0;
		}
	}

	.focus-guest-buttons{
		flex: 0 0 auto;
		display: flex;
		align-items: center;
		justify-content: center;
		list-style: none;
		font-size: @xf-fontSizeNormal;
		font-weight: bold;
		//text-transform: uppercase;
		margin: 0;
		padding: 0;

		li{
			flex: 0 0 auto;
			padding: 0;
			margin: 0 4px;
		}

		a{
			display: flex;
			align-items: center;
			text-decoration: none;
			border-radius: 3px;
			position: relative;

			&:active{
				top: 1px;
			}

			&::before{
				.m-faBase();
        		.m-faContent(@fa-var-plus);
				font-size: 14px;
				border-radius: inherit;
				border-top-right-radius: 0;
				border-bottom-right-radius: 0;
			}

			&[href$="login/"]::before{
				.m-faContent(@fa-var-key);
			}

			&::after{
				content: \'\';
				position: absolute;
				top: 0;
				right: 0;
				bottom: 0;
				left: 0;
				pointer-events: none;
				border-radius: inherit;
			}
		}
	}


	&.focus-guest-alert{
		padding: 0px;

		.xf-xenfocus_guestStyle();
		';
		if ($__templater->func('property', array('xenfocus_guestStyle--background-color', ), false)) {
			$__finalCompiled .= '
			border: 1px solid xf-intensify(@xf-xenfocus_guestStyle--background-color, 20%);
			border-bottom-color: xf-intensify(@xf-xenfocus_guestStyle--background-color, 30%);
		';
		}
		$__finalCompiled .= '
		.xenfocus_guestStyle();

		.focus-guest-header{
			/*
			.xf-xenfocus_guestInternalStyle();
			';
		if ($__templater->func('property', array('xenfocus_guestInternalStyle--background-color', ), false)) {
			$__finalCompiled .= '
				background-image: linear-gradient(to top, lighten(@xf-xenfocus_guestInternalStyle--background-color, 7%) 0%, @xf-xenfocus_guestInternalStyle--background-color 100%);
				box-shadow: inset xf-intensify(@xf-xenfocus_guestInternalStyle--background-color, 20%) 0px 1px 4px;
			';
		}
		$__finalCompiled .= '
			border-radius: inherit;
			padding: 14px;
			.xenfocus_guestInternalStyle();
			*/
			display: none;
		}

		.focus-guest-align{
			display: flex;
			align-items: center;

			@media (max-width: @xf-responsiveMedium){
				display: block;
			}
		}

		.focus-guest-buttons{
			line-height: 34px;
			padding: 10px;

			a{
				background-color: xf-default(@xf-xenfocus_guestInternalStyle--background-color, @xf-buttonDefault--background-color);
				color: xf-default(@xf-xenfocus_guestInternalStyle--color, @xf-buttonDefault--color);
				border: 1px solid desaturate(darken(xf-default(@xf-xenfocus_guestInternalStyle--background-color, @xf-buttonDefault--background-color), 15%), 15%);

				&:hover{
					background-color: darken(xf-default(@xf-xenfocus_guestInternalStyle--background-color, @xf-buttonDefault--background-color), 5%);
				}

				&::before{
					padding: 0 7px;
					background: rgba(255,255,255,0.15);
					//border-right: 1px solid fade(desaturate(darken(xf-default(@xf-xenfocus_guestInternalStyle--background-color, @xf-buttonDefault--background-color), 15%), 15%), 80%);
				}

				&::after{
					//background-image: linear-gradient(to bottom, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 100%);
					//box-shadow: inset rgba(255,255,255,0.13) 0px 1px 0px;
				}

				span{
					padding: 0 12px;
				}
			}
		}
	}


	&.focus-guest-wallpaper{
		position: relative;
		.xf-contentBase();
		.xf-blockBorder();
		.focus-block-container();

		';
		if ($__templater->func('property', array('xenfocus_guestWallpaper--background-image', ), false) AND $__templater->func('property', array('xenfocus_guestWallpaperOpacity', ), false)) {
			$__finalCompiled .= '
			&::before{
				background-color: inherit;
				content: \'\';
				position: absolute; top: 0; left: 0; right: 0; bottom: 0;
				border-radius: inherit;
				opacity: @xf-xenfocus_guestWallpaperOpacity;
			}
			
			> *{
				position: relative;
			}
		';
		}
		$__finalCompiled .= '

		.xf-xenfocus_guestWallpaper();
		background-size: cover;
		background-position: 50% 50%;
		padding: 40px 20px;
		text-align: center;
		font-size: @xf-fontSizeLarge;
		.xenfocus_guestWallpaper();

		.focus-guest-header{
			font-size: @xf-fontSizeLargest;
			font-weight: bold;
			line-height: 1;
		}

		.focus-guest-content{
			padding: 30px 0;
			max-width: 700px;
			margin: 0 auto;
		}

		.focus-guest-buttons{
			line-height: 38px;
			font-size: @xf-fontSizeSmaller;

			li:first-child{
				order: 1;
			}

			a{
				border: 2px solid currentcolor;
				';
		if ($__templater->func('property', array('xenfocus_guestWallpaper--color', ), false)) {
			$__finalCompiled .= '
				border-color: fade(@xf-xenfocus_guestWallpaper--color, 70%);
				';
		}
		$__finalCompiled .= '
				border-radius: 3px;
				padding: 0 12px;
				transition: all 0.1s linear;

				&:hover{
					border-color: currentcolor;
					';
		if ($__templater->func('property', array('xenfocus_guestWallpaper--color', ), false)) {
			$__finalCompiled .= '
					background: fade(@xf-xenfocus_guestWallpaper--color, 10%);
					';
		}
		$__finalCompiled .= '
				}

				&[href$="register/"]{
					';
		if ($__templater->func('property', array('xenfocus_guestWallpaper--color', ), false)) {
			$__finalCompiled .= '
						background: @xf-xenfocus_guestWallpaper--color;
						border-color: transparent;
						';
			if ($__templater->func('property', array('xenfocus_guestWallpaper--background-color', ), false)) {
				$__finalCompiled .= '
							color: @xf-xenfocus_guestWallpaper--background-color;
						';
			}
			$__finalCompiled .= '
					';
		}
		$__finalCompiled .= '

					&:hover{
						';
		if ($__templater->func('property', array('xenfocus_guestWallpaper--color', ), false)) {
			$__finalCompiled .= '
						background: lighten(@xf-xenfocus_guestWallpaper--color, 10%);
						';
		}
		$__finalCompiled .= '
					}
				}

				span{
					padding-left: 7px;
				}
			}
		}
	}

}

';
	}
	$__finalCompiled .= '




/*
	----------------
	- Footer
	----------------
*/

// Footer
.p-footer{

	> :first-child{
		border-top-left-radius: inherit;
		border-top-right-radius: inherit;
	}

	> :last-child{
		border-bottom-left-radius: inherit;
		border-bottom-right-radius: inherit;
	}

	@media (max-width: @xf-responsiveMedium){
		border-radius: 0;
	}
	
}

.p-footer-inner{
    padding: 15px;
}

	.p-footer-linkList{
		display: flex;
		flex-wrap: wrap;
		justify-content: center;

		> li a{
	        padding: 6px;
	        border-radius: 3px;
	        display: inline-block;
	    }

	    .fa, .fas, .far, .fal, .fab{
			margin-right: .3em;
		}
	}

		// Remove margin on RSS icon
		.p-footer-rssLink .fa-rss{
			margin: 0;
		}

    .p-footer-row-main,
    .p-footer-row-opposite{
        margin-bottom: 0;
    }

@media (min-width: (@xf-responsiveWide + 1px)){
	.p-footer-row-opposite{
		margin-left: auto;
	}
}

.p-footer-row{
	margin-bottom: 0;

	&::before,
	&::after{
		display: none;
	}
}

.p-footer-copyright{
	margin-top: 10px;
	text-align: center;
}

.footer-align,
.p-footer-row{
	display: flex;
	align-items: center;
	justify-content: space-between;
	flex-wrap: wrap;

	@media (max-width: @xf-responsiveWide){
		flex-direction: column;
	}

	> div{
		flex: 0 1 auto;
	}
}

.xenfocus\\:branding{
	white-space: nowrap;
	
	&:not(:first-child)::before,
	&:not(:last-child)::after{
		content: \' // \';
		opacity: 0.35;
		margin: 0 8px;
	}
	a{
		color: inherit;
	}
}

// IE11 bug: Make sure footer links don\'t cause horizontal scrollbar
@media (max-width: @xf-responsiveNarrow){
	.p-footer-linkList,
	.p-footer-copyright{
		max-width: ~"calc(100vw - 18px)";
	}
}

/*
	----------------
	- Mega footer
	----------------
*/

';
	if ($__templater->func('property', array('xenfocus_footerEnable', ), false)) {
		$__finalCompiled .= '

.focus-footer{
	padding: 15px;
	border-bottom: 1px solid fade(@xf-publicFooter--color, 10%);

	';
		if (!$__templater->func('property', array('xenfocus_footerMobile', ), false)) {
			$__finalCompiled .= '
		@media (max-width: @xf-responsiveMedium){
			display: none;
		}
	';
		}
		$__finalCompiled .= '
}

.focus-footer__align{
	display: flex;
	justify-content: space-between;
	flex-wrap: wrap;
}

.focus-footer-col{
	padding: 10px;
	
	@media (min-width: 926px){
		flex: 1 1 10px;
	}

	@media (min-width: 500px) and (max-width: 925px){
		&:not(:only-child){
			width: 50%;
		}
	}

	@media (max-width: 925px){
		&:not(:last-of-type){
			margin-bottom: 40px;
		}
	}

	@media (max-width: 499px){
		width: 100%;
	}

	h4{
		color: fadein(@xf-publicFooter--color, 50%);
		display: block;
		padding: 0;
		margin: 0;
		margin-bottom: 20px;
	}

	a{
		color: inherit;

		&:hover{
			color: @xf-publicFooterLink--color;
		}
	}

	h4 + p{
		margin-top: 0;
	}

	p:last-child{
		margin-bottom: 0;
	}
}

.focus-footer-list{
	list-style: none;
	display: block;
	padding: 0;
	margin: 0;

	& li{
		display: block;

		&:not(:last-child){
			padding-bottom: 5px;
		}
	}
}

.focus-footer + .footer-bottom-wrap{
	background: @mega-footer-copyright;
}

';
	}
	$__finalCompiled .= '


/*
	----------------
	- Grid layout for nodes
	----------------
*/

';
	if ($__templater->func('property', array('xenfocus_gridEnable', ), false) OR $__templater->func('property', array('xenfocus_gridToggle', ), false)) {
		$__finalCompiled .= '

// Hide the grid panel for old browsers, and show it using @supports
.focus-editor-panel[data-setting="focus-grid"]{
	display: none;
	@supports (display: grid){
		display: flex;
	}
}

@supports (display: grid){

	.focus-grid{

		--grid-node-icon-width: @node-grid-padding + @node-grid-padding + (@xf-xenfocus_iconWidth*1px);
		@media (max-width: @xf-responsiveNarrow){
			--grid-node-icon-width: @node-grid-padding + @node-grid-padding + (@xf-xenfocus_iconWidth*0.7px);
		}

		';
		if ($__templater->func('property', array('xenfocus_grid_nodes', ), false)) {
			$__finalCompiled .= '
			@{xf-xenfocus_grid_nodes}
		';
		} else {
			$__finalCompiled .= '
			.block--category
		';
		}
		$__finalCompiled .= '
		{

			.block-body{
				display: flex;
				flex-wrap: wrap;
				padding: @grid-node-gap;

				// Add a background and padding to the grid wrapper if no background exists on the main content wrapper
				';
		if (!$__templater->func('property', array('xenfocus_gridWallpaper', ), false)) {
			$__finalCompiled .= '
					background: @grid-node-wrapper;
				';
		}
		$__finalCompiled .= '

				.reset-grid-wrapper(@debug) when (@debug = true) {
					background: none;
					border: 0;
					box-shadow: none;
					padding: 0px;
					margin-top: @grid-node-gap;
					@media (min-width: (@xf-responsiveMedium + 1px)){
						margin: @grid-node-gap -@grid-node-gap -@grid-node-gap -@grid-node-gap;
					}
				}
				.reset-grid-wrapper(@reset-grid-wrapper);

			}

			.node{
				flex: 1 0 var(--grid-node-width, @grid-node-width);
				margin: @grid-node-gap;
				max-width: 100%;
				border: 0;

				// Overwrite the inline-styles from the minimal layout
				';
		if ($__templater->func('property', array('xenfocus_tableLayout', ), false) == 'minimal') {
			$__finalCompiled .= '
					display: block;
					width: auto;
				';
		}
		$__finalCompiled .= '

				@media (max-width: @xf-responsiveMedium){
					max-width: ~"calc(100% - @{grid-node-gap} - @{grid-node-gap})";
				}

				&::before{
					top: @grid-hover-inset;
					left: @grid-hover-inset;
					right: @grid-hover-inset;
					bottom: @grid-hover-inset;
					z-index: 5;
					pointer-events: none;
				}
			}

			.node-body{
				width: auto;
				height: 100%;
				display: grid;
				grid-template-columns: auto 1fr;
				';
		if ($__templater->func('property', array('xenfocus_grid_minimal', ), false)) {
			$__finalCompiled .= '
					grid-template-rows: 1fr;
				';
		} else {
			$__finalCompiled .= '
					grid-template-rows: 1fr minmax(61px, auto);
				';
		}
		$__finalCompiled .= '
				grid-template-areas:
			               "nodeicon nodetitle"
			               "nodelatest nodelatest";
				align-items: center;
				border-radius: @xf-blockBorderRadius;
				position: relative;
				padding: 0;

				';
		if (!$__templater->func('property', array('xenfocus_grid_minimal', ), false)) {
			$__finalCompiled .= '
					&::before{
						content: \'\';
						display: block;
						align-self: stretch;
						grid-area: nodelatest;
						border-bottom-left-radius: inherit;
						border-bottom-right-radius: inherit;
						position: relative;
						z-index: 2;
					}
				';
		}
		$__finalCompiled .= '
			}

			.node--link .node-body,
			.node--page .node-body{
				grid-template-rows: 1fr;

				';
		if (!$__templater->func('property', array('xenfocus_grid_minimal', ), false)) {
			$__finalCompiled .= '
					&::before{
						display: none;
					}
				';
		}
		$__finalCompiled .= '
			}

			.node-icon{
				grid-area: nodeicon;
				padding: @node-grid-padding;
				padding: var(--node-grid-padding, @node-grid-padding);
				padding-right: 0px;


				';
		if ((!$__templater->func('property', array('xenfocus_iconStyles--background-color', ), false)) AND (!$__templater->func('property', array('xenfocus_iconRead--background-color', ), false))) {
			$__finalCompiled .= '
				/* i{
					color: inherit !important;
				} */
				';
		}
		$__finalCompiled .= '
			}

			.node-main{
				grid-area: nodetitle;
				padding: @node-grid-padding;
				padding: var(--node-grid-padding, @node-grid-padding);
			}

			.node-subNodeMenu{
				display: block;
				margin-top: 5px;
			}

			.node-extra{
				';
		if ($__templater->func('property', array('xenfocus_grid_minimal', ), false)) {
			$__finalCompiled .= '
					display: none;
				';
		} else {
			$__finalCompiled .= '
					grid-area: nodelatest;
					width: auto;
					margin: 0;
					padding-top: 10px;
					padding-bottom: 10px;
					padding-left: @node-grid-padding + @node-grid-padding + (@xf-xenfocus_iconWidth*1px);
					padding-left: var(--grid-node-icon-width);
					position: relative;
					display: flex;
					align-items: center;
					flex-wrap: wrap;
					z-index: 2;
				';
		}
		$__finalCompiled .= '

				.node-extra-icon{
					position: absolute;
					left: 0;
					width: @node-grid-padding + @node-grid-padding + (@xf-xenfocus_iconWidth*1px);
					width: var(--grid-node-icon-width);
					padding: 0;
					text-align: center;
					// Ensure the avatar is shown on mobiles
					display: block;
				}

				.node-extra-row{
					flex: 0 0 auto;
					width: 100%;
					white-space: normal;
					height: @xf-lineHeightDefault*1em;
					position: relative;
				}

				.node-extra-row:first-child{
					font-weight: bold;
				}

				.node-extra-user a{
					color: inherit;
				}
				
				// Truncate long topic titles using ellipsis
				.node-extra-row .node-extra-title{
					position: absolute;
					left: 0;
					right: 0;
					overflow: hidden;
					white-space: nowrap;
					text-overflow: ellipsis;
				}
			}

			.node-statsMeta{
			';
		if ($__templater->func('property', array('xenfocus_grid_stats', ), false)) {
			$__finalCompiled .= '
				// Hide the node stats in grid view if setting is enabled
				display: none;
			';
		} else {
			$__finalCompiled .= '
				display: flex;
				align-items: center;
				font-size: 0.9em;
				margin-top: 5px;

				dl{
					padding: 0;
					width: auto;
					flex: 0 0 auto;

					&:not(:last-child):after{
						display: none;
					}
				}

				dt{
					display: none;
				}

				dd:before{
					.m-faBase();
        			.m-faContent(@fa-var-comment);
					margin-right: 5px;
				}

				dl:last-child{
					opacity: 0.4;
					margin-left: 15px;

					dd:before{
						.m-faContent(@fa-var-comments);
					}
				}
			';
		}
		$__finalCompiled .= '
			}

			.node-stats{
				display: none;
			}



			// Colour scheme: normal or wallpaper
			';
		if ($__templater->func('property', array('xenfocus_gridWallpaper', ), false)) {
			$__finalCompiled .= '
				.node-body{
					color: @xf-xenfocus_gridColor;
					background-color: @xf-xenfocus_gridBackground;
					background-size: cover;
					background-position: 50% 50%;
					
					&::before{
						background: rgba(0,0,0,0.3);
					}

					&::after{
						content: \'\';
						position: absolute; top: 0; left: 0; right: 0; bottom: 0;
						pointer-events: none;
						border-radius: inherit;
						z-index: 3;
						';
			if ($__templater->func('property', array('styleType', ), false) === 'light') {
				$__finalCompiled .= '
						border: 1px solid rgba(0,0,0,0.2);
						';
			} else {
				$__finalCompiled .= '
						border: 1px solid rgba(255,255,255,0.2);
						';
			}
			$__finalCompiled .= '
					}

					a, .node-description, .node-extra-row{
						color: inherit;
					}

					.node-description, .node-extra-row:nth-of-type(2){
						opacity: 0.7;
					}
				}
			';
		} else {
			$__finalCompiled .= '
				.node-body{
					.xf-contentBase();
					.xf-blockBorder();
					.reset-grid-wrapper-2(@debug) when (@debug = true) {
						.focus-block-container();
					}
					.reset-grid-wrapper-2(@reset-grid-wrapper);
					
					&::before{
						background: xf-intensify(@xf-contentBg, 1%);
						border-top: 1px solid xf-intensify(@xf-contentBg, 7%);
					}
				}
			';
		}
		$__finalCompiled .= '

		}

	}
}


// Assign node wallpapers

';
		if ($__templater->func('property', array('xenfocus_gridImage', ), false) AND $__templater->func('property', array('xenfocus_gridWallpaper', ), false)) {
			$__finalCompiled .= '

	@wallpapernodes: @xf-xenfocus_gridImage;

	.node-wallpapers-mixin(@i: length(@wallpapernodes)) when (@i > 0) {

		.node-wallpapers-mixin(@i - 1);
	    @wallpapernode: extract(@wallpapernodes, @i); 
	    .node--id@{wallpapernode} .node-body {
	        background-image: url(\'@{grid-wallpaper-folder}/@{wallpapernode}.jpg?v=@xf-xenfocus_cache\');
	    }

	}

	@supports (display: grid){
		.focus-grid{
			.block--category{
				.node-wallpapers-mixin();
			}
		}
	}

';
		}
		$__finalCompiled .= '




// Hide node stats on smaller screens for a cleaner look
.hide-node-statsMeta-mobile(@debug) when (@debug = true) {
	@media (max-width: @xf-responsiveNarrow){
		.node-statsMeta,
		.focus-grid .block--category .node-statsMeta{
			display: none;
		}
	}
}
.hide-node-statsMeta-mobile(@hide-node-statsMeta-mobile);

';
	}
	$__finalCompiled .= '

/*
	----------------
	- Blocks
	----------------
*/

.focus-block-container(){}
.focus-block-header(){}
.focus-block-body(){}
.focus-block-container-shift(){};
.focus-block-header-shift(){};
.focus-block-body-shift(){}
.focus-block-minor-header(){}

@{block-container}{
	.focus-block-container();
}

@{block-header}{
	.focus-block-header();
	@media (max-width: @xf-responsiveEdgeSpacerRemoval){
		border-radius: 0;
		border-left-width: 0;
		border-right-width: 0;
	}
}

@{block-body}{
	.focus-block-body();
}

@{block-minor-header}{
	.focus-block-minor-header();
}

// If shadows are added to blocks, remove them from ones which don\'t need them
.blockMessage.blockMessage--none,
.block--messages .block-container{
	box-shadow: none;
}

.block-header{
	.block-desc{
		color: inherit;
		opacity: 0.7;
	}
	.button{
		text-shadow: none;
	}
}

// Move block wrap from container to body
.block-container-shift(@debug) when (@debug = true) {
    
	.block--category{

		.block-container{
			border-width: 0;
			box-shadow: none;
			background: none;
			.focus-block-container-shift();
		}

		// The #XF is required to overwrite the border-radius defined by: .block-container:not(.block-container--noStripRadius) > :first-child
		#XF & .block-header{
			.focus-block-header-shift();
		}

		.block-body{
			.xf-contentBase();
			.xf-blockBorder();
			border-radius: @xf-blockBorderRadius !important;
			.focus-block-container();
			.focus-block-body-shift();
		}

		@media (max-width: @xf-responsiveEdgeSpacerRemoval){
			.block-container,
			#XF & .block-header,
			.block-body{
				border-radius: 0;
				border-left-width: 0;
				border-right-width: 0;
			}
		}
	}
}
.block-container-shift(@block-container-shift);

.p-body-sidebar .block-row:not(:last-child){
	border-bottom: 1px solid @xf-borderColorFaint;
}

// Inherit border-radius for last forum in each category
.block-body > .node:last-child{
	border-bottom-left-radius: inherit;
	border-bottom-right-radius: inherit;
}

// Fix collapsed margins on sidebar block headers
.p-body-sidebar .block-container,
.p-body-sideNavContent .block-container{
	padding: .01px 0;
}


/*
	----------------
	- Mobile navigation panel
	----------------
*/

.offCanvasMenu--nav
{
	.offCanvasMenu-content
	{
		background: @mobile-navigation-background;
		color: @mobile-navigation-color;
		transition-duration: 0.2s;
	}

	.offCanvasMenu-subList{
		background: fade(@mobile-navigation-color, 10%);

		';
	if ($__templater->func('property', array('xenfocus_navIcons', ), false)) {
		$__finalCompiled .= '
			.offCanvasMenu-link{
				padding-left: 34px;
			}
		';
	}
	$__finalCompiled .= '
	}

	.offCanvasMenu-linkHolder.is-selected{
		color: inherit;
		font-weight: bold;
		background: fade(@mobile-navigation-color, 15%);
		text-transform: inherit;
	}

}


/*
	----------------
	- Countdown
	----------------
*/

';
	if ($__templater->func('property', array('xenfocus_countdownEnable', ), false)) {
		$__finalCompiled .= '

.focus-timer{
	text-align: center;
	font-size: 1.2em;
	display: flex;
	flex-direction: column;
	justify-content: center;
	min-height: 140px;
	border-radius: @xf-blockBorderRadius;

	';
		if ($__templater->func('property', array('xenfocus_countdownColor', ), false)) {
			$__finalCompiled .= '
		color: @xf-xenfocus_countdownColor;
		';
			if ($__templater->func('property', array('xenfocus_wrapperStyles--background-color', ), false)) {
				$__finalCompiled .= '
		    @media (min-width: (@xf-responsiveMedium + 1px)){
			    margin-left: -((@xf-elementSpacer) / 2);
				margin-right: -((@xf-elementSpacer) / 2);
			}
	    ';
			}
			$__finalCompiled .= '
	';
		} else {
			$__finalCompiled .= '
		.xf-contentBase();
		.xf-blockBorder();
		.focus-block-container();
	';
		}
		$__finalCompiled .= '

	margin-bottom: 10px;
	padding: 15px;

	html:not(.focus-countdown) &{
		display: none;
	}

	h3{
		margin: 0;
		padding: 0;
		font-size: 1.3em;
		line-height: 1;
		font-weight: normal;
	}

	a{
		color: inherit;
		text-decoration: underline;
	}

	> div{
		padding-top: 12px;
	}

	.focus-timer-numbers{
		line-height: 1em;
		min-height: 1em;
		opacity: 0.8;

		span{
			opacity: 0.6;
		}
	}

	.focus-timer-numbers,
	.focus-timer-desc,
	.focus-timer-desc-done{
		display: none;
	}

	// Hide text depending on countdown state
	&.focus-timer-done .focus-timer-desc-done,
	&.focus-timer-counting .focus-timer-desc,
	&.focus-timer-counting .focus-timer-numbers{
		display: block;
	}

}

// Text for Weeks, days, etc
[data-countdown-text]::before{
	content: attr(data-countdown-text);
}

';
	}
	$__finalCompiled .= '

/*
	----------------
	- Topic List
	----------------
*/

// Align topic avatar to middle
.structItem-cell{
	vertical-align: middle;
}

// Remove padding from end avatar since its parent alignment is set to center
.structItem-cell.structItem-cell--icon.structItem-cell--iconEnd .structItem-iconContainer{
	padding-top: 0;
}

// Restore top alignment for quick topic form
form[data-xf-init*="quick-thread"] .structItem-cell--icon{
	vertical-align: top;
	align-self: flex-start;
}

// Sync Replies and Views text
.structItem-cell--meta .pairs{
	font-size: @xf-fontSizeSmaller;
}

	.structItem-minor dd{
		color: @xf-textColor;
	}


// Sticky thread separator
.structItemContainer-group--sticky::before,
.structItemContainer-group--sticky::after{
	';
	if ($__templater->func('property', array('xenfocus_sticky', ), false)) {
		$__finalCompiled .= '
		display: block;
		padding: 9px;
		font-size: 10px;
		font-weight: bold;
		background: @xf-contentAltBg;
		text-transform: uppercase;
		border: @xf-borderSize solid @xf-borderColorFaint;
		border-width: 1px 0 0 0;
	';
	} else {
		$__finalCompiled .= '
		display: none;
	';
	}
	$__finalCompiled .= '
}

// Make topic start date light in colour
.structItem-parts > li:nth-child(2n){
	color: inherit;
}


/*
	----------------
	- Topic View
	----------------
*/

// Sticky author
';
	if ($__templater->func('property', array('xenfocus_stickyAuthor', ), false)) {
		$__finalCompiled .= '
@media (min-width: (@xf-responsiveMedium + 1px)){
	.message-user{
		position: -webkit-sticky;
		position: sticky;
		';
		if (($__templater->func('property', array('publicNavSticky', ), false) === 'primary') OR ($__templater->func('property', array('publicNavSticky', ), false) === 'all')) {
			$__finalCompiled .= '
		top: @sticky-top * 1px + 10px;
		';
		} else {
			$__finalCompiled .= '
		top: 10px;
		';
		}
		$__finalCompiled .= '
	}
}
';
	}
	$__finalCompiled .= '


// Remove arrow, just because..
.message-userArrow{
	display: none;
}

// Online icon
.message-avatar-wrapper .message-avatar-online::before{
	background: #fff;
	border-color: #fff;
}


// Remove border from post date for minimalism
.message-attribution{
	border-width: 0;
	padding-bottom: 6px;

	@media (min-width: (@xf-responsiveMedium + 1px)){
		padding-top: 2px;
	}
}


// Fade the date and moderation links in an attempt to reduce clutter in posts
';
	if ($__templater->func('property', array('faded_post_meta', ), false)) {
		$__finalCompiled .= '
	@media (hover:hover) and (min-width: (@xf-responsiveMedium + 1px)){
		[data-template="thread_view"] .message-attribution,
		.actionBar-set--internal{
			opacity: @post-meta-opacity;
			transition: opacity 0.2s ease-in-out;
			&:hover{
				opacity: 1;
			}
		}
	}
';
	}
	$__finalCompiled .= '



// Remove user panel background and border
';
	if ($__templater->func('property', array('focus_post_minimal', ), false)) {
		$__finalCompiled .= '
	@media (min-width: (@xf-responsiveMedium + 1px)){
		.message-cell.message-cell--user{
			background-color: transparent;
			border-color: transparent !important;
			// padding-right: 0;
		}
	}
';
	}
	$__finalCompiled .= '


// User badge
.userBanner{
	border-radius: @xf-borderRadiusMedium;
	padding-top: 3px;
	padding-bottom: 3px;

	.message-userBanner &{
		margin-top: 5px;
	}
}

// Post font-size
.message-body{
	font-size: @xf-fontSizeNormal + 1px;
	line-height: 1.75;
	
	// Reduce margins above posts because the line separator no longer exists (configured above)
	margin-top: 4px;
	
	// Make sure links are easy to recognise
	a{
		text-decoration: underline;
	}
}


// Place like bar above buttons
/*
.message-footer{
	display: flex;
	flex-direction: column;

	> *{
		flex: 0 0 auto;
		width: 100%;
	}

	.reactionsBar{ order: -1; }
}
*/


// Restyle reactions bar
.reactionsBar{
	background: fade(@xf-textColor, 4%);
	border-width: 0px;
	border-radius: 4px;
	color: @xf-textColorMuted;

	a{
		color: inherit;
	}
	bdi{
		color: @xf-textColor;
	}
	.message &{
		padding: 9px;
	}
}


// Style post buttons
.actionBar-action{
	border-width: 0px;
}

@focus-post-button: @xf-buttonDefault--background-color;
@focus-post-button--minimal--text: @xf-linkColor;
@focus-post-button--minimal--background: @xf-linkColor;
';
	if ($__templater->func('property', array('xenfocus_postButton', ), false) != 'none') {
		$__finalCompiled .= '
    
	.actionBar-set{
		display: flex;
		align-items: center;

		&.actionBar-set--external{
			margin-right: 0;

			.actionBar-action{
				padding: 5px 8px;
				text-decoration: none;

				';
		if ($__templater->func('property', array('xenfocus_postButton', ), false) == 'button') {
			$__finalCompiled .= '
					background: @focus-post-button;
					color: @xf-buttonDefault--color;
					border-width: 1px;
					border-color: xf-intensify(@focus-post-button, 9%);
					.m-transition(background-color);

					&:hover{
						background-color: xf-intensify(@focus-post-button, 5%);
					}
				';
		}
		$__finalCompiled .= '

				';
		if ($__templater->func('property', array('xenfocus_postButton', ), false) == 'minimal') {
			$__finalCompiled .= '
					color: @focus-post-button--minimal--text;
					background-color: fade(@focus-post-button--minimal--background, 6%);
					font-weight: 600;

					&:hover{
						background-color: fade(@focus-post-button--minimal--background, 10%);
					}

					&.is-selected{
						background-color: fade(@focus-post-button--minimal--background, 20%);
					}
				';
		}
		$__finalCompiled .= '

				&::before{
					margin-right: 7px;
					display: inline-block;
				}

				&.actionBar-action--like:before{
					.m-faContent(@fa-var-thumbs-up);
				}

				&.actionBar-action--reply:before{
					.m-faContent(@fa-var-quote-left);
				}
			}
		}

		&.actionBar-set--internal{

			color: @xf-textColorMuted;

			a.actionBar-action{
				color: inherit;
				text-decoration: none;
				margin: 0;
				padding-left: 8px;
				padding-right: 8px;

				&:hover{
					color: @xf-textColor;
					background: fade(@xf-textColor, 6%);
				}
			}
		}

		// Add padding to Like button
		.actionBar-action.actionBar-action--reaction .reaction-text{
			padding-left: 5px;
		}
	}

	.actionBar-action.actionBar-action--inlineMod label{
		color: inherit;
	}

';
	}
	$__finalCompiled .= '


// Like bar
	.likeIcon::before{
		color: @xf-textColorDimmed;
	}

	// Remove underline from Like button
	a.reaction:hover .reaction-text,
	a.reaction:focus .reaction-text{
		text-decoration: none;
	}

	// Force normal text color on active reactions to prevent poor contrast
	.reset-reaction-text(@debug) when (@debug = true) {

		.has-reaction .reaction-text{
			color: inherit;
		}

	}
	.reset-reaction-text(@reset-reaction-text);

	// Reaction popup box
	.tooltip--reaction .tooltip-content{
		background: @xf-contentAltBg;
		border-width: 0;
		';
	if ($__templater->func('property', array('styleType', ), false) == 'light') {
		$__finalCompiled .= '
			box-shadow: 0 0 0 1px rgba(0, 0, 0, .08), 0 2px 2px rgba(0, 0, 0, .15);
		';
	} else {
		$__finalCompiled .= '
			box-shadow: inset rgba(255,255,255,0.1) 0px 1px 0px;
		';
	}
	$__finalCompiled .= '
	}


';
	if ($__templater->func('property', array('styleType', ), false) == 'dark') {
		$__finalCompiled .= '
// Add background to embeds such as facebook
.bbWrapper iframe{
	background: #bbb;
}
';
	}
	$__finalCompiled .= '


// Swap Preview and Post buttons
.message--quickReply .formButtonGroup-primary,
body[data-template="forum_post_thread"] .formSubmitRow-controls{
	display: flex;
	align-items: center;

	.button--primary{
		order: 1;
		margin-left: 5px;
	}
}


// Polls
.pollResult-bar{
	background: fade(@xf-progressBarColor, 20%);
	border-radius: @xf-borderRadiusMedium;

	&::after{
		content: \'\';
		position: absolute;
		top: 0; left: 0; right: 0; bottom: 0;
		border-radius: inherit;
		border: 1px solid fade(xf-intensify(@xf-progressBarColor, 30%), 10%);
		pointer-events: none;
	}
}

.pollResult.pollResult--showVoters:hover{
	background: @xf-contentAltBg;
}


// Space out username in left column
@media (min-width: (@xf-responsiveWide + 1px)){
	.message-name{
		margin-top: 10px;
	}
}


@media (max-width: @xf-responsiveMedium){
	// Align username vertically with avatar on mobiles
	.message:not(.message--forceColumns) .message-user{
		align-items: center;
	}
	// Remove bottom margin to ensure avatar is aligned correctly
	.message-avatar-wrapper{
		margin-bottom: 0;
	}
}

// Remove margin-top from bbcode boxes if they\'re the first child
.bbCodeBlock:first-child{
	margin-top: 0;
}



/*
	----------------
	- Editor
	----------------
*/

.fr-box.fr-basic {
	.fr-toolbar.fr-top{
		background: @editor-bg !important;
	}
	.fr-wrapper {
		background: @editor-bg;
		border-bottom-left-radius: inherit;
		border-bottom-right-radius: inherit;
	}
	.fr-element{
		color: @editor-text;
	}
}
.fr-element{
	font-family: @xf-fontFamilyBody;
}


';
	if ($__templater->func('property', array('styleType', ), false) == 'dark') {
		$__finalCompiled .= '
	// Fix webkit browser selection
	.fr-wrapper ::selection {
		background: #fff;
		color: #222;
	}
';
	}
	$__finalCompiled .= ' 


/*
	----------------
	- Profiles
	----------------
*/

// Inherit border-radius
.memberHeader, .memberHeader-main{
	border-top-left-radius: inherit;
	border-top-right-radius: inherit;
}



/*
	----------------
	- Sidebar
	----------------
*/

// Prevent horizontal scrollbar on themes with no background on the content wrapper
';
	if (!$__templater->func('property', array('xenfocus_wrapperStyles--background-color', ), false)) {
		$__finalCompiled .= '
@media (max-width: @xf-responsiveWide){
	.p-body-sidebar{
		margin-left: 0;
		margin-right: 0;
	}
}
';
	}
	$__finalCompiled .= '

// Sidebar icons, widget icons
.focus-sidebar-icons(@debug) when (@debug = true) {
	.block[data-widget-definition]{

		.block-minorHeader::before{
			.m-faBase();
        	content: @minorHeader-icon;
			display: inline-block;
			transform: translate(0,0);
			margin-right: 6px;
			opacity: 0.7;
		}

	}

	.block-minorHeader::before{

		.block[data-widget-definition="members_online"] &,
		.block[data-widget-definition="online_statistics"] &{
			.m-faContent(@fa-var-user);
		}

		.block[data-widget-section="staffMembers"] &{
			.m-faContent(@fa-var-user-shield);
		}

		.block[data-widget-definition="new_profile_posts"] &{
			.m-faContent(@fa-var-user-edit);
		}

		.block[data-widget-definition="forum_statistics"] &{
			.m-faContent(@fa-var-chart-pie);
		}
		
		.block[data-widget-definition="xfmg_gallery_statistics"] &{
			.m-faContent(@fa-var-file-image);
		}

		.block[data-widget-definition="share_page"] &{
			.m-faContent(@fa-var-share-alt);
		}

		.block[data-widget-definition="new_posts"] &{
			.m-faContent(@fa-var-comments);
		}

		.block[data-widget-definition="new_threads"] &{
			.m-faContent(@fa-var-comments);
		}
		
		.block[data-widget-definition="find_member"] &{
			.m-faContent(@fa-var-search);
		}
		
		.block[data-widget-definition="newest_members"] &{
			.m-faContent(@fa-var-user-plus);
		}

		.block[data-widget-definition="sytrySupportUs"] &{
			.m-faContent(@fa-var-shopping-cart);
		}

		.block[data-widget-definition="xfmg_media_slider"] &{
			.m-faContent(@fa-var-image);
		}

		.block[data-widget-definition="calendarEvents"] &{
			.m-faContent(@fa-var-calendar-alt);
		}
		
		.block[data-widget-definition="xfmg_media_slider"] &{
			.m-faContent(@fa-var-image);
		}
		.block[data-widget-definition="at_law_widget"] &{
			.m-faContent(@fa-var-comments);
		}
		.block[data-widget-definition="birthdays"] &{
			.m-faContent(@fa-var-birthday-cake);
		}

	}

	// Remove icons from 3rd party widget headers and use pseudo elements for consistency
	.block[data-widget-definition="sytrySupportUs"] .block-minorHeader .fa,
	.block[data-widget-definition="calendarEvents"] .block-minorHeader .far{
		display: none;
	}
}
.focus-sidebar-icons(@focus-sidebar-icons);


// Neaten spacing of blocks on mobiles
@media (max-width: @xf-responsiveWide){
	.p-body-sidebar > *{
		margin-bottom: 10px;
	}
}
/*
	----------------
	- Sticky sidebar
	----------------
*/

.focus-editor-panel[data-setting="focus-sidebar-sticky"]{
	display: none;
}

// Recode sidebar into flex layout
@media (min-width: (@xf-responsiveWide + 1px)){
	.p-body-main--withSidebar{
		display: flex;
		align-items: flex-start;
		
		.p-body-content{
			// These values are all necessary to ensure the media slider works. Do not change
			flex: 0 1 auto;
			display: block;
			width: ~"calc(100% - @xf-sidebarWidth)";
		}
		
		.p-body-sideNav,
		.p-body-sidebar{
			flex: 0 0 auto;
			// IE fix
			display: block;
		}

		// Remove the table-column elements
		.p-body-contentCol,
		.p-body-sidebarCol,
		.p-body-sideNavCol{
			display: none;
		}

	}

	// Switch sidebar to left side if enabled
	.focus-sidebar-flip .p-body-sidebar{
		order: -1;
	}

		// And adjust padding
		.focus-sidebar-flip{
			.p-body-main--withSidebar .p-body-content{
				padding-right: 0;
				padding-left: @content-padding;
			}
		}

	// Sticky side blocks
	';
	if ($__templater->func('property', array('xenfocus_stickyBlocks', ), false) OR $__templater->func('property', array('xenfocus_stickyToggle', ), false)) {
		$__finalCompiled .= '
	@supports ((position: sticky) or (position: -webkit-sticky)){
		.focus-sidebar-sticky .p-body-sidebar{
			position: -webkit-sticky;
			position: sticky;
			';
		if (($__templater->func('property', array('publicNavSticky', ), false) === 'primary') OR ($__templater->func('property', array('publicNavSticky', ), false) === 'all')) {
			$__finalCompiled .= '
			top: @sticky-top * 1px + 10px;
			';
		} else {
			$__finalCompiled .= '
			top: 10px;
			';
		}
		$__finalCompiled .= '
		}
		.focus-editor-panel[data-setting="focus-sidebar-sticky"]{
			display: flex;
		}
	}
	';
	}
	$__finalCompiled .= '
}


';
	if ($__templater->func('property', array('xenfocus_eventOverlay', ), false) === 'snow') {
		$__finalCompiled .= '

/*
	----------------
	- Animated snow
	----------------
*/

@-webkit-keyframes snow_1 {
    0% { transform: translate(-250px, 0); }
    100% { transform: translate(250px, 300vh); }
}
@-webkit-keyframes snow_2 {
    0% { transform: translate(0, 0); }
    100% { transform: translate(-100px, 300vh); }
}
@-webkit-keyframes snow_3 {
    0% { transform: translate(-50px, 0); }
    100% { transform: translate(0, 300vh); }
}
@keyframes snow_1 {
    0% { transform: translate(-250px, 0); }
    100% { transform: translate(250px, 300vh); }
}
@keyframes snow_2 {
    0% { transform: translate(0, 0); }
    100% { transform: translate(-100px, 300vh); }
}
@keyframes snow_3 {
    0% { transform: translate(-50px, 0); }
    100% { transform: translate(0, 300vh); }
}

.xenfocus-snow{
	position: fixed;
	top: 0; left: 0;
	width: 100%; height: 100%;
	overflow: hidden;
	z-index: 20;
	pointer-events: none;
}

html:not(.focus-snow) .xenfocus-snow{
	display: none;
}

.xenfocus-snow-panel{
	height: 200vh;
	margin-top: -200vh;
	position: relative;
	will-change: transform;
}

.f-sF{
    position: absolute;
    background: #fff;
    border-radius: 50%;
    box-shadow: #000 0px 1px 2px;

    &:nth-child(1) {
	    left: 5%;
	    top: 5%;
	    width: 4px;
	    height: 5px;
	}
	&:nth-child(2) {
	    left: 15%;
	    top: 10%;
	    width: 6px;
	    height: 5px;
	}
	&:nth-child(3) {
	    left: 23%;
	    top: 40%;
	    width: 2px;
	    height: 5px;
	}
	&:nth-child(4) {
	    left: 36%;
	    top: 15%;
	    width: 3px;
	    height: 3px;
	}
	&:nth-child(5) {
	    left: 47%;
	    top: 70%;
	    width: 2px;
	    height: 5px;
	}
	&:nth-child(6) {
	    left: 53%;
	    top: 50%;
	    width: 1px;
	    height: 2px;
	}
	&:nth-child(7) {
	    left: 61%;
	    top: 90%;
	    width: 2px;
	    height: 1px;
	}
	&:nth-child(8) {
	    left: 78%;
	    top: 14%;
	    width: 6px;
	    height: 4px;
	}
	&:nth-child(9) {
	    left: 85%;
	    top: 86%;
	    width: 5px;
	    height: 1px;
	}
	&:nth-child(10) {
	    left: 96%;
	    top: 59%;
	    width: 3px;
	    height: 1px;
	}
	&:nth-child(11) {
	    left: 3%;
	    top: 91%;
	    width: 4px;
	    height: 4px;
	}
	&:nth-child(12) {
	    left: 18%;
	    top: 31%;
	    width: 3px;
	    height: 3px;
	}
	&:nth-child(13) {
	    left: 26%;
	    top: 52%;
	    width: 5px;
	    height: 6px;
	}
	&:nth-child(14) {
	    left: 38%;
	    top: 36%;
	    width: 5px;
	    height: 3px;
	}
	&:nth-child(15) {
	    left: 43%;
	    top: 81%;
	    width: 3px;
	    height: 2px;
	}
	&:nth-child(16) {
	    left: 54%;
	    top: 11%;
	    width: 2px;
	    height: 3px;
	}
	&:nth-child(17) {
	    left: 67%;
	    top: 62%;
	    width: 4px;
	    height: 1px;
	}
	&:nth-child(18) {
	    left: 76%;
	    top: 9%;
	    width: 5px;
	    height: 5px;
	}
	&:nth-child(19) {
	    left: 87%;
	    top: 2%;
	    width: 3px;
	    height: 1px;
	}
	&:nth-child(20) {
	    left: 98%;
	    top: 98%;
	    width: 4px;
	    height: 1px;
	}
	&:nth-child(21) {
	    left: 7%;
	    top: 60%;
	    width: 6px;
	    height: 5px;
	}
	&:nth-child(22) {
	    left: 14%;
	    top: 45%;
	    width: 2px;
	    height: 5px;
	}
	&:nth-child(23) {
	    left: 25%;
	    top: 65%;
	    width: 1px;
	    height: 3px;
	}
	&:nth-child(24) {
	    left: 36%;
	    top: 11%;
	    width: 3px;
	    height: 4px;
	}
	&:nth-child(25) {
	    left: 49%;
	    top: 24%;
	    width: 3px;
	    height: 4px;
	}
	&:nth-child(26) {
	    left: 58%;
	    top: 37%;
	    width: 2px;
	    height: 5px;
	}
	&:nth-child(27) {
	    left: 69%;
	    top: 49%;
	    width: 6px;
	    height: 6px;
	}
	&:nth-child(28) {
	    left: 75%;
	    top: 55%;
	    width: 6px;
	    height: 3px;
	}
	&:nth-child(29) {
	    left: 84%;
	    top: 86%;
	    width: 5px;
	    height: 3px;
	}
	&:nth-child(30) {
	    left: 94%;
	    top: 90%;
	    width: 4px;
	    height: 1px;
	}
	&:nth-child(31) {
        left: 59%;
        top: 61%;
        width: 4px;
        height: 6px;
    }
}

.xenfocus-snow-panel-1 {
    -webkit-animation: snow_1 8s linear infinite;
    animation: snow_1 8s linear infinite;
}
.xenfocus-snow-panel-2 {
    -webkit-animation: snow_2 13s 0s linear infinite;
    animation: snow_2 13s 0s linear infinite;
}
.xenfocus-snow-panel-3 {
    -webkit-animation: snow_3 16s 6s linear infinite;
    animation: snow_3 16s 6s linear infinite;
}

/* Hide snow on tablets and mobiles */
@media screen and (max-width:979px){
	.focus-editor-panel[data-setting=\'focus-snow\'],
	.xenfocus-snow{
		display: none;
	}
}

';
	}
	$__finalCompiled .= '




';
	if ($__templater->func('property', array('xenfocus_eventOverlay', ), false) === 'confetti') {
		$__finalCompiled .= '

/*
	----------------
	- Animated confetti
	----------------
*/

@-webkit-keyframes confetti_1 {
    0% { transform: translate(-250px, 0); }
    100% { transform: translate(250px, 300vh); }
}
@-webkit-keyframes confetti_2 {
    0% { transform: translate(0, 0); }
    100% { transform: translate(-100px, 300vh); }
}
@-webkit-keyframes confetti_3 {
    0% { transform: translate(-50px, 0); }
    100% { transform: translate(0, 300vh); }
}
@keyframes confetti_1 {
    0% { transform: translate(-250px, 0); }
    100% { transform: translate(250px, 300vh); }
}
@keyframes confetti_2 {
    0% { transform: translate(0, 0); }
    100% { transform: translate(-100px, 300vh); }
}
@keyframes confetti_3 {
    0% { transform: translate(-50px, 0); }
    100% { transform: translate(0, 300vh); }
}

.xenfocus-confetti{
	position: fixed;
	top: 0; left: 0;
	width: 100%; height: 100%;
	overflow: hidden;
	z-index: 20;
	pointer-events: none;
}

html:not(.focus-confetti) .xenfocus-confetti{
	display: none;
}

.xenfocus-confetti-panel{
	height: 200vh;
	margin-top: -200vh;
	position: relative;
	will-change: transform;
}

.f-con{
    position: absolute;
    width: 9px;
    height: 5px;
    border-radius: 2px;

    &:nth-child(1) {
	    left: 5%;
	    top: 5%;
	}
	&:nth-child(2) {
	    left: 15%;
	    top: 10%;
	}
	&:nth-child(3) {
	    left: 23%;
	    top: 40%;
	}
	&:nth-child(4) {
	    left: 36%;
	    top: 15%;
	}
	&:nth-child(5) {
	    left: 47%;
	    top: 40%;
	}
	&:nth-child(6) {
	    left: 53%;
	    top: 50%;
	}
	&:nth-child(7) {
	    left: 61%;
	    top: 90%;
	}
	&:nth-child(8) {
	    left: 78%;
	    top: 14%;
	}
	&:nth-child(9) {
	    left: 85%;
	    top: 86%;
	}
	&:nth-child(10) {
	    left: 96%;
	    top: 59%;
	}
	&:nth-child(11) {
	    left: 3%;
	    top: 91%;
	}
	&:nth-child(12) {
	    left: 18%;
	    top: 31%;
	}
	&:nth-child(13) {
	    left: 26%;
	    top: 52%;
	}
	&:nth-child(14) {
	    left: 38%;
	    top: 36%;
	}
	&:nth-child(15) {
	    left: 43%;
	    top: 81%;
	}
	&:nth-child(16) {
	    left: 54%;
	    top: 11%;
	}
	&:nth-child(17) {
	    left: 67%;
	    top: 62%;
	}
	&:nth-child(18) {
	    left: 76%;
	    top: 9%;
	}
	&:nth-child(19) {
	    left: 87%;
	    top: 2%;
	}
	&:nth-child(20) {
	    left: 98%;
	    top: 98%;
	}
	&:nth-child(21) {
	    left: 7%;
	    top: 60%;
	}
	&:nth-child(22) {
	    left: 14%;
	    top: 45%;
	}
	&:nth-child(23) {
	    left: 25%;
	    top: 65%;
	}
	&:nth-child(24) {
	    left: 36%;
	    top: 1%;
	}
	&:nth-child(25) {
	    left: 49%;
	    top: 24%;
	}
	&:nth-child(26) {
	    left: 58%;
	    top: 32%;
	}
	&:nth-child(27) {
	    left: 69%;
	    top: 49%;
	}
	&:nth-child(28) {
	    left: 75%;
	    top: 55%;
	}
	&:nth-child(29) {
	    left: 84%;
	    top: 86%;
	}
	&:nth-child(30) {
	    left: 94%;
	    top: 90%;
	}
	&:nth-child(31) {
        left: 59%;
        top: 61%;
    }
}

.xenfocus-confetti-panel-1 {
    -webkit-animation: confetti_1 8s linear infinite;
    animation: confetti_1 8s linear infinite;

    .f-con{
    	background: fade(#e84c4c, 80%);
    	transform: rotate(30deg);
    }
}
.xenfocus-confetti-panel-2 {
    -webkit-animation: confetti_2 13s 0s linear infinite;
    animation: confetti_2 13s 0s linear infinite;

    .f-con{
    	background: fade(#5ec745, 80%);
    	transform: rotate(-10deg);
    }
}
.xenfocus-confetti-panel-3 {
    -webkit-animation: confetti_3 16s 6s linear infinite;
    animation: confetti_3 16s 6s linear infinite;

    .f-con{
    	background: fade(#3895e5, 80%);
    	transform: rotate(50deg);
    }
}

/* Hide snow on tablets and mobiles */
@media screen and (max-width:979px){
	.focus-editor-panel[data-setting=\'focus-confetti\'],
	.xenfocus-confetti{
		display: none;
	}
}

';
	}
	$__finalCompiled .= '




/*
	----------------
	- Holidays
	----------------
*/

';
	if ($__templater->func('property', array('xenfocus_holiday', ), false) != 'none') {
		$__finalCompiled .= '
	.focus-logo--holiday{
		height: 100%;
		display: flex;
		align-items: center;
	}
';
	}
	$__finalCompiled .= '

// Valentines
';
	if ($__templater->func('property', array('xenfocus_holiday', ), false) === 'valentines') {
		$__finalCompiled .= '

@-webkit-keyframes valentines{
	0%, 30%, 50%, 60%, 80%, 100% {
		transform: scale(1);
	}
	40% {
		transform: scale(1.12);
	}
	70% {
		transform: scale(1.06);
	}
}

@keyframes valentines{
	0%, 30%, 50%, 60%, 80%, 100% {
		transform: scale(1);
	}
	40% {
		transform: scale(1.12);
	}
	70% {
		transform: scale(1.06);
	}
}

.focus-logo--holiday .fa-heart{
	color: #FF717E;
	animation: valentines 2s infinite linear;
}

';
	}
	$__finalCompiled .= '

// Halloween
';
	if ($__templater->func('property', array('xenfocus_holiday', ), false) === 'halloween') {
		$__finalCompiled .= '

@keyframes halloween {
	0%,100%{
		transform: translateY(-7%);
	}
	50% {
		transform: translateY(7%);
	}
}

.p-header-logo .focus-logo--holiday img{
	max-height: 60%;
	animation: halloween 3s infinite linear;
}

';
	}
	$__finalCompiled .= '


/*
	----------------
	- Pagination
	----------------
*/

.focus-pagination(@debug) when (@debug = true) {

	.pageNav{
		display: flex;

		> *{
			flex: 0 0 auto;
			margin-right: @pagination-gap;
		}
	}

		.pageNav-main{
			display: flex;
		}

		.pageNav-jump{
			padding-left: 12px;
			padding-right: 12px;
		}

	.pageNav-page{
		display: block;
		flex: 0 0 auto;
		border-radius: inherit;
		font-weight: bold;

		&:not(:last-child){
			margin-right: @pagination-gap;
		}

		> a{
			padding-left: 11px;
			padding-right: 11px;
		}
	}


	// Make border-radius inherit from parent
	.pageNavWrapper{
		border-radius: @pagination-radius;
	}

		.pageNav,
		.pageNav-main,
		.pageNavSimple,
		.pageNav-jump,
		.pageNavSimple-el,
		#XF .pageNav-page{
			border-radius: inherit;
		}


	// Style pagination buttons
	#XF{

		.pageNav-jump,
		.pageNav-page,
		.pageNavSimple-el{
			background: @pagination-page;
			color: contrast(@pagination-page, @xf-textColor, #fff);
			border-width: 0px;
			box-shadow: @pagination-shadow;

			&:hover,
			&:active{
				background-color: @pagination-page-hover;
				//color: contrast(@pagination-page, rgba(0,0,0,0.8), #fff);
			}
		}

		// Active page
		.pageNav-page.pageNav-page--current,
		.pageNavSimple-el.pageNavSimple-el--current{
			background: @pagination-active;
			color: contrast(@pagination-active, rgba(0,0,0,0.8), #fff);
			border-width: 0;
			box-shadow: @pagination-shadow-active;

			&:hover,
			&:active{
				background-color: xf-intensify(@pagination-active, 3%);
			}
		}

		// First and Last buttons on mobiles
		.pageNavSimple-el{
			padding-left: 10px;
			padding-right: 10px;
		}

	}

	// Add space around prev/next arrow
	.pageNavSimple-el--prev i::before,
	.pageNav-jump.pageNav-jump--prev::before{
		margin-right: 3px;
		width: auto;
	}

	.pageNavSimple-el--next i::before,
	.pageNav-jump.pageNav-jump--next::after{
		margin-left: 3px;
		width: auto;
	}

}
.focus-pagination(@focus-pagination);


/*
	----------------
	- Mobile footer bar
	----------------
*/

';
	if ($__templater->func('property', array('xenfocus_mobile_navigation_bar', ), false)) {
		$__finalCompiled .= '

.mobile-navigation-bar{
	';
		if ($__templater->func('property', array('xenfocus_mnb_scroll', ), false)) {
			$__finalCompiled .= '
		position: fixed;
	';
		} else {
			$__finalCompiled .= '
		position: -webkit-sticky;
		position: sticky;
	';
		}
		$__finalCompiled .= '
	bottom: 0;
	left: 0;
	right: 0;
	background: @xf-xenfocus_mnb_background;
	color: @xf-xenfocus_mnb_color;
	z-index: 490;
	padding-bottom: env(safe-area-inset-bottom);
	padding-left: env(safe-area-inset-left);
	padding-right: env(safe-area-inset-right);
	';
		if ($__templater->func('property', array('styleType', ), false) == 'light') {
			$__finalCompiled .= '
		box-shadow: rgba(0,0,0,0.1) 0px -1px 0px;
	';
		} else {
			$__finalCompiled .= '
		box-shadow: rgba(255,255,255,0.1) 0px -1px 0px;
	';
		}
		$__finalCompiled .= '
	text-align: center;
	transform: translateY(0);
	transition: transform 0.15s ease-in-out;

	';
		if ($__templater->func('property', array('xenfocus_mnb_toggle', ), false)) {
			$__finalCompiled .= '
		// If toggling is allowed, hide the mobile footer if it has been disabled
		html:not(.focus-mobile-navigation-bar) &{
			display: none;
		}
	';
		}
		$__finalCompiled .= '

	.mobile-navigation-bar--hidden &{
		transform: translateY(~"calc(100% + 2px)");
	}
}

	@supports ((-webkit-backdrop-filter: blur(10px)) or (backdrop-filter:blur(10px))){
		.mobile-navigation-bar{
			background: fade(@xf-xenfocus_mnb_background, 80%);
			-webkit-backdrop-filter: blur(10px);
			backdrop-filter: blur(10px);
		}
	}

	// Hide the footer bar and its toggle on desktops
	@media (min-width: (@xf-responsiveMedium + 1px)){
		.mobile-navigation-bar,
		.focus-editor-panel[data-setting=\'focus-mobile-navigation-bar\']{
			display: none;
		}
	}

.mobile-navigation-bar__list{
	display: flex;
	justify-content: space-around;
	padding: 0;
	margin: 0;
	list-style: none;

	li{
		flex: 1 1 10px;
	}

	a{
		display: block;
		padding: 6px 0;
		text-decoration: none;
		color: inherit;
	}
}

	.mobile-navigation-bar__icon{
		display: flex;
		justify-content: center;
		align-items: center;
		height: 28px;
		font-size: 20px;

		i{
			font-weight: @xf-xenfocus_mnb_weight;
		}
	}

	.mobile-navigation-bar__text{
		font-size: 10px;
		text-transform: capitalize;
	}

	// Adjust elements to accommodate for the bottom bar
	@media (max-width: @xf-responsiveMedium){
		.focus-mobile-navigation-bar.has-hiddenscroll .u-scrollButtons{
			bottom: 80px;
		}

		.focus-mobile-navigation-bar .p-footer-inner{
			padding-bottom: 75px;
		}

		@supports (padding-bottom: env(safe-area-inset-bottom)){
			.focus-mobile-navigation-bar.has-hiddenscroll .u-scrollButtons{
				--mobile-navigation-bar--padding-bottom: env(safe-area-inset-bottom);
				bottom: ~"calc(var(--mobile-navigation-bar--padding-bottom) + 80px)";
			}
		}
	}

// Active icons
[data-template="forum_list"] .mobile-navigation-bar--forums,
[data-template="forum_view"] .mobile-navigation-bar--forums,
[data-template="thread_view"] .mobile-navigation-bar--forums,
[data-template="whats_new"] .mobile-navigation-bar--whatsnew,
[data-template="whats_new_posts"] .mobile-navigation-bar--whatsnew,
[data-template="whats_new_profile_posts"] .mobile-navigation-bar--whatsnew,
[data-template="news_feed"] .mobile-navigation-bar--whatsnew,
[data-template="latest_activity"] .mobile-navigation-bar--whatsnew,
[data-template="forum_post_thread"] .mobile-navigation-bar--postthread,
[data-template="login"] .mobile-navigation-bar--login,
[data-template="register"] .mobile-navigation-bar--register,
[data-template="search_form"] .mobile-navigation-bar--search,
[data-template="search_results"] .mobile-navigation-bar--search{
	color: @xf-xenfocus_mnb_active;
	font-weight: bold;
}

';
	}
	$__finalCompiled .= '

/*
	----------------
	- Animated blocks onload
	----------------
*/
/*
@keyframes loading-blocks{
	from{
		opacity: 0;
		transform: translateY(30px);
	}
	to{
		opacity: 1;
		transform: translateY(0px);
	}
}

@supports (animation-name: name){
	.block--category,
	.p-body-sidebar .block{
		opacity: 0;
		transform: translateY(30px);


		animation-name: loading-blocks;
		animation-duration: 0.4s;
		animation-fill-mode: forwards;
		animation-timing-function: ease-in-out;
		animation-iteration-count: 1;
		animation-delay: 0s;

		&:nth-child(2){
			animation-delay: 0.1s;
		}

		&:nth-child(3){
			animation-delay: 0.2s;
		}

		&:nth-child(4){
			animation-delay: 0.3s;
		}
	}
}
*/

/*
	----------------
	- iPhoneX Landscape
	----------------
*/

// iPhoneX landscape padding
@media (max-width: @xf-responsiveWide) and (orientation:landscape) and (-webkit-device-pixel-ratio : 3) {
	.p-header,
	.p-nav,
	body .p-body-inner,
	.focus-width .p-body-inner,
	.focus-footer
	{
		padding-left: ~"max(0px, env(safe-area-inset-left))";
    	padding-right: ~"max(0px, env(safe-area-inset-right))";
    }
    // Remove default
    .p-nav-inner{
    	padding-left: 0;
    	padding-right: 0;
    }
}

/*
	----------------
	- Post thread pop up
	----------------
*/

';
	if ($__templater->func('property', array('styleType', ), false) == 'light') {
		$__finalCompiled .= '
	@treeEntryChooser-header--hover: fade(@xf-linkColor, 6%);
';
	} else {
		$__finalCompiled .= '
	@treeEntryChooser-header--hover: fade(@xf-linkColor, 6%);
';
	}
	$__finalCompiled .= '

.block--treeEntryChooser{
	margin: 0;
	padding: 10px;

	&:not(:first-child){
		padding-top: 0;
	}

	a:hover{
		text-decoration: none;
	}

	.block-container{
		border-width: 0;
		box-shadow: none;
		background: @xf-paletteNeutral1;
	}

	.block-header{
		border-radius: 3px !important;
		padding: 12px 18px;
		margin: 0 0 10px 0;
		border-width: 1px;

		&::before,
		&::after{
			display: none;
		}
	}

	.block-row.block-row--separated + .block-row{
		border-width: 0;
	}

	&.block .block-row{
		padding: 10px 18px;
		border-radius: 3px !important;
	}

	// Hover
	.block-row.block-row--clickable:hover{
		background: @treeEntryChooser-header--hover;
	}

	// Forums without a category
	> .block-container > .block-row:first-child{
		margin-top: 30px;
	}
}

/*
	----------------
	- Other
	----------------
*/

// Ensure bottom margin is the same size as content padding
@media (min-width: (@xf-responsiveEdgeSpacerRemoval + 1px)){
	.p-body-header{
		margin-bottom: @content-padding;
	}
}

// Hide elements based on desktop or mobile
@media (min-width: (@xf-responsiveMedium + 1px)){
	.hide\\:desktop{
		display: none !important;
	}
}
@media (max-width: @xf-responsiveMedium){
	.hide\\:mobile{
		display: none !important;
	}
}

// Media gallery
.itemList-itemOverlay {
    height: auto;
    bottom: -70px;
}

// Remove transition from social links
.shareButtons-button{
	transition: none;
}

// Scroll buttons
.button.button--scroll, a.button.button--scroll {
    //box-shadow: 1px 2px 10px 0 rgba(0,0,0,0.25);
    box-shadow: none;
    border-color: transparent;
}

// Staff bar
.p-staffBar{
    border: 0;
    border-radius: @xf-blockBorderRadius;
    margin-bottom: 10px;
}

// Admin and moderator bar
.p-staffBar-inner{
	padding-left: 4px;
	padding-right: 4px;
	// Reset default
	max-width: none;

	.hScroller-scroll{
		display: flex;
	}
}

.p-staffBar-link{
	padding-left: 10px;
	padding-right: 10px;

	&::before{
		.m-faBase();
        .m-faContent(@fa-var-lock);
		display: inline-block;
		margin-right: 6px;
	}

	&[data-xf-key="alt+m"]::before{
		.m-faContent(@fa-var-check-square);
	}

	&[href*=\'/admin\']{
		margin-left: auto;
	}
}

// Add a background to certain boxes if a wallpaper design is used
.focus-wallpaper(@debug) when (@debug = true) {
    @{focus-wallpaper-elements}{
        .xf-contentBase();
        .xf-blockBorder();
        border-radius: @xf-blockBorderRadius;
        padding: 14px;
        .focus-block-container();
    }
	.p-body-header{
		padding: 20px 15px;
	}
}
.focus-wallpaper(@focus-wallpaper);





// Node description
.node-description{
    margin-top: 5px;
    color: @xf-textColorMuted;
}

// Soften shadows on menus
.menu{
	box-shadow: 0 5px 30px 0 rgba(0,0,0,0.25), rgba(0,0,0,0.15) 0px 3px 5px;
}

// Tooltip blur
.tooltip--basic .tooltip-content{
	-webkit-backdrop-filter: blur(5px);
	backdrop-filter: blur(5px);
}

// Avatars
.avatar{
	position: relative;
	//box-shadow: rgba(0,0,0,0.1) 0px 3px 10px;
	text-shadow: none;

	&::after{
		content: \'\';
		display: block;
		position: absolute;
		top: 0; left: 0; right: 0; bottom: 0;
		border: 1px solid fade(@xf-textColor, 15%);
		border-radius: inherit;
		pointer-events: none;
		';
	if ($__templater->func('property', array('styleType', ), false) == 'light') {
		$__finalCompiled .= '
			box-shadow: inset rgba(0,0,0,0.1) 0px 1px 3px;
		';
	}
	$__finalCompiled .= '
	}

	// Fix alignment in \'Edit Avatar\' box
	&.js-avatarCropper{
		top: 0 !important;
		left: 0 !important;
	}
}



/*
	----------------
	- Tooltips: Minimal layout for user popups, topic previews, etc
	----------------
*/

/*
body{

	.tooltip--bookmark .tooltip-content,
	.tooltip--member .tooltip-content,
	.tooltip--share .tooltip-content {
	    border-width: 0px;
	    box-shadow: 0 10px 15px 0 rgba(0,0,0,0.15), rgba(0,0,0,0.08) 0px 0px 0px 1px;
	}

	.tooltip--member.tooltip--top .tooltip-arrow{
		border-top-color: rgba(0,0,0,0.1);
	}

	.memberTooltip-header{
		background-color: transparent;
	}

	.memberTooltip-header,
	.memberTooltip-info,
	.memberTooltip-actions{
		padding: 15px;
	}

}
*/



/*
	----------------
	- BB code tag
	----------------
*/

';
	if ($__templater->func('property', array('styleType', ), false) == 'light') {
		$__finalCompiled .= '
@bbcode-comment: #a50;
@bbcode-tag: #170;
@bbcode-boolean: #219;
@bbcode-symbol: #708;
@bbcode-selector: #05a;
@bbcode-deleted: #d44;
@bbcode-inserted: #292;
@bbcode-string: #a11;
@bbcode-number: #164;
@bbcode-char: #00c;
@bbcode-variable: #05a;
@bbcode-class-name: #00f;
@bbcode-constant: #05a;
';
	} else {
		$__finalCompiled .= '
@bbcode-comment: #ebe7e3;
@bbcode-tag: #e8bd89;
@bbcode-boolean: #e8bd89;
@bbcode-symbol: #acc47e;
@bbcode-selector: #7ea9c4;
@bbcode-deleted: #797979;
@bbcode-inserted: #292;
@bbcode-string: #7ea9c4;
@bbcode-number: #e8bd89;
@bbcode-char: #df897a;
@bbcode-variable: #df897a;
@bbcode-class-name: #df897a;
@bbcode-constant: #05a;
';
	}
	$__finalCompiled .= '

.bbCodeCode
{
	.prism-token
	{
		&.prism-comment,
		&.prism-prolog,
		&.prism-doctype,
		&.prism-cdata
		{
			color: @bbcode-comment;
		}

		&.prism-tag
		{
			color: @bbcode-tag;
		}

		&.prism-boolean
		{
			color: @bbcode-boolean;
		}

		&.prism-symbol,
		&.prism-atrule,
		&.prism-keyword
		{
			color: @bbcode-symbol;
		}

		&.prism-selector,
		&.prism-function
		{
			color: @bbcode-selector;
		}

		&.prism-deleted
		{
			color: @bbcode-deleted;
		}

		&.prism-inserted
		{
			color: @bbcode-inserted;
		}

		&.prism-string,
		&.prism-attr-value
		{
			color: @bbcode-string;
		}

		&.prism-number
		{
			color: @bbcode-number;
		}

		&.prism-attr-name,
		&.prism-char,
		&.prism-builtin
		{
			color: @bbcode-char;
		}

		&.prism-regex,
		&.prism-important,
		&.prism-variable,
		&.prism-package
		{
			color: @bbcode-variable;
		}

		&.prism-class-name,
		&.prism-important,
		&.prism-bold
		{
			color: @bbcode-class-name;
		}

		&.prism-italic,
		&.prism-constant
		{
			color: @bbcode-constant;
		}
	}
}

// Prevent code block titles from being copied
.bbCodeBlock--code .bbCodeBlock-title{
	-webkit-user-select: none;
	-moz-user-select: none;
	user-select: none;
	pointer-events: none;
}
	
/*
	----------------
	- Bug fixes
	----------------
*/

// [BS] Live forum statistics
.lfs .tabGroup .structItem{
	display: table;
	> *{
		display: table-cell;
	}
}
.lfs .tabGroup .structItem-cell--secondData {
	display: none;
}

// Fix alignment of icons on Media Upload page
.mediaList.mediaList--buttons > .mediaList-button .mediaList-inner::before{
	width: 100%;
}

// Fix border color on consecutive blocks (such as profiles)
.block-body + .block-minorHeader{
	border-top-color: @xf-blockMinorHeader--border-color;
}

// Fix 3rd party addon: similar threads
';
	if ($__templater->func('property', array('xenfocus_tableLayout', ), false) != 'standard') {
		$__finalCompiled .= '
@media (min-width: (@xf-responsiveMedium + 1px)){
	.block--similarContents .structItem{
		display: flex;
	}
}
';
	}
	$__finalCompiled .= '

// Attach image popup box in editor
.fr-popup .fr-input-focus {
	background: @xf-paletteNeutral1;
}

// Insert code

	#XF .cm-s-default.CodeMirror .CodeMirror-gutters{
		background: @xf-paletteColor1;
		color: @xf-paletteColor5;
		border-color: transparent;
	}


// Remove the border on the notice system in dark themes
';
	if ($__templater->func('property', array('styleType', ), false) == 'dark') {
		$__finalCompiled .= '
	.notice{
		border-color: transparent;
		border-top-color: rgba(255,255,255,0.3);
	}
';
	}
	$__finalCompiled .= '

// Reduce z-index to prevent "Click to expand" quotes from overlapping fixed headers
.bbCodeBlock-expandLink{ z-index: 1; }

// Assign a more appropriate background to overlays since they currently use the page background
.overlay{
	background: @xf-contentBg;
}

// Correctly align icon in "incorrect password" message
.blockMessage--iconic::before{
    top: 50%;
    transform: translateY(-50%);
	left: 4px;
}

// Prevent wide menu\'s from spilling over mobiles: This occurred with the search menu 
.menu.menu--wide{
	max-width: ~"calc(100wv - 6px)";
}

// Make the css-checkbox inherit colours of surrounding text
label.iconic > input + i::before,
label.iconic > input + i:hover::before,
label.iconic:hover > input + i::before{
	color: inherit;
}

// Clear floated user links
.p-nav-opposite{
	.m-clearFix();
}

// Correctly colour the arrows in the date picker
.pika-prev, .pika-next{ color: inherit; }

// [AL] Original Poster Highlight
div.ribbonBox .ribbon-wrapper{ z-index: 1; }

// Fix anti-spam plugin on Quick Thread
.structItem > script{ display: none; }



// Modify borders and hover color of buttons by using modified mixins
.focus-m-buttonColorVariation(@bgColor; @textColor){
	.m-buttonBorderColorVariation(@bgColor);

	&:hover,
	&:active,
	&:focus{
		background-color: xf-intensify(@bgColor, 5%);
	}
}

// button--splitTrigger has been removed since it doesnt appear in any HTML template. Maybe redundant?
.focus-m-buttonBlockColorVariationSimple(@color){
	.focus-m-buttonBorderColorVariation(@color);

	/*
	&:not(.button--splitTrigger):not(.button--provider),
	&.button--splitTrigger:not(.button--provider) > .button-text,
	&.button--splitTrigger:not(.button--provider) > .button-menu{
		&:hover,
		&:focus,
		&:active{
			background-color: xf-intensify(@color, 5%);
		}
	}
	*/
	// Instead of the above, use this...
	&:not(.button--provider){
		&:hover,
		&:focus,
		&:active{
			background-color: xf-intensify(@color, 5%);
		}
	}
}

.focus-m-buttonBorderColorVariation(@borderColor){
	border-color: xf-intensify(@borderColor, 9%);

	/*
	&.button--splitTrigger{
		> .button-text { border-right-color: xf-intensify(@borderColor, 9%); }
		> .button-menu { border-left-color: xf-intensify(@borderColor, 9%); }
	}
	*/
}

.button,
a.button{
	.focus-m-buttonBlockColorVariationSimple(xf-default(@xf-buttonDefault--background-color, transparent));

	&.button--primary{
		.focus-m-buttonBlockColorVariationSimple(xf-default(@xf-buttonPrimary--background-color, transparent));
	}
	&.button--cta{
		.focus-m-buttonBlockColorVariationSimple(xf-default(@xf-buttonCta--background-color, transparent));
	}
	&.button--link{
		.focus-m-buttonBorderColorVariation(@xf-borderColor);
		color: xf-intensify(@xf-borderColorHeavy, 50%);
		&:hover,
		&:active,
		&:focus{
			background: xf-intensify(@xf-contentBg, 5%);
		}
	}
	&.is-disabled{
		.focus-m-buttonBorderColorVariation(xf-default(@xf-buttonDisabled--background-color, transparent));
	}
}

.toggleButton{
	> span{
		.focus-m-buttonBorderColorVariation(xf-default(@xf-buttonDisabled--background-color, transparent));
	}
	> input:checked + span{
		.focus-m-buttonBlockColorVariationSimple(xf-default(@xf-buttonDefault--background-color, transparent));
	}
}

// Buttons in block-header
.block-header .button.button--link{
	background: fade(@xf-blockHeader--color, 10%);
	color: inherit;
	border-color: fade(@xf-blockHeader--color, 40%);

	&:hover{
		background: fade(@xf-blockHeader--color, 20%);
	}
}


:root{
	@media (max-width: @xf-responsiveNarrow){
		--responsive: \'max-width responsiveNarrow\';
	}

	@media (min-width: (@xf-responsiveNarrow + 1px)) and (max-width: @xf-responsiveMedium){
		--responsive: \'max-width responsiveMedium\';
	}

	@media (min-width: (@xf-responsiveMedium + 1px)) and (max-width: @xf-responsiveWide){
		--responsive: \'max-width responsiveWide\';
	}

	@media (min-width: (@xf-responsiveWide + 1px)){
		--responsive: \'Larger than responsiveWide\';
	}





	--xenfocus-version: \'2.2.15\';
	--xenfocus-date: \'February 4, 2024\';
}';
	return $__finalCompiled;
}
);