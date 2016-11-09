<?php
namespace Sitemap\Test\App\Config;

use Cake\Routing\Router;

Router::scope('/', function ($routes) {
	$routes->connect('/pages/view/:id', [
		'controller' => 'Pages',
		'action' => 'view',
	], ['pass' => ['id']]);
});

require ROOT . DS . 'config/routes.php';
