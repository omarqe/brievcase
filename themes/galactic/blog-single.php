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
	<section class="single-blog">
		<div class="content">
			<?php _e( '<img src="%s">', the_header() ); ?>

			<div class="the-content">
				<div class="title-container">
					<?php _e( '<h1 class="the-title">%s</h1>', the_title() ); ?>
					<?php _e( '<div class="date"><i class="fa fa-calendar"></i>%s</div>', the_date() ); ?>
				</div>
				<?php _e( the_content() ); ?>

				<?php if ( have_next_blog() || have_prev_blog() ): ?>
				<div class="blog-navigation row">
					<div class="col-xs-6">
						<?php
						if ( have_prev_blog() ){
							list( $slug, $title ) = get_list(['slug', 'title'], prev_blog());

							_e( '<a href="%s">', get_blog_link($slug) );
							_e( '<h4>&larr; Previous post</h4>' );
							_e( '<h5>%s</h5>', $title );
							_e( '</a>' );
						}
						?>
					</div>
					<div class="col-xs-6 text-right">
						<?php
						if ( have_next_blog() ){
							list( $slug, $title ) = get_list(['slug', 'title'], next_blog());

							_e( '<a href="%s">', get_blog_link($slug) );
							_e( '<h4>Next post &rarr;</h4>' );
							_e( '<h5>%s</h5>', $title );
							_e( '</a>' );
						}
						?>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php get_footer(); ?>