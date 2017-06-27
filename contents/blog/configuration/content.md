---
date: 24 June 2017 00:02
slug: configuration
---

# Configuration

Configuration Brievcase is simple, it uses `YAML` and `PHP array` to configure the settings. All configuration files can be found in `/contents/user` directory.

## Configuration files

All configuration files are listed as follow:

- `settings.php` – contains general settings for the whole Brievcase.
- `contact.yaml` – contains your contact information such as email, phone, WhatsApp, etc.
- `profile.yaml` – contains your personal information such as name, age, etc.
- `service.yaml` – contains the services you provide to your clients.
- `social_media.yaml` – contains the list of your social media.

### settings.php

This file contains the general settings for the Brievcase environment. Each configuration is well commented so you might check it out in the file for more details.

>  Note: Please do not use your primary email for the SMTP settings. I recommend you to create a new email just for this purpose.

The sample configuration file:

```php
return [
  	// Website title and tagline
	'site_title' => [
		'name' => 'Brievcase',
		'tagline' => 'Simple Online Portfolio Platform'
	],

  	// The theme configuration, all lowercase letter please.
	'theme' => [
		'name' => 'briev',
		'version' => 'automatic'
	],

    // The menu that appears on your website (this depends on theme)
	'menu' => [
		'Home' => '#home',
		'About' => '#about',
		'Service' => '#service',
		'Portfolio' => '#work',
		'Contact' => '#contact'
	],

    // The blog configuration
	'blog' => [
        // Blog label in menu
		'menu_label' => 'Blog',
        // The blog URL, for example: /blog, /posts
		'url' => '/blog',
        // Enable or disable blog
		'enable' => true,
        // Rename folder to the valid slug
		'auto_slug_rename' => true,
        // Sort blog in descending order (latest on top)
		'sort_descending' => false,
        // Blog categories
		'categories' => [
			'life' => 'Life',
			'tech' => 'Technology',
			'business' => 'Business'
		],
        // Active categories, I don't recommend you to delete
        // categories that you've added for your blog. Otherwise,
        // you can set which categories shall be active.
		'active_categories' => ['life', 'tech', 'business']
	],
	
    // Date settings
	'date' => [
		'format' => 'D, j F Y \a\t g.ia',
		'timezone' => 'Asia/Kuala_Lumpur'
	],

    // Google reCAPTCHA is primarily use in contact form.
    // This is to prevent spam.
	'recaptcha' => [
		'enabled' => true,
		'site_key' => '',
		'secret_key' => ''
	],

    // SMTP settings, use to send email directly from the form
    // straight to your inbox.
	'smtp' => [
        // SMTP server host, e.g: smtp.google.com
		'host' => 'smtp.example.com',
        // SMTP port, Google uses 587 for TLS.
		'port' => 587,
        // Your enquiry email. I recommend you create a new email
        // purposely for this enquiry. DON'T USE YOUR PRIMARY EMAIL.
		'username' => 'example@website.com',
        // The email password. It's in cleartext, that's why.
		'password' => 'helloworld',
        // The mail subject. This helps improve the visibility of
        // your clients' emails.
		'mail_subject' => "[website.com] Let's work together, John Doe!"
	],

    // Brievcase version.
	'app_version' => '1.0'
];
```



---

### contact.yaml

This file contains your contact information.

```yaml
whatsapp: 60166402441
phone: +60166402441
email: enquiry@example.com
website: http://www.example.com

# quick response corresponds to the contact keys above. e.g: whatsapp, email, phone
quick_response:
  whatsapp
  email
```



---

### profile.yaml

This file contains your personal information.

```yaml
enabled: true
name: Omar Mokhtar
photo: profile.bmp
bio: |
 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris varius libero et purus sagittis, tincidunt ultrices tortor convallis. Nunc consectetur non mi id eleifend. Nam vehicula mattis imperdiet. Etiam consectetur libero turpis, non commodo risus feugiat ut.

table:
 age: 21 years old
 experience: 7+ years
 #phone: use_contact
 #email: use_contact
 website: www.omarqe.com
 languages: English, Malay
 education:
  University of Malaya
  Computer Science (Software Engineering)
```



---

### service.yaml

This file contains all the services you provide to your clients. Please note that the icon is totally depending on the theme you use. Check the theme documentation (if any) for more information. Brievcase default theme, `galactic`, uses [FontAwesome](http://fontawesome.io) as the icons.

Sample service configuration:

```yaml
web_application:
  icon: fa fa-code
  title: Web Application
  caption: Full-stack online softwares built with the popular PHP programming language for businesses and organisations.

wordpress_website:
  icon: fa fa-wordpress
  title: Wordpress Website
  caption: Wordpress websites built on top of premium theme for organisations, events, etc.

graphic_design:
  icon: fa fa-paint-brush
  title: Graphic Design
  caption: Vector-styled poster, banner, business card, book cover for authors, events, businesses and other individuals.

ui_design:
  icon: fa fa-mobile
  title: UI/UX Design
  caption: User interface designs for various mobile and web applications.

web_design:
  icon: fa fa-television
  title: Web Design
  caption: Static HTML5/CSS3 web designs for small to medium sized projects

portfolio_design:
  icon: fa fa-briefcase
  title: Portfolio Design
  caption: Online portfolio design using the Showcase platform.
```



---

### social_media.yaml

This file contains your social media profile. Please use your social media username only, don't use the full URL. You can add more social media such as Youtube, etc., but please make sure that you use all lowercase letters.

```yaml
facebook: omarqe
instagram: omarqe
twitter: omarqe
github: omarqe
linkedin: omarqe
```

