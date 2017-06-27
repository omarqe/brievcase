---
date: 24 June 2017 00:04
slug: portfolio
---

# Adding portfolio

Portfolio is the main reason why Brievcase exists. Adding a portfolio is **very simple,** but you need to understand a few things first.

## Portfolio structure

Like blog, portfolio is per folder. It is just that you can add as many photos per portfolio as you want. If the theme supports, it will be able to display all the photos for you. The portfolio metadata (url, title, client, category and caption) are written in `default.yaml`, in YAML format. All portfolios are uploaded in `contents/portfolio` directory.

```shell
contents/portfolio
|-- 01
    |-- cover.jpg
    |-- default.yaml
    |-- photo1.jpg
    `-- phoot2.jpg
`-- 02
	|-- cover.jpg
	`-- default.yaml
```

## Uploading the portfolio

There are many approaches you can take to upload a portfolio, as long as they are uploaded in `contents/portfolio` directory.

### Option 1: Terminal (SCP)

You can use the `scp` module to upload your portfolio, just like blog.

To begin, type the following command (please note the `-r` option to upload folder):

``` shell
$ scp -r /path/to/portfolio/folder user@example.com:/path/to/webroot/contents/portfolio
```

You will be prompted to enter the user password.

## Option 2: Terminal (SFTP)

You can use SFTP as well to upload your portfolio. Type the following command in your terminal.

```shell
$ sftp user@example.com
user@example.com's password:
```

After you entered the password correctly, change your working directory to `contents/portfolio` like so:

```shell
sftp> cd /path/to/webroot/contents/portfolio
```

To make sure that you are working in the correct directory, type this command:

```shell
sftp> pwd
```

You'll get something like this:

```shell
Remote working directory: /path/to/webroot/contents/portfolio
```

If your working directory is correct, type this command to upload the portfolio from your local machine (note the `-r` option to upload a folder):

```shell
sftp> put -r /path/to/portfolio/folder
```

### Option 3: FTP client

If you're not familiar with commands, this is the easiest way to upload your portfolio. Use an FTP client such as [FileZilla](https://filezilla-project.org/) to do this.

1. Login to your web FTP server by providing the `host`, `user`, `password` and [optional: `port`].
2. After successful login, on your server directory, navigate to `path/to/webroot/contents/portfolio`.
3. Upload your blog folder there.
4. Done.

## Portfolio format & metadata

The portfolio file is written in YAML format, in `default.yaml` file. This file is **required** for each portfolio.

### Metadata

- `url` - Optional. The URL of the project.
- `title` - Required. The title of the project.
- `client` - Required. The client this project belongs to.
- `photos` - Optional. The work photo. The first photo is considered the portfolio cover.
- `category` - Optional. The category of the portfolio. Default is Uncategorised.
- `caption` - Required. The description of the project, tell what the project is all about.

Below is the sample metadata file, `default.yaml`:

```yaml
url: http://www.ustartum.com
title: U-Start Conference Malaysia
client: UMCIC
photos:
  cover.jpg
category: website
caption: |
 An event organized by University of Malaya through its Centre of Innovation and Commercialization UMCIC, showcasing university technology startups, interactive panel discussions from experts and providing business networking and investor matching opportunities.
```