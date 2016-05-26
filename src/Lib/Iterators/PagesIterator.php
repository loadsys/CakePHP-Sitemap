<?php
/**
 * Uses an ExtFilteredDirIterator to create an array of filtered records from
 * a directory's contents, and formats the results as a Cake-Model-like array
 * record.
 */
namespace Sitemap\Lib\Iterators;

/**
 * \Sitemap\Lib\Iterators\PagesIterator
 */
class PagesIterator extends ExtFilteredDirIterator {
	/**
	 * A list of file extensions that will be passed through the Iterator.
	 * Files not ending in one of these extensions will be excluded from the
	 * list.
	 *
	 * @var array
	 */
	private $allowed = [
		'ctp',
	];

	/**
	 * Stores the relative depth of folders between the "root" and the
	 * "current" directory. Used when generating individual record arrays.
	 *
	 * @var array
	 */
	private $depth = null;

	/**
	 * Stores $this->request->webroot from the calling Controller. Used
	 * when generating individual record arrays.
	 *
	 * @var string
	 */
	private $webroot = null;

	/**
	 * __construct
	 *
	 * Creates a new ExtFilteredDirIterator (which is based on a
	 * DirectoryIterator) that spits out image record arrays instead
	 * of SplFileInfo objects. Suitable for passing directly to a
	 * view and used in a foreach() loop directly.
	 *
	 * @param string	$path				Filesystem path for the folder to read.
	 * @param array	$depth				An ordered array of intermediate folders
	 *										between the image root folder and the
	 *										current directory represented by
	 *										basename($path).
	 * @param string	$webroot			The relative Cake webroot as returned
	 *										in a Controller by $this->request->webroot.
	 *										(There is no static access to this property,
	 *										hence having to pass it in.)
	 * @param array	$allowedExtensions	An optional array of file extensions
	 *										to filter the resulting directory
	 *										list against.
	 */
	public function __construct($path, $depth, $webroot, $allowedExtensions = null) {
		$this->depth = $depth;
		$this->webroot = $webroot;
		if (is_array($allowedExtensions)) {
			$this->allowed = $allowedExtensions; // Save this to pass into subfolder count calculations.
		}

		parent::__construct($path, $this->allowed);
	}

	/**
	 * accept
	 *
	 * In addition to filtering by filename extension in our parent
	 * ExtFilteredDirIterator, also filter out any .ctp files that begin with
	 * 'admin_' to prevent modifying a management view.
	 *
	 * @return bool True if the basename of the current file does not begin with "admin_".
	 */
	public function accept() {
		$current = parent::current();
		return parent::accept() && (strpos($current->getBasename('.ctp'), 'admin_') !== 0);
	}

	/**
	 * current
	 *
	 * Takes a Fileinfo object representing a file or folder from the
	 * $this->_standardPath folder and an array of elements representing the
	 * intermediate folder names to the file from the "root" in order.
	 * Generates a new "Page" record using this information and returns the
	 * resulting array. Example returned record:
	 *
	 * 	array(
	 *		'basename' => 'file.ext',
	 *		'filename' => 'subfolder/file.ext',
	 *		'title' => 'File',
	 *		'url' => '/subfolder/file.ext',
	 *		'bytes' => 14566,
	 *		'modified' => 1383075606,  // unix timestamp
	 *	);
	 *
	 * Folders will have an dditional [children] element that contains an
	 * integer count of the (matching) folder contents from that sub-directory.
	 *
	 * @return	array	A fake [Page] record including basename, filename
	 *					(including relative path from the image root),
	 *					display_url (as an absolute URL without the FQDN), url
	 *					(relative to Cake's root folder), bytes, modified
	 *					(and 'children', in the case of directories) fields.
	 */
	public function current() {
		$fileinfo = parent::current();
		$depth = $this->depth;
		$parent = implode('/', $depth);
		$url = str_replace(WWW_ROOT, $this->webroot, Router::url(array_merge(
			[
				'plugin' => false,
				'controller' => 'pages',
				'action' => 'display',
			],
			$depth,
			[$fileinfo->getBasename('.ctp')]
		)));
		$page = [
			'basename' => $fileinfo->getFilename(),
			'filename' => ltrim($parent . '/' . $fileinfo->getFilename(), '/'),
			'title' => Inflector::humanize($fileinfo->getBasename('.ctp')),
			'url' => str_replace($this->webroot, '/', $url),
			'bytes' => $fileinfo->getSize(),
			'modified' => $fileinfo->getMTime(),
		];
		if ($fileinfo->isDir()) { // Override the target URL and get a count of the children in subdirs.
			$page['url'] = array_merge(
				[
					'plugin' => false,
					'controller' => 'pages',
					'action' => 'index',
				],
				$depth,
				[$page['basename']]
			);
			$page['children'] = iterator_count(new ExtFilteredDirIterator($fileinfo->getRealPath(), $this->allowed));
		}

		return $page;
	}
}
