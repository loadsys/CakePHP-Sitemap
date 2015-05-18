<?php
/**
 * Custom test suite to execute all Sitemap Plugin tests.
 *
 * @package Sitemap.Test.Case
 */

/**
 * AllSitemapTest
 */
class AllSitemapTest extends PHPUnit_Framework_TestSuite {

	/**
	 * the suites to load
	 * @var array
	 */
	public static $suites = array(
		'AllSitemapLibsTest.php',
		'AllSitemapModelsTest.php',
		'AllSitemapControllersTest.php',
	);

	/**
	 * load the suites
	 *
	 * @return CakeTestSuite
	 */
	public static function suite() {
		$path = dirname(__FILE__) . '/';
		$suite = new CakeTestSuite('All Sitemap Tests');

		foreach (self::$suites as $file) {
			if (is_readable($path . $file)) {
				$suite->addTestFile($path . $file);
			}
		}
		return $suite;
	}

}
