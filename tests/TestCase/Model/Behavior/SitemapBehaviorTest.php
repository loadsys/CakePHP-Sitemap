<?php
namespace App\Test\TestCase\Model\Behavior;

use App\Model\Behavior\SitemapBehavior;
use Cake\TestSuite\TestCase;

/**
 * \App\Test\TestCase\Model\Behavior\SitemapBehaviorTest
 */
class SitemapBehaviorTest extends TestCase {
	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = [
		'sitemap.pages',
	];
	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		$this->Sitemap = new SitemapBehavior();
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->Sitemap);

		parent::tearDown();
	}

	/**
	 * Test initial setup
	 *
	 * @return void
	 */
	public function testInitialization() {
		$this->markTestIncomplete('Not implemented yet.');
	}

	/**
	 * Test returnUrlForEntity method
	 *
	 * @return void
	 */
	public function testReturnUrlForEntity() {
		$this->markTestIncomplete('Not implemented yet.');
	}

	/**
	 * Test findSitemapRecords method
	 *
	 * @return void
	 */
	public function testFindSitemapRecords() {
		$this->markTestIncomplete('Not implemented yet.');
	}
}
