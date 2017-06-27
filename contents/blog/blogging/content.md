---
date: 24 June 2017 00:03
slug: blogging
---

# Blogging

Blogging is the most fun part (I think) about Brievcase. I love to write stuffs on my website, and that is the reason why I create the blogging feature for Brievcase. However, blogging with Brievcase isn't the same as blogging with WordPress or any other CMS, since it doesn't have an admin panel.

Brievcase make use of Markdown for content creation. You write the content of your blog locally on your computer with your favourite Markdown editor (as mentioned earlier). Once you've finished, just upload it to the `contents/blog/` directory.

## Blog structure

A post in a blog is per folder, the folder name is the slug of the blog. The slug appears as the permalink to the specific post, for example, `http://example.com/blog/my-first-blog/`. The post content is written in a file named `content.md`. All image files that is embedded/used in the post shall be put in the same folder as `content.md` or it can be located remotely (when you're using the image URL instead).

```shell
contents/blog/
|-- my-first-blog/
    |-- content.md
    |-- header.jpg
    |-- another_image.jpeg
    `-- meta.yaml (this is optional)
`-- my-second-blog/
    |-- content.md
    `-- image.jpeg
```



## Uploading the blog

There are various ways of uploading a blog post to Brievcase. You can either use terminal (command-line) approach or use any FTP client (as mentioned in the [Requirements](./requirements)).

### Option 1: Terminal (SCP)

For Mac OS X, the terminal is usually bundled with `scp` module, but for Windows, I am not really sure about that. However, you might want to use [Putty](http://www.putty.org/) on Windows. But I am not sure whether Putty works with `scp` or not, but if not, use Option 3 straightaway.

Type the following command to your terminal (note the `-r` option to upload folder):

```shell
$ scp -r ~/path/to/blog/folder/my-first-blog/ user@example.com:/path/to/webroot/contents/blog
```

You are required to enter your user password and it'll upload the folder for you. The `scp` is actually copy and paste. It works like this.. `$ scp {copy_from_which_directory} {to_which_directory}`. Google this for more information.

### Option 2: Terminal (SFTP)

You can also use SFTP via terminal. Again, Mac OS X terminal already packed with this module. Type the following command and enter the user password:

```shell
$ sftp user@example.com
user@example.com's password: 
```

Upon successful login, change the working directory to your web root:

```shell
sftp> cd /path/to/webroot/contents/blog
```

To make sure that you're working in the right directory, type this command:

```shell
sftp> pwd
```

It will show you something like this:

```shell
Remote working directory: /path/to/webroot/contents/blog
```

If the working directory is correct (you should be in the blog directory), upload your post folder like so (e.g: `my-first-blog`). Please note the `-r` option to upload folder:

```
sftp> put -r /Users/omarqe/Desktop/my-first-blog
```

### Option 3: FTP client

The easiest way to upload your blog is by using FTP client such as [FileZilla](https://filezilla-project.org/). Just follow the simple steps below.

1. Login to your web FTP server by providing the `host`, `user`, `password` and [optional: `port`].
2. After successful login, on your server directory, navigate to `path/to/webroot/contents/blog`.
3. Upload your blog folder there.
4. Done.

If you need help in using FTP on your web server, you can try searching the tutorial on search engine or Youtube or ask your hosting provider.

## Blog format

### Post metadata

The meta is written in the following conditions:

1. Minimum metadata is should be provided in each post is `date`.
2. Must be written in YAML format
3. Must be written either in `content.md` as [YAML front matter](https://jekyllrb.com/docs/frontmatter/) or in a separate file named `meta.yaml`. (Please note that the front matter take precedence over `meta.yaml`, so if they exists in both, the `meta.yaml` will be ignored).
4. If metadata is written as YAML front matter, **it must be located on the very top** in `content.md` file.
5. If no metadata exist in both `front matter ` and `meta.yaml`, we'll take the file creation date instead as the `date`.
6. All meta keys must be written in all-lowercase characters.

All the metadata keys are as follow:

- date - **Required.** The date of post in `j F Y H:i` format (e.g: 25 June 2017 14:52). For more information about the date format, read [this documentation](http://php.net/manual/en/function.date.php).
- slug - Optional. The post slug. Make sure that the slug is unique, since conflict may occur.
- author - Optional. The author of the post
- category - Optional. The post category. By default, the category of a post falls under *Uncategorised*.

#### Sample metadata

###### Writing metadata in content.md file as front matter (note the triple dashes, they indicate the beginning and the end of the front matter)

```yaml
---
date: 25 June 2017 13:56
slug: my-first-blog
author: Omar Mokhtar
category: technology
---
```

###### Writing metadata in meta.yaml file

```yaml
date: 25 June 2017 13:56
slug: my-first-blog
author: Omar Mokhtar
category: technology
```

### Header image

Header image is optional, but if you want to put it, **it must be located in the first line** after YAML front matter (if any).

The header image is written in the standard Markdown format for image, 

- For remote file, you can provide the full URL of the image like this: `![alt text](http://example.com/media/header.jpeg)`.
- Alternatively, for the local header file, you can write the file name only such as: `![alt text](header.bmp)`; however, the `header.bmp` file **must contain in the same folder as `content.md`**.

### Post title

The post title is **required,** thus a blog post without a title is totally ignored. The post title is written just right after the header image (if any). It uses the H1 heading; so in the standard Markdown format, it is written like this: `# My First Blog`.

### Post body

Everything written under the post title is considered the body/content of the post.

### Embedding image

You can embed images anywhere in your blog. The image file can either be locally or remotely. Use the standard Markdown format for image (as written in *Header image* above). For remote image, you can provide the full URL to the image. For local image, you can provide the filename but please make sure that the image file is located in the same folder as `content.md`.

### Example blog

```markdown
---
date: 25 June 2017 14:52
slug: blogging-with-brievcase
category: feature
---

![header](header.jpg)
# The title of the blog

Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris varius libero et purus sagittis, tincidunt ultrices tortor convallis. Nunc consectetur non mi id eleifend. Nam vehicula mattis imperdiet. Etiam consectetur libero turpis, non commodo risus feugiat ut. Maecenas in dolor sollicitudin, tincidunt turpis sed, iaculis massa.

Phasellus malesuada molestie nunc eget lobortis. In pharetra, nisl ut ornare dictum, mi mauris iaculis nulla, nec interdum justo justo a nulla. Donec aliquet lectus ac ligula pretium malesuada. Aliquam iaculis orci dolor, eu pellentesque purus facilisis ac. Morbi in mi non arcu pharetra molestie. Suspendisse non nulla diam. Pellentesque tempus a lacus in accumsan. Nullam ut mi nibh. Proin dignissim orci quis velit vehicula, quis congue mauris ornare. Aliquam posuere interdum tortor eget tempor.

> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris varius libero et purus sagittis, tincidunt ultrices tortor convallis.

Nunc vel venenatis libero. Nunc eleifend, nisl eu accumsan iaculis, ex enim finibus dui, in congue ante diam at tortor. Maecenas non pellentesque nulla. Nam semper dictum pretium. Nullam pharetra nunc non risusµ egestas, at consectetur massa pellentesque. Morbi ligula tortor, pulvinar a turpis sit amet, commodo suscipit nunc. Nam a sapien rhoncus neque porta condimentum vitae sit amet neque.
```