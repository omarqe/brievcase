<?php get_header(); ?>
	<section id="home" class="main">
		<div class="overlay"><div class="particles" id="particles-js"></div></div>

		<div class="content">
			<div class="centralized">
				<div class="content">
					<h5 class="greeting">Hello, It's <span class="green">Omar Mokhtar Al-Asad.</span></h5>
					<h2 style="margin-top:10px">I am <span id="i_am_typed">web designer.</span></h2>
				</div>
			</div>
		
			<div class="indicator-container">
				<a class="indicator" data-invoke="scroll" data-target="#about"><i class="fa fa-chevron-down animated slow fadeInDown infinite"></i></a>	
			</div>
		</div>
	</section>

	<?php if ( have_profile() ): ?>
	<section id="about">
		<img class="bg_element favor-right animated-onscroll" data-animation="slideInRight" src="<?php _e( get_image_link('coffee_cup.png') ); ?>"
			style="width:400px; right:3%; top:20%">
		<img class="bg_element favor-left animated-onscroll" data-animation="slideInLeft" src="<?php _e( get_image_link('header_papers.png') ); ?>"
			style="width:600px; top:20%">
		<img class="bg_element favor-left animated-onscroll" data-animation="slideInLeft" src="<?php _e( get_image_link('header_edding.png') ); ?>"
			style="top:50%; left:10%">
		<img class="bg_element animated-onscroll" data-animation="slideInUp" src="<?php _e( get_image_link('header_flowerpot.png') ); ?>"
			style="bottom:-10%; right:15%">

		<div class="content">
			<div class="card profile-card" style="margin-bottom:0">
				<div class="content">
					<div class="display_photo-container">
						<div class="display_photo" style="background-image:url(<?php echo get_display_photo(); ?>)"></div>

						<?php if ( have_social_media() ): ?>
						<div class="social-container">
							<ul>
								<?php
								foreach ( get_social_media() as $socmed_name => $socmed_url ){
									_e(
										'<li><a class="orb %1$s" href="%2$s" target="_blank"><i class="fa fa-%1$s"></i></a></li>',
										$socmed_name,
										$socmed_url
									);
								}
								?>
							</ul>
						</div>
						<?php endif; ?>
					</div>

					<div class="body">
						<?php _e( '<h3 style="margin-top:0">%s</h3>', get_profile('name') ); ?>
						<?php if(!empty(get_profile('bio'))) _e('<p class="bio">%s</p>', get_profile('bio')); ?>

						<?php
						$profile_info = (array)get_profile('table');

						if ( !empty($profile_info) ):
						?>
						<br class="page-separator">
						<table class="table table-default information text-left no-margin">
							<?php foreach ( $profile_info as $key => $value ): ?>
							<?php if ( $key != 'education' ): ?>
							<tr>
								<td style="width:25%"><?php _e(ucfirst($key)) ?></td>
								<td class="text-right"><?php _e($value); ?></td>
							</tr>
							<?php else: ?>
							<tr>
								<td style="width:25%"><?php _e(ucfirst($key)) ?></td>
								<td class="text-right"><?php _e('%1$s<br/><small>%2$s</small>', parse_arg(0, $value), parse_arg(1, $value)); ?></td>
							</tr>
							<?php endif; ?>
							<?php endforeach; ?>
						</table>
						<?php endif; ?>

						<div class="btn-area text-right">
							<a class="btn btn-white" data-invoke="scroll" data-target="#contact"><i class="fa fa-user"></i> Contact</a>
							<a class="btn btn-green"><i class="fa fa-download"></i> Download resumé</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( have_services() ): ?>
	<section id="service" style="background:white">
		<div class="content text-center">
			<div class="heading-group">
				<h3 class="header">My services.</h3>
				<h6 class="subtitle">What I can help you with.</h6>
			</div>

			<div class="row masonry">
				<?php foreach ( get_services() as $svc_key => $svc_info ): ?>
				<div class="col-md-4 grid-item animated-onscroll" data-animation="fadeIn">
					<div class="card bordered-card svc">
						<div class="content">
							<div class="iconic">
								<?php _e( '<i class="%s"></i>', parse_arg('icon', $svc_info) ); ?>
							</div>
							<?php
							_e( '<h1 class="context-heading">%s</h1>', parse_arg('title', $svc_info) );
							_e( '<p>%s</p>', parse_arg('caption', $svc_info) );
							?>
							
						</div>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( have_folio() ): ?>
	<section id="work">
		<div class="content">
			<div class="heading-group">
				<h3 class="header">My work.</h3>
				<h6 class="subtitle">Recent works from my portfolio.</h6>
			</div>

			<div class="row masonry">
				<?php while ( have_folio() ): the_folio(); ?>
				<div class="col-md-4 grid-item" style="position:static;">
					<div class="portfolio">
						<img src="<?php _e( project_cover() ); ?>">
						<div class="details">
							<div>
								<div class="title">
									<?php _e( '<h5>%s</h5>', project_title() ); ?>
									<?php _e( '<small>%s</small>', project_client() ); ?>
								</div>
								<?php if ( project_has_url() || !empty(project_caption()) ): ?>
								<div class="icons-area">
									<ul>
										<?php
										if( project_has_url() ){
											_e( '<li><a class="fa fa-link" href="%s" target="_blank"></a></li>', project_url() );
										}
										if( !empty(project_caption()) ){
											_e( '<li><a class="fa fa-search" data-invoke="modal" data-target="#%s"></a></li>',
												project_id() );
										}
										?>
									</ul>
								</div>
								<?php endif; ?>
							</div>
						</div>
					</div>

					<div class="popup" id="<?php _e( project_id() ); ?>">
						<div class="popup-content">
							<div class="media">
								<img src="<?php _e( project_cover() ); ?>" width="100%" height="auto">
							</div>

							<a class="btn btn-white btn-sm close-btn"><i class="fa fa-times"></i> Close</a>

							<div class="details">
								<div class="caption">
									<div class="heading">
										<?php _e( project_title() ); ?>
										<?php if(!empty(project_date())) _e( project_title() ); ?>
									</div>

									<?php if ( project_has_url() ): ?>
									<div class="btn-area">
										<?php _e( '<a class="btn btn-green btn-sm" href="%s" target="_blank">View project &rarr;</a>', project_url() ); ?>
									</div>
									<?php endif; ?>

									<?php _e( project_caption(true) ); ?>
								</div>
							</div>

							<br class="clear">
						</div>
					</div>
				</div>
				<?php endwhile; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<section id="contact" class="dark text-center" style="background:url(<?php echo get_image_link('background2.jpg') ?>) top center">
		<div class="overlay"></div>
		<div class="content">
			<div class="heading-group">
				<h3 class="header animated-onscroll" data-animation="fadeInDown">Let's work together!</h3>
				<h6 class="subtitle animated-onscroll" data-animation="fadeInUp">Get the job done. Hire me now! =)</h6>
			</div>

			<div class="btn-area animated-onscroll" data-animation="fadeInUp">
				<a class="btn btn-green btn-lg btn-round" data-invoke="scroll" data-target="#contact_form">Get a Quote</a>
			</div>
		</div>
	</section>

	<section id="contact_form">
		<div class="content">
			<div class="heading-group">
				<h3 class="header">Contact.</h3>
				<h6 class="subtitle">Tell me about your project.</h6>
			</div>

			<div class="row">
				<div class="col-md-8">
					<form data-invoke="contact" autocomplete="off" method="post">
						<div class="form-group">
							<input type="text" id="name" name="name" class="form-control" placeholder="Name*">
						</div>
						<div class="form-group">
							<input type="email" id="email" name="email" class="form-control" placeholder="Email*">
						</div>
						<div class="form-group">
							<textarea class="form-control" id="message" name="message" placeholder="Message*"></textarea>
						</div>

						<?php if ( has_recaptcha() ): ?>
						<div class="form-group">
							<?php get_recaptcha(); ?>
						</div>
						<?php endif; ?>

						<div class="form-group">
							<input type="hidden" name="action" value="send_enquiry">
							<button class="btn btn-green btn-lg">Submit</button>
						</div>
					</form>
				</div>

				<div class="col-md-4 quick-response">
					<h5 style="margin:0 0 10px">Need faster response?</h5>
					<div class="info">
						<i class="fa fa-whatsapp fa-lg"></i>
						<a href="<?php echo home_url('/whatsapp'); ?>" target="_blank">+601 6 640 2441</a>
					</div>
					<div class="info">
						<i class="fa fa-envelope-o fa-lg"></i>
						<a href="mailto:omar.veyron@gmail.com">omar.veyron@gmail.com</a>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php get_footer(); ?>