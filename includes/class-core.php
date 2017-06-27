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
 * Get the homepage flag.
 * 
 * @uses 	Core::is_homepage()
 * @return 	boolean
 * @since 	1.0
 **/
function is_homepage(){
	global $core;
	return $core->is_homepage();
}

/**
 * Get the blog flag.
 * 
 * @uses 	Core::is_blog()
 * @return 	boolean
 * @since 	1.0
 **/
function is_blog(){
	global $core;
	return $core->is_blog();
}

/**
 * Get the search flag.
 * 
 * @uses 	Core::is_search()
 * @return 	boolean
 * @since 	1.0
 **/
function is_search(){
	global $core;
	return $core->is_search();
}

/**
 * Get the 404 flag.
 * 
 * @uses 	Core::is_404()
 * @return 	boolean
 * @since 	1.0
 **/
function is_404(){
	global $core;
	return $core->is_404();
}

/**
 * Get the script page flag.
 * 
 * @uses 	Core::is_script()
 * @return 	boolean
 * @since 	1.0
 **/
function is_script(){
	global $core;
	return $core->is_script();
}

/**
 * Get the media page flag.
 * 
 * @uses 	Core::is_media()
 * @return 	boolean
 * @since 	1.0
 **/
function is_media(){
	global $core;
	return $core->is_media();
}

/**
 * Get the media page flag.
 * 
 * @uses 	Core::is_single()
 * @return 	boolean
 * @since 	1.0
 **/
function is_single(){
	global $core;
	return $core->is_single();
}

/**
 * Get the query variables.
 * 
 * @uses 	Core::get_query_vars()
 * @return 	array
 * @since 	1.0
 **/
function get_query_vars(){
	global $core;
	return $core->get_query_vars();
}

/**
 * Get the value from a query var.
 * 
 * @uses 	Core::get_var()
 * @return 	mixed
 * @since 	1.0
 **/
function get_var( $key ){
	global $core;
	return $core->get_var( $key );
}

/**
 * Get the Showcase settings.
 * 
 * @uses 	Core::get_settings()
 * @return 	mixed
 * @since 	1.0
 **/
function get_settings( $key = '' ){
	global $core;
	return $core->get_settings( $key );
}

/**
 * Get the default date format.
 * 
 * @return 	string
 * @since 	1.0
 **/
function get_date_format(){
	$date_settings = get_settings( 'date' );
	$format = parse_arg( 'format', $date_settings );

	return $format;
}

/**
 * Showcase Core Class
 * 
 * The Core class helps Showcase parse the request URL and render the correct output to the browser. All URL requests
 * made to the server are pointed to index.php file. Technically, the output that the users see is actually parsed by
 * this class.
 * 
 * @since 	1.0
 **/
class Core {
	/**
	 * URL rewrite rules.
	 * 
	 * @var 	array
	 * @since 	protected
	 * @since 	1.0
	 **/
	protected $rewrite_rules = array(
		'/$' => 'index.php?page=home',
		'/404$' => 'index.php?page=404',
		'/blog$' => 'index.php?page=blog',
		'/blog/([^/]+)$' => 'index.php?page=single&post=%1$s',
		'/search$' => 'index.php?page=search',

		// Load files
		'/css$' => 'index.php?page=script&type=css',
		'/js$' => 'index.php?page=script&type=js',
		'/media$' => 'index.php?page=media&directory=default',
		'/media/t/((?:[^/]*/)*)(.*)$' => 'index.php?page=media&directory=theme&folder=%1$s&file=%2$s',
		'/media/((?:[^/]*/)*)(.*)$' => 'index.php?page=media&directory=default&folder=%1$s&file=%2$s',
	);

	/**
	 * Determines whether it is the homepage.
	 * 
	 * @var 	boolean
	 * @access 	private
	 * @since 	1.0
	 **/
	private $is_homepage = false;

	/**
	 * Determines whether it is the blog.
	 * 
	 * @var 	boolean
	 * @access 	private
	 * @since 	1.0
	 **/
	private $is_blog = false;

	/**
	 * Determines whether it is 404 Not Found page.
	 * 
	 * @var 	boolean
	 * @access 	private
	 * @since 	1.0
	 **/
	private $is_404 = false;

	/**
	 * Determines whether it is search page.
	 * 
	 * @var 	boolean
	 * @access 	private
	 * @since 	1.0
	 **/
	private $is_search = false;

	/**
	 * Determines whether it is script page.
	 * 
	 * @var 	boolean
	 * @access 	private
	 * @since 	1.0
	 **/
	private $is_script = false;

	/**
	 * Determines whether it is media page.
	 * 
	 * @var 	boolean
	 * @access 	private
	 * @since 	1.0
	 **/
	private $is_media = false;

	/**
	 * Determines whether it is a single blog page.
	 * 
	 * @var 	boolean
	 * @access 	private
	 * @since 	1.0
	 **/
	private $is_single = false;

	/**
	 * An array of the URL parameters.
	 * 
	 * @var 	array
	 * @access 	public
	 * @since 	1.0
	 **/
	public $query_vars = array();

