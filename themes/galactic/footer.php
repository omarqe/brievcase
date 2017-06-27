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
	<?php if (is_blog() || is_single() || is_404()): ?></div> <!-- .global --><?php endif; ?>
	<section class="footer">
		<div class="overlay"></div>
		<div class="content">
			<div class="row">
				<div class="col-md-9 footer-left">
					<small>&copy; 2017 Omar Mokhtar Al-Asad. All right reserved. <small class="darker-text hidden-xs">| Designed by @omarqe for Brievcase.</small></small>
				</div>

				<div class="col-md-3 footer-right">
					<ul class="social">
						<?php
						if ( have_social_media() ){
							foreach ( get_social_media(['facebook', 'instagram', 'twitter'], 'include') as $key => $value ){
								$icon = ($key == 'facebook') ? 'facebook-square' : $key;
								_e( '<li><a class="fa fa-%1$s" href="%2$s" target="_blank"></a></li>', $icon, $value );
							}
						}
						?>
						
						<!-- <li><a class="fa fa-instagram" href="http://instagr.am/omarqe" target="_blank"></a></li>
						<li><a class="fa fa-twitter" href="https://twitter.com/omarqe" target="_blank"></a></li> -->
						<li class="to-top"><a class="back-top" data-invoke="scroll" data-target="#home">Back to top &uarr;</a></li>
					</ul>
				</div>
			</div>
		</div>
	</section>

	<script type="text/javascript" src="<?php echo get_javascript_url([
		'jquery-3.1.1.min.js',
		'bootstrap.min.js',
		'particles.min.js',
		'jquery.scrollTo.min.js',
		'typed.min.js',
		'masonry.pkgd.min.js',
		// 'aos.js',
		// 'scrollspy.min.js',
		'assets.js'
	]); ?>"></script>
</body>
</html>