<?php
App::uses('AppController', 'Controller');

class SitemapsController extends SitemapAppController {

	public $helpers = array(
		'Time',
		'Html',
		'Cache',
	);

	public $components = array(
		'RequestHandler',
		'Auth',
	);

	public $cacheAction = array(
    'display' => 36000,
	);

	/**
	 * beforeFilter method
	 *
	 * @return void
	 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('display'));
	}

	/**
	 * [beforeRender description]
	 * @return [type] [description]
	 */
	public function beforeRender() {
		parent::beforeRender();
	}

	/**
	 * [display description]
	 * @return [type] [description]
	 */
	public function display() {

		$sitemapData = array();

		//Generate a list of Controllers in the App
		$controllers = $this->_generateListOfControllers();

		//foreach controller
		foreach($controllers as $controller) {
			App::uses($controller['Instance'], 'Controller');

			// We need to load the class
			$newController = new $controller['Instance'];
			$newController->constructClasses();

			if(array_key_exists('Sitemap.Sitemap', $newController->components)) {
				$response = $newController->Sitemap->returnSitemapData($newController);
				$sitemapData[$newController->name] = $response;
			} else {
			}
			unset($newController);
		}

		$this->set('sitemapData', $sitemapData);
	}

	/**
	 * [_generateListOfControllers description]
	 * @return [type] [description]
	 */
	protected function _generateListOfControllers() {
		$aCtrlClasses = App::objects('Controller');

		//foreach Controller
		foreach ($aCtrlClasses as $controller) {
			if ($controller != 'AppController') {
				// Load the controller
				App::import('Controller', str_replace('Controller', '', $controller));

				// Load its methods / actions
				$aMethods = get_class_methods($controller);

				foreach ($aMethods as $idx => $method) {

					if ($method{0} == '_') {
						unset($aMethods[$idx]);
					}
				}

				// Load the ApplicationController (if there is one)
				App::import('Controller', 'AppController');
				$parentActions = get_class_methods('AppController');

				$controllers[$controller] = array_diff($aMethods, $parentActions);
				$controllers[$controller]['Instance'] = $controller;
			}
		}

		return $controllers;
		}
	}

?>