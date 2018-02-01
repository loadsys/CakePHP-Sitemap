<?php
/**
 * Tests for the SitemapBehavior class.
 */
namespace Sitemap\Test\TestCase\Model\Behavior;

use Cake\Core\Configure;
use Cake\Database\Schema\TableSchema;
use Cake\Datasource\ConnectionManager;
use Cake\I18n\Time;
use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\TestSuite\TestCase;
use Sitemap\Model\Behavior\SitemapBehavior;

/**
 * \Siteamp\Test\TestCase\Model\Behavior\TestSitemapBehavior
 *
 * Class to expose the protected properties and methods for SitemapBehavior.
 */
class TestSitemapBehavior extends SitemapBehavior {
	// @codingStandardsIgnoreStart
	public $_config;
	public $_table;
	// @codingStandardsIgnoreEnd
}

/**
 * \Siteamp\Test\TestCase\Model\Behavior\SitemapBehaviorTest
 *
 * Test class for the SitemapBehavior class.
 */
class SitemapBehaviorTest extends TestCase {
	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = [
		'plugin.sitemap.pages',
	];

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->Pages = TableRegistry::get('Pages');
		$sitemapConfig = [];
		$this->Pages->addBehavior('Sitemap.Sitemap', $sitemapConfig);
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->Pages);

		parent::tearDown();
	}

	/**
	 * Test initial setup, essentially verify configuartion is passing in correctly.
	 *
	 * @return void
	 */
	public function testInitialization() {
		$sitemapConfig = [];
		$configOut = [
			'cacheConfigKey' => 'default',
			'lastmod' => 'modified',
			'changefreq' => 'daily',
			'priority' => '0.9',
			'conditions' => [],
			'order' => [],
			'fields' => [],
			'implementedMethods' => [
				'getUrl' => 'returnUrlForEntity',
			],
			'implementedFinders' => [
				'forSitemap' => 'findSitemapRecords',
			],
		];

		$Sitemap = new TestSitemapBehavior($this->Pages, $sitemapConfig);
		$this->assertEquals(
			$configOut,
			$Sitemap->_config,
			'On an empty configuration array, the default configuration should be equal'
		);

		$sitemapConfig = [
			'cacheConfigKey' => 'canary',
			'lastmod' => 'lastmoddate',
			'fields' => ['id', 'modified'],
		];
		$configOut = [
			'cacheConfigKey' => 'canary',
			'lastmod' => 'lastmoddate',
			'changefreq' => 'daily',
			'priority' => '0.9',
			'conditions' => [],
			'order' => [],
			'fields' => ['id', 'modified'],
			'implementedMethods' => [
				'getUrl' => 'returnUrlForEntity',
			],
			'implementedFinders' => [
				'forSitemap' => 'findSitemapRecords',
			],
		];

		$Sitemap = new TestSitemapBehavior($this->Pages, $sitemapConfig);
		$this->assertEquals(
			$configOut,
			$Sitemap->_config,
			'On an valid configuration array, the configuration should be updated to match.'
		);
	}

	/**
	 * Test returnUrlForEntity method
	 *
	 * @return void
	 */
	public function testReturnUrlForEntity() {
		$id = 'canary';
		$entity = new Entity([
			'id' => $id,
		]);
		$this->assertEquals(
			"/pages/view/{$id}",
			$this->Pages->getUrl($entity),
			'The method getUrl should return a valid url string for the passed entity.'
		);
	}

	/**
	 * Test the url for a plugin entity is correct
	 *
	 * @return void
	 */
	public function testReturnUrlForPluginEntity() {
		Router::connect('/posts/view/:id', ['controller' => 'Posts', 'action' => 'view'], ['id' => '[\d]+', 'pass' => ['id']]);

		$exampleTableName = 'Example/Plugin.Posts';
		Configure::write('Sitemap.tables', [$exampleTableName]);

		$tableInstance = new Table([
			'registryAlias' => 'Example/Plugin.Posts',
			'alias' => 'Posts',
			'table' => 'posts',
			'schema' => new TableSchema('posts', [
				'id' => ['type' => 'integer'],
				'title' => ['type' => 'string'],
			]),
		]);
		$tableInstance->setPrimaryKey('id');
		$tableInstance->addBehavior('Sitemap.Sitemap');

		$post = new Entity([
			'id' => 1,
			'title' => 'First post',
		], [
			'source' => $tableInstance,
		]);

		$expected = '/posts/view/1';

		$behavior = $tableInstance->behaviors()->get('Sitemap');

		$this->assertEquals($expected, $behavior->returnUrlForEntity($post));
	}

	/**
	 * Test ::findSitemapRecords when the Fields config is set.
	 *
	 * @return void
	 */
	public function testFindSitemapRecordsFields() {
		$configs = [
			'conditions' => [
				'field1' => 'value1',
			],
			'cacheConfigKey' => 'cache-key-asdf',
			'order' => [
				'field2' => 'value2',
			],
			'fields' => [
				'field3' => 'value3',
			],
		];
		$options = [
			'foo' => 'baz',
		];

		$TableMock = $this
			->getMockBuilder('\Cake\ORM\Table')
			->disableOriginalConstructor()
			->getMock();
		$SitemapBehavior = $this
			->getMockBuilder('\Sitemap\Model\Behavior\SitemapBehavior')
			->setMethods(['mapResults'])
			->setConstructorArgs([$TableMock, $configs])
			->getMock();

		$QueryMock = $this->getMockBuilder('\Cake\ORM\Query')
			->setMethods([
				'where',
				'cache',
				'order',
				'formatResults',
				'select',
				'repository',
				'alias',
			])
			->disableOriginalConstructor()
			->getMock();

		$QueryMock->expects($this->once())
			->method('where')
			->with($configs['conditions'])
			->will($this->returnSelf());
		$QueryMock->expects($this->once())
			->method('repository')
			->with()
			->will($this->returnSelf());
		$QueryMock->expects($this->once())
			->method('alias')
			->with()
			->will($this->returnValue('alias-canary'));
		$QueryMock->expects($this->once())
			->method('cache')
			->with('sitemap_alias-canary', $configs['cacheConfigKey'])
			->will($this->returnSelf());
		$QueryMock->expects($this->once())
			->method('order')
			->with($configs['order'])
			->will($this->returnSelf());
		$QueryMock->expects($this->once())
			->method('formatResults')
			->with($this->isInstanceOf('closure'))
			->will($this->returnSelf());
		$QueryMock->expects($this->once())
			->method('select')
			->with($configs['fields'])
			->will($this->returnValue('canary'));

		$output = $SitemapBehavior->findSitemapRecords($QueryMock, $options);
		$this->assertEquals(
			'canary',
			$output,
			'The output from ::findSitemapRecords should be our mocked response from the Query Object.'
		);
	}

	/**
	 * Test ::findSitemapRecords when the Fields config is not set.
	 *
	 * @return void
	 */
	public function testFindSitemapRecordsNoFields() {
		$configs = [
			'conditions' => [
				'field1' => 'value1',
			],
			'cacheConfigKey' => 'cache-key-asdf',
			'order' => [
				'field2' => 'value2',
			],
		];
		$options = [
			'foo' => 'baz',
		];

		$TableMock = $this
			->getMockBuilder('\Cake\ORM\Table')
			->disableOriginalConstructor()
			->getMock();
		$SitemapBehavior = $this
			->getMockBuilder('\Sitemap\Model\Behavior\SitemapBehavior')
			->setMethods(['mapResults'])
			->setConstructorArgs([$TableMock, $configs])
			->getMock();

		$QueryMock = $this->getMockBuilder('\Cake\ORM\Query')
			->setMethods([
				'where',
				'cache',
				'order',
				'formatResults',
				'select',
				'repository',
				'alias',
			])
			->disableOriginalConstructor()
			->getMock();

		$QueryMock->expects($this->once())
			->method('where')
			->with($configs['conditions'])
			->will($this->returnSelf());
		$QueryMock->expects($this->once())
			->method('repository')
			->with()
			->will($this->returnSelf());
		$QueryMock->expects($this->once())
			->method('alias')
			->with()
			->will($this->returnValue('alias-canary'));
		$QueryMock->expects($this->once())
			->method('cache')
			->with('sitemap_alias-canary', $configs['cacheConfigKey'])
			->will($this->returnSelf());
		$QueryMock->expects($this->once())
			->method('order')
			->with($configs['order'])
			->will($this->returnSelf());
		$QueryMock->expects($this->once())
			->method('formatResults')
			->with($this->isInstanceOf('closure'))
			->will($this->returnValue('canary'));
		$QueryMock->expects($this->never())
			->method('select');

		$output = $SitemapBehavior->findSitemapRecords($QueryMock, $options);
		$this->assertEquals(
			'canary',
			$output,
			'The output from ::findSitemapRecords should be our mocked response from the Query Object.'
		);
	}

	/**
	 * Test the mapEntity method.
	 *
	 * @return void
	 */
	public function testMapEntity() {
		$pageId = '3b65a356-6df8-11e5-b2cc-000c29a33c4c';
		$sitemapConfig = [];
		$Sitemap = new TestSitemapBehavior($this->Pages, $sitemapConfig);

		$entity = $this->Pages->get($pageId);
		$entity = $Sitemap->mapEntity($entity);
		$this->assertEquals(
			"/pages/view/{$pageId}",
			$entity->_loc,
			'The _loc field should be set to our standard url'
		);

		$this->assertEquals(
			new Time('2015-10-08 21:27:04'),
			$entity->_lastmod,
			'The _loc field should be set to our standard url'
		);

		$this->assertEquals(
			"daily",
			$entity->_changefreq,
			'The _changefreq field should be set to our standard daily'
		);

		$this->assertEquals(
			"0.9",
			$entity->_priority,
			'The _priority field should be set to our standard 0.9'
		);
		unset($Sitemap);

		// test with a modified Sitemap Configuration
		$sitemapConfig = [
			'priority' => '0.1',
			'changefreq' => 'weekly',
		];
		$Sitemap = new TestSitemapBehavior($this->Pages, $sitemapConfig);

		$entity = $this->Pages->get($pageId);
		$entity = $Sitemap->mapEntity($entity);
		$this->assertEquals(
			"/pages/view/{$pageId}",
			$entity->_loc,
			'The _loc field should be set to our standard url'
		);

		$this->assertEquals(
			new Time('2015-10-08 21:27:04'),
			$entity->_lastmod,
			'The _loc field should be set to our standard url'
		);

		$this->assertEquals(
			"weekly",
			$entity->_changefreq,
			'The _changefreq field should be set to our modified weekly'
		);

		$this->assertEquals(
			"0.1",
			$entity->_priority,
			'The _priority field should be set to our modified 0.1'
		);
	}
}
