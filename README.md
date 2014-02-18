#CakePHP-Sitemap Plugin

Generate automatic HTML and XML sitemaps for your CakePHP application.

##Background

Only generates a sitemap currently for models in the core App, not in Plugins.
Generates an HTML list using a dl list.
Generates an sitemap.xml file as well.
View caching used for the HTML files.
Allows for setting a custom callback function to build urls.

##Requirements

* PHP 5.3+
* CakePHP 2.1+

## Installation ##

### Composer ###

Ensure `require` is present in `composer.json`. This will install the plugin into `Plugin/SocialLinks`:

```
{
	"require": {
		"loadsys/cakephp_sitemap": "dev-master",
	}
}
```

###GIT Submodule

In your app directory type:

``` bash
git submodule add git://github.com/loadsys/CakePHP-Sitemap.git Plugin/Sitemap
git submodule init
git submodule update
```

##Usage

* Add this this line to your bootstrap:
````php
CakePlugin::load(array('Sitemap' => array('routes' => TRUE, 'bootstrap' => TRUE)));
````

* Add the behavior to the model desired to generate a sitemap for that model
````php
public $actsAs = array(
	'Sitemap.Sitemap' => array(
		'primaryKey' => 'id', //Default primary key field
		'loc' => 'buildUrl', //Default function called that builds a url, passes parameters (Model $Model, $primaryKey)
		'lastmod' => 'modified', //Default last modified field, can be set to FALSE if no field for this
		'changefreq' => 'daily', //Default change frequency applied to all model items of this type, can be set to FALSE to pass no value
		'priority' => '0.9', //Default priority applied to all model items of this type, can be set to FALSE to pass no value
		'conditions' => array(), //Conditions to limit or control the returned results for the sitemap
	)
);
````

* Sitemap should now be visible at /sitemap and /sitemap.xml

## Contributing

* Fork the plugin to your Github account
* Checkout the plugin
* Create a new branch with your changes
* Issue a PR back to the master branch with your changes

## License

Copyright (c) 2013 Loadsys Web Strategies