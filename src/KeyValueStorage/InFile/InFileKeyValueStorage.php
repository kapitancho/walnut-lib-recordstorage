<?php

namespace Walnut\Lib\RecordStorage\KeyValueStorage\InFile;

use Walnut\Lib\FileAccessor\FileAccessor;
use Walnut\Lib\RecordStorage\KeyValueStorage\KeyValueStorage;

/**
 * @package Walnut\Lib\RecordStorage
 */
final class InFileKeyValueStorage implements KeyValueStorage {
	public function __construct(
		private readonly KeyToFileNameMapper $keyToFileNameMapper,
		private readonly FileAccessor $fileAccessor
	) { }

	private function key(string $key): string {
		return $this->keyToFileNameMapper->fileNameFor($key);
	}

	public function store(string $key, string $value): void {
		$this->fileAccessor->writeToFile($this->key($key), $value);
	}

	public function retrieve(string $key): string {
		return $this->fileAccessor->readFromFile($this->key($key));
	}
}