	/**
	 * The constructor function. Parse the request URL into output.
	 * 
	 * @see 	Core::parse_request()
	 * @since 	1.0
	 **/
	public function __construct(){
		$this->is_homepage = false;
		$this->is_blog = false;
		$this->is_404 = false;
		$this->is_search = false;
		$this->is_media = false;
		$this->is_single = false;

		$blog_settings = $this->get_settings( 'blog' );
		$blog_url = strtolower( parse_arg('url', $blog_settings) );

		if ( $blog_url != 'blog' && !is_url($blog_url) ){
			$new_rules = array(
				'/'.$blog_url.'$' => 'index.php?page=blog',
				'/'.$blog_url.'/([^/]+)$' => 'index.php?page=single&post=%1$s',
			);

			unset( $this->rewrite_rules['/blog$'], $this->rewrite_rules['/blog/([^/]+)$'] );
			$this->rewrite_rules = array_merge( $this->rewrite_rules, $new_rules );
		}

		// Set the timezone
		$timezone = $this->get_settings( 'date' );
		$timezone = parse_arg( 'timezone', $timezone );
		date_default_timezone_set( $timezone );

		$this->parse_request();
	}

	/**
	 * Parse the request made to the server.
	 * 
	 * @return 	boolean
	 * @since 	1.0
	 **/
	private function parse_request(){
		list( $request ) = explode( '?', $_SERVER['REQUEST_URI'] );

		// Modify match
		if ( !empty($this->get_settings('root')) && $root = $this->get_settings('root') ){
			foreach ( $this->rewrite_rules as $match => $query ){
				$this->rewrite_rules[ "/{$root}{$match}" ] = $query;
				unset( $this->rewrite_rules[$match] );
			}
		}

		// Find a match in the rewrite rules.
		foreach ( $this->rewrite_rules as $match => $query ){
			if ( preg_match("#^$match#", $request, $matches) ){
				array_shift( $matches );
				$request = vsprintf( $query, $matches );
				$error = '';
				break;
			} else {
				// Throw error since we don't find match in our rewrite rules.
				$error = '404';
			}
		}

		// Page is found
		if ( empty($error) ){
			$query_str = !empty($request) ? parse_url( "/$request", PHP_URL_QUERY ) : '';
			$query_str = trim( $query_str, '/' );

			// Parse the query variables
			$qv = array();
			if ( !empty($query_str) ){
				$vars = explode('&', $query_str);
				foreach ( $vars as $bits ){
					list( $var, $value ) = explode('=', $bits);
					$qv[$var] = str_replace('+', ' ', $value);
				}
			}

			$this->query_vars = $qv;

			// Set the output flags
			if ( isset($qv['page']) && $page = strtolower($qv['page']) ){
				if 		( $page === 'home'		&& $this->is_homepage = true 	):
				elseif 	( $page === 'blog'		&& $this->is_blog = true 		):
				elseif 	( $page === 'search'	&& $this->is_search = true 		):
				elseif 	( $page === '404'		&& $this->is_404 = true 		):
				elseif 	( $page === 'script'	&& $this->is_script = true 		):
				elseif 	( $page === 'media'		&& $this->is_media = true 		):
				elseif 	( $page === 'single'	&& $this->is_single = true 		):
				endif;
			}
		} else {
			$this->query_vars['page'] = '404';
			$this->is_404 = true;
		}

		return true;
	}

	/**
	 * Get the homepage flag.
	 * 
	 * @return 	boolean
	 * @since 	1.0
	 **/
	public function is_homepage(){
		return (bool)$this->is_homepage;
	}

	/**
	 * Get the blog flag.
	 * 
	 * @return 	boolean
	 * @since 	1.0
	 **/
	public function is_blog(){
		return (bool)$this->is_blog;
	}

	/**
	 * Get the single blog flag.
	 * 
	 * @return 	boolean
	 * @since 	1.0
	 **/
	public function is_single(){
		return (bool)$this->is_single;
	}

	/**
	 * Get the search flag.
	 * 
	 * @return 	boolean
	 * @since 	1.0
	 **/
	public function is_search(){
		return (bool)$this->is_search;
	}

	/**
	 * Get the 404 flag.
	 * 
	 * @return 	boolean
	 * @since 	1.0
	 **/
	public function is_404(){
		return (bool)$this->is_404;
	}

	/**
	 * Get the script page flag.
	 * 
	 * @return 	boolean
	 * @since 	1.0
	 **/
	public function is_script(){
		return (bool)$this->is_script;
	}

	/**
	 * Get the media page flag.
	 * 
	 * @return 	boolean
	 * @since 	1.0
	 **/
	public function is_media(){
		return (bool)$this->is_media;
	}

	/**
	 * Get the query variables.
	 * 
	 * @return 	array
	 * @since 	1.0
	 **/
	public function get_query_vars(){
		return (array)$this->query_vars;
	}

	/**
	 * Get the value from a query var.
	 * 
	 * @return 	mixed
	 * @since 	1.0
	 **/
	public function get_var( $key ){
		return parse_arg( $key, (array)$this->query_vars );
	}

	/**
	 * Get the Showcase settings.
	 * 
	 * @param 	string 	$key 	The settings key. If this isn't provide, we'll return the full settings array. Note
	 * 							that this method will return NULL if the key is not found in the settings.
	 * @return 	mixed
	 * @since 	1.0
	 **/
	public function get_settings( $key = '' ){
		$abspath 		= defined('ABSPATH') ? ABSPATH : dirname(dirname(__FILE__));
		$settings_file 	= $abspath . '/contents/user/settings.php';

		// Check if settings file exists
		if ( !file_exists($settings_file) )
			die( "Settings file not found." );

		$key 	  = strtolower( $key );
		$settings = include( $settings_file );

		if ( !empty($key) ){
			$return = parse_arg( $key, $settings );
			return $return === '' ? NULL : $return;
		}

		return $settings;
	}
}