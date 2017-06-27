<?php
/**
 * Showcase - an open source portfolio platform for freelancers.
 * 
 * @package 	Showcase.Core
 * @author 		Omar Mokhtar Al-Asad
 * @link 		http://omarqe.com
 * 
 * @copyright	Copyright (C) 2016-2017 Margs Empire. All right reserved.
 * @license 	MIT license; see LICENSE.txt for more detials.
 **/

// If the request is script, render script file.
if ( is_script() ){
	require_once( ABSPATH . '/script.php' );
	exit;
}

// If the request is media, render the media file.
elseif ( is_media() ){
	require_once( ABSPATH . '/file.php' );
	exit;
}

// Once the required classes are load and the environment is initialized,
// render the page to the client.
$template = 'index.php';
if 		( is_homepage()	&& 	$template = 'index.php' 		):
elseif 	( is_search()	&&	$template = 'search.php' 		):
elseif 	( is_blog()		&&	$template = 'blog.php' 			):
elseif 	( is_single()	&&	$template = 'blog-single.php' 	):
elseif 	( is_404()		&&	$template = '404.php' 			):
endif;

require_once( get_theme_path() . '/' . $template );