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

switch ( parse_arg('action', $_REQUEST) ){
	case "send_enquiry":
		$keys = ['name', 'email', 'message', 'g-recaptcha-response'];
		list( $name, $email, $message, $recaptcha ) = get_list( $keys, $_POST );

		if ( has_required(parse_args($keys, $_POST), $required) ){
			send_required([
				'name' => 'Please enter your name.',
				'email' => 'Please provide a valid email address.',
				'message' => 'Please enter a message.',
				'g-recaptcha-response' => 'Please prove that you are not a robot.'
			], $required);
		}

		if ( !valid_recaptcha($recaptcha) )
			send_response( "We cannot validate the reCAPTCHA. Please try again.", "red" );
		if ( !send_enquiry($email,$message, $name) )
			send_response( get_contact_error(), "red" );
		
		send_response( "Your enquiry has been sent.", "green", true );
	exit;
}

send_response( "Sorry, but we cannot process your request at this moment.", "red" );