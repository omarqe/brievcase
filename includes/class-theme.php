<?php
/**
 * Showcase - an open source portfolio platform for freelancers.
 * 
 * @package 	Showcase.Themes
 * @author 		Omar Mokhtar Al-Asad
 * @link 		http://omarqe.com
 * 
 * @copyright	Copyright (C) 2016-2017 Margs Empire. All right reserved.
 * @license 	MIT license; see LICENSE.txt for more detials.
 **/

/**
 * Get the current theme name.
 * 
 * @return 	string
 * @since 	1.0
 **/
function get_theme_name(){
	global $theme;
	return $theme->get_theme_name();
}

/**
 * Get the theme information.
 * 
 * @return 	array
 * @since 	1.0
 **/
function get_theme_info(){
	global $theme;
	return $theme->get_theme_info();
}

/**
 * Get the theme path.
 * 
 * @return 	string
 * @since 	1.0
 **/
function get_theme_path(){
	global $theme;
	return $theme->get_theme_path();
}

/**
 * Get theme stylesheet file.
 * 
 * @param 	string 	$file 	The stylesheet file.
 * @param 	string 	$type 	The script type, either css or js.
 * @return 	string
 * @since 	1.0
 **/
function get_theme_script( $file, $type = 'js' ){
	$path = get_theme_path();
	$type = strtolower( $type );
	if ( !in_array($type, ['js','css']) )
		$type = 'js';

	return "$path/$type/$file";
}

/**
 * Get the stylesheet URL.
 * 
 * @param 	array|string 	$files 	The stylesheet files (must include the extension).
 * @return 	string
 * @since 	1.0
 **/
function get_stylesheet_url( $files ){
	$files = (array)$files;
	if ( empty($files) )
		return '';

	foreach ( $files as $i => $file )
		$files[$i] = trim($file);

	$files = implode( ',', $files );
	return add_url_query( array('file' => $files), home_url('css'), true );
}

/**
 * Get the javascript URL.
 * 
 * @param 	array|string 	$files 	The javascript files (must include the extension).
 * @return 	string
 * @since 	1.0
 **/
function get_javascript_url( $files ){
	$files = (array)$files;
	if ( empty($files) )
		return '';

	foreach ( $files as $i => $file )
		$files[$i] = trim($file);

	$files = implode( ',', $files );
	return add_url_query( array('file' => $files), home_url('js'), true );
}

/**
 * Get the header file (header.php)
 * 
 * @return 	boolean
 * @since 	1.0
 **/
function get_header(){
	$theme_path = get_theme_path();
	$header 	= $theme_path . '/header.php';

	if ( !file_exists($header) )
		die( 'Header file does not exist.' );

	return require_once( $header );
}

/**
 * Get the blog header file (blog-header.php)
 * 
 * @return 	boolean
 * @since 	1.0
 **/
function get_blogheader(){
	$theme_path = get_theme_path();
	$header 	= $theme_path . '/blog-header.php';

	if ( !file_exists($header) )
		return get_header();

	return require_once( $header );
}

/**
 * Get the footer file (footer.php)
 * 
 * @return 	boolean
 * @since 	1.0
 **/
function get_footer(){
	$theme_path = get_theme_path();
	$footer 	= $theme_path . '/footer.php';

	if ( !file_exists($footer) )
		die( 'Footer file does not exist.' );

	return require_once( $footer );
}

/**
 * Get the website menu.
 * 
 * @param 	boolean 	$full_url 	Use full URL. For Scrollspy, we might not want to use full URL.
 * @return 	array
 * @since 	1.0
 **/
