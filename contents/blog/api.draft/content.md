---
date: 24 June 2017 13:00
slug: api
---

# Brievcase API

Brievcase comes with its own theming API. The naming of the functions in the API is almost similar to WordPress theme API. So, if you're familiar with WordPress theme, creating theme on Brievcase would be easy for you. The API functions that you can use in your theme can be found in `includes` folder. I've commented on each function to allow you to understand more about how to use them.

## API files

All API functions can be found in `includes/` folder. Each file handles a specific feature in Brievcase. The file structure is shown below:

```shell
includes/
|-- lib/
    |-- ...
|-- class-blog.php
|-- class-contact.php
|-- class-core.php
|-- class-portfolio.php
|-- class-theme.php
|-- functions.php
|-- load.php
|-- render.php
```

Generic description of each API file. You should focus on all these files but not necessarily `load.php` and `render.php`.

- `class-blog.php` – Handles the blog feature.
- `class-contact.php` – Handles the contact feature such as sending email and reCAPTCHA validation.
- `class-core.php` – Handles the core feature on Brievcase such as handling the URL, permalinks and initiating the Brievcase environment.
- `class-portfolio.php` – Handles the portfolio feature, such as fetching the list of portfolios.
- `class-theme.php` – Handles the theme feature. Generic theme functions can be found here.
- `functions.php` – Contains general functions that are used in the Brievcase environment.
- `load.php` – Loads internal and external libraries and initiating all the classes.
- `render.php` – Renders the front-end.


## Method definitions

Each file contains a class that is responsible for handling a specific feature in Brievcase. The table below shows the methods that you can use in your theme. To learn more about each method in details, please open the file where the method is located.

### class-blog.php
<div class="table-responsive">
    <table>
        <tr>
            <th style="width:30%">Method</th>
            <th style="width:20%">Return value</th>
            <th style="width:50%">Description</th>
        </tr>
    
        <tr>
            <td><code>init()</code></td>
            <td>Void</td>
            <td>This method scans the blog directory and parse the blog posts to determine the header image, title, body and metadata. It converts the content into a big array.</td>
        </tr>
    
        <tr>
            <td><code>get_current_blog()</code></td>
            <td>Array</td>
            <td>Get the current blog, which is previously set by <code>set_postdata()</code>.</td>
        </tr>
    
        <tr>
            <td><code>get_blogs()</code></td>
            <td>Array</td>
            <td>Get all the blog array.</td>
        </tr>
    
        <tr>
            <td><code>have_blog()</code></td>
            <td>Boolean</td>
            <td>Determine whether we have any post in the blog directory. This method can be used as the loop condition </td>
        </tr>
    
        <tr>
            <td><code>the_blog()</code></td>
            <td>Void</td>
            <td>Increment the blog counter in the loop and set the current blog.</td>
        </tr>
    
        <tr>
            <td><code>set_postdata( $post_id )</code></td>
            <td>Void</td>
            <td>Set the current blog.</td>
        </tr>
    
        <tr>
            <td><code>have_next_blog()</code></td>
            <td>Boolean</td>
            <td>Determine whether we have the next blog.</td>
        </tr>
    
        <tr>
            <td><code>have_prev_blog()</code></td>
            <td>Boolean</td>
            <td>Determine whether we have the previous blog.</td>
        </tr>
    
        <tr>
            <td><code>next_blog()</code></td>
            <td>Boolean</td>
            <td>Get the next blog array.</td>
        </tr>
    
        <tr>
            <td><code>prev_blog()</code></td>
            <td>Array</td>
            <td>Get the previous blog array.</td>
        </tr>
    
        <tr>
            <td><code>the_title()</code></td>
            <td>Array</td>
            <td>Get the current blog title.</td>
        </tr>
    
        <tr>
            <td><code>the_header()</code></td>
            <td>String</td>
            <td>Get the current blog header image URL.</td>
        </tr>
    
        <tr>
            <td><code>the_slug()</code></td>
            <td>String</td>
            <td>Get the current blog slug.</td>
        </tr>
    
        <tr>
            <td><code>the_content( $raw )</code></td>
            <td>String</td>
            <td>Get the current blog content.</td>
        </tr>
    
        <tr>
            <td><code>the_date( $format )</code></td>
            <td>String</td>
            <td>Get the current blog date.</td>
        </tr>
    </table>
</div>