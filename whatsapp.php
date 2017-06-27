<?php
/**
 * Showcase - an open source portfolio platform for freelancers.
 * 
 * @package 	Showcase.WhatsApp
 * @author 		Omar Mokhtar Al-Asad
 * @link 		http://omarqe.com
 * 
 * @copyright	Copyright (C) 2016-2017 Margs Empire. All right reserved.
 * @license 	MIT license; see LICENSE.txt for more detials.
 **/

define( 'SHOWCASE_READY', true );
define( 'ABSPATH'	, dirname(__FILE__) );
define( 'INCLUDES'	, '/includes' );

// Load Showcase bootstrap loader
require_once( ABSPATH.INCLUDES.'/load.php' );

$whatsapp = get_profile( 'phone' );

$api_url  = 'http://api.whatsapp.com/send';
$redirect = add_url_query( array("phone" => $whatsapp, "text" => "Hi Omar, I come from your personal website. I want to build something and need your help, can we talk?"), $api_url );
$redirect = str_replace( "+", "%20", $redirect );

// Send to WhatsApp API
header( "Location: $redirect" );