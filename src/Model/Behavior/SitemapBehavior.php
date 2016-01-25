<?php
/**
 * Behavior for loading Sitemap records
 */
namespace Sitemap\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\Orm\Entity;
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

	/**
	 * Return the URL for the primary view action for an Entity.
	 *
	 * @return string Returns the URL string.
	 */
	public function returnUrlForEntity(Entity $entity) {
		return Router::url(
			[
				'controller' => $this->_table->registryAlias(),
				'action' => 'view',
				$entity->{$this->_table->primaryKey()},
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
			->where($this->_config['conditions'])
			->cache("sitemap_{$query->repository()->alias()}", $this->_config['cacheConfigKey'])
			->order($this->_config['order']);

		return $query;
	}
}
