<?php
use Cake\Routing\Router;

Router::plugin('Sitemap', function ($routes) {
	$routes->fallbacks('DashedRoute');
});
