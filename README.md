# CakePHP-Sitemap

[![Latest Version](https://img.shields.io/github/release/loadsys/CakePHP-Sitemap.svg?style=flat-square)](https://github.com/loadsys/CakePHP-Sitemap/releases)
[![Build Status](https://img.shields.io/travis/loadsys/CakePHP-Sitemap/master.svg?style=flat-square)](https://travis-ci.org/loadsys/CakePHP-Sitemap)
[![Coverage Status](https://img.shields.io/coveralls/loadsys/CakePHP-Sitemap/master.svg?style=flat-square)](https://coveralls.io/r/loadsys/CakePHP-Sitemap)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/loadsys/cakephp_sitemap.svg?style=flat-square)](https://packagist.org/packages/loadsys/cakephp_sitemap)

The Sitemap provides a mechanism for displaying Sitemap style information (the url, change frequency, priority and last modified datetime) for a set of Tables that CakePHP has access to.


## Requirements

* CakePHP 3.0.0+
* PHP 5.6+


## Installation

```bash
$ composer require loadsys/cakephp_sitemap
```

In your `config/bootstrap.php` file, add:

```php
Plugin::load('Sitemap', ['bootstrap' => false, 'routes' => true]);
```

OR

```php
bin/cake plugin load Sitemap
```

## Usage

* Add list of tables to display Sitemap records via an array at `Sitemap.tables`

```php
Configure::write('Sitemap.tables', [
	'Pages',
	'Sites',
	'Camps',
]);
```

* Add the `Sitemap.Sitemap` Behavior to each table as well

```php
$this->addBehavior('Sitemap.Sitemap');
```

### Configuration

* Default configuration options for the `Sitemap` Behavior is:

```php
'cacheConfigKey' => 'default',
'lastmod' => 'modified',
'changefreq' => 'daily',
'priority' => '0.9',
'conditions' => [],
'order' => [],
'fields' => [],
'implementedMethods' => [
	'getUrl' => 'returnUrlForEntity',
],
'implementedFinders' => [
	'forSitemap' => 'findSitemapRecords',
],
```

* To modify these options for instance to change the `changefreq` when listing records, updated the `addBehavior` method call for the `Table` in question like so:

```php
$this->addBehavior('Sitemap.Sitemap', ['changefreq' => 'weekly']);
```

* To customize the url generated for each record create a method named `getUrl` in the matching `Table` class.

```
public function getUrl(\App\Model\Entity $entity) {
	return \Cake\Routing\Router::url(
		[
			'prefix' => false,
			'plugin' => false,
			'controller' => $this->registryAlias(),
			'action' => 'display',
			$entity->display_id,
		],
		true
	);
}
```

## Contributing

### Code of Conduct

This project has adopted the Contributor Covenant as its [code of conduct](CODE_OF_CONDUCT.md). All contributors are expected to adhere to this code. [Translations are available](http://contributor-covenant.org/).

### Reporting Issues

Please use [GitHub Isuses](https://github.com/loadsys/CakePHP-Sitemap/issues) for listing any known defects or issues.

### Development

When developing this plugin, please fork and issue a PR for any new development.

Set up a working copy:
```shell
$ git clone git@github.com:YOUR_USERNAME/CakePHP-Sitemap.git
$ cd CakePHP-Sitemap/
$ composer install
$ vendor/bin/phpcs --config-set installed_paths vendor/loadsys/loadsys_codesniffer,vendor/cakephp/cakephp-codesniffer
```

Make your changes:
```shell
$ git checkout -b your-topic-branch
# (Make your changes. Write some tests.)
$ vendor/bin/phpunit
$ vendor/bin/phpcs -p --extensions=php --standard=Loadsys ./src ./tests
```

Then commit and push your changes to your fork, and open a pull request.


## License

[MIT](https://github.com/loadsys/CakePHP-Sitemap/blob/master/LICENSE.md)


## Copyright

[Loadsys Web Strategies](http://www.loadsys.com) 2016
