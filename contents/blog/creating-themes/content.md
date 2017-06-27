---
date: 24 June 2017 00:05
slug: creating-theme
---

# Creating theme

> For effective learning, you might want to study the default theme, Galactic. This is the best theme sample I can give you since it comes with Brievcase by default. In this section, I only show you examples that involve the API.

Creating theme for Brievcase is extremely easy. Brievcase architecture is purposely designed to allow you to edit your theme HTML file without hussle. Once you have your HTML template ready, all you have to do is to PHP-ise the theme using the theme API, you can always edit the file (to add or delete feature) afterwards. All themes are stored in `themes/` folder.

## Theme structure

To create a theme, you need to understand the theme structure first. The theme structure is simple, the folder name is actually the theme name. All theme support files (images, CSS, Javascript) shall be stored in their respective folders. **Also, please make sure that all the files and folders are named correctly and in lowercase.**

```shell
themes/
|-- theme_name/
    |-- css/
        `-- style.css (required)
    |-- images/
    |-- js/
    |-- 404.php (required)
    |-- blog-header.php
    |-- blog-single.php (required)
    |-- blog.php (required)
    |-- header.php
    |-- index.php (required)
    `-- info.json (required)
```
Since you've understand how the structure above, now you need to understand the purpose of each file in the theme.

- `images/` – Not required if you're not using any image in your theme. If you do, the image files must be stored in this folder.
- `js/` – Not required if you're not using any Javascript in your theme. But if you do, the javascript files must be stored in this folder.
- `css/style.css` – **Required.** It must be named as `style.css` and must be located in the `css` folder.
- `404.php` – **Required.** Display the 404 not found page.
- `index.php` – **Required.** This file renders the main portfolio page.
- `info.json` – **Required.** This file contains the theme information.
- `blog-single.php` – **Required.** This file renders the specific blog post.
- `blog.php` – **Required.** This file renders all the blog posts uploaded by you.
- `blog-header.php` – Optional. The specific header file for the blog (sometimes, blog needs different header though).
- `header.php` – Optional. The header file.

## Designing a theme

In this guideline, I'll guide you on how to create a basic theme. First, all you need to have is a HTML template for your theme. Creating a HTML template is ridiculously easy, but to make it works with Brievcase might be a bit tricky for some people. However, I am sure that you'll be able to create your own theme at the end of this section.

### Defining your theme

You should give your theme some information like name, description, author and etc. The theme information is written in JSON format in `info.json` file. Below is the sample `info.json` file.

```json
{
	"name":"galactic",
	"display_name":"Galactic",
	"description":"The default theme for the Showcase app. Inspired from the galaxy and transformed into a beautiful theme for your pleasure.",
	"version":"1.0"
}
```



### Creating header and footer

This is completely optional, but I recommend you to do this since you might want to use them repeatedly in `index.php`, `blog.php` and `blog-single.php` later, so you don't have to *redundantly* write the header and footer codes again.

###### header.php

```html
<!DOCTYPE html>
<html>
<head>
	<title><?php _e( get_site_title() ); ?></title>
  
  	<!-- load the stylesheet -->
	<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_url(['bootstrap.min.css', 'font-awesome.min.css', 'style.css', 'animate.css', 'hybrid.css']); ?>">
	
  	<!-- load the javascripts -->
	<script src="<?php echo get_javascript_url('highlight.pack.js'); ?>"></script>
</head>
  
<body>
```

###### footer.php

```
</body>
</html>
```



#### The homepage

The `index.php` file is the homepage. This is where the portfolio is displayed. In the example below is from Galactic's `index.php` file. Brievcase's portfolio is designed to allow you to add/delete section easily. If you're good in HTML and CSS, you can always edit the codes below.

###### index.php

```html
<?php get_header(); // Use get_header() to include the header file. ?>
<div class="global">
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
</div>
<?php get_footer(); // Use get_footer() to include the footer file. ?>
```



### Looping the blog posts

#### Displaying all blog posts

All blog posts are displayed in `blog.php` file. You may see the sample below to see how it works. The `the_excerpt()` function is the first 50 words (or how much you want) in the first paragraph. To learn more about Brievcase API, you can read the [documentation here](./api).

###### blog.php

```html
<?php get_blogheader(); // this renders the blog-header.php file ?>
<div>
  	<?php if (have_post()): ?>
  		<?php while(have_post()): the_post(); ?>
        <h1><?php _e( the_title() ); ?></h1>
      	<h5 class="date"><?php _e( the_date() ); ?></h5>
      	<div class="content">
        	<?php _e( the_excerpt() ); ?>
      	</div>
  		<?php endwhile; ?>
  	<?php else: ?>
      <div>
          <h1>There is no blog post available.</h1>
      </div>
  	<?php endif; ?>
</div>
<?php the_footer(); ?>
```



#### Showing a specific post

The full post is is displayed in `blog-single.php`. See the sample below to see how it works. In this sample, the layout is much similar to the one in `blog.php` (in this case), but we don't include the loop and use `the_content()` instead of `the_excerpt()` because we want to display the full blog post.

Note that we don't verify whether the post exists or not since it has already been checked in the core file and a 404 page will be displayed.

###### blog-single.php

```html
<?php get_blogheader(); ?>
<div>
  <h1><?php _e( the_title() ); ?></h1>
  <h5 class="date"><?php _e( the_date() ); ?></h5>
  <div class="content">
    <?php _e( the_content() ); ?>
  </div>
</div>
<?php the_footer(); ?>
```

