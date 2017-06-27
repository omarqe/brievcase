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

if ( !defined('SHOWCASE_READY') || defined('SHOWCASE_READY') && !SHOWCASE_READY )
	die;

require_once( ABSPATH . INCLUDES . '/class-core.php' );
require_once( ABSPATH . INCLUDES . '/class-theme.php' );
require_once( ABSPATH . INCLUDES . '/class-blog.php' );
require_once( ABSPATH . INCLUDES . '/class-portfolio.php' );
require_once( ABSPATH . INCLUDES . '/class-contact.php' );
require_once( ABSPATH . INCLUDES . '/functions.php' );

// Require external libraries
require_once( ABSPATH . INCLUDES . '/lib/minifier/vendor/autoload.php' );
require_once( ABSPATH . INCLUDES . '/lib/parsedown/Parsedown.php' );
require_once( ABSPATH . INCLUDES . '/lib/spyc/Spyc.php' );
require_once( ABSPATH . INCLUDES . '/lib/phpmailer/PHPMailerAutoload.php' );


/**
 * Create Core object.
 * 
 * @since 	1.0
 **/
$GLOBALS['core'] = new Core();

/**
 * Create Theme object.
 * 
 * @since 	1.0
 **/
$GLOBALS['theme'] = new Theme();

/**
 * Create Parsedown object.
 * 
 * @since 	1.0
 **/
$GLOBALS['markdown'] = new Parsedown();

/**
 * Create Blog object.
 * 
 * @since 	1.0
 **/
$GLOBALS['blog'] = new Blog();

/**
 * Create Portfolio object.
 * 
 * @since 	1.0
 **/
$GLOBALS['portfolio'] = new Portfolio();

/**
 * Create Contact object.
 * 
 * @since 	1.0
 **/
$GLOBALS['contact'] = new Contact();

// Unregister globals
sc_unregister_globals();

// When it is an AJAX request, we'll take process.php to handle the request.
if ( doing_ajax() ){
	require_once( ABSPATH . '/process.php' );
	exit;
}

// Load renderer
if ( defined('USE_THEME') && USE_THEME ){
	require_once( ABSPATH . INCLUDES . '/render.php' );
}