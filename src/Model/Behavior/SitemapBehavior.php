<?php
/**
 * Behavior for loading Sitemap records
 */
namespace Sitemap\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Routing\Router;

/**
 * \Sitemap\Model\Behavior\SitemapBehavior
 */
class SitemapBehavior extends Behavior {
	/**
	 * Default configuration.
	 *
	 * @var array
	 */
	protected $_defaultConfig = [
		'cacheConfigKey' => 'default',
		'lastmod' => 'modified',
		'changefreq' => 'daily',
		'priority' => '0.9',
		'conditions' => [],
		'order' => [],
		'implementedMethods' => [
			'getUrl' => 'returnUrlForEntity',
		],
		'implementedFinders' => [
			'forSitemap' => 'findSitemapRecords',
		],
	];

	/**
	 * Constructor hook method.
	 *
	 * Implement this method to avoid having to overwrite
	 * the constructor and call parent.
	 *
	 * @param array $config The configuration settings provided to this behavior.
	 * @return void
	 */
	public function initialize(array $config) {
		parent::initialize($config);
	}

	public function returnUrlForEntity() {
		return Router::url(
			[
				'controller' => 'Post', 'action' => 'view', 'something'
			],
			true
		);
	}

	/**
	 * Find the Sitemap Records for a Table.
	 *
	 * @param Query $query The Query being modified.
	 * @param array $options The array of options for the find.
	 * @return Query Returns the modified Query object.
	 */
	public function findSitemapRecords(Query $query, array $options) {
		$query
			->conditions($this->_config['conditions'])
			->cache("sitemap_{$query->repository()->alias()}", $this->_config['cacheConfigKey'])
			->order($this->_config['order']);
	}
}
