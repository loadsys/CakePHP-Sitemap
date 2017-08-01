<?php
/**
 * Test class for Sitemap\SitemapsController Class
 */
namespace Sitemap\Test\TestCase\Controller;

use Cake\Core\Configure;
use Cake\Database\Schema\TableSchema;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;
use Sitemap\Controller\SitemapsController;

/**
 * \Sitemap\Test\TestCase\Controller\SitemapsControllerTestCase
 */
class SitemapsControllerTestCase extends IntegrationTestCase {
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
		$this->setupSession();
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->Pages);

		Configure::clear();

		parent::tearDown();
	}

	/**
	 * setup Session properties needed for the controller level tests
	 *
	 * @return void
	 */
	public function setupSession() {
		$this->session([]);
	}

	/**
	 * Test index method with no models defined
	 *
	 * @return void
	 * @covers \Sitemap\Controller\SitemapsController::index
	 */
	public function testIndexNoModels() {
		$Controller = $this->getMock(
			'\Sitemap\Controller\SitemapsController',
			['set']
		);

		$Controller->expects($this->at(0))
			->method('set')
			->with('data', [])
			->will($this->returnValue(true));

		$Controller->expects($this->at(1))
			->method('set')
			->with('_serialize', false)
			->will($this->returnValue(true));

		$Controller->index();
	}

	/**
	 * Test index method with no models defined
	 *
	 * @return void
	 * @covers \Sitemap\Controller\SitemapsController::index
	 */
	public function testIndexWithModels() {
		Configure::write('Sitemap.tables', ['Pages']);
		$pagesFindQuery = $this->Pages->find('forSitemap');

		$Controller = $this->getMock(
			'\Sitemap\Controller\SitemapsController',
			['set', 'loadModel']
		);

		$Controller->expects($this->at(1))
			->method('set')
			->with('data', ['Pages' => $pagesFindQuery])
			->will($this->returnValue(true));

		$Controller->expects($this->at(2))
			->method('set')
			->with('_serialize', false)
			->will($this->returnValue(true));

		$Controller->expects($this->once())
			->method('loadModel')
			->with('Pages')
			->will($this->returnValue(true));

		$Controller->Pages = $this->Pages;

		$Controller->index();
	}

	/**
	 * Test the index method that the correct route is loaded and works.
	 *
	 * @return void
	 * @covers \Sitemap\Controller\SitemapsController::index
	 */
	public function testIndexAccess() {
		$this->get('/sitemap.xml');

		$this->assertResponseOk();
	}

	/**
	 * Test that the index method can execute finds on namespaced plugin tables
	 *
	 * @return void
	 */
	public function testLoadingPluginTables() {
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
		$tableInstance->addBehavior('Sitemap.Sitemap');

		$Controller = $this->getMockBuilder(SitemapsController::class)
			->setMethods(['loadModel'])
			->getMock();

		$Controller->expects($this->once())
			->method('loadModel')
			->with($exampleTableName)
			->willReturn($tableInstance);

		$Controller->index();
	}
}
