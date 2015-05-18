<?php
/**
 * Behavior that adds methods to return sitemap information for a Model instance
 *
 * @package Sitemap.Model.Behavior
 */

/**
 * SitemapBehavior
 */
class SitemapBehavior extends ModelBehavior {

	/**
	 * Cache Key
	 *
	 * @var string
	 */
	protected $_CacheKey = 'Sitemap.ModelData.';

	/**
	 * setup
	 *
	 * @param Model $Model The model to add the Behavior to
	 * @param array $settings The settings for the Behavior for the Model instance
	 * @return void
	 */
	public function setup(Model $Model, $settings = array()) {
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
		$this->settings[$Model->alias] = array_merge($this->settings[$Model->alias], $settings);
	}

	/**
	 * basic build URL function for the model behavior, basic URL using action => 'view'
	 *
	 * @param Model $Model The model instance being acted upon
	 * @param string|int $primaryKey The Primary Key for the Model
	 * @return string
	 */
	public function buildUrl(Model $Model, $primaryKey) {
		return Router::url(array('plugin' => null, 'controller' => Inflector::tableize($Model->name), 'action' => 'view', $primaryKey), true);
	}

	/**
	 * generate the sitemap data, attempting to hit the cache for this data
	 *
	 * @param Model $Model The model instance being acted upon
	 * @return array The generated Sitemap data as an array
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
	 * build the sitemap elements
	 *
	 * @param Model $Model The model instance being acted upon
	 * @param array $modelData The current record for the Model
	 * @return array an array of sitemap data
	 */
	protected function _buildSitemapElements(Model $Model, $modelData) {
		$sitemapData = array();

		//Loop through the Model data and create the array of elements for the sitemap
		foreach ($modelData as $key => $data) {
			$sitemapData[$key] = array();

			$sitemapData[$key]['loc'] = call_user_func(array($Model, $this->settings[$Model->alias]['loc']), $data[$Model->alias][$this->settings[$Model->alias]['primaryKey']]);

			if ($this->settings[$Model->alias]['lastmod'] !== false) {
				$sitemapData[$key]['lastmod'] = $data[$Model->alias][$this->settings[$Model->alias]['lastmod']];
			}

			if ($this->settings[$Model->alias]['changefreq'] !== false) {
				$sitemapData[$key]['changefreq'] = $this->settings[$Model->alias]['changefreq'];
			}

			if ($this->settings[$Model->alias]['priority'] !== false) {
				$sitemapData[$key]['priority'] = $this->settings[$Model->alias]['priority'];
			}
		}

		return $sitemapData;
	}

}
