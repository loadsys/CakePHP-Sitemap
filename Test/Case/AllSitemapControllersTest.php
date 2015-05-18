<?php
/**
 * Custom test suite to execute all Sitemap Plugin Controller tests.
 *
 * @package Sitemap.Test.Case
 */

/**
 * AllSitemapControllersTest
 */
class AllSitemapControllersTest extends PHPUnit_Framework_TestSuite {

	/**
	 * load the suites
	 *
	 * @return CakeTestSuite
	 */
	public static function suite() {
		$suite = new CakeTestSuite('All Sitemap Controller Lib Tests');
		$suite->addTestDirectoryRecursive(dirname(__FILE__) . '/Controller/');
		return $suite;
	}

}
