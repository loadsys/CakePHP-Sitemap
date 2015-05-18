<?php
/**
 * Fixtures for the Sitemap Behavior to test with
 */

/**
 * PostFixture
 *
 * @package Sitemap.Test.Fixture
 */
class PostFixture extends CakeTestFixture {

	/**
	 * fields for the User Fixture
	 *
	 * @var array
	 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'title' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'text' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'updated' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	/**
	 * Records to load into the database
	 *
	 * @var array
	 */
	public $records = array(
		array(
			'id' => '7d5b22bd-fc92-11e3-b153-080027dec79b',
			'title' => 'Test Titlte',
			'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sed lorem magna. Quisque egestas sollicitudin lectus, a lacinia orci accumsan in. Quisque faucibus odio ac leo imperdiet, non consectetur sem interdum. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nullam eu sem sit amet magna pellentesque scelerisque a vel lacus. Ut eget bibendum nibh. Curabitur scelerisque vel turpis eget varius. Duis cursus ultricies eros ac suscipit. Nullam luctus ultrices ipsum, id tristique tellus ultricies lacinia. Donec a aliquet nisi, et dapibus arcu. Vestibulum ut commodo tellus. Donec id nisl in nisl mollis molestie nec in quam. Duis in purus enim. Nulla quam nisl, vestibulum et velit ac, luctus viverra leo.',
			'status' => 1,
			'updated' => '2014-05-07 17:03:05',
			'created' => '2014-05-07 17:03:05'
		),
		array(
			'id' => 'c64ddc9c-7193-11e4-b74c-000c290352bb',
			'title' => 'Test Second Titlte',
			'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sed lorem magna. Quisque egestas sollicitudin lectus, a lacinia orci accumsan in. Quisque faucibus odio ac leo imperdiet, non consectetur sem interdum. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nullam eu sem sit amet magna pellentesque scelerisque a vel lacus. Ut eget bibendum nibh. Curabitur scelerisque vel turpis eget varius. Duis cursus ultricies eros ac suscipit. Nullam luctus ultrices ipsum, id tristique tellus ultricies lacinia. Donec a aliquet nisi, et dapibus arcu. Vestibulum ut commodo tellus. Donec id nisl in nisl mollis molestie nec in quam. Duis in purus enim. Nulla quam nisl, vestibulum et velit ac, luctus viverra leo.',
			'status' => 0,
			'updated' => '2015-05-07 17:03:05',
			'created' => '2015-05-07 17:03:05'
		),
	);
}
