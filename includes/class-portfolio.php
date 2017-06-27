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
 * Get the portfolio array.
 * 
 * @return 	array
 * @since 	1.0
 **/
function get_portfolio(){
	global $portfolio;
	return $portfolio->get_portfolio();
}

/**
 * Set the current portfolio.
 * 
 * @return 	array
 * @since 	1.0
 **/
function set_folio_data( $folio_id ){
	global $portfolio;
	return $portfolio->set_folio_data( $folio_id );
}

/**
 * Determines if we have any portfolio.
 * 
 * @see 	Portfolio::have_folio()
 * @return 	boolean
 * @since 	1.0
 **/
function have_folio(){
	global $portfolio;
	return $portfolio->have_folio();
}

/**
 * Increment the loops in the portfolio and set the current portfolio data.
 * 
 * @see 	Portfolio::the_folio()
 * @since 	1.0
 **/
function the_folio(){
	global $portfolio;
	return $portfolio->the_folio();
}

/**
 * Get the project title.
 * 
 * @return 	string
 * @since 	1.0
 **/
function project_title(){
	global $portfolio;
	return $portfolio->project_title();
}

/**
 * Get the project URL.
 * 
 * @return 	string
 * @since 	1.0
 **/
function project_url(){
	global $portfolio;
	return $portfolio->project_url();
}

/**
 * Get the project client.
 * 
 * @return 	string
 * @since 	1.0
 **/
function project_client(){
	global $portfolio;
	return $portfolio->project_client();
}

/**
 * Get the project photos.
 * 
 * @return 	string
 * @since 	1.0
 **/
function project_photos(){
	global $portfolio;
	return $portfolio->project_photos();
}

/**
 * Get the project category.
 * 
 * @return 	string
 * @since 	1.0
 **/
function project_category(){
	global $portfolio;
	return $portfolio->project_category();
}

/**
 * Get the project caption.
 * 
 * @return 	string
 * @since 	1.0
 **/
function project_caption( $use_markdown = false ){
	global $portfolio;
	return $portfolio->project_caption( $use_markdown );
}

/**
 * Get the project date.
 * 
 * @return 	string
 * @since 	1.0
 **/
function project_date(){
	global $portfolio;
	return $portfolio->project_date();
}

/**
 * Get the project cover.
 * 
 * @return 	string
 * @since 	1.0
 **/
function project_cover(){
	$photos = project_photos();
	if ( empty($photos) )
		return ''; // Return the placeholder image

	return parse_arg( 0, $photos );
}

/**
 * Get the project ID.
 * 
 * @return 	string
 * @since 	1.0
 **/
function project_id(){
	global $portfolio;
	return $portfolio->project_id();
}

/**
 * Determine if the project has a URL.
 * 
 * @return 	boolean
 * @since 	1.0
 **/
function project_has_url(){
	return !empty( project_url() );
}

class Portfolio {
	/**
	 * The current portfolio index.
	 * 
	 * @var 	integer
	 * @access 	private
	 * @since 	1.0
	 **/
	private $current_index = -1;

	/**
	 * The total portfolio posts.
	 * 
	 * @var 	integer
	 * @access 	private
	 * @since 	1.0
	 **/
	private $total_items = 0;

	/**
	 * Determine if we're in the loop.
	 * 
	 * @var 	boolean
	 * @access 	private
	 * @since 	1.0
	 **/
	private $in_the_loop = false;

	/**
	 * Get the portfolio.
	 * 
	 * @var 	array
	 * @access 	protected
	 * @since 	1.0
	 **/
	protected $portfolio = array();

	/**
	 * The current portfolio data.
	 * 
	 * @var 	array
	 * @access 	protected
	 * @since 	1.0
	 **/
	protected $current_portfolio = array();

	/**
	 * The project title.
	 * 
	 * @var 	string
	 * @access 	protected
	 * @since 	1.0
	 **/
	protected $the_title = '';

	/**
	 * The project URL.
	 * 
	 * @var 	string
	 * @access 	protected
	 * @since 	1.0
	 **/
	protected $the_url = '';

	/**
	 * The client.
	 * 
	 * @var 	string
	 * @access 	protected
	 * @since 	1.0
	 **/
	protected $the_client = '';

	/**
	 * The photos of the project.
	 * 
	 * @var 	array
	 * @access 	protected
	 * @since 	1.0
	 **/
	protected $the_photos = array();

	/**
	 * The category of the project.
	 * 
	 * @var 	string
	 * @access 	protected
	 * @since 	1.0
	 **/
	protected $the_category = '';

	/**
	 * The project caption/description.
	 * 
	 * @var 	string
	 * @access 	protected
	 * @since 	1.0
	 **/
	protected $the_caption = '';

	/**
	 * The project ID.
	 * 
	 * @var 	string
	 * @access 	protected
	 * @since 	1.0
	 **/
	protected $the_id = '';

