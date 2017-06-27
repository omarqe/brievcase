<?php
/**
 * Showcase - an open source portfolio platform for freelancers.
 * 
 * @author 		Omar Mokhtar Al-Asad
 * @link 		http://omarqe.com
 * 
 * @copyright	Copyright (C) 2016-2017 Margs Empire. All right reserved.
 * @license 	MIT license; see LICENSE.txt for more detials.
 **/
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php _e( get_site_title() ); ?></title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

	<?php
	if ( is_single() ){
		$header_image = the_header();
		if ( !empty($header_image) )
			_e( '<meta property="og:image" content="%s">', $header_image );
	}
	?>

	<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_url(['bootstrap.min.css', 'font-awesome.min.css', 'animate.css', 'style.css', 'blog.css']); ?>">
	<script src='https://www.google.com/recaptcha/api.js'></script>

	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-101504401-1', 'auto');
		ga('send', 'pageview');
	</script>
</head>

<body>
	<div class="global">
	<section class="blog-header" id="home">
		<?php _e( '<a class="logo animated fadeInDown" href="%s"><span><sup>Awesome</sup>blog.</span></a>', home_url() ); ?>

		<div class="navigation animated fadeIn">
			<ul>
				<?php foreach ( get_menu() as $label => $href ){
					_e( '<li><a href="%1$s">%2$s</a></li>', $href, $label );
				} ?>
			</ul>
		</div>

		<br class="page-separator animated fadeIn">
	</section>