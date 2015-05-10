<?php

// ensure we can parze xml files
Router::parseExtensions('xml');

// connect the /sitemap to the sitemap controller
Router::connect('/sitemap', array(
	'plugin' => 'sitemap',
	'controller' => 'sitemaps',
	'action' => 'display'
));
