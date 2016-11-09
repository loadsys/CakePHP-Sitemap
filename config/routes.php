<?php
use Cake\Routing\Router;

Router::plugin(
	'Sitemap',
	['path' => '/'],
	function ($routes) {
		$routes->extensions(['xml']);
		$routes->connect('/sitemap', [
			'controller' => 'Sitemaps',
			'plugin' => 'Sitemap',
			'action' => 'index'
		]);
	}
);
