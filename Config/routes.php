<?php
Router::parseExtensions('xml');
Router::connect('/sitemap', array('plugin' => 'sitemap', 'controller' => 'sitemaps', 'action' => 'display'));
?>