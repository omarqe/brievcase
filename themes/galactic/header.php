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
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_url(['bootstrap.min.css', 'font-awesome.min.css', 'style.css', 'animate.css', 'aos.css']); ?>">

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
	<div class="noty-container"></div>

	<div class="nav">
		<?php _e( '<a class="logo" href="%s"></a>', home_url() ); ?>

		<ul class="fullscreen">
			<div>
			<?php
			$blog_settings = get_settings('blog');
			$blog_label = parse_arg( 'menu_label', $blog_settings );

			foreach ( get_menu(false) as $label => $href ){
				if ( $blog_label == $label ){
					_e( '<li><a class="animated jello infinite" data-href="%1$s">%2$s</a></li>', $href, $label );
					continue;
				}

				_e( '<li><a href="%1$s">%2$s</a></li>', $href, $label );
			} ?>
			</div>
		</ul>

		<div class="menu-toggle-container">
			<div class="menu-toggle">
				<div id="hamburger">
					<span></span>
					<span></span>
					<span></span>
				</div>
				<div id="cross">
					<span></span>
					<span></span>
				</div>
			</div>
		</div>
	</div>