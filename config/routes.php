<?php
use Cake\Routing\Router;

Router::plugin(
	'Sitemap',
	['path' => '/sitemap'],
	function ($routes) {
		$routes->extensions(['xml']);
		$routes->fallbacks('DashedRoute');
	}
);
