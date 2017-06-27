<?php
/**
 * Showcase - an open source portfolio platform for freelancers.
 * 
 * @package 	Showcase.Settings
 * @author 		Omar Mokhtar Al-Asad
 * @link 		http://omarqe.com
 * 
 * @copyright	Copyright (C) 2016-2017 Margs Empire. All right reserved.
 * @license 	MIT license; see LICENSE.txt for more detials.
 **/

return [
	'site_title' => [
		'name' => 'Brievcase',
		'tagline' => 'Simple Online Portfolio Platform'
	],

	/**
	 * The theme configuration.
	 * 
	 * @since 	1.0
	 **/
	'theme' => [
		'name' => 'briev',
		'version' => 'automatic'
	],

	/**
	 * The website menu. [label] => [href]
	 * 
	 * @since 	1.0
	 **/
	'menu' => [
		'Home' => '#home',
		'About' => '#about',
		'Service' => '#service',
		'Portfolio' => '#work',
		'Contact' => '#contact'
	],

	/**
	 * The blog menu.
	 * 
	 * @since 	1.0
	 **/
	'blog' => [
		'menu_label' => 'Blog',
		'url' => 'docs',
		'enable' => true,
		// Rename slug automatically based on the first H1 in the content file (the slug is renamed
		// only when the slug is invalid).
		'auto_slug_rename' => true,
		// Set to true to sort the blog from latest to oldest.
		'sort_descending' => false,
		// The blog categories: Array( category_id => category_label )
		// BE CAREFUL: Changing the category ID may affect your posts under that specific category. If you wish to 
		// delete a category, exclude the ID from the active_categories settings.
		'categories' => [
			'life' => 'Life',
			'tech' => 'Technology',
			'business' => 'Business'
		],
		// Active categories are the post categories that can be displayed on the blog.
		'active_categories' => ['life', 'tech', 'business']
	],
	
	'date' => [
		// The date format in PHP. The date characters can be referred here http://php.net/manual/en/function.date.php
		// Default format: D, j F Y \a\t g.ia (e.g. Thu, 1 June 2017 at 5:28am)
		'format' => 'D, j F Y \a\t g.ia',
		// The timezone we should use for the system. The timezone string can be referred here:
		// http://php.net/manual/en/timezones.php
		'timezone' => 'Asia/Kuala_Lumpur'
	],

	// Google's reCAPTCHA settings
	// reCAPTCHA is a way to prevent bot from submitting form on your website. In Showcase, we use this primarily
	// in contact form. To get your own reCAPTCHA, go to: https://www.google.com/recaptcha
	'recaptcha' => [
		'enabled' => true,
		// The reCAPTCHA site key that is used when embedding the reCAPTCHA widget into forms.
		'site_key' => '',
		// The reCAPTCHA secret key so that Showcase is able to communicate with Google's server.
		'secret_key' => ''
	],

	// SMTP settings
	// We need this setting to be configured correctly to allow us to send enquiry email directly from a form
	// on your portfolio. If you are using Gmail, this website (https://www.lifewire.com/what-are-the-gmail-smtp-settings-1170854)
	// has an article about the settings.
	'smtp' => [
		// The SMTP server, for example smtp.gmail.com
		'host' => 'smtp.example.com',
		// Leave this empty to automatically find the port.
		'port' => 587,
		// We recommend you create a new email and turn on the less secure app option
		// here: https://myaccount.google.com/lesssecureapps
		// NOTE: The message will be sent to the email you set in /contents/user/contact.yaml file.
		'username' => 'example@website.com',
		'password' => 'helloworld',
		// The email subject. This helps you recognise the email coming from your portfolio better.
		'mail_subject' => "[website.com] Let's work together, John Doe!"
	],

	/**
	 * The current Showcase version.
	 * 
	 * @since 	1.0
	 **/
	'app_version' => '1.0 (Beta)'
];