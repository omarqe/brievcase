<?php get_header(); ?>
	<div class="header">
		<div>
			<div>
				<a class="logo animated bounce"></a>
				<div class="animated fadeIn">
					<h1><span>b</span>rievcase</h1>
					<h6>Simple online portfolio platform.</h6>
				</div>
			</div>

			<div class="button-container animated fadeIn">
				<a class="btn btn-blue" href="https://github.com/omarqe/brievcase"><i class="fa fa-github"></i> Download</a>
				<div class="version"><?php _e('Version %s', get_version()); ?> &middot; <a href="<?php _e(home_url('/docs')); ?>">Documentation</a></div>
			</div>
		</div>
	</div>
<?php get_footer(); ?>