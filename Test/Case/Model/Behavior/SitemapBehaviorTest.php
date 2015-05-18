<?php
/**
 * Tests the SocialLinks Behavior Class
 */
App::uses('SocialLinksBehavior', 'SocialLinks.Model/Behavior');

/**
 * SocialLinksBehaviorTest
 *
 * @package SocialLinks.Test.Case.Model.Behavior
 */
class SocialLinksBehaviorTest extends CakeTestCase {

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

	public function testSetup() {
		$this->markTestIncomplete("testSetup Incomplete");
	}

	public function testBuildUrl() {
		$this->markTestIncomplete("testBuildUrl Incomplete");
	}

	public function testGenerateSitemapData() {
		$this->markTestIncomplete("testGenerateSitemapData Incomplete");
	}

	public function testBuildSitemapElements() {
		$this->markTestIncomplete("testBuildSitemapElements Incomplete");
	}

}
