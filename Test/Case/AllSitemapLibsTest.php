<?php
/**
 * Custom test suite to execute all Sitemap Plugin Lib tests.
 *
 * @package Sitemap.Test.Case
 */

/**
 * AllSitemapLibsTest
 */
class AllSitemapLibsTest extends PHPUnit_Framework_TestSuite {

	/**
	 * load the suites
	 *
	 * @return CakeTestSuite
	 */
	public static function suite() {
		$suite = new CakeTestSuite('All Sitemap Plugin Lib Tests');
		$suite->addTestDirectoryRecursive(dirname(__FILE__) . '/Lib/');
		return $suite;
	}

}