function get_menu( $full_url = true ){
	$menu = get_settings( 'menu' );
	$blog = get_settings( 'blog' );

	list( $blog_label, $blog_url, $blog_enabled ) = get_list(
		['menu_label', 'url', 'enable'],
		$blog
	);

	// Unset if there is a menu label similar with the blog link.
	if ( isset($menu[$blog_label]) ) unset($menu[$blog_label]);

	// If the blog is enabled, append the link to the end of the menu.
	if ( $blog_enabled ){
		$blog_url = ltrim( $blog_url, '/' );
		$menu[$blog_label] = "/$blog_url";
	}

	if ( true === $full_url ){
		foreach ( (array)$menu as $label => $href ){
			$home_url = home_url();
			if ( !is_url($href) ){
				$href = !is_array($href)
					? $home_url . $href
					: add_url_query( $href, $home_url, true );
			}

			$menu[$label] = $href;
		}
	}

	return $menu;
}

/**
 * Get site title.
 * 
 * @return 	string
 * @since 	1.0
 **/
function get_site_title(){
	$default = 'My Portfolio';
	$site_title = get_settings( 'site_title' );

	$name = parse_arg( 'name', $site_title );
	$tagline = parse_arg( 'tagline', $site_title );

	if ( empty($site_title) || empty($name) )
		return $default;

	$format = !empty($tagline) ? '{page}{sitename}{tagline}' : '{sitename}';

	$page = '';
	if 		( is_blog()		&& $page = 'Blog' 		):
	elseif 	( is_single()	&& $page = the_title()  ):
		$tagline = '';
	endif;

	if ( !empty($page) )
		$page = $page . ' &rsaquo; ';
	if ( !empty($tagline) )
		$tagline = ' | ' . $tagline;

	return str_replace(
		['{sitename}', '{tagline}', '{page}'],
		[$name, $tagline, $page],
		$format
	);
}

/**
 * Get the profile data.
 * 
 * @param 	string 		$key 	The key. Return null if key not found. Leave blank to return the full profile array.
 * @return 	mixed
 * @since 	1.0
 **/
function get_profile( $key = '' ){
	$file = abspath('/contents/user/profile.yaml');
	if ( !file_exists($file) )
		return -1;

	$profile = spyc_load_file( $file );
	$profile = array_change_key_case_recursive( $profile );

	if ( !empty($key) && $key = strtolower($key) ){
		if ( array_key_exists($key, $profile) )
			return $profile[$key];

		return null;
	}

	return $profile;
}

/**
 * Determine whether this user has a profile.
 * 
 * @return 	boolean
 * @since 	1.0
 **/
function have_profile(){
	return ( get_profile('enabled') === true && get_profile() !== -1 );
}

/**
 * Get the social media.
 * 
 * @param 	string|array 	$list 		Exclude some social media from the list.
 * @param 	string 			$behavior 	Include or exclude the $list from from the social media. Value: include|exclude
 * @return 	array
 * @since 	1.0
 **/
function get_social_media( $list = '', $behavior = 'exclude' ){
	$file = abspath('/contents/user/social_media.yaml');
	if ( !file_exists($file) )
		return array();

	$social_media = spyc_load_file( $file );
	$social_media = array_change_key_case_recursive( $social_media );

	$base_urls = array(
		"facebook" => "https://www.facebook.com",
		"twitter" => "https://twitter.com",
		"instagram" => "https://www.instagram.com",
		"linkedin" => "https://www.linkedin.com/in",
		"github" => "https://www.github.com",
		"youtube" => "https://www.youtube.com/user",
		"youtube_channel" => "https://www.youtube.com/channel",
	);

	$behavior = strtolower( $behavior );
	if ( !in_array($behavior, ['include', 'exclude']) )
		$behavior = 'exclude';

	foreach ( $social_media as $key => $value ){
		if ( !empty($list) ){
			$inexclude = in_array( $key, (array)$list );
			if ( $behavior === 'include' )
				$inexclude = !$inexclude;

			if ( $inexclude ){
				unset( $social_media[$key] );
				continue;
			}
		}

		if ( !is_url($value) ){
			if ( !array_key_exists($key, $base_urls) ){
				unset( $social_media[$key] );
				continue;
			}

			$social_media[$key] = "$base_urls[$key]/$value";
		}
	}

	return $social_media;
}

/**
 * Determine whether we have a social media.
 * 
 * @return 	boolean
 * @since 	1.0
 **/
function have_social_media(){
	$social_media = get_social_media();
	return !empty($social_media) && is_array($social_media);
}

/**
 * Get services provided.
 * 
 * @return 	array
 * @since 	1.0
 **/
function get_services(){
	$file = abspath( '/contents/user/service.yaml' );
	if ( !file_exists($file) )
		return array();

	$service = spyc_load_file( $file );
	$service = array_change_key_case_recursive( $service );

	return $service;
}

/**
 * Determine if the services provided is set.
 * 
 * @return 	boolean
 * @since 	1.0
 **/
function have_services(){
	$services = get_services();
	return !empty($services) && is_array($services);
}


/**
 * Get profile display photo URL.
 * 
 * @return 	boolean|string
 * @since 	1.0
 **/
function get_display_photo(){
	$display_photo = get_profile( 'photo' );
	if ( empty($display_photo) || !file_exists(abspath('/contents/images/profile/'.$display_photo)) )
		return false;

	return get_image_link( "/images/profile/$display_photo", "default" );
}

/**
 * Parse the theme settings and render the theme to the browser.
 * 
 * @since 	1.0
 **/
class Theme {
	/**
	 * Default theme name.
	 * 
	 * @var 	string
	 * @access 	public
	 * @since 	1.0
	 **/
	public $default_theme = 'galactic';

	/**
	 * Theme info.
	 * 
	 * @var 	array
	 * @access 	protected
	 * @since 	1.0
	 **/
	protected $theme_info = array();

	/**
	 * Theme path.
	 * 
	 * @var 	string
	 * @access 	protected
	 * @since 	1.0
	 **/
	protected $theme_path = '';

	/**
	 * Get the current theme.
	 * 
	 * @var 	array
	 * @access 	protected
	 * @since 	1.0
	 **/
	protected $current_theme = '';

	/**
	 * The constructor function.
	 * 
	 * @since 	0.1
	 **/
	public function __construct(){
		$settings 	= get_settings( 'theme' );
		$theme_path = abspath( '/themes' );
		$requires 	= ['index.php', 'info.json', 'css/style.css'];

		list( $current_theme, $theme_version ) = get_list( ['name','version'], $settings );

		$current_theme	 = trim( strtolower($current_theme) );
		$theme_path 	.= "/$current_theme/";

		// Check the theme first before loading it.
		if ( empty($current_theme) )
			die( "No theme is loaded. Please check your settings." );
		elseif ( !file_exists($theme_path) )
			die( "Theme not found." );

		// Check the required theme files exists.
		$theme_files = scan_dir( $theme_path, true );
		foreach ( $requires as $required_file ){
			if ( !in_array($required_file, $theme_files) ){
				die( sprintf('The <code>%s</code> file is not exists in the theme folder.', $required_file) );
			}
		}

		// Get the theme info
		$theme_info = file_get_contents( $theme_path . '/info.json' );
		$theme_info = !empty($theme_info) ? json_decode($theme_info, true) : array();

		// Set theme information to the instances.
		$this->current_theme 	= $current_theme;
		$this->theme_path 		= rtrim( $theme_path, '/' );
		$this->theme_info 		= $theme_info;
	}

	/**
	 * Get the current theme name.
	 * 
	 * @return 	string
	 * @since 	1.0
	 **/
	public function get_theme_name(){
		return $this->current_theme;
	}

	/**
	 * Get the theme information.
	 * 
	 * @return 	array
	 * @since 	1.0
	 **/
	public function get_theme_info(){
		return (array)$this->theme_info;
	}

	/**
	 * Get the theme path.
	 * 
	 * @return 	string
	 * @since 	1.0
	 **/
	public function get_theme_path(){
		return $this->theme_path;
	}
}