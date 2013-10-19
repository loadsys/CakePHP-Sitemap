<?php
class SitemapBehavior extends ModelBehavior {

	/**
	 * setup
	 *
	 * @param  Model  $Model    [description]
	 * @param  array  $settings [description]
	 * @return [type]           [description]
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
	 * buildUrl
	 *
	 * @return [type] [description]
	 */
	public function buildUrl(Model $Model, $primaryKey) {
		return Router::url(array('plugin' => NULL, 'controller' => Inflector::tableize($Model->name), 'action' => 'view', $primaryKey), TRUE);
	}

	/**
	 * generateSitemapData
	 *
	 * @param  Model  $Model [description]
	 * @return [type]        [description]
	 */
	public function generateSitemapData(Model $Model) {

		$sitemapData = Cache::read('Sitemap.ModelData.' . $Model->name);

		if ($sitemapData !== false) {
			return $sitemapData;
		}

		//Load the Model Data
		$modelData = $Model->find('all', array(
			'conditions' => $this->settings[$Model->alias]['conditions'],
			'contain' => array(
			),
		));

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

		Cache::write('Sitemap.ModelData.' . $Model->name, $sitemapData);

		return $sitemapData;
	}
}
?>