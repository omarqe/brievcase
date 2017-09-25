<?php
/**
 * Showcase - an open source portfolio platform for freelancers.
 * 
 * @package 	Showcase.Blog
 * @author 		Omar Mokhtar Al-Asad
 * @link 		http://omarqe.com
 * @link 		https://github.com/paquettg/php-html-parser
 * 
 * @copyright	Copyright (C) 2016-2017 Margs Empire. All right reserved.
 * @license 	MIT license; see LICENSE.txt for more detials.
 **/

/**
 * Validate blog slug.
 * 
 * @return 	boolean
 * @since 	1.0
 **/
function is_slug( $slug ){
	return preg_match( '"^[a-zA-Z0-9_-]*$"', $slug ) === 1;
}

/**
 * Apply slug correction by removing the non-alphanumeric characters from it.
 * 
 * @return 	string
 * @since 	1.0
 **/
function apply_slug_correction( $slug ){
	$slug = str_replace( " ", "-", $slug );
	$slug = preg_replace( "/[^a-zA-Z0-9_-]+/", "", $slug );
	$slug = strtolower( $slug );

	return $slug;
}

/**
 * Determines if we have a blog post.
 * 
 * @see 	Blog::have_blog()
 * @return 	boolean
 * @since 	1.0
 **/
function have_blog(){
	global $blog;
	return $blog->have_blog();
}

/**
 * Increment the index in the loop.
 * 
 * @see 	Blog::the_blog()
 * @since 	1.0
 **/
function the_blog(){
	global $blog;
	return $blog->the_blog();
}

/**
 * Get the current blog data.
 * 
 * @return 	array
 * @since 	1.0
 **/
function get_current_blog(){
	global $blog;
	return $blog->get_current_blog();
}

/**
 * Set the current blog data.
 * 
 * @see 	Blog::set_postdata()
 * @return 	array
 * @since 	1.0
 **/
function set_postdata( $post_id ){
	global $blog;
	return $blog->set_postdata( $post_id );
}

/**
 * Get blog title.
 * 
 * @return 	string
 * @since 	1.0
 **/
function the_title(){
	global $blog;
	return $blog->the_title();
}

/**
 * Get the blog header.
 * 
 * @return 	string
 * @since 	1.0
 **/
function the_header(){
	global $blog;
	return $blog->the_header();
}

/**
 * Check if the post has a header.
 * 
 * @return 	string
 * @since 	1.0
 **/
function have_blog_header(){
	return !empty( the_header() );
}

/**
 * Get the blog slug.
 * 
 * @return 	string
 * @since 	1.0
 **/
function the_slug(){
	global $blog;
	return $blog->the_slug();
}

/**
 * Get the blog content.
 * 
 * @return 	string
 * @since 	1.0
 **/
function the_content( $raw = false ){
	global $blog;
	return $blog->the_content( $raw );
}

/**
 * Get the date.
 * 
 * @return 	string
 * @since 	1.0
 **/
function the_date( $format = '' ){
	global $blog;
	return $blog->the_date( $format );
}

/**
 * Get the post excerpt.
 * 
 * @param 	integer 	$word_len 	The number of words to be included in the excerpt.
 * @return 	string
 * @since 	1.0
 **/
function the_excerpt( $word_len = 50, $parse = true ){
	global $markdown;

	$content = the_content( true );
	$content = explode( "\n", $content );

	if ( empty($content) ) return '';

	$paragraph = '';
	foreach ( $content as $i => $line ){
		if ( preg_match('/^([\w\-]+)/', $line, $word) ){
			$word = parse_arg( 1, $word );
			if ( !empty($word) ){
				$paragraph = $line;
				break;
			}
		}
	}

	if ( !is_integer($word_len) || $word_len > 100 || $word_len < 1 )
		$word_len = 50;

	// Parse the Markdown string into HTML
	if ( true === $parse ) $paragraph = $markdown->text( $paragraph );

	$paragraph = slice_text( $paragraph, $word_len );

	return $paragraph;
}

/**
 * Get the blog link.
 * 
 * @return 	string
 * @since 	1.0
 **/
function the_permalink(){
	$blog_settings = get_settings( 'blog' );
	$blog_url = parse_arg( 'url', $blog_settings );
	$base_url = !is_url($blog_url) ? home_url($blog_url) : $blog_url;
	$base_url = rtrim( $base_url, '/' );

	$slug = the_slug();
	return $base_url . '/' . $slug;
}

/**
 * Determines whether we have the next blog.
 * 
 * @return 	boolean
 * @since 	1.0
 **/
function have_next_blog(){
	global $blog;
	return $blog->have_next_blog();
}

/**
 * Determines whether we have the previous blog.
 * 
 * @return 	boolean
 * @since 	1.0
 **/
function have_prev_blog(){
	global $blog;
	return $blog->have_prev_blog();
}

/**
 * Get next blog.
 * 
 * @return 	array
 * @since 	1.0
 **/
function next_blog(){
	global $blog;
	return $blog->next_blog();
}

/**
 * Get previous blog.
 * 
 * @return 	array
 * @since 	1.0
 **/
function prev_blog(){
	global $blog;
	return $blog->prev_blog();
}

/**
 * Get the blog link.
 * 
 * @return 	string
 * @since 	1.0
 **/
function get_blog_link( $slug = '' ){
	$blog_path = parse_arg('url', get_settings('blog'));

	return home_url( (empty($slug) ? $blog_path : "$blog_path/$slug") );
}

/**
 * Parse the blog date. Format: j F Y H:i -or- d F Y H:i
 * 
 * @param 	string 			$date 	The date string.
 * 
 * @return 	array|boolean	Return false on error.
 * @since 	1.0
 **/
function parse_blog_date( $date ){
	if ( empty($date) )
		return false;

	$parse = explode( " ", $date );
	list($day, $month, $year, $time) = get_list([0,1,2,3], $parse);

	$month = date('n', strtotime($month));
	$hour = $minute = $second = '00';
	if ( !empty($time) ){
		$time = explode( ':', $time );
		list( $hour, $minute ) = get_list([0,1], $time);
	}

	if ( empty($day) || empty($month) || empty($year) || empty($hour) || empty($minute) )
		return false;
	
	return compact('day', 'month', 'year', 'hour', 'minute', 'second');
}

/**
 * Convert blog date to time.
 * 
 * @param 	array|string 	$date 	The date string or array.
 * 
 * @return 	long|false 		Return false on error.
 * @since 	1.0
 **/
function blogdate2time( $date ){
	if ( is_string($date) ){
		$date = parse_blog_date( $date );
		if ( $date === false )
			return false;
	}

	list(
		$day,
		$month,
		$year,
		$hour,
		$minute,
		$second
	) = array_values($date);

	return mktime($hour, $minute, $second, $month, $day, $year);
}

class Blog {
	/**
	 * The blog path.
	 * 
	 * @var 	string
	 * @access 	private
	 * @since 	1.0
	 **/
	private $blog_path = '';

	/**
	 * Determine whether the blog is enable or otherwise.
	 * 
	 * @var 	boolean
	 * @access 	protected
	 * @since 	1.0
	 **/
	protected $blog_enabled = false;

	/**
	 * The blog array.
	 * 
	 * @var 	array
	 * @access 	protected
	 * @since 	1.0
	 **/
	protected $blogs_arr = array();

	/**
	 * The current blog index.
	 * 
	 * @var 	integer
	 * @access 	private
	 * @since 	1.0
	 **/
	private $current_index = -1;

	/**
	 * The total blog posts.
	 * 
	 * @var 	integer
	 * @access 	private
	 * @since 	1.0
	 **/
	private $total_posts = 0;

	/**
	 * Determine if we're in the loop.
	 * 
	 * @var 	boolean
	 * @access 	private
	 * @since 	1.0
	 **/
	private $in_the_loop = false;

	/**
	 * Holds the current blog data.
	 * 
	 * @var 	array
	 * @access 	protected
	 * @since 	1.0
	 **/
	protected $current_blog = array();

	private $markdown_image_regex = "/(?:\\(|:\\s+)(?!http|https)([^\\s]+\\.(?:jpe?g|gif|png|svg|pdf))/";

	/**
	 * The blog post instances.
	 * 
	 * @var 	string
	 * @access 	protected
	 * @since 	1.0
	 **/
	protected $the_title = '';
	protected $the_header = '';
	protected $the_slug = '';
	protected $the_content = '';
	protected $created_time = '';
	protected $modified_time = '';
	protected $the_content_markdown = '';

	/**
	 * The next blog data.
	 * 
	 * @var 	array
	 * @access 	protected
	 * @since 	1.0
	 **/
	protected $next_blog = array();

	/**
	 * The previous blog data.
	 * 
	 * @var 	array
	 * @access 	protected
	 * @since 	1.0
	 **/
	protected $prev_blog = array();

	public $debug = '';

	/**
	 * The constructor function. It'll check the blog path for invalid slug and rename it according to the header.
	 * 
	 * @since 	1.0
	 **/
	public function __construct(){
		$this->init();

		// The blog is not found.
		if ( is_single() ){
			$slug = get_var( 'post' );

			if ( !array_key_exists($slug, (array)$this->blogs_arr) ){
				redirect( home_url('/404') );
				exit;
			}
		}
	}

	/**
	 * Initialise the blog. This will check the blog path for invalid slug string and apply correction.
	 * This will also discard blogs in the future.
	 * 
	 * @since 	1.0
	 **/
	public function init(){
		global $markdown;
		$blog_settings = get_settings('blog');
		$blog_path = $this->blog_path = abspath( '/contents/blog' );

		// Blog is disabled
		if ( !(bool)parse_arg('enable', $blog_settings) )
			return;

		// Blog path is not exists or it is not a directory!
		if ( !file_exists($blog_path) || !is_dir($blog_path) )
			die( "The blog path is not exists or it is not a directory." );
		elseif ( !is_writable($blog_path) )
			die( "The blog directory is not writable." );

		$blogs 		= $duplicated_folder = $sorted_blogs = array();
		$blog_dir 	= scan_dir( $blog_path );

		foreach ( $blog_dir as $i => $file ){
			if ( substr($file,0,1) === '.' ) continue;

			$folder = explode( '/', $file );
			$folder = parse_arg( 0, $folder );

			$blog_status = explode( '.', $folder );
			$blog_status = parse_arg( count($blog_status)-1, $blog_status );

			if ( strtolower($blog_status) === 'draft' ) continue;

			// The result of scan_dir() is recursive, therefore files in the same folder may appear multiple time.
			// To prevent unnecessary loops, we add the unexisting folder into the duplicated array and checks whether
			// the folder exists or not. If exists, skip.
			if ( !in_array($folder, $duplicated_folder) )
				$duplicated_folder[] = $folder;
			else continue;

			// Specify the blog path and the files for the blog: content.md, meta.yaml
			$blog_content_path 	= "$blog_path/$folder";
			$blog_content_file 	= "$blog_content_path/content.md";
			$blog_meta_file 	= "$blog_content_path/meta.yaml";

			// If the content file is not exists, skip the blog.
			if ( ! file_exists($blog_content_file) ) continue;

			// Get the raw content (Markdown format)
			$raw_content_uncompressed = file_get_contents( $blog_content_file );
			$raw_content = $this->compress_content( $raw_content_uncompressed );

			// =============================
			// EXTRACTING THE BLOG METADATA
			// =============================
			// The meta data of a single blog can exists in two forms: YAML front matter or meta.yaml file. The front
			// matter took precedence over meta.yaml. If no metadata found, we take the minimal information about the
			// blog such as file creation date, folder name as date and slug.
			$metadata = array();
			$blogstat = stat( $blog_content_file );
			$has_front_matter = false;
			foreach ( $raw_content as $j => $line ){
				if ( $j == 0 && $line !== '---' ) break; 		// No front matter found in this blog

				// Change the front matter flag to true to tell that this blog has front matter.
				$has_front_matter = true;

				if ( $j != 0 && $line === '---' 	 ) break;	 // End of front matter.
				if ( $line === '---' || empty($line) ) continue; // We don't take the dashes or empty line into meta data

				$metadata[] = $line;
			}

			// Trace where the front matter line ends.
			$front_matter_end = $j;

			// When YAML front matter is not available, check for another alternative: meta.yaml
			if ( !$has_front_matter && file_exists($blog_meta_file) && filesize($blog_meta_file) !== 0 )
				$metadata = file_get_contents($blog_meta_file);

			// Convert the metadata into array.
			if ( is_array($metadata) ) $metadata = implode( "\n", $metadata );
			$metadata = spyc_load( $metadata );

			list( $meta_date, $meta_updated_date, $meta_slug ) = get_list(
				['date', 'updated_date', 'slug'],
				$metadata
			);

			// The last alternative for the blog metadata is to get the file information. If date is missing from the
			// front matter, we'll get the file creation date instead.
			if ( empty($metadata) || empty($meta_date) || empty($meta_updated_date) ){
				if ( $blogstat === false ) continue;

				$date_format = 'j M Y H:i';
				list( $created_time, $updated_time ) = get_list(['ctime', 'mtime'], $blogstat);

				$created_date = date( $date_format, $created_time );
				$updated_date = date( $date_format, $updated_time );

				if ( empty($meta_date) )
					$metadata['date'] = $created_date;

				if ( empty($meta_updated_date) )
					$metadata['updated_date'] = $updated_date;
			}

			// If the blog slug is not set in the metadata, use the folder as slug instead.
			if ( empty($meta_slug) ) $metadata['slug'] = $folder;

			// Remove YAML front matter (if any) from the raw content.
			if ( $has_front_matter ) $raw_content = array_slice( $raw_content, $front_matter_end+1 );



			// =============================================
			// DETERMINING THE BLOG HEADER, TITLE AND BODY.
			// =============================================
			// Apart of metadata, the blog is separated into several parts: header, title and body. The header and
			// title is to be separated from the body at the end of this process. The header is the header image of
			// the blog and it is optional. The title, however, is required. If the title is missing, the blog will
			// not be displayed.
			$header = $title = $title_hash = '';
			foreach ( $raw_content as $j => $line ){
				$line = trim( $line );

				// Get the header source URL.
				if ( $j == 0 && $line[0] === '!' ){
					$header = preg_match($this->markdown_image_regex, $line, $match);
					$header = parse_arg( 1, $match );

					// For remote header, we need to parse it into HTML first and get the file from the src
					// attribute for good.
					if ( empty($header) ){
						$blog_header = $markdown->text( $line );
						if ( !is_html($blog_header) ) continue;

						$dom = new DOMDocument();
						$dom->loadHTML( $blog_header );
						$tags = @$dom->getElementsByTagName('img');
						foreach ( $tags as $tag ){
							$header = $tag->getAttribute( 'src' );
							break;
						}
					}

					$header = !is_url( $header )
						? get_image_link( "/blog/$folder/$header", "default" )
						: $header;

					// Remove the header line from the raw content
					if ( !empty($header) ) unset( $raw_content[$j] );
					continue;
				}

				// Get the blog title
				if ( ($j == 0 || 1 == $j) && $line[0] === '#' ){
					$title_hash = hash( 'sha1', $line );
					$title 		= preg_match( '/^#{1}(.+)$/', $line, $match );
					$title 		= trim( parse_arg(1, $match) );

					// Unset the title from the raw content. At this point, $raw_content becomes the pure blog content.
					unset( $raw_content[$j] );
					break;
				}
			}

			// Determining the body from the uncompressed raw content.
			$pure_content = !is_array($raw_content_uncompressed)
				? explode( "\n", $raw_content_uncompressed )
				: $raw_content_uncompressed;

			$body_offset = 0;
			foreach ( $pure_content as $j => $line ){
				if ( $title_hash == hash('sha1', $line) ){
					$body_offset = $j;
					break;
				}
			}

			// Clean the extra spaces on top.
			$pure_content = array_slice( $pure_content, $body_offset+1 );
			$residue_flag = false;
			$clean_offset = 0; 
			foreach ( $pure_content as $i => $line ){
				if ( $residue_flag === true ) break;
				if ( empty($line) ) continue;

				$clean_offset = $i;
				$residue_flag = true;
			}

			// Correct the image source.
			foreach ( $pure_content as $i => $line ){
				if ( preg_match($this->markdown_image_regex, $line, $match) ){
					$image_filename = parse_arg( 1, $match );
					if ( is_url($image_filename) )
						continue;

					$image_src = get_image_link( "/blog/$folder/$image_filename", "default" );
					$pure_content[$i] = str_replace( $image_filename, $image_src, $line );
				}
			}

			$content = array_slice( $pure_content, $clean_offset );
			$content = implode( "\n", $content );

			// ====================
			// VALIDATING THE BLOG
			// ====================
			// Before displaying the blog post in the website, we need to validate several things first. All required
			// information for the blog must be there. We also skips the future blog posts.
			$slug = parse_arg( 'slug', $metadata );
			$created_date = parse_arg( 'date', $metadata );
			$created_time = blogdate2time( $created_date );
			$modified_date = parse_arg( 'updated_date', $metadata );
			$modified_time = blogdate2time( $modified_date );

			if ( empty($title) ) continue; // The blog has no title.
			elseif ( $created_time > time() ) continue; // The blog is in the future.

			if ( !is_slug($slug) )
				$slug = apply_slug_correction( $slug );

			// Add the blog slug and time for sorting purpose
			$sorted_blogs[$slug] = $created_time;

			$blogs[$slug] = array(
				'slug' => $slug,
				'title' => $title,
				'header' => $header,
				'content' => $content,
				'raw_content' => $raw_content_uncompressed,
				'created_time' => $created_time,
				'modified_time' => $modified_time
			);
		}

		// Get the blog sort settings.
		$sort_settings = get_settings('blog');
		$sort_descending = (bool)parse_arg('sort_descending', $sort_settings);

		// Sort the blog posts based on time.
		if ( $sort_descending === true ) arsort( $sorted_blogs );
		else asort( $sorted_blogs );
		$blogs = parse_args( array_keys($sorted_blogs), $blogs );

		// Update instances
		$this->total_posts = count($blogs);
		$this->blogs_arr = $blogs;
	}

	/**
	 * Get the current blog.
	 * 
	 * @return 	array
	 * @since 	1.0
	 **/
	public function get_current_blog(){
		return (array)$this->current_blog;
	}

	/**
	 * Get the blog array.
	 * 
	 * @return 	array
	 * @since 	1.0
	 **/
	public function get_blogs(){
		return (array)$this->blogs_arr;
	}

	/**
	 * Determine if we have a blog.
	 * 
	 * @return 	boolean
	 * @since 	1.0
	 **/
	public function have_blog(){
		$current_index 	= $this->current_index + 1;
		$total_posts 	= $this->total_posts;

		// If we don't have any item in the feed, return false.
		if ( $total_posts < 0 ){
			$this->prev_blog = array();
			$this->next_blog = array();
			return false;
		}
		elseif ( $this->current_index + 1 < $this->total_posts )
			return true;

		$this->current_index = -1;
		$this->in_the_loop 	 = false;
		$this->prev_blog = array();
		$this->next_blog = array();
		return false;
	}

	/**
	 * Loop the items in the home feed.
	 * 
	 * @since 	0.1
	 **/
	public function the_blog(){
		$this->current_index++;
		$this->in_the_loop = true;

		// Get all item IDs in the correct order.
		$item_ids = array_keys( $this->blogs_arr );
		set_postdata( parse_arg($this->current_index, $item_ids) );
	}

	/**
	 * Set the current post data.
	 * 
	 * @param 	string 			$post_id 	The post ID, namely the slug.
	 * @return 	boolean|array
	 * @since 	1.0
	 **/
	public function set_postdata( $post_id ){
		$blogs = $this->blogs_arr;

		if ( !array_key_exists($post_id, $blogs) ){
			$this->current_blog = array();
			return;
		}

		$blog = $this->current_blog = $blogs[$post_id];
		list( $header, $title, $slug, $content, $created_time, $modified_time ) = get_list(
			['header', 'title', 'slug', 'content', 'created_time', 'modified_time'],
			$blog
		);

		$current_index = 0;
		$blog_tree = array_values( $blogs );
		foreach ( $blog_tree as $i => $blog_data ){
			$slug = parse_arg( 'slug', $blog_data );
			if ( $post_id == $slug ){
				$current_index = $i;
				break;
			}
		}

		$total_posts = $this->total_posts;
		$next_index = $current_index+1;
		$prev_index = $current_index-1;

		if ( $prev_index >= 0 )
			$this->prev_blog = $blog_tree[$prev_index];
		if ( $next_index <= $total_posts-1 )
			$this->next_blog = $blog_tree[$next_index];

		// Set instances
		$this->the_title 	= $title;
		$this->the_header 	= $header;
		$this->the_slug 	= $slug;
		$this->the_content	= $content;
		$this->created_time = $created_time;
		$this->modified_time = $modified_time;
	}

	/**
	 * Determines whether we have the next blog.
	 * 
	 * @return 	boolean
	 * @since 	1.0
	 **/
	public function have_next_blog(){
		return !empty($this->next_blog);
	}

	/**
	 * Determines whether we have the previous blog.
	 * 
	 * @return 	boolean
	 * @since 	1.0
	 **/
	public function have_prev_blog(){
		return !empty($this->prev_blog);
	}

	/**
	 * Get next blog.
	 * 
	 * @return 	array
	 * @since 	1.0
	 **/
	public function next_blog(){
		return (array)$this->next_blog;
	}

	/**
	 * Get previous blog.
	 * 
	 * @return 	array
	 * @since 	1.0
	 **/
	public function prev_blog(){
		return (array)$this->prev_blog;
	}

	/**
	 * Get blog title.
	 * 
	 * @return 	string
	 * @since 	1.0
	 **/
	public function the_title(){
		return $this->the_title;
	}

	/**
	 * Get the blog header.
	 * 
	 * @return 	string
	 * @since 	1.0
	 **/
	public function the_header(){
		$slug = the_slug();
		$header = $this->the_header;

		if ( is_url($header) || empty($header) )
			return $header;

		return get_image_link( "/blog/$slug/$header", "default" );
	}

	/**
	 * Get the blog slug.
	 * 
	 * @return 	string
	 * @since 	1.0
	 **/
	public function the_slug(){
		return $this->the_slug;
	}

	/**
	 * Compress the raw content (which is in Markdown format) by reducing empty lines.
	 * 
	 * @param 	array|string 	The content.
	 * @return 	array
	 * @since 	1.0
	 **/
	private function compress_content( $content, $include_front_matter = true ){
		$content_raw_array = !is_array($content) ? explode("\n", $content) : $content;

		$compressed = array();
		$in_front_matter = false;
		foreach ( $content_raw_array as $i => $line ){
			if ( $i === 0 && $line === '---' )
				$in_front_matter = true;

			if ( empty($line) || (!$include_front_matter && $in_front_matter) ){
				if ( $i !== 0 && $line === '---' )
					$in_front_matter = false;

				continue;
			}

			$compressed[] = $line;
		}

		return $compressed;
	}

	/**
	 * Get the blog content.
	 * 
	 * @param 	boolean 	$raw 	Get the raw content.
	 * @return 	string
	 * @since 	1.0
	 **/
	public function the_content( $raw = false ){
		global $markdown;

		$content = $this->the_content;
		return $raw !== true ? $markdown->text($content) : $content;
	}

	/**
	 * Get the date.
	 * 
	 * @param 	string 	$format 	The date format.
	 * @return 	string
	 * @since 	1.0
	 **/
	public function the_date( $format = '' ){
		$date_format = !empty($format) ? $format : get_date_format();
		$created_time = $this->created_time;

		if ( empty($created_time) || empty($date_format) )
			return 'undefined';

		return date( $date_format, $created_time );
	}
}