---
date: 24 June 2017 00:02
slug: installing
---

# Download & Installation

It is very easy to deploy Brievcase, that there is no installation needed at all. All you have to do is to download the ZIP package from the Github repository and extract it to your web server.

## Check for PHP version

Brievcase works well with PHP 5.6.30 and above. I haven't try it with the previous PHP version. But if you want, you can do it too and see whether it's working.

To check your PHP version, open terminal program and enter this command:

```
$ php -v
```

You will see something similar to this:

```shell
PHP 5.6.30 (cli) (built: Jan 20 2017 08:24:09) 
Copyright (c) 1997-2016 The PHP Group
Zend Engine v2.6.0, Copyright (c) 1998-2016 Zend Technologies
```

## Download and installation

#### Option 1: Install from ZIP package

The easiest way to install Brievcase is by extracting the ZIP archive file into your webroot.

1. Simply go to [Brievcase repository on GitHub](https://github.com/omarqe/brievcase) and download the ZIP archive.
2. Extract the ZIP file into the webroot of your server.

#### Option 2: Clone from the GitHub repository

Alternatively, you can clone Brievcase from the GitHub repository directly into your webroot by typing the following commands:

```shell
$ cd ~/path/to/your/webroot
$ clone https://github.com/omarqe/brievcase.git
$ sudo chmod 0777 -R contents
```



## Successful installation

Upon successful installation, you will see your portfolio is up and there should be no error appear on screen. Good luck!