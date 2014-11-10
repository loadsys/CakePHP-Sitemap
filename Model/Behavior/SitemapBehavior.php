<?php
/**
 * Sitemap Behavior enables sites to display and list a sitemap that is tied
 * to a specified model
 */

App::uses('ModelBehavior', 'Model');

/**
 * SitemapBhavior
 */
class SitemapBehavior extends ModelBehavior {

	/**
	 * the key to cache data under
	 *
	 * @var string
	 */
	protected $_CacheKey = 'Sitemap.ModelData.';

	/**
	 * Sets up the configuration for this model to use the behavior
	 *
	 * @param  Model $model Model using this behavior.
	 * @param  array $config Configuration options.
	 * @return void
	 */
	public function setup(Model $Model, $config = array()) {
		if (!isset($this->settings[$Model->alias])) {
			$this->settings[$Model->alias] = array(
				'primaryKey' => 'id',
				'loc' => 'buildUrl',
				'lastmod' => 'modified',
				'changefreq' => 'daily',
				'priority' => '0.9',
				'conditions' => array(),
			);
		}
		$this->settings[$Model->alias] = array_merge($this->settings[$Model->alias], $config);
	}

	/**
	 * basic build URL function for the model behavior, basic URL using action => 'view'
	 *
	 * @return string the url for the
	 */
	/**
	 * basic build URL function for the model behavior, basic URL using
	 * action => 'view'
	 *
	 * @param  Model  		$Model      the Model for this object
	 * @param  string|id 	$primaryKey the primary key for this object
	 * @return string             		the complete url to access the item
	 */
	public function buildUrl(Model $Model, $primaryKey) {
		return Router::url(array('plugin' => null, 'controller' => Inflector::tableize($Model->name), 'action' => 'view', $primaryKey), true);
	}

	/**
	 * generate the sitemap data, attempting to hit the cache for this data
	 *
	 * @param  Model  $Model 	the Model for this object
	 * @return array 					an array of data for the sitemap
	 */
	public function generateSitemapData(Model $Model) {

		//Attempt to hit the Model Cache for data
		$sitemapData = Cache::read($this->_CacheKey . $Model->name);

		if ($sitemapData !== false) {
			return $sitemapData;
		}

		//Load the Model Data
		$modelData = $Model->find('all', array(
			'conditions' => $this->settings[$Model->alias]['conditions'],
			'recursive' => -1,
		));

		//Build the sitemap elements
		$sitemapData = $this->_buildSitemapElements($Model, $modelData);

		//Write to the Cache
		Cache::write($this->_CacheKey . $Model->name, $sitemapData);

		return $sitemapData;
	}

	/**
	 * build a single sitemap element
	 *
	 * @param  Model  $Model     the Model for this object
	 * @param  array 	$modelData the single data record for the object
	 * @return array 							the data to build a sitemap record for this object
	 */
	protected function _buildSitemapElements(Model $Model, $modelData) {
		$sitemapData = array();

		//Loop through the Model data and create the array of elements for the sitemap
		foreach($modelData as $key => $data) {
			$sitemapData[$key] = array();

			$sitemapData[$key]['loc'] = call_user_func(array($Model, $this->settings[$Model->alias]['loc']), $data[$Model->alias][$this->settings[$Model->alias]['primaryKey']]);

			if($this->settings[$Model->alias]['lastmod'] !== FALSE) {
				$sitemapData[$key]['lastmod'] = $data[$Model->alias][$this->settings[$Model->alias]['lastmod']];
			}

			if($this->settings[$Model->alias]['changefreq'] !== FALSE) {
				$sitemapData[$key]['changefreq'] = $this->settings[$Model->alias]['changefreq'];
			}

			if($this->settings[$Model->alias]['priority'] !== FALSE) {
				$sitemapData[$key]['priority'] = $this->settings[$Model->alias]['priority'];
			}
		}

		return $sitemapData;
	}
}
