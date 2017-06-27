<?php get_blogheader(); ?>
	<?php if ( have_blog() ): ?>
	<section class="bloglist wide">
		<div class="content">
			<div class="row masonry">
				<?php while( have_blog() ): the_blog(); ?>
				<div class="col-md-6 grid-item">
					<div class="blogcard">
						<?php
						if ( have_blog_header() ){
							_e( '<a href="%1$s"><img src="%2$s"></a>', the_permalink(), the_header() );
						}
						?>
						<div class="content">
							<?php _e( '<h1><a href="%2$s">%1$s</a></h1>', the_title(), the_permalink() ); ?>
							<?php _e( '<div class="date"><i class="fa fa-calendar"></i>%s</div>', the_date() ); ?>

							<?php _e( the_excerpt() ); ?>
							<div class="btn-area text-right">
								<?php _e( '<a class="btn btn-white btn-sm" href="%1$s">Read more &rarr;</a>', the_permalink() ); ?>
							</div>
						</div>
					</div>
				</div>
				<?php endwhile; ?>
			</div>
		</div>
	</section>
	<?php else: ?>
		<section class="empty-state">
			<div class="text-center">
				<h1>Empty blog.</h1>
				<p>I don't feel like blogging yet right now. Check again later?</p>
			</div>
		</section>
	<?php endif; ?>
<?php get_footer(); ?>