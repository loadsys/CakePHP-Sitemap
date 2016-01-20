# CakePHP-Sitemap

A CakePHP 2.x Plugin for adding automatic XML and HTML Sitemaps to an CakePHP app


[![Latest Version](https://img.shields.io/github/release/loadsys/CakePHP-Sitemap.svg?style=flat-square)](https://github.com/loadsys/CakePHP-Sitemap/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/loadsys/cakephp_sitemap.svg?style=flat-square)](https://packagist.org/packages/loadsys/cakephp_sitemap)
<!--
[![Build Status](https://travis-ci.org/loadsys/{PLUGIN_NAME}.svg?branch=master&style=flat-square)](https://travis-ci.org/loadsys/CakePHP-SocialLinks)
[![Coverage Status](https://coveralls.io/repos/loadsys/{PLUGIN_NAME}/badge.svg)](https://coveralls.io/r/loadsys/{PLUGIN_NAME})
-->

## Background

* Only generates a sitemap currently for models in the core App, not in Plugins.
* Generates an HTML list using a dl list.
* Generates an sitemap.xml file as well.
* View caching used for the HTML files.
* Allows for setting a custom callback function to build urls.

## Requirements

* PHP 5.3+
* CakePHP 2.1+

## Installation

### Composer

````bash
$ composer require loadsys/cakephp_sitemap:~1.0
````

## Usage

* Add this this line to your `bootstrap.php`:

````php
CakePlugin::load(array('Sitemap' => array('routes' => true, 'bootstrap' => true)));
````

* Add the behavior to the model desired to generate a sitemap for that model

````php
public $actsAs = array(
	'Sitemap.Sitemap' => array(
		'primaryKey' => 'id', // Default primary key field
		'loc' => 'buildUrl', // Default function called that builds a url, passes parameters (Model $Model, $primaryKey)
		'lastmod' => 'modified', // Default last modified field, can be set to FALSE if no field for this
		'changefreq' => 'daily', // Default change frequency applied to all model items of this type, can be set to FALSE to pass no value
		'priority' => '0.9', // Default priority applied to all model items of this type, can be set to FALSE to pass no value
		'conditions' => array(), // Conditions to limit or control the returned results for the sitemap
	)
);
````

* Sitemap should now be visible at /sitemap and /sitemap.xml

## Contributing

### Reporting Issues

Please use [GitHub Isuses](https://github.com/loadsys/CakePHP-Sitemap/issues) for listing any known defects or issues.

<!-- ### Development

When developing this plugin, please fork and issue a PR for any new development.

The Complete Test Suite for the plugin can be run via this command:

`./lib/Cake/Console/cake test Sitemap AllSitemaps` -->

## License ##

[MIT](https://github.com/loadsys/CakePHP-Sitemap/blob/master/LICENSE.md)


## Copyright ##

[Loadsys Web Strategies](http://www.loadsys.com) 2016