	/**
	 * The constructor function. Scans portfolio directory.
	 * 
	 * @since 	1.0
	 **/
	public function __construct(){
		$path = abspath( '/contents/portfolio' );

		$portfolio = array();
		$scan_dir = scan_dir( $path );

		if ( !empty($scan_dir) && is_array($scan_dir) ){
			foreach ( $scan_dir as $i => $file ){
				if ( substr($file, 0, 1) === '.' )
					continue;

				$explode 	= explode( '/', $file );
				$folder 	= parse_arg( 0, $explode );
				$default	= parse_arg( count($explode)-1, $explode );
				if ( $default !== 'default.yaml' )
					continue;

				$the_file 	= "$path/$folder/$default";
				if ( !file_exists($the_file) )
					continue;

				$hash = substr( hash('sha1', $folder), 0, 8 );
				$data = spyc_load_file( $the_file );

				$title = parse_arg( 'title', $data );
				$photos = (array)parse_arg( 'photos', $data );
				if ( empty($data) || empty($title) )
					continue;

				// Get the full URL of the photo
				foreach ( $photos as $j => $photo ){
					if ( !file_exists(abspath("/contents/portfolio/$folder/$photo")) ){
						unset($photos[$j]);
						continue;
					}

					$photos[$j] = get_image_link( "/portfolio/$folder/$photo", "default" );
				}

				// Set the photos URL
				$data['photos'] = $photos;
				$data['project_id'] = $hash;

				$portfolio[$hash] = $data;
			}
		}

		$this->portfolio 	= $portfolio;
		$this->total_items 	= count( $portfolio );
	}

	/**
	 * Get the portfolio array.
	 * 
	 * @return 	array
	 * @since 	1.0
	 **/
	public function get_portfolio(){
		return (array)$this->portfolio;
	}

	/**
	 * Determine if we have any portfolio.
	 * 
	 * @return 	boolean
	 * @since 	1.0
	 **/
	public function have_folio(){
		$current_index 	= $this->current_index + 1;
		$total_items 	= $this->total_items;

		// If we don't have any item in the feed, return false.
		if ( $total_items < 0 )
			return false;
		elseif ( $this->current_index + 1 < $this->total_items )
			return true;

		$this->current_index = -1;
		$this->in_the_loop 	 = false;
		return false;
	}

	/**
	 * Increment the loops for the portfolio and set the current portfolio data.
	 * 
	 * @since 	1.0
	 **/
	public function the_folio(){
		$this->current_index++;
		$this->in_the_loop = true;

		// Get all item IDs in the correct order.
		$item_ids = array_keys( $this->portfolio );
		set_folio_data( parse_arg($this->current_index, $item_ids) );
	}

	/**
	 * Set the current portfolio.
	 * 
	 * @return 	array
	 * @since 	1.0
	 **/
	public function set_folio_data( $folio_id ){
		if ( empty($folio_id) )
			return array();

		$portfolio = $this->portfolio;
		if ( array_key_exists($folio_id, $portfolio) ){
			$current = $this->current_portfolio = $portfolio[$folio_id];

			list( $title, $url, $client, $photos, $category, $caption, $date, $project_id ) = get_list(
				['title', 'url', 'client', 'photos', 'category', 'caption', 'date', 'project_id'],
				$current
			);

			$this->the_title = $title;
			$this->the_url = $url;
			$this->the_client = $client;
			$this->the_photos = $photos;
			$this->the_category = $category;
			$this->the_caption = $caption;
			$this->the_date = $date;
			$this->the_id = $project_id;
		}

		return array();
	}

	/**
	 * Get the project title.
	 * 
	 * @return 	string
	 * @since 	1.0
	 **/
	public function project_title(){
		return $this->the_title;
	}

	/**
	 * Get the project URL.
	 * 
	 * @return 	string
	 * @since 	1.0
	 **/
	public function project_url(){
		return $this->the_url;
	}

	/**
	 * Get the project client.
	 * 
	 * @return 	string
	 * @since 	1.0
	 **/
	public function project_client(){
		return $this->the_client;
	}

	/**
	 * Get the project photos.
	 * 
	 * @return 	string
	 * @since 	1.0
	 **/
	public function project_photos(){
		return (array)$this->the_photos;
	}

	/**
	 * Get the project category.
	 * 
	 * @return 	string
	 * @since 	1.0
	 **/
	public function project_category(){
		return $this->the_category;
	}

	/**
	 * Get the project caption.
	 * 
	 * @param 	boolean 	$use_markdown 	Set to true to parse this as Markdown.
	 * @return 	string
	 * @since 	1.0
	 **/
	public function project_caption( $use_markdown = false ){
		global $markdown;

		$caption = $this->the_caption;
		if ( $use_markdown === true )
			$caption = $markdown->text( $caption );

		return $caption;
	}

	/**
	 * Get the project date.
	 * 
	 * @return 	string
	 * @since 	1.0
	 **/
	public function project_date(){
		return $this->the_date;
	}

	/**
	 * Get the project ID.
	 * 
	 * @return 	string
	 * @since 	1.0
	 **/
	public function project_id(){
		return $this->the_id;
	}
}