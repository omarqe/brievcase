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

define( 'SHOWCASE_READY', true );
define( 'USE_THEME', true );

define( 'ABSPATH'	, dirname(__FILE__) );
define( 'INCLUDES'	, '/includes' );
define( 'CONTENTS'	, '/contents' );
define( 'THEMES'	, '/themes' );

// Load Showcase bootstrap loader
require_once( ABSPATH.INCLUDES.'/load.php' );