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

$post = get_var( 'post' );

set_postdata( $post );
?>
<?php get_blogheader(); ?>
	<section class="empty-state">
		<div class="text-center">
			<h1>404 Not Found!</h1>
			<p>Sorry, the post that you are looking for is nowhere to be found.</p>
		</div>
	</section>
<?php get_footer(); ?>