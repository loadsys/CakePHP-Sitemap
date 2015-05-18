<?php
/**
 * Extends DirectoryIterator to provide filtering based on filename extension.
 * Skips the ./ and ../ entries, and any file that does not end in an extension
 * in ::allowed.
 *
 * @package Sitemap.Lib.Iterators
 */

/**
 * ExtFilteredDirIterator
 */
class ExtFilteredDirIterator extends FilterIterator {

	/**
	 * A list of file extensions that will be passed through the Iterator.
	 * Files not ending in one of these extensions will be excluded from the
	 * list. Each entry should exclude the leading '.' and be lowercase. For
	 * example: 'jpg' and not '.JPG'.
	 *
	 * @var	array
	 */
	private $__allowed = array();

	/**
	 * Creates a new DirectoryIterator that can be used in a foreach loop
	 * (providing an SplFileInfo object in each loop pass.)
	 *
	 * @param string $path A filesystem path to a directory on which to operate.
	 * @param array $allowedExtensions Optional indexed array of allowed file extensions, without the leading '.'s.
	 * @throws Exception If the provided path is not a directory or not readable.
	 */
	public function __construct($path, $allowedExtensions = null) {
		parent::__construct(new DirectoryIterator($path));
		if (!is_null($allowedExtensions)) {
			$this->__allowed = $allowedExtensions;
		}
	}

	/**
	 * accept
	 *
	 * Called for each item in the Iterator. Will allow the entry if:
	 *    - It is not ./ or ../
	 *    - It is a sub-directory
	 *    - It is in the provided ::allowed array
	 *    - Or if no ::allowed array has been provided (which essentially allows all files and folders.)
	 *
	 * @return bool True for all non-dot directories, and files with extensions in $this->allowed.
	 */
	public function accept() {
		$current = $this->getInnerIterator()->current();
		return (
			!$current->isDot()
			&&
			(
				!is_array($this->__allowed) // No extensions defined. Allow everything through.
				|| in_array(strtolower($current->getExtension()), $this->__allowed) // Allow if extension is in provided list.
				|| $current->isDir() // Allow if entry is a sub-directory.
			)
		);
	}
}
