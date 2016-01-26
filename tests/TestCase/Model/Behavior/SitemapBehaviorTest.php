<?php
/**
 * Tests for the Sitemap Behavior class.
 */
namespace Sitemap\Test\TestCase\Model\Behavior;

use Cake\Datasource\ConnectionManager;
use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Sitemap\Model\Behavior\SitemapBehavior;

/**
 * \Siteamp\Test\TestCase\Model\Behavior\TestSitemapBehavior
 */
class TestSitemapBehavior extends SitemapBehavior {
	public $_config;
	public $_table;
}

/**
 * \Siteamp\Test\TestCase\Model\Behavior\SitemapBehaviorTest
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
			'fields' => '*',
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
	 * Test findSitemapRecords method
	 *
	 * @param array $sitemapConfig The Configs for the Sitemap Behavior.
	 * @param int $expectedCount The expected number of returning results from the find.
	 * @return void
	 * @dataProvider providerFindSitemapRecords
	 */
	public function testFindSitemapRecords($sitemapConfig, $expectedCount) {
		$this->Pages->removeBehavior('Sitemap');
		$this->Pages->addBehavior('Sitemap.Sitemap', $sitemapConfig);

		$query = $this->Pages->find('forSitemap');
		$count = $query->count();
		$this->assertEquals(
			$expectedCount,
			$count,
			"The count of the pages should be equal to {$expectedCount}"
		);
	}

	/**
	 * DataProvider for testFindSitemapRecords.
	 *
	 * @return array Data inputs for testFindSitemapRecords.
	 */
	public function providerFindSitemapRecords() {
		return [
			'Empty Config Options' => [
				[],
				5,
			],
			'Non Conditional Config Options' => [
				[
					'lastmod' => 'modified_date'
				],
				5,
			],

			'Is Indexed TRUE Config Options' => [
				[
					'conditions' => [
						'is_indexed' => true,
					]
				],
				4,
			],

			'Is Indexed FALSE Config Options' => [
				[
					'conditions' => [
						'is_indexed' => false,
					]
				],
				1,
			],
		];
	}
}
