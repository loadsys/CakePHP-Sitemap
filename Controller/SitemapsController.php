<?php
/**
 * SitemapsController contains the action that loads and displays the sitemap
 */
App::uses('SitemapAppController', 'Sitemap.Controller');
App::uses('PagesIterator', 'Sitemap.Lib/Iterators');

/**
 * SitemapsController
 */
class SitemapsController extends SitemapAppController {

	/**
	 * array of helpers
	 *
	 * @var array
	 */
	public $helpers = array(
		'Time',
		'Html',
		'Cache',
	);

	/**
	 * array of components
	 *
	 * @var array
	 */
	public $components = array(
		'RequestHandler',
		'Auth',
	);

	/**
	 * view cache timing
	 *
	 * @var array
	 */
	public $cacheAction = array(
    'display' => 43200,
	);

	/**
	 * beforeFilter callback
	 *
	 * @return void
	 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('display'));
	}

	/**
	 * display the sitemap
	 *
	 * @return void
	 */
	public function display() {
		$sitemapData = array();

		//Generate a list of Models in the App
		$listOfModels = $this->_generateListOfModels();

		//foreach model
		foreach($listOfModels as $model) {
			App::uses($model, 'Model');

			// We need to load the class
			$newModel = new $model;

			if (
				!empty($newModel->actsAs)
				&& array_key_exists('Sitemap.Sitemap', $newModel->actsAs)
			) {
				$response = $newModel->generateSitemapData();
				$sitemapData[$newModel->name] = $response;
			}
			unset($newModel);
		}

		//Generate Sitemap of Static Pages
		$sitemapData['Page'] = $this->_generateListOfStaticPages();

		$this->set('sitemapData', $sitemapData);
	}

	/**
	 * generate the list of models
	 *
	 * @return array array of Models with the class names
	 */
	protected function _generateListOfModels() {
		//Generate list of Models
		$appModelClasses = App::objects('Model');
		$listOfModels = array();

		foreach ($appModelClasses as $modelClass) {
			if ($modelClass != 'AppModel') {
				// Load the Model
				App::import('Model', str_replace('Model', '', $modelClass));
				$listOfModels[] = $modelClass;
			}
		}

		return $listOfModels;
	}

	/**
	 * generate the list of static pages and the sitemap data
	 *
	 * @return array array of sitemap data for all the static pages
	 */
	protected function _generateListOfStaticPages() {
		$pagesSitemap = array();

		$pages = new PagesIterator(APP . 'View' . DS .'Pages' . DS, array(), $this->request->webroot);
		$pagesArray = iterator_to_array($pages);

		foreach($pagesArray as $key => $page) {
			$pagesSitemap[$key] = array();

			$pagesSitemap[$key]['loc'] = $page['url'];
			$pagesSitemap[$key]['lastmod'] = $page['modified'];
			$pagesSitemap[$key]['changefreq'] = 'daily';
			$pagesSitemap[$key]['priority'] = '1.0';
		}

		return $pagesSitemap;
	}

}
