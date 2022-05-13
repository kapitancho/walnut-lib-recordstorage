<?php

namespace Walnut\Lib\RecordStorage\KeyValueStorage\InFile;

/**
 * @package Walnut\Lib\RecordStorage
 */
final class PerFileKeyToFileNameMapper implements KeyToFileNameMapper {
	public function __construct(
		private readonly string $baseDir,
		private readonly string $fileExtension
	) { }

	public function fileNameFor(string $key): string {
		return "$this->baseDir/$key.$this->fileExtension";
	}
}
