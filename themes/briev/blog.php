<?php redirect( home_url('/docs/introduction') ); ?>
<?php get_blogheader(); ?>
	<div class="main-container">
		<div class="content">
			<?php set_postdata('introduction'); ?>
			<?php _e( '<h1>%s</h1>', the_title() ); ?>
			<?php _e( the_content() ); ?>
		</div>
	</div>
<?php get_footer(); ?>