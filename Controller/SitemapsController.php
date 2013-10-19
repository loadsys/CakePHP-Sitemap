<?php
App::uses('AppController', 'Controller');

class SitemapsController extends SitemapAppController {

	/**
	 * helpers - array of helpers
	 *
	 * @var array
	 */
	public $helpers = array(
		'Time',
		'Html',
		'Cache',
	);

	/**
	 * components - array of components
	 *
	 * @var array
	 */
	public $components = array(
		'RequestHandler',
		'Auth',
	);

	/**
	 * cacheAction - view cache timing
	 *
	 * @var array
	 */
	public $cacheAction = array(
    'display' => 43200,
	);

	/**
	 * beforeFilter - beforeFilter callback
	 *
	 * @return void
	 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('display'));
	}

	/**
	 * beforeRender - beforeRender callback
	 *
	 * @return [type] [description]
	 */
	public function beforeRender() {
		parent::beforeRender();
	}

	/**
	 * display - display the sitemap
	 *
	 * @return [type] [description]
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

			if(array_key_exists('Sitemap.Sitemap', $newModel->actsAs)) {
				$response = $newModel->generateSitemapData();
				$sitemapData[$newModel->name] = $response;
			} else {
			}
			unset($newModel);
		}

		$this->set('sitemapData', $sitemapData);
	}

	/**
	 * _generateListOfModels - generate the list of models
	 *
	 * @return [type] [description]
	 */
	protected function _generateListOfModels() {
		//Generate list of Models
		$appModelClasses = App::objects('Model');

		$listOfModels = array();

		//Foreach Model
		foreach ($appModelClasses as $modelClass) {
			if ($modelClass != 'AppModel') {
				// Load the Model
				App::import('Model', str_replace('Model', '', $modelClass));
				$listOfModels[] = $modelClass;
			}
		}

		return $listOfModels;
	}

}
?>