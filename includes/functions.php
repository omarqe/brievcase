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

/**
 * Turn register globals off as inspired from WordPress wp_unregister_GLOBALS()
 * 
 * @since 	1.0
 **/
function sc_unregister_globals(){
	if ( !ini_get('register_globals') )
		return;

	if ( isset( $_REQUEST['GLOBALS'] ) )
		die('GLOBALS overwrite attempt detected.');

	$no_unset = array( 'GLOBALS', '_GET', '_POST', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES' );

	$input = array_merge( $_GET, $_POST, $_COOKIE, $_SERVER, $_ENV, $_FILES, isset( $_SESSION ) && is_array( $_SESSION ) ? $_SESSION : array() );

	foreach( $input as $k => $v )
		if ( !in_array( $k, $no_unset ) && isset($GLOBALS[$k]) )
			unset( $GLOBALS[$k] );
}

/**
 * Get the variables in an array.
 * 
 * @param 	array 	$keys 		The items in the globals array
 * @param 	array 	$array 		The globals
 * @param 	mixed 	$default 	The default value if the items are not in the 
 * 								globals.
 * @since 	1.0
 **/
function parse_args( $keys, $array, $default = NULL ){
	$return = array();
	foreach ( (array)$keys as $key )
		$return[$key] = array_key_exists($key, (array)$array) ? $array[$key] : $default;

	return $return;
}

/**
 * Get the array_values() of parse_args() to be used when we're using list()
 * 
 * @param 	array|string 	$keys 	The keys, must be in order.
 * @param 	array 			$array 	The array.
 * @return 	array
 * @since 	1.0
 **/
function get_list( $keys, $array ){
	return array_values( parse_args((array)$keys, $array) );
}

/**
 * Checks whether a variable exists in an array but instead of returning the whole,
 * this function returns the value of the variable.
 * 
 * @param 	string 	$key 		The variable key.
 * @param 	array 	$array 		The array.
 * @param 	mixed 	$default 	The default value if not exists.
 * 
 * @return 	mixed
 * @since 	1.0
 **/
function parse_arg( $key, $array, $default = '' ){
	$args = parse_args( $key, (array)$array, $default );
	return $args[$key];
}

/**
 * Prints codes in HTML <pre> block.
 * 
 * @param 	mixed 	$input 		The thing to print.
 * @param 	bool 	$return		Set to true to return the output instead of echoing it.
 * @return 	string
 * @since 	1.0
 **/
function print_p( $input, $return = false ){
	if ( '' === $input ) return '';

	$input = sprintf( '<pre>%s</pre>', print_r($input, true) );

	if ( $return )
		return $input;

	echo $input;
}

/**
 * Escape any unwanted character from the URL, as inspired from WordPress.
 * 
 * @return 	string
 * @since 	1.0
 **/
function esc_url( $url ) {
	if ('' == $url)
		return $url;

	$url 	= preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
	$strip 	= array('%0d', '%0a', '%0D', '%0A');
	$url 	= (string) $url;

	$count = 1;
	while ($count) {
		$url = str_replace($strip, '', $url, $count);
	}

	$url = str_replace(';//', '://', $url);
	$url = htmlentities($url);
	$url = str_replace('&amp;', '&#038;', $url);
	$url = str_replace("'", '&#039;', $url);

	if ( $url[0] == '/' )
		return '';

	return $url;
}

/**
 * Determine whether or not to add a slash at the beginning of the path.
 * 
 * @param 	string 	The URL path string.
 * @return 	string
 * @since 	1.0
 **/
function addslash_path( $path, $slash = '/' ){
	if ( !in_array($slash, ['/', '\\']) )
		$slash = '\\';

	if ( !empty($path) )
		$path = substr($path,0,1) === $slash ? $path : "{$slash}{$path}";

	return $path;
}

/**
 * Get the full URL of the current page the user is viewing.
 * 
 * @param 	bool 	$echo 	Whether to echo the URL or just return it.
 * @return 	string
 * @since 	1.0
 **/
function get_current_url( $echo = false ){
	$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
	$protocol = substr(strtolower($_SERVER["SERVER_PROTOCOL"]), 0, strpos(strtolower($_SERVER["SERVER_PROTOCOL"]), "/")) . $s;
	$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);

	$url = trim( $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'] );
	if ( $echo == false )
		return $url;

	echo $url;
}

/**
 * Get the home URL.
 * 
 * @var 	string 	$path 		Additional path at the end of the URL.
 * @var 	string 	$scheme 	The URL scheme. Default is http.
 * @return 	string
 * @since 	1.0
 **/
function home_url( $path = '', $scheme = 'http' ){
	$url 	= parse_url( get_current_url(), PHP_URL_HOST );
	$scheme = strtolower($scheme);

	if ( !in_array($scheme, ['http', 'https', 'relative']) )
		$scheme = 'http';

	$return_url = sprintf('%s://%s', $scheme, $url);

	$path = ltrim($path, './');
	if ( !empty(get_settings('root')) && $root = get_settings('root') )
		$path = $root . '/' . $path;

	$path = addslash_path($path);
	if ( !empty($path) && is_string($path) )
		$return_url .= $path;

	if ( 'relative' === $scheme )
		$return_url = $path;

	return esc_url( rtrim($return_url, '/') );
}

/**
 * Get the document root path.
 * 
 * @param 	string 	$path 	Append a file to create the full path to the file.
 * @return 	string
 * @since 	1.0
 **/
function abspath( $path = '' ){
	$abspath = dirname(dirname(__FILE__));

	if ( !empty($path) && $path = addslash_path($path, '/') )
		$abspath .= $path;

	return $abspath;
}

/**
 * Scans a directory recursively.
 * 
 * @author 	@majick
 * @link 	https://goo.gl/72Wdp0
 * 
 * @param 	string 		$dir 		The directory to scan.
 * @param 	boolean 	$recursive 	Whether to scan recursively.
 * @param 	string 		$basedir 	Append base directory.
 * @return 	array
 * @since 	1.0
 **/
function scan_dir($dir, $recursive = true, $basedir = '') {
	if ($dir == '') {return array();} else {$results = array(); $subresults = array();}
	if (!is_dir($dir)) {$dir = dirname($dir);} // so a files path can be sent
	if ($basedir == '') {$basedir = realpath($dir).DIRECTORY_SEPARATOR;}

	$files = scandir($dir);
	foreach ($files as $key => $value){
		if ( ($value != '.') && ($value != '..') ) {
			$path = realpath($dir.DIRECTORY_SEPARATOR.$value);
			if (is_dir($path)) { // do not combine with the next line or..
				if ($recursive) { // ..non-recursive list will include subdirs
					$subdirresults = scan_dir($path,$recursive,$basedir);
					$results = array_merge($results,$subdirresults);
				}
			} else { // strip basedir and add to subarray to separate file list
				$subresults[] = str_replace($basedir,'',$path);
			}
		}
	}
	// merge the subarray to give the list of files then subdirectory files
	if (count($subresults) > 0) {$results = array_merge($subresults,$results);}
	return $results;
}

/**
 * Get the components of an URL.
 * 
 * @return 	string
 * @since 	1.0
 **/
function get_url_components(){
	$url = 'http://username:password@hostname:80/path?arg=value#anchor';
	$components = array_keys( parse_url($url) );
	return $components;
}

/**
 * Add/remove a new query parameters to the current/given URL.
 * 
 * @param 	array 	$query 	The array of the new query. To remove a query parameter from the URL, simply set the parameter to blank.
 * @param 	string 	$url 	The URL to manipulate. Leaving this blank will manipulate the current URL.
 * @param 	bool 	$reset 	
 * @since 	1.0
 **/
function add_url_query( $query, $url = "", $reset = false ){
	$url = $url != "" ? $url : get_current_url();

	if ( !is_array($query) && $query != '' )
		return $url;

	$parse = parse_args( get_url_components(), parse_url($url) );

	if ( $reset )
		$parse['query'] = '';

	parse_str( $parse['query'], $current );

	$query = (array)$query;
	// Remove any blank parameter value
	foreach ( $query as $key => $value ){
		if ( empty($key) || in_array($key, array_keys($current)) && $value == false ){
			unset($current[$key]);
			unset($query[$key]);
		}
	}

	$query = http_build_query( array_merge($current, $query) );

	$parse['query'] = $query;
	$url = http_build_url( $parse );

	if ( empty($query) )
		$url = substr($url, 0, strlen($url)-1); // minus the question mark (?)

	return $url;
}

/**
 * http_build_url
 * Stand alone version of http_build_url (http://php.net/manual/en/function.http-build-url.php)
 * Based on buggy and inefficient version I found at http://www.mediafire.com/?zjry3tynkg5 by
 * tycoonmaster@gmail.com
 * 
 * @author Chris Nasr (chris@fuelforthefire.ca)
 * @copyright Fuel for the Fire
 * @package http
 * @version 0.1
 * @created 2012-07-26
 */
if( !function_exists('http_build_url') ){
	// Define constants
	define('HTTP_URL_REPLACE',			0x0001);	// Replace every part of the first URL when there's one of the second URL
	define('HTTP_URL_JOIN_PATH',		0x0002);	// Join relative paths
	define('HTTP_URL_JOIN_QUERY', 		0x0004);	// Join query strings
	define('HTTP_URL_STRIP_USER', 		0x0008);	// Strip any user authentication information
	define('HTTP_URL_STRIP_PASS',		0x0010);	// Strip any password authentication information
	define('HTTP_URL_STRIP_PORT',		0x0020);	// Strip explicit port numbers
	define('HTTP_URL_STRIP_PATH',		0x0040);	// Strip complete path
	define('HTTP_URL_STRIP_QUERY',		0x0080);	// Strip query string
	define('HTTP_URL_STRIP_FRAGMENT',	0x0100);	// Strip any fragments (#identifier)

	// Combination constants
	define('HTTP_URL_STRIP_AUTH',		HTTP_URL_STRIP_USER | HTTP_URL_STRIP_PASS);
	define('HTTP_URL_STRIP_ALL', 		HTTP_URL_STRIP_AUTH | HTTP_URL_STRIP_PORT | HTTP_URL_STRIP_QUERY | HTTP_URL_STRIP_FRAGMENT);

	/**
	 * HTTP Build URL
	 * Combines arrays in the form of parse_url() into a new string based on specific options
	 * @name http_build_url
	 * @param string|array $url		The existing URL as a string or result from parse_url
	 * @param string|array $parts	Same as $url
	 * @param int $flags			URLs are combined based on these
	 * @param array &$new_url		If set, filled with array version of new url
	 * @return string
	 */
	function http_build_url($url, $parts = array(), $flags = HTTP_URL_REPLACE, &$new_url = false){
		// If the $url is a string
		if( is_string($url) )
			$url = parse_url($url);
	
		// If the $parts is a string
		if( is_string($parts) )
			$parts	= parse_url($parts);

		// Scheme and Host are always replaced
		if( isset($parts['scheme']) )	$url['scheme']	= $parts['scheme'];
		if( isset($parts['host']) 	)	$url['host']	= $parts['host'];

		// (If applicable) Replace the original URL with it's new parts
		if(HTTP_URL_REPLACE & $flags){
			// Go through each possible key
			foreach(array('user','pass','port','path','query','fragment') as $key)
			{
				// If it's set in $parts, replace it in $url
				if(isset($parts[$key]))	$url[$key]	= $parts[$key];
			}
		}
		else
		{
			// Join the original URL path with the new path
			if(isset($parts['path']) && (HTTP_URL_JOIN_PATH & $flags))
			{
				if(isset($url['path']) && $url['path'] != '')
				{
					// If the URL doesn't start with a slash, we need to merge
					if($url['path'][0] != '/')
					{
						// If the path ends with a slash, store as is
						if('/' == $parts['path'][strlen($parts['path'])-1])
						{
							$sBasePath	= $parts['path'];
						}
						// Else trim off the file
						else
						{
							// Get just the base directory
							$sBasePath	= dirname($parts['path']);
						}

						// If it's empty
						if('' == $sBasePath)	$sBasePath	= '/';

						// Add the two together
						$url['path']	= $sBasePath . $url['path'];

						// Free memory
						unset($sBasePath);
					}

					if(false !== strpos($url['path'], './'))
					{
						// Remove any '../' and their directories
						while(preg_match('/\w+\/\.\.\//', $url['path'])){
							$url['path']	= preg_replace('/\w+\/\.\.\//', '', $url['path']);
						}

						// Remove any './'
						$url['path']	= str_replace('./', '', $url['path']);
					}
				}
				else
				{
					$url['path']	= $parts['path'];
				}
			}

			// Join the original query string with the new query string
			if(isset($parts['query']) && (HTTP_URL_JOIN_QUERY & $flags))
			{
				if (isset($url['query']))	$url['query']	.= '&' . $parts['query'];
				else						$url['query']	= $parts['query'];
			}
		}

		// Strips all the applicable sections of the URL
		if(HTTP_URL_STRIP_USER & $flags)		unset($url['user']);
		if(HTTP_URL_STRIP_PASS & $flags)		unset($url['pass']);
		if(HTTP_URL_STRIP_PORT & $flags)		unset($url['port']);
		if(HTTP_URL_STRIP_PATH & $flags)		unset($url['path']);
		if(HTTP_URL_STRIP_QUERY & $flags)		unset($url['query']);
		if(HTTP_URL_STRIP_FRAGMENT & $flags)	unset($url['fragment']);

		// Store the new associative array in $new_url
		$new_url	= $url;

		// Combine the new elements into a string and return it
		return
			 ((isset($url['scheme'])) ? $url['scheme'] . '://' : '')
			.((isset($url['user'])) ? $url['user'] . ((isset($url['pass'])) ? ':' . $url['pass'] : '') .'@' : '')
			.((isset($url['host'])) ? $url['host'] : '')
			.((isset($url['port'])) ? ':' . $url['port'] : '')
			.((isset($url['path'])) ? $url['path'] : '')
			.((isset($url['query'])) ? '?' . $url['query'] : '')
			.((isset($url['fragment'])) ? '#' . $url['fragment'] : '')
		;
	}
}

/**
 * Get the list of HTTP status codes and descriptions.
 * 
 * @param 	integer 	$code 	The status code.
 * @return 	array
 * @since 	1.0
 **/
function status_header_desc( $code ){
	$codes = array(
		100 => 'Continue',
		101 => 'Switching Protocols',
		102 => 'Processing',

		200 => 'OK',
		201 => 'Created',
		202 => 'Accepted',
		203 => 'Non-Authoritative Information',
		204 => 'No Content',
		205 => 'Reset Content',
		206 => 'Partial Content',
		207 => 'Multi-Status',
		226 => 'IM Used',

		300 => 'Multiple Choices',
		301 => 'Moved Permanently',
		302 => 'Found',
		303 => 'See Other',
		304 => 'Not Modified',
		305 => 'Use Proxy',
		306 => 'Reserved',
		307 => 'Temporary Redirect',
		308 => 'Permanent Redirect',

		400 => 'Bad Request',
		401 => 'Unauthorized',
		402 => 'Payment Required',
		403 => 'Forbidden',
		404 => 'Not Found',
		405 => 'Method Not Allowed',
		406 => 'Not Acceptable',
		407 => 'Proxy Authentication Required',
		408 => 'Request Timeout',
		409 => 'Conflict',
		410 => 'Gone',
		411 => 'Length Required',
		412 => 'Precondition Failed',
		413 => 'Request Entity Too Large',
		414 => 'Request-URI Too Long',
		415 => 'Unsupported Media Type',
		416 => 'Requested Range Not Satisfiable',
		417 => 'Expectation Failed',
		418 => 'I\'m a teapot',
		421 => 'Misdirected Request',
		422 => 'Unprocessable Entity',
		423 => 'Locked',
		424 => 'Failed Dependency',
		426 => 'Upgrade Required',
		428 => 'Precondition Required',
		429 => 'Too Many Requests',
		431 => 'Request Header Fields Too Large',
		451 => 'Unavailable For Legal Reasons',

		500 => 'Internal Server Error',
		501 => 'Not Implemented',
		502 => 'Bad Gateway',
		503 => 'Service Unavailable',
		504 => 'Gateway Timeout',
		505 => 'HTTP Version Not Supported',
		506 => 'Variant Also Negotiates',
		507 => 'Insufficient Storage',
		510 => 'Not Extended',
		511 => 'Network Authentication Required'
	);

	$c = abs( (int)$code );

	if ( !isset($codes[$c]) )
		return $codes[$c];

	return false;
}

/**
 * Sets the HTTP status header.
 * 
 * @param 	integer 	$code 	The HTTP response code.
 * @since 	1.0
 **/
function status_header( $code ){
	$description = status_header_desc($code);
	if ( !$description )
		return false;

	$status = "HTTP/1.0 $code $description";

	@header( $status, true, $code );
}

/**
 * Get image link.
 * 
 * @param 	string 	$path 	Path of the image file.
 * @param 	string 	$dir 	The directory of which this image file belongs. Either 'theme' or 'default'.
 * @return 	string
 * @since 	1.0
 **/
function get_image_link( $path, $dir = 'theme' ){
	$path = ltrim( $path, '/' );
	$dir  = strtolower( $dir );
	if ( !in_array($dir, ['default', 'theme']) )
		$dir = 'default';

	$base_url = $dir == 'default'
		? home_url( '/media' )
		: home_url( '/media/t' );

	return $base_url . '/' . $path;
}

/**
 * Validates an e-mail.
 * 
 * @param 	string 	$email 	The e-mail to validate.
 * @since 	1.0
 **/
function is_valid_email( $email ){
	return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Alias of is_valid_email()
 * 
 * @param 	string 		$email 	The email to validat.e
 * @return 	boolean
 * @since 	1.0
 **/
function is_email( $email ){
	return is_valid_email( $email );
}

/**
 * Validate a URL string.
 * 
 * @param	string	$string		The string to validate.
 * @return	boolean
 * @since	1.0
 **/
function is_url( $string ){
	return filter_var( $string, FILTER_VALIDATE_URL );
}

function __( $string ){
	$args = func_get_args();
	$args = array_slice($args, 1);

	if ( empty($args) )
		return $string;

	if ( isset($args[0]) && is_array($args[0]) )
		return vsprintf($string, $args[0]);
	else
		return vsprintf($string, $args);
}

/**
 * Prints an escaped string
 * 
 * @param 	string 	$string 	The text to be printed.
 * @since 	1.0
 **/
function _e( $string ){
	$args = func_get_args();
	$args = array_slice($args, 1);

	if ( empty($args) ){
		echo $string;
		return;
	}

	echo __( $string, $args );
}

function __esc( $string ){
	$args = array_slice(func_get_args(), 1);

	$str = $string;
	if ( isset($args[0]) && $args[0] != false )
		$str = vsprintf($string, $args);

	return html_entity_decode($str);
}

function _esc( $string ){
	$args = array_slice(func_get_args(), 2);
	_e( htmlentities($string), $args );
}

function __e( $string ){
	$args = array_slice(func_get_args(), 1);

	if ( isset($args[0]) && $args[0] != false )
		$str = sprintf($string, $args);
	else
		$str = $string;

	if ( !$decode )
		echo $str;
	else
		echo html_entity_decode($str);
}

/**
 * Check if string contains HTML.
 * 
 * @return 	boolean
 * @since 	1.0
 **/
function is_html( $string ){
  return preg_match("/<[^<]+>/",$string,$m) != 0;
}

/**
 * Cut long texts.
 * 
 * @param 	string 	$str 		The description string.
 * @param 	int 	$limit 		The word limit.
 * @param 	int 	$length 	The characters length.
 * 
 * @return 	string
 * @since 	1.0
 **/
function slice_text( $str, $limit = 5, $length = 30 ){
	if ( !is_integer($limit) )
		$limit = 5;

	$words = explode( " ", $str );

	if ( count($words) > $limit ){
		$words = array_slice($words, 0, $limit);
		$words[$limit] = "...";
	}

	$return = implode(" ", $words);

	return $return;
}

/**
 * Redirect to another page
 * 
 * @param 	$location 	The location to redirect the client
 * @since 	1.0
 **/
function redirect( $location ){
	@header( "Location: $location" );
}

/**
 * Change array key case recursively.
 * 
 * @return 	array
 **/
function array_change_key_case_recursive( $arr ){
    return array_map(function($item){
        if ( is_array($item) ){
            $item = array_change_key_case_recursive($item);
        }

        return $item;
    }, array_change_key_case($arr));
}

/**
 * Determine if it is an AJAX request.
 * 
 * @return 	boolean
 * @since 	1.0
 **/
function doing_ajax(){
	return isset($_SERVER['HTTP_X_REQUESTED_WITH'])
		&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

/** 
 * Send a POST requst using cURL 
 * 
 * @param 	string 		$url 		to request 
 * @param 	array 		$post 		values to send 
 * @param 	array 		$options 	for cURL
 * 
 * @link 	http://php.net/manual/en/function.curl-exec.php#98628
 * @return 	string 
 **/ 
function curl_post( $url, array $post = NULL, array $options = array() ){ 
    $defaults = array( 
        CURLOPT_POST => 1, 
        CURLOPT_HEADER => 0, 
        CURLOPT_URL => $url, 
        CURLOPT_FRESH_CONNECT => 1, 
        CURLOPT_RETURNTRANSFER => 1, 
        CURLOPT_FORBID_REUSE => 1, 
        CURLOPT_TIMEOUT => 4, 
        CURLOPT_POSTFIELDS => http_build_query($post) 
    ); 

    $ch = curl_init(); 
    curl_setopt_array($ch, ($options + $defaults)); 
    if( ! $result = curl_exec($ch) )
    	return false;

    curl_close($ch); 
    return $result; 
} 

/** 
 * Send a GET requst using cURL
 * 
 * @param 	string 	$url 		to request 
 * @param 	array 	$get 		values to send 
 * @param 	array 	$options 	for cURL
 * 
 * @link 	http://php.net/manual/en/function.curl-exec.php#98628
 * @return 	string 
 **/ 
function curl_get( $url, array $get = NULL, array $options = array() ){    
    $defaults = array( 
        CURLOPT_URL => $url. (strpos($url, '?') === FALSE ? '?' : ''). http_build_query($get), 
        CURLOPT_HEADER => 0, 
        CURLOPT_RETURNTRANSFER => TRUE, 
        CURLOPT_TIMEOUT => 4 
    ); 
    
    $ch = curl_init(); 
    curl_setopt_array($ch, ($options + $defaults)); 
    if( ! $result = curl_exec($ch) )
    	return false;
    
    curl_close($ch); 
    return $result; 
}

/**
 * Send AJAX response.
 * 
 * @return 	string
 * @since 	1.0
 **/
function send_response( $message, $color = 'green', $status = false, $extras = array() ){
	if ( isset($extras['message']) )
		unset($extras['message']);
	if ( isset($extras['color']) )
		unset($extras['color']);

	$response = compact( 'message', 'color', 'status', 'extras' );

	echo json_encode( $response );
	exit;
}

/**
 * Validate required form.
 * 
 * @param 	array 		$input 		The inputs.
 * @return 	boolean
 * @since 	1.0
 **/
function has_required( $input, &$required = array() ){
	if ( !is_array($input) ) // Don't validate input that is not an array
		return true;

	$required = array();
	foreach ( $input as $key => $value ){
		if ( $value === '' || empty($value) || is_null($value) )
			$required[] = $key;
	}

	return !empty( $required );
}

/**
 * Send required input feedback to the client.
 * 
 * @param 	array 	$array 		The required input ID and error message.
 * @param 	array 	$required 	The required input that is empty.
 * @return 	string
 * @since 	1.0
 **/
function send_required( $array, $required = array() ){
	if ( empty($required) || !is_array($required) ){
		echo '{}';
		exit;
	}
	
	$required = array(
		'required' => parse_args( $required, $array )
	);

	echo json_encode( $required );
	exit;
}

/**
 * Get the app version.
 * 
 * @return 	string
 * @since 	1.0
 **/
function get_version(){
	return get_settings( 'app_version' );
}