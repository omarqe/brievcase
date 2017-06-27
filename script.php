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

$files 	= parse_arg( 'file', $_GET );
$files 	= array_filter( explode(',', $files) );
$type  	= get_var( 'type' );
$mime	= $type == 'css' ? 'text/css' : 'text/javascript';

header( "Content-Type: $mime" );
if ( empty($files) )
	echo 'No script to render.';

ob_start();
foreach ( $files as $file ){
	$file = trim( $file );
	$script_file = get_theme_script( $file, $type );
	if ( !file_exists($script_file) )
		continue;

	echo file_get_contents($script_file);
}
$output = ob_get_clean();


/**
 * Minify the script to reduce the load time.
 * 
 * @since 	1.0
 **/
use MatthiasMullie\Minify;
if ( $type == 'css' ) $minify = new Minify\CSS();
else $minify = new Minify\JS();

$minify->add( $output );
echo $minify->minify();