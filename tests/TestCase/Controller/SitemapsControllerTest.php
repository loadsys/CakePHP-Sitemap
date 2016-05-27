<?php
/**
 * Test class for Sitemap\SitemapsController Class
 */
namespace Sitemap\Test\TestCase\Controller;

use Cake\Core\Configure;
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
		$Controller->expects($this->once())
			->method('set')
			->with('data', [])
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
		$Controller->expects($this->once())
			->method('set')
			->with('data', ['Pages' => $pagesFindQuery])
			->will($this->returnValue(true));

		$Controller->expects($this->once())
			->method('loadModel')
			->with('Pages')
			->will($this->returnValue(true));

		$Controller->Pages = $this->Pages;

		$Controller->index();
	}
}
