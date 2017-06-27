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

if ( !defined('SHOWCASE_READY') )
	die( 'No direct access.' );

// Get the image path from URL
list($directory, $folder, $filename) = get_list(
	['directory', 'folder', 'file'],
	get_query_vars()
);

/**
 * File display error.
 * 
 * @param 	string 	$message 	The message.
 * @since 	1.0
 **/
function display_error( $message = '' ){
	if ( empty($message) || !is_string($message) )
		$message = "The file cannot be displayed.";

	header( 'Content-type: application/json' );
	die( $message );
}

// Correct the path to the image file
$path = ($directory == 'theme')
	? get_theme_path() . '/images/' . $folder
	: abspath( '/contents/' . $folder );
$path = rtrim( $path, '/' );
$file = "$path/$filename";

// Check if image exists
if ( !file_exists($file) ){
	status_header( 404 );
	display_error( "File does not exist." );
	exit;
}

$filetype = explode( '.', $filename );
$filetype = parse_arg( count($filetype)-1, $filetype );
$mimetype = mime_content_type( $file );
if ( empty($mimetype) )
	display_error();

switch ( $mimetype ){
	case "image/jpeg":
	case "image/png":
	case "image/gif":
	case "image/bmp":
		$headers = apache_request_headers(); 

	    // Checking if the client is validating his cache and if it is current.
	    if (isset($headers['If-Modified-Since']) && (strtotime($headers['If-Modified-Since']) == filemtime($file))) {
	        // Client's cache IS current, so we just respond '304 Not Modified'.
	        header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($file)).' GMT', true, 304);
	    } else {
	        // Image not cached or cache outdated, we respond '200 OK' and output the image.
	        header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($file)).' GMT', true, 200);
	        header('Content-Length: '.filesize($file));
	        header('Content-Type: image/png');
	    }

		header( "Content-type: $mimetype" );
		readfile( $file );
	exit;

	case "application/json":
	case "text/plain":
		if ( $filetype == 'json' )
			$mimetype = 'application/json';

		header( 'Content-Type: ' . $mimetype );
		echo file_get_contents( $file );
	exit;
}

