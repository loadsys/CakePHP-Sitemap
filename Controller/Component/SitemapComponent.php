<?php
class SitemapComponent extends Component {

	/**
	 * Constructor
	 *
	 * @param ComponentCollection $collection A ComponentCollection this component can use to lazy load its components
	 * @param array $settings Array of configuration settings.
	 */
	public function __construct(ComponentCollection $collection, $settings = array()) {
		$settings = array_merge($this->settings, (array)$settings);
		$this->Controller = $collection->getController();
		parent::__construct($collection, $settings);
	}

	/**
	 * [_getSitemap description]
	 * @return [type] [description]
	 */
	public function returnSitemapData(Controller $controller) {
		App::uses($controller->modelClass, 'Model');
		$controllerModel = new $controller->modelClass;

		$sitemapData = $controllerModel->generateSitemapData();

		unset($controller);
		unset($controllerModel);

		return $sitemapData;
	}
}
?>