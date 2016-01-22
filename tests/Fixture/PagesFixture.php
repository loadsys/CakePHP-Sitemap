<?php
/**
 * Sample Pages Fixtures to provide Integration Style Tests.
 */
namespace Sitemap\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * \Sitemap\Test\Fixture\PagesFixture
 */
class PagesFixture extends TestFixture {
	/**
	 * Fields
	 *
	 * @var array
	 */
	// @codingStandardsIgnoreStart
	public $fields = [
		'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => 'UUID primary key.', 'precision' => null],
		'title' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => 'Title of the record.', 'precision' => null, 'fixed' => null],
		'keywords' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => 'Meta keywords of the record.', 'precision' => null, 'fixed' => null],
		'description' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => 'Meta description of the record.', 'precision' => null, 'fixed' => null],
		'body' => ['type' => 'text', 'length' => null, 'null' => false, 'default' => null, 'comment' => 'Main (HTML) body content for this page.', 'precision' => null],
		'is_indexed' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '1', 'comment' => 'Boolean field that determines if a Page is indexable by search engines.', 'precision' => null],
		'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'Date and time of record creation.', 'precision' => null],
		'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'Date and time of last modification.', 'precision' => null],
		'_constraints' => [
			'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
		],
		'_options' => [
			'engine' => 'InnoDB',
			'collation' => 'utf8_general_ci'
		],
	];
  // @codingStandardsIgnoreEnd

	/**
	 * Records
	 *
	 * @var array
	 */
	public $records = [
		[
			'id' => '3b65a356-6df8-11e5-b2cc-000c29a33c4c',
			'title' => 'Test Page 1',
			'keywords' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet',
			'body' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'is_indexed' => 1,
			'created' => '2015-10-08 21:27:04',
			'modified' => '2015-10-08 21:27:04',
		],
		[
			'id' => '55057c21-eab2-40f1-bea9-b24f7bc4f74e',
			'title' => 'Test Page 2',
			'keywords' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet',
			'body' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'is_indexed' => 1,
			'created' => '2015-10-08 21:27:04',
			'modified' => '2015-10-08 21:27:04',
		],
		[
			'id' => '05f79d0f-efd1-49b4-b627-c8721bdcc635',
			'title' => 'Test Page 3',
			'keywords' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet',
			'body' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'is_indexed' => 1,
			'created' => '2015-10-08 21:27:04',
			'modified' => '2015-10-08 21:27:04',
		],
		[
			'id' => '05f79d0f-efd2-49b4-b627-c8721bdcc635',
			'title' => 'Test Page 4',
			'keywords' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet',
			'body' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'is_indexed' => 1,
			'created' => '2015-10-08 21:27:04',
			'modified' => '2015-10-08 21:27:04',
		],
		[
			'id' => '25f79d0f-efd2-49b4-b627-c8721bdcc635',
			'title' => 'Test Page 5',
			'keywords' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet',
			'body' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'is_indexed' => 0,
			'created' => '2015-10-08 21:27:04',
			'modified' => '2015-10-08 21:27:04',
		],
	];
}
