<?php
// FROM HASH: 39a64a3e1320ead2505ae5915245a4a3
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->includeTemplate('xenfocus_base.less', $__vars) . '
' . $__templater->includeTemplate('xenfocus_theme.less', $__vars) . '

/* Place your custom code below */
/* Group 1: Red text with shadow and hover effect */
.username-group-donors {
    background: url(\'GIF_URL_1\') no-repeat center;
    background-size: cover;
    color: yellow;
    text-shadow: 0 0 10px red, 0 0 20px orange; /* Glowing shadow effect */
    font-weight: bold; /* Bold text */
    display: inline-block;
    padding: 5px 10px; /* Add padding for better spacing */
    border-radius: 5px; /* Optional rounded corners */
    transition: transform 0.3s ease, text-shadow 0.3s ease; /* Smooth hover transition */
}

.username-group-donors:hover {
    transform: scale(1.1); /* Slight zoom effect on hover */
    text-shadow: 0 0 20px red, 0 0 30px yellow; /* Enhanced glow effect */
}

/* Group 2: Blue text with shadow and hover effect */
.username-group-2 {
    background: url(\'GIF_URL_2\') no-repeat center;
    background-size: cover;
    color: blue;
    text-shadow: 0 0 10px blue, 0 0 20px lightblue; /* Glowing shadow effect */
    font-weight: bold; /* Bold text */
    display: inline-block;
    padding: 5px 10px;
    border-radius: 5px; /* Optional rounded corners */
    transition: transform 0.3s ease, text-shadow 0.3s ease; /* Smooth hover transition */
}

.username-group-2:hover {
    transform: scale(1.1); /* Slight zoom effect on hover */
    text-shadow: 0 0 20px blue, 0 0 30px white; /* Enhanced glow effect */
}';
	return $__finalCompiled;
}
);