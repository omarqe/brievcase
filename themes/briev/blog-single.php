<?php get_blogheader(); ?>
	<div class="main-container">
		<div class="content">
			<?php set_postdata(get_var('post')); ?>
			<?php _e( '<h1>%s</h1>', the_title() ); ?>
			<?php _e( the_content() ); ?>

			<?php if (have_prev_blog() || have_next_blog()): ?>
			<div class="blog-navigation">
				<div class="row">
					<div class="col-xs-6">
						<?php
						if (have_prev_blog()){
							list( $slug, $title ) = get_list(['slug', 'title'], prev_blog());
							_e( '<a href="%s">&larr; %s</a>', get_blog_link($slug), $title );
						}
						?>
					</div>
					<div class="col-xs-6">
						<?php
						if (have_next_blog()){
							list( $slug, $title ) = get_list(['slug', 'title'], next_blog());
							_e( '<a href="%s">%s &rarr;</a>', get_blog_link($slug), $title );
						}
						?>
					</div>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
<?php get_footer(); ?>