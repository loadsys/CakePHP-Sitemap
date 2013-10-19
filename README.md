#CakePHP-Sitemap Plugin

Generate automatic HTML and XML sitemaps for your CakePHP application.

##Background

Only generates a sitemap currently for controllers/models in the core App, not in Plugins.
Generates an HTML list using a dl list.
Generates an sitemap.xml file as well.
View caching used for the HTML files.
Allows for setting a custom callback function to build urls.

##Requirements

PHP 5.3+
CakePHP 2.1+

##Installation

###Manual

Download this: http://github.com/loadsys/CakePHP-Sitemap/zipball/master
Unzip that download.
Copy the resulting folder to app/Plugin
Rename the folder you just copied to Sitemap

###GIT Submodule

In your app directory type:

git submodule add git://github.com/loadsys/CakePHP-Sitemap.git Plugin/Sitemap
git submodule init
git submodule update

###GIT Clone

In your plugin directory type

git clone git://github.com/loadsys/CakePHP-Sitemap.git Sitemap

##Usage

* Add this this line to your bootstrap:
````php
CakePlugin::load(array('Sitemap' => array('routes' => TRUE, 'bootstrap' => TRUE)));
````

* Add the component to the controllers desired to generate a sitemap for that controller
````php
public $components = array(
	'Sitemap.Sitemap',
);
````

* Add the behavior to the model desired to generate a sitemap for that model
````php
public $behaviors = array(
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

####Options


###Todo

* Write Unit Tests

##License

Copyright (c) 2013 Loadsys Web Strategies