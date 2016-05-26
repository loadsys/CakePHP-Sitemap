<?php
/**
 * Basic Sitemaps Controller to display a standard Sitemap in HTML and XML.
 */
namespace Sitemap\Controller;

use Cake\Core\Configure;
use Sitemap\Controller\AppController;

/**
 * \Sitemap\Controller\SitemapsController
 */
class SitemapsController extends AppController {
	/**
	 * Index page for the sitemap.
	 *
	 * @return void
	 */
	public function index() {
		$tablesToList = [];
		$data = [];

		if (Configure::check('Sitemap.tables')) {
			$tablesToList = Configure::read('Sitemap.tables');
		}

		foreach ($tablesToList as $table) {
			$this->loadModel($table);
			$data[$table] = $this->{$table}->find('forSitemap');
		}

		$this->set('data', $data);
	}
}
