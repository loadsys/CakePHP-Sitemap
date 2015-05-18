<?php
/**
 * Custom test suite to execute all Sitemap Plugin Model tests.
 *
 * @package Sitemap.Test.Case
 */

/**
 * AllSitemapModelsTest
 */
class AllSitemapModelsTest extends PHPUnit_Framework_TestSuite {

	/**
	 * load the suites
	 *
	 * @return CakeTestSuite
	 */
	public static function suite() {
		$suite = new CakeTestSuite('All Sitemap Model Lib Tests');
		$suite->addTestDirectoryRecursive(dirname(__FILE__) . '/Model/');
		return $suite;
	}

}
