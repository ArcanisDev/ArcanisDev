<?php
// FROM HASH: c7b454823b2e5c9b03b27fbdf85e4779
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '@body-padding-bottom: 10px;
@breadcrumb-shadow: rgba(0,0,0,0.4);
@sticky-top: @xf-xenfocus_navHeight + 16;
@register-offset-v: 10px;
@focus-editor-overlay: rgba(255,255,255,0.4);

/*
	----------------
	- Backgrounds
	----------------
*/

.background-fade {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    overflow: hidden;
}

.background-fade-image {
    position: relative;

    &::before {
		//height: calc(919 / 1800 * 100vw);
		background-size: cover;
		background-position: 50% 0;
		background-repeat: no-repeat;
		content: \'\';
		display: block;
	}

	&::after {
		//background-image: linear-gradient(to bottom, rgba(26,25,33,0) 0, rgba(26,25,33,1) 95%);
		height: 50%;
		content: \'\';
		position: absolute;
		left: 0;
		right: 0;
		bottom: 0;
	}
}

// Blur effect
.xenfocus-blur{
	position: absolute;
	overflow: hidden;
	border-radius: 3px;
	top: 8px;
	right: 8px;
	bottom: 8px;
	left: 8px;
	z-index: 0;
}

.xenfocus-blur,
.block-header{
	&::before{
		content: \'\';
		position: absolute;
		top: -35px;
		left: -35px;
		right: -35px;
		bottom: -35px;
		-webkit-filter: blur(35px) saturate(320%);
		filter: blur(35px) saturate(320%);
		z-index: -2;
		background-size: 100vw auto;
		background-position: 50% 50%;
		display: block;

		.nav-wrap &{
			background-position: 50% @align-nav-blur;
		}
	}

	&::after {
		content: \'\';
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		border-radius: inherit;
		background: rgba(255,255,255,0.1) url(\'' . $__templater->func('asset', array('xenfocus', ), true) . '/texture.png\') repeat 50% 50%;
		border-radius: 3px;
		box-shadow: inset rgba(255,255,255,0.1) 0px 0px 0px 1px, inset rgba(255,255,255,0.3) 0px 1px 0px;
		z-index: -1;
		display: block;
	}
}

@background1-width: 1800;
@background1-height: 900;

@background2-width: 1800;
@background2-height: 900;

@background3-width: 1800;
@background3-height: 900;

@background4-width: 1800;
@background4-height: 900;

@background5-width: 1800;
@background5-height: 900;

@background6-width: 1800;
@background6-height: 900;

@background7-width: 1800;
@background7-height: 900;

@background8-width: 1800;
@background8-height: 900;

@background9-width: 1800;
@background9-height: 900;

@background10-width: 1800;
@background10-height: 900;

html[data-focus-bg=\'1\']{
	&,
	.xenfocus-blur::before,
	.block-header::before,
	.block-minorHeader{
		background-color: @xf-xenfocus_bg1_hex;
	}
	';
	if ($__templater->func('property', array('xenfocus_bg1_image', ), false)) {
		$__finalCompiled .= '
		';
		if ($__templater->func('property', array('xenfocus_bg1_attachment', ), false) == 'fixed') {
			$__finalCompiled .= '
		.background-fade{
			position: fixed;
			height: 100%;
		}
		';
		}
		$__finalCompiled .= '
		.xenfocus-blur::before,
		.block-header::before{
			background-image: url(@xf-xenfocus_bg1_image);
			// If a pattern is used or if the natural size is requested..
			';
		if ((($__templater->func('property', array('xenfocus_bg1_repeat', ), false) == 'repeat')) OR (($__templater->func('property', array('xenfocus_bg1_size', ), false) == 'auto'))) {
			$__finalCompiled .= '
				background-size: auto;
			';
		}
		$__finalCompiled .= '
		}
		.background-fade-image {
	    	';
		if ($__templater->func('property', array('xenfocus_bg1_repeat', ), false) == 'repeat') {
			$__finalCompiled .= '
		    	height: 100%;
		    ';
		}
		$__finalCompiled .= '
	    	&::before {
	    		// Display image at faux-cover size by default
				background-image: url(@xf-xenfocus_bg1_image);
				height: calc(@background1-height / @background1-width * 100vw);

				// If \'auto\' is assigned in style properties, image will be shown at natural size
				';
		if ($__templater->func('property', array('xenfocus_bg1_size', ), false) == 'auto') {
			$__finalCompiled .= '
			    	height: @background1-height*1px;
				    background-size: auto;
			    ';
		}
		$__finalCompiled .= '

			    // If repeat is selected, a pattern is assumed, which covers the whole page
			    ';
		if ($__templater->func('property', array('xenfocus_bg1_repeat', ), false) == 'repeat') {
			$__finalCompiled .= '
			    	background-repeat: repeat;
			    	height: 100%;
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
	    	}
	    	&::after {
				background-image: linear-gradient(to bottom, fade(@xf-xenfocus_bg1_hex, 0%) 0, @xf-xenfocus_bg1_hex 95%);

				// Remove gradient if a pattern is used
				';
		if ($__templater->func('property', array('xenfocus_bg1_repeat', ), false) == 'repeat') {
			$__finalCompiled .= '
					display: none;
				';
		}
		$__finalCompiled .= '
			}
	    }
	';
	} else {
		$__finalCompiled .= '
		.background-image-fade{
			display: none;
		}
	';
	}
	$__finalCompiled .= '
}

html[data-focus-bg=\'2\']{
	&,
	.xenfocus-blur::before,
	.block-header::before,
	.block-minorHeader{
		background-color: @xf-xenfocus_bg2_hex;
	}
	';
	if ($__templater->func('property', array('xenfocus_bg2_image', ), false)) {
		$__finalCompiled .= '
		';
		if ($__templater->func('property', array('xenfocus_bg2_attachment', ), false) == 'fixed') {
			$__finalCompiled .= '
		.background-fade{
			position: fixed;
			height: 100%;
		}
		';
		}
		$__finalCompiled .= '
		.xenfocus-blur::before,
		.block-header::before{
			background-image: url(@xf-xenfocus_bg2_image);
			// If a pattern is used or if the natural size is requested..
			';
		if ((($__templater->func('property', array('xenfocus_bg2_repeat', ), false) == 'repeat')) OR (($__templater->func('property', array('xenfocus_bg2_size', ), false) == 'auto'))) {
			$__finalCompiled .= '
				background-size: auto;
			';
		}
		$__finalCompiled .= '
		}
		.background-fade-image {
	    	';
		if ($__templater->func('property', array('xenfocus_bg2_repeat', ), false) == 'repeat') {
			$__finalCompiled .= '
		    	height: 100%;
		    ';
		}
		$__finalCompiled .= '
	    	&::before {
	    		// Display image at faux-cover size by default
				background-image: url(@xf-xenfocus_bg2_image);
				height: calc(@background2-height / @background2-width * 100vw);

				// If \'auto\' is assigned in style properties, image will be shown at natural size
				';
		if ($__templater->func('property', array('xenfocus_bg2_size', ), false) == 'auto') {
			$__finalCompiled .= '
			    	height: @background2-height*1px;
				    background-size: auto;
			    ';
		}
		$__finalCompiled .= '

			    // If repeat is selected, a pattern is assumed, which covers the whole page
			    ';
		if ($__templater->func('property', array('xenfocus_bg2_repeat', ), false) == 'repeat') {
			$__finalCompiled .= '
			    	background-repeat: repeat;
			    	height: 100%;
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
	    	}
	    	&::after {
				background-image: linear-gradient(to bottom, fade(@xf-xenfocus_bg2_hex, 0%) 0, @xf-xenfocus_bg2_hex 95%);

				// Remove gradient if a pattern is used
				';
		if ($__templater->func('property', array('xenfocus_bg2_repeat', ), false) == 'repeat') {
			$__finalCompiled .= '
					display: none;
				';
		}
		$__finalCompiled .= '
			}
	    }
	';
	} else {
		$__finalCompiled .= '
		.background-image-fade{
			display: none;
		}
	';
	}
	$__finalCompiled .= '
}

html[data-focus-bg=\'3\']{
	&,
	.xenfocus-blur::before,
	.block-header::before,
	.block-minorHeader{
		background-color: @xf-xenfocus_bg3_hex;
	}
	';
	if ($__templater->func('property', array('xenfocus_bg3_image', ), false)) {
		$__finalCompiled .= '
		';
		if ($__templater->func('property', array('xenfocus_bg3_attachment', ), false) == 'fixed') {
			$__finalCompiled .= '
		.background-fade{
			position: fixed;
			height: 100%;
		}
		';
		}
		$__finalCompiled .= '
		.xenfocus-blur::before,
		.block-header::before{
			background-image: url(@xf-xenfocus_bg3_image);
			// If a pattern is used or if the natural size is requested..
			';
		if ((($__templater->func('property', array('xenfocus_bg3_repeat', ), false) == 'repeat')) OR (($__templater->func('property', array('xenfocus_bg3_size', ), false) == 'auto'))) {
			$__finalCompiled .= '
				background-size: auto;
			';
		}
		$__finalCompiled .= '
		}
		.background-fade-image {
	    	';
		if ($__templater->func('property', array('xenfocus_bg3_repeat', ), false) == 'repeat') {
			$__finalCompiled .= '
		    	height: 100%;
		    ';
		}
		$__finalCompiled .= '
	    	&::before {
	    		// Display image at faux-cover size by default
				background-image: url(@xf-xenfocus_bg3_image);
				height: calc(@background3-height / @background3-width * 100vw);

				// If \'auto\' is assigned in style properties, image will be shown at natural size
				';
		if ($__templater->func('property', array('xenfocus_bg3_size', ), false) == 'auto') {
			$__finalCompiled .= '
			    	height: @background3-height*1px;
				    background-size: auto;
			    ';
		}
		$__finalCompiled .= '

			    // If repeat is selected, a pattern is assumed, which covers the whole page
			    ';
		if ($__templater->func('property', array('xenfocus_bg3_repeat', ), false) == 'repeat') {
			$__finalCompiled .= '
			    	background-repeat: repeat;
			    	height: 100%;
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
	    	}
	    	&::after {
				background-image: linear-gradient(to bottom, fade(@xf-xenfocus_bg3_hex, 0%) 0, @xf-xenfocus_bg3_hex 95%);

				// Remove gradient if a pattern is used
				';
		if ($__templater->func('property', array('xenfocus_bg3_repeat', ), false) == 'repeat') {
			$__finalCompiled .= '
					display: none;
				';
		}
		$__finalCompiled .= '
			}
	    }
	';
	} else {
		$__finalCompiled .= '
		.background-image-fade{
			display: none;
		}
	';
	}
	$__finalCompiled .= '
}

html[data-focus-bg=\'4\']{
	&,
	.xenfocus-blur::before,
	.block-header::before,
	.block-minorHeader{
		background-color: @xf-xenfocus_bg4_hex;
	}
	';
	if ($__templater->func('property', array('xenfocus_bg4_image', ), false)) {
		$__finalCompiled .= '
		';
		if ($__templater->func('property', array('xenfocus_bg4_attachment', ), false) == 'fixed') {
			$__finalCompiled .= '
		.background-fade{
			position: fixed;
			height: 100%;
		}
		';
		}
		$__finalCompiled .= '
		.xenfocus-blur::before,
		.block-header::before{
			background-image: url(@xf-xenfocus_bg4_image);
			// If a pattern is used or if the natural size is requested..
			';
		if ((($__templater->func('property', array('xenfocus_bg4_repeat', ), false) == 'repeat')) OR (($__templater->func('property', array('xenfocus_bg4_size', ), false) == 'auto'))) {
			$__finalCompiled .= '
				background-size: auto;
			';
		}
		$__finalCompiled .= '
		}
		.background-fade-image {
	    	';
		if ($__templater->func('property', array('xenfocus_bg4_repeat', ), false) == 'repeat') {
			$__finalCompiled .= '
		    	height: 100%;
		    ';
		}
		$__finalCompiled .= '
	    	&::before {
	    		// Display image at faux-cover size by default
				background-image: url(@xf-xenfocus_bg4_image);
				height: calc(@background4-height / @background4-width * 100vw);

				// If \'auto\' is assigned in style properties, image will be shown at natural size
				';
		if ($__templater->func('property', array('xenfocus_bg4_size', ), false) == 'auto') {
			$__finalCompiled .= '
			    	height: @background4-height*1px;
				    background-size: auto;
			    ';
		}
		$__finalCompiled .= '

			    // If repeat is selected, a pattern is assumed, which covers the whole page
			    ';
		if ($__templater->func('property', array('xenfocus_bg4_repeat', ), false) == 'repeat') {
			$__finalCompiled .= '
			    	background-repeat: repeat;
			    	height: 100%;
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
	    	}
	    	&::after {
				background-image: linear-gradient(to bottom, fade(@xf-xenfocus_bg4_hex, 0%) 0, @xf-xenfocus_bg4_hex 95%);

				// Remove gradient if a pattern is used
				';
		if ($__templater->func('property', array('xenfocus_bg4_repeat', ), false) == 'repeat') {
			$__finalCompiled .= '
					display: none;
				';
		}
		$__finalCompiled .= '
			}
	    }
	';
	} else {
		$__finalCompiled .= '
		.background-image-fade{
			display: none;
		}
	';
	}
	$__finalCompiled .= '
}

html[data-focus-bg=\'5\']{
	&,
	.xenfocus-blur::before,
	.block-header::before,
	.block-minorHeader{
		background-color: @xf-xenfocus_bg5_hex;
	}
	';
	if ($__templater->func('property', array('xenfocus_bg5_image', ), false)) {
		$__finalCompiled .= '
		';
		if ($__templater->func('property', array('xenfocus_bg5_attachment', ), false) == 'fixed') {
			$__finalCompiled .= '
		.background-fade{
			position: fixed;
			height: 100%;
		}
		';
		}
		$__finalCompiled .= '
		.xenfocus-blur::before,
		.block-header::before{
			background-image: url(@xf-xenfocus_bg5_image);
			// If a pattern is used or if the natural size is requested..
			';
		if ((($__templater->func('property', array('xenfocus_bg5_repeat', ), false) == 'repeat')) OR (($__templater->func('property', array('xenfocus_bg5_size', ), false) == 'auto'))) {
			$__finalCompiled .= '
				background-size: auto;
			';
		}
		$__finalCompiled .= '
		}
		.background-fade-image {
	    	';
		if ($__templater->func('property', array('xenfocus_bg5_repeat', ), false) == 'repeat') {
			$__finalCompiled .= '
		    	height: 100%;
		    ';
		}
		$__finalCompiled .= '
	    	&::before {
	    		// Display image at faux-cover size by default
				background-image: url(@xf-xenfocus_bg5_image);
				height: calc(@background5-height / @background5-width * 100vw);

				// If \'auto\' is assigned in style properties, image will be shown at natural size
				';
		if ($__templater->func('property', array('xenfocus_bg5_size', ), false) == 'auto') {
			$__finalCompiled .= '
			    	height: @background5-height*1px;
				    background-size: auto;
			    ';
		}
		$__finalCompiled .= '

			    // If repeat is selected, a pattern is assumed, which covers the whole page
			    ';
		if ($__templater->func('property', array('xenfocus_bg5_repeat', ), false) == 'repeat') {
			$__finalCompiled .= '
			    	background-repeat: repeat;
			    	height: 100%;
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
	    	}
	    	&::after {
				background-image: linear-gradient(to bottom, fade(@xf-xenfocus_bg5_hex, 0%) 0, @xf-xenfocus_bg5_hex 95%);

				// Remove gradient if a pattern is used
				';
		if ($__templater->func('property', array('xenfocus_bg5_repeat', ), false) == 'repeat') {
			$__finalCompiled .= '
					display: none;
				';
		}
		$__finalCompiled .= '
			}
	    }
	';
	} else {
		$__finalCompiled .= '
		.background-image-fade{
			display: none;
		}
	';
	}
	$__finalCompiled .= '
}

html[data-focus-bg=\'6\']{
	&,
	.xenfocus-blur::before,
	.block-header::before,
	.block-minorHeader{
		background-color: @xf-xenfocus_bg6_hex;
	}
	';
	if ($__templater->func('property', array('xenfocus_bg6_image', ), false)) {
		$__finalCompiled .= '
		';
		if ($__templater->func('property', array('xenfocus_bg6_attachment', ), false) == 'fixed') {
			$__finalCompiled .= '
		.background-fade{
			position: fixed;
			height: 100%;
		}
		';
		}
		$__finalCompiled .= '
		.xenfocus-blur::before,
		.block-header::before{
			background-image: url(@xf-xenfocus_bg6_image);
			// If a pattern is used or if the natural size is requested..
			';
		if ((($__templater->func('property', array('xenfocus_bg6_repeat', ), false) == 'repeat')) OR (($__templater->func('property', array('xenfocus_bg6_size', ), false) == 'auto'))) {
			$__finalCompiled .= '
				background-size: auto;
			';
		}
		$__finalCompiled .= '
		}
		.background-fade-image {
	    	';
		if ($__templater->func('property', array('xenfocus_bg6_repeat', ), false) == 'repeat') {
			$__finalCompiled .= '
		    	height: 100%;
		    ';
		}
		$__finalCompiled .= '
	    	&::before {
	    		// Display image at faux-cover size by default
				background-image: url(@xf-xenfocus_bg6_image);
				height: calc(@background6-height / @background6-width * 100vw);

				// If \'auto\' is assigned in style properties, image will be shown at natural size
				';
		if ($__templater->func('property', array('xenfocus_bg6_size', ), false) == 'auto') {
			$__finalCompiled .= '
			    	height: @background6-height*1px;
				    background-size: auto;
			    ';
		}
		$__finalCompiled .= '

			    // If repeat is selected, a pattern is assumed, which covers the whole page
			    ';
		if ($__templater->func('property', array('xenfocus_bg6_repeat', ), false) == 'repeat') {
			$__finalCompiled .= '
			    	background-repeat: repeat;
			    	height: 100%;
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
	    	}
	    	&::after {
				background-image: linear-gradient(to bottom, fade(@xf-xenfocus_bg6_hex, 0%) 0, @xf-xenfocus_bg6_hex 95%);

				// Remove gradient if a pattern is used
				';
		if ($__templater->func('property', array('xenfocus_bg6_repeat', ), false) == 'repeat') {
			$__finalCompiled .= '
					display: none;
				';
		}
		$__finalCompiled .= '
			}
	    }
	';
	} else {
		$__finalCompiled .= '
		.background-image-fade{
			display: none;
		}
	';
	}
	$__finalCompiled .= '
}

html[data-focus-bg=\'7\']{
	&,
	.xenfocus-blur::before,
	.block-header::before,
	.block-minorHeader{
		background-color: @xf-xenfocus_bg7_hex;
	}
	';
	if ($__templater->func('property', array('xenfocus_bg7_image', ), false)) {
		$__finalCompiled .= '
		';
		if ($__templater->func('property', array('xenfocus_bg7_attachment', ), false) == 'fixed') {
			$__finalCompiled .= '
		.background-fade{
			position: fixed;
			height: 100%;
		}
		';
		}
		$__finalCompiled .= '
		.xenfocus-blur::before,
		.block-header::before{
			background-image: url(@xf-xenfocus_bg7_image);
			// If a pattern is used or if the natural size is requested..
			';
		if ((($__templater->func('property', array('xenfocus_bg7_repeat', ), false) == 'repeat')) OR (($__templater->func('property', array('xenfocus_bg7_size', ), false) == 'auto'))) {
			$__finalCompiled .= '
				background-size: auto;
			';
		}
		$__finalCompiled .= '
		}
		.background-fade-image {
	    	';
		if ($__templater->func('property', array('xenfocus_bg7_repeat', ), false) == 'repeat') {
			$__finalCompiled .= '
		    	height: 100%;
		    ';
		}
		$__finalCompiled .= '
	    	&::before {
	    		// Display image at faux-cover size by default
				background-image: url(@xf-xenfocus_bg7_image);
				height: calc(@background7-height / @background7-width * 100vw);

				// If \'auto\' is assigned in style properties, image will be shown at natural size
				';
		if ($__templater->func('property', array('xenfocus_bg7_size', ), false) == 'auto') {
			$__finalCompiled .= '
			    	height: @background7-height*1px;
				    background-size: auto;
			    ';
		}
		$__finalCompiled .= '

			    // If repeat is selected, a pattern is assumed, which covers the whole page
			    ';
		if ($__templater->func('property', array('xenfocus_bg7_repeat', ), false) == 'repeat') {
			$__finalCompiled .= '
			    	background-repeat: repeat;
			    	height: 100%;
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
	    	}
	    	&::after {
				background-image: linear-gradient(to bottom, fade(@xf-xenfocus_bg7_hex, 0%) 0, @xf-xenfocus_bg7_hex 95%);

				// Remove gradient if a pattern is used
				';
		if ($__templater->func('property', array('xenfocus_bg7_repeat', ), false) == 'repeat') {
			$__finalCompiled .= '
					display: none;
				';
		}
		$__finalCompiled .= '
			}
	    }
	';
	} else {
		$__finalCompiled .= '
		.background-image-fade{
			display: none;
		}
	';
	}
	$__finalCompiled .= '
}

html[data-focus-bg=\'8\']{
	&,
	.xenfocus-blur::before,
	.block-header::before,
	.block-minorHeader{
		background-color: @xf-xenfocus_bg8_hex;
	}
	';
	if ($__templater->func('property', array('xenfocus_bg8_image', ), false)) {
		$__finalCompiled .= '
		';
		if ($__templater->func('property', array('xenfocus_bg8_attachment', ), false) == 'fixed') {
			$__finalCompiled .= '
		.background-fade{
			position: fixed;
			height: 100%;
		}
		';
		}
		$__finalCompiled .= '
		.xenfocus-blur::before,
		.block-header::before{
			background-image: url(@xf-xenfocus_bg8_image);
			// If a pattern is used or if the natural size is requested..
			';
		if ((($__templater->func('property', array('xenfocus_bg8_repeat', ), false) == 'repeat')) OR (($__templater->func('property', array('xenfocus_bg8_size', ), false) == 'auto'))) {
			$__finalCompiled .= '
				background-size: auto;
			';
		}
		$__finalCompiled .= '
		}
		.background-fade-image {
	    	';
		if ($__templater->func('property', array('xenfocus_bg8_repeat', ), false) == 'repeat') {
			$__finalCompiled .= '
		    	height: 100%;
		    ';
		}
		$__finalCompiled .= '
	    	&::before {
	    		// Display image at faux-cover size by default
				background-image: url(@xf-xenfocus_bg8_image);
				height: calc(@background8-height / @background8-width * 100vw);

				// If \'auto\' is assigned in style properties, image will be shown at natural size
				';
		if ($__templater->func('property', array('xenfocus_bg8_size', ), false) == 'auto') {
			$__finalCompiled .= '
			    	height: @background8-height*1px;
				    background-size: auto;
			    ';
		}
		$__finalCompiled .= '

			    // If repeat is selected, a pattern is assumed, which covers the whole page
			    ';
		if ($__templater->func('property', array('xenfocus_bg8_repeat', ), false) == 'repeat') {
			$__finalCompiled .= '
			    	background-repeat: repeat;
			    	height: 100%;
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
	    	}
	    	&::after {
				background-image: linear-gradient(to bottom, fade(@xf-xenfocus_bg8_hex, 0%) 0, @xf-xenfocus_bg8_hex 95%);

				// Remove gradient if a pattern is used
				';
		if ($__templater->func('property', array('xenfocus_bg8_repeat', ), false) == 'repeat') {
			$__finalCompiled .= '
					display: none;
				';
		}
		$__finalCompiled .= '
			}
	    }
	';
	} else {
		$__finalCompiled .= '
		.background-image-fade{
			display: none;
		}
	';
	}
	$__finalCompiled .= '
}

html[data-focus-bg=\'9\']{
	&,
	.xenfocus-blur::before,
	.block-header::before,
	.block-minorHeader{
		background-color: @xf-xenfocus_bg9_hex;
	}
	';
	if ($__templater->func('property', array('xenfocus_bg9_image', ), false)) {
		$__finalCompiled .= '
		';
		if ($__templater->func('property', array('xenfocus_bg9_attachment', ), false) == 'fixed') {
			$__finalCompiled .= '
		.background-fade{
			position: fixed;
			height: 100%;
		}
		';
		}
		$__finalCompiled .= '
		.xenfocus-blur::before,
		.block-header::before{
			background-image: url(@xf-xenfocus_bg9_image);
			// If a pattern is used or if the natural size is requested..
			';
		if ((($__templater->func('property', array('xenfocus_bg9_repeat', ), false) == 'repeat')) OR (($__templater->func('property', array('xenfocus_bg9_size', ), false) == 'auto'))) {
			$__finalCompiled .= '
				background-size: auto;
			';
		}
		$__finalCompiled .= '
		}
		.background-fade-image {
	    	';
		if ($__templater->func('property', array('xenfocus_bg9_repeat', ), false) == 'repeat') {
			$__finalCompiled .= '
		    	height: 100%;
		    ';
		}
		$__finalCompiled .= '
	    	&::before {
	    		// Display image at faux-cover size by default
				background-image: url(@xf-xenfocus_bg9_image);
				height: calc(@background9-height / @background9-width * 100vw);

				// If \'auto\' is assigned in style properties, image will be shown at natural size
				';
		if ($__templater->func('property', array('xenfocus_bg9_size', ), false) == 'auto') {
			$__finalCompiled .= '
			    	height: @background9-height*1px;
				    background-size: auto;
			    ';
		}
		$__finalCompiled .= '

			    // If repeat is selected, a pattern is assumed, which covers the whole page
			    ';
		if ($__templater->func('property', array('xenfocus_bg9_repeat', ), false) == 'repeat') {
			$__finalCompiled .= '
			    	background-repeat: repeat;
			    	height: 100%;
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
	    	}
	    	&::after {
				background-image: linear-gradient(to bottom, fade(@xf-xenfocus_bg9_hex, 0%) 0, @xf-xenfocus_bg9_hex 95%);

				// Remove gradient if a pattern is used
				';
		if ($__templater->func('property', array('xenfocus_bg9_repeat', ), false) == 'repeat') {
			$__finalCompiled .= '
					display: none;
				';
		}
		$__finalCompiled .= '
			}
	    }
	';
	} else {
		$__finalCompiled .= '
		.background-image-fade{
			display: none;
		}
	';
	}
	$__finalCompiled .= '
}

html[data-focus-bg=\'10\']{
	&,
	.xenfocus-blur::before,
	.block-header::before,
	.block-minorHeader{
		background-color: @xf-xenfocus_bg10_hex;
	}
	';
	if ($__templater->func('property', array('xenfocus_bg10_image', ), false)) {
		$__finalCompiled .= '
		';
		if ($__templater->func('property', array('xenfocus_bg10_attachment', ), false) == 'fixed') {
			$__finalCompiled .= '
		.background-fade{
			position: fixed;
			height: 100%;
		}
		';
		}
		$__finalCompiled .= '
		.xenfocus-blur::before,
		.block-header::before{
			background-image: url(@xf-xenfocus_bg10_image);
			// If a pattern is used or if the natural size is requested..
			';
		if ((($__templater->func('property', array('xenfocus_bg10_repeat', ), false) == 'repeat')) OR (($__templater->func('property', array('xenfocus_bg10_size', ), false) == 'auto'))) {
			$__finalCompiled .= '
				background-size: auto;
			';
		}
		$__finalCompiled .= '
		}
		.background-fade-image {
	    	';
		if ($__templater->func('property', array('xenfocus_bg10_repeat', ), false) == 'repeat') {
			$__finalCompiled .= '
		    	height: 100%;
		    ';
		}
		$__finalCompiled .= '
	    	&::before {
	    		// Display image at faux-cover size by default
				background-image: url(@xf-xenfocus_bg10_image);
				height: calc(@background10-height / @background10-width * 100vw);

				// If \'auto\' is assigned in style properties, image will be shown at natural size
				';
		if ($__templater->func('property', array('xenfocus_bg10_size', ), false) == 'auto') {
			$__finalCompiled .= '
			    	height: @background10-height*1px;
				    background-size: auto;
			    ';
		}
		$__finalCompiled .= '

			    // If repeat is selected, a pattern is assumed, which covers the whole page
			    ';
		if ($__templater->func('property', array('xenfocus_bg10_repeat', ), false) == 'repeat') {
			$__finalCompiled .= '
			    	background-repeat: repeat;
			    	height: 100%;
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
	    	}
	    	&::after {
				background-image: linear-gradient(to bottom, fade(@xf-xenfocus_bg10_hex, 0%) 0, @xf-xenfocus_bg10_hex 95%);

				// Remove gradient if a pattern is used
				';
		if ($__templater->func('property', array('xenfocus_bg10_repeat', ), false) == 'repeat') {
			$__finalCompiled .= '
					display: none;
				';
		}
		$__finalCompiled .= '
			}
	    }
	';
	} else {
		$__finalCompiled .= '
		.background-image-fade{
			display: none;
		}
	';
	}
	$__finalCompiled .= '
}


/*
	----------------
	- Logo
	----------------
*/

@logo-slogan-opacity: 0.7;
@logo-slogan-size: 0.3em;
@logo-slogan-margin: 10px;

.focus-logo--name{
	text-shadow: 0px 0px 20px, rgba(0,0,0,0.6) 0px 1px 2px;
}


/*
	----------------
	- Navigation
	----------------
*/

.focus-wrap-nav{
	font-family: \'Oswald\', sans-serif;
	text-transform: uppercase;
}

@align-nav-blur: -1px * @xf-xenfocus_logoHeight + 35;

.nav-wrap{
	background-color: rgba(10,10,10,0.85);
	box-shadow: inset rgba(0,0,0,0.8) 0px 1px 8px, rgba(255,255,255,0.1) 0px 0px 0px 1px, rgba(255,255,255,0.1) 0px 1px 0px;
	border-radius: 4px;
	position: relative;

	.nav-main-wrap{
		padding: 8px;
		position: relative;
	}

	.p-sectionLinks{
		border: 0;
		background: none;
		margin-top: -8px;
	}
}

// Second navigation bar
.p-nav{
	background: none;
}




/* Interface effect */
.p-nav-list{
	padding: 0 10px;

	// Remove float and use flexbox instead
	.p-navEl-link{
		float: none;
	}

	.p-navEl{
		display: flex;
		position: relative;
		vertical-align: top;

		&::before,
		&::after{
			content: \'\';
			display: block;
			height: 100%;
			position: absolute;
			top: 0;
			left: -8px;
			right: 40px;
			background: url(\'' . $__templater->func('asset', array('xenfocus', ), true) . '/nav-hover.png\') no-repeat;
			background-position: 0 50%;
			background-size: 400px 80px;
			pointer-events: none;
			z-index: -1;
			opacity: 0;
			
			transition-property: transform, opacity;
			transition-duration: 0.25s, 0.25s;
			transition-delay: 0.25s, 0s;
			transition-timing-function: ease-in-out;
			
			transform: scaleY(0) translate(0,0);
			transform-origin: 100% 50%;
		}

		&::after{
			left: auto;
			right: -8px;
			width: 48px;
			background-position: 100% 50%;
			transform-origin: 0% 50%;
		}

		&:hover::before,
		&:hover::after{
			opacity: 1;
			transform: scaleY(1) translate(0,0);
			transition-delay: 0s, 0s;
		}

		&.is-selected{
			&::before,
			&::after{
				opacity: 1;
				transform: none;
				background-image: url(\'' . $__templater->func('asset', array('xenfocus', ), true) . '/nav-active.png\');
				background-size: 408px 80px;
				left: -5px;
				right: 30px;
			}
			&::after{
				left: auto;
				right: -5px;
				width: 35px;
			}
			.p-navEl-splitTrigger{
				padding-right: 16px;
			}
		}

		.p-navEl-splitTrigger::before{
			background: linear-gradient(to right, @xf-publicNavTab--color 0%, fade(@xf-publicNavTab--color, 0%) 100%);
		}
	}
}


/*
	----------------
	- Search
	----------------
*/

.focus-search{
	box-shadow: inset rgba(255,255,255,0.2) 0px 1px 0px, rgba(0,0,0,0.3) 0px 1px 4px;
	-webkit-backdrop-filter: blur(15px) saturate(130%);
	backdrop-filter: blur(15px) saturate(130%);
}

/*
	----------------
	- Breadcrumbs
	----------------
*/

.xenfocus_breadcrumb(){
	box-shadow: inset rgba(255,255,255,0.3) 0px 1px 0px, rgba(0,0,0,0.3) 0px 1px 3px;
	-webkit-backdrop-filter: blur(15px) saturate(130%);
	backdrop-filter: blur(15px) saturate(130%);	
}


/*
	----------------
	- Social
	----------------
*/

.xenfocus-social a:not(:hover){
	background-color: @xf-xenfocus_breadcrumb--background-color;
	background-image: @xf-xenfocus_breadcrumb--background-image;
	-webkit-backdrop-filter: blur(15px) saturate(130%);
	backdrop-filter: blur(15px) saturate(130%);	
}

.xenfocus-social a:hover::after {
    background: none;
}



/*
	----------------
	- Content wrapper
	----------------
*/

// Page titles
.p-title-value{
	text-transform: uppercase;
	font-family: "Oswald",sans-serif;
}


/*
	----------------
	- Blocks
	----------------
*/

.block-header{
	position: relative;
	z-index: 0;
	overflow: hidden;
	background: none;
}

body[data-template="forum_list"] .p-body-pageContent .block-container{
	padding: 7px;
}

.focus-grid .block--category .block-body{
	background: transparent;
	margin: @grid-node-gap -@grid-node-gap -@grid-node-gap -@grid-node-gap;
	padding: 0;
}

@media (min-width: (@xf-responsiveMedium + 1px)){

	html:not(.focus-grid) body[data-template="forum_list"] .p-body-pageContent{

		// Increase padding of index boxes
		';
	if ($__templater->func('property', array('xenfocus_tableLayout', ), false) == 'minimal') {
		$__finalCompiled .= '
		.block-body{
			margin: -@nodeHover-padding;
			margin-top: 0px;
		}
		';
	}
	$__finalCompiled .= '
		
	}
}

.focus-block-container(){
	box-shadow: inset rgba(0,0,0,0.8) 0px 1px 8px, rgba(255,255,255,0.1) 0px 0px 0px 1px, rgba(255,255,255,0.1) 0px 1px 0px;
	-webkit-backdrop-filter: blur(15px) saturate(130%);
	// Disabled due to buggy implementation in Chrome
	// backdrop-filter: blur(15px) saturate(130%);
	border-color: transparent;
}

	.focus-block-header(){
		padding: 15px;
	}

	.focus-block-body(){

	}

	.focus-block-minor-header(){
		border-radius: @xf-blockBorderRadius;
		margin: 5px;
		margin-bottom: 0;
		padding: 9px;
		box-shadow: inset rgba(255,255,255,0.1) 0px 0px 0px 1px, inset rgba(255,255,255,0.3) 0px 1px 0px;
		background-image: url(\'' . $__templater->func('asset', array('xenfocus', ), true) . '/texture.png\'), linear-gradient(to bottom, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.1) 100%);
		background-repeat: repeat;
		background-position: 50% 50%;
	}

/*
	----------------
	- Other
	----------------
*/

.focus-editor{
	background: @xf-paletteNeutral1;
}

#XF .button{
	background-image: url(\'' . $__templater->func('asset', array('xenfocus', ), true) . '/carbon-net-dark.png\');
	background-repeat: repeat;
}

.focus-footer + .footer-bottom-wrap{
	border: 0;
}

.p-staffBar,
.p-footer{
	-webkit-backdrop-filter: blur(15px) saturate(130%);
	backdrop-filter: blur(15px) saturate(130%);
}

.tooltip--member .tooltip-content{
	background: lighten(@xf-paletteNeutral1, 6%);
}

.tooltip--member.tooltip--top .tooltip-arrow::after{
	border-top-color: lighten(@xf-paletteNeutral1, 6%);
}';
	return $__finalCompiled;
}
);