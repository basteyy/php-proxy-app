
<center>
  
![](https://img.shields.io/packagist/dt/Athlon1600/php-proxy-app.svg) ![](https://img.shields.io/github/last-commit/Athlon1600/php-proxy-app.svg) ![](https://img.shields.io/github/license/Athlon1600/php-proxy-app.svg)

</center>


# php-proxy-app

Web Proxy Application built on [**php-proxy library**](https://github.com/Athlon1600/php-proxy) ready to be installed on your server

![alt text](http://i.imgur.com/KrtU5KE.png?1 "This is how PHP-Proxy looks when installed")

## To Do List

As of **March 25**, 2018:

* Plugin for facebook.com  
* Plugin for dailymotion.com
* Better support/documentation for Plugin Development
* Better Javascript support

## Web-Proxy vs Proxy Server

Keep in mind that sites/pages that are too script-heavy or with too many "dynamic parts", may not work with this proxy script.
That is a known limitation of web proxies. For such sites, you should use an actual proxy server to route your browser's HTTP requests through:  

https://www.proxynova.com/proxy-software/


## Installation

Keep in mind that this is a **project** and not a library. Installing this via *require* would do you not good.
A project such as this, should be installed straight into the public directory of your web server.

```bash
composer create-project athlon1600/php-proxy-app:dev-master /var/www/
```

If you do not have composer or trying to host this application on either a **shared hosting**, or a VPS hosting with limited permissions (dreamhost.com), then download a pre-installed version of this app as a ZIP archive from [**www.php-proxy.com**](https://www.php-proxy.com/).

**Direct Link:**  
https://www.php-proxy.com/download/php-proxy.zip

## Keep it up-to-date

Application itself rarely will change, the vast majority of changes will be done to its requirement packages like php-proxy. Simply call this command once in a while to make sure your proxy is always using the latest versions.

```
composer update
```

#### config.php

This file will be loaded into the global Config class.

#### /src/Templates/

This should have been named "views", but for historic purposes we keep it named as templates for now.

#### /src/Plugins/

PHP-Proxy provides many of its own native plugins, but users are free to write their own custom plugins, which could then be automatically loaded from this very folder. See /plugins/TestPlugin.php for an example.

## Shell Commands

For setup the portal, you can use the Setup-Script to change the config. The script should be performed by default the time you setup it with composer. You can regenerate the 
setup with the following composer command: `composer run-script PhpProxyAppSetupForce`

### Command Options

You can add a few options to the shell script: `composer run-script PhpProxyAppSetupForce -- --command --command2 --command3`

Options:
* `--regenerate_keys` Regenerate all keys
* `--debug:off|on` Turn debug mode off or on
* `--expose:off|on` Turn expose php mode off or on

Full command example, which turns debug and expose mode on:
`composer run-script PhpProxyAppSetupForce -- --debug:on --expose:on`