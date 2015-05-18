<?php
/**
 * Test the SitemapsController
 */
App::uses('SitemapsController', 'Sitemap.Controller');

class SitemapsControllerTest extends ControllerTestCase {

	/**
	 * Fixtures
	 *
	 * @var	array
	 */
	public $fixtures = array(
		'plugin.sitemap.post'
	);

	/**
	 * setUp method
	 *
	 * @return	void
	 */
	public function setUp() {
		$this->Post = ClassRegistry::init('Sitemap.Post');
		$this->Post->Behaviors->load('Sitemap.Sitemap');

		parent::setUp();
	}

	/**
	 * tearDown method
	 *
	 * @return	void
	 */
	public function tearDown() {
		unset($this->Post);
		parent::tearDown();
	}

	public function testBeforeFilter() {
		$this->markTestIncomplete("testBeforeFilter Incomplete");
	}

	public function testDisplay() {
		$this->markTestIncomplete("testDisplay Incomplete");
	}

	public function testGenerateListOfModels() {
		$this->markTestIncomplete("testGenerateListOfModels Incomplete");
	}

	public function testGenerateListOfStaticPages() {
		$this->markTestIncomplete("testGenerateListOfStaticPages Incomplete");
	}

}
