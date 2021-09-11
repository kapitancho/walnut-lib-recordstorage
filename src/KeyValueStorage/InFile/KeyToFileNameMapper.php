<?php

namespace Walnut\Lib\RecordStorage\KeyValueStorage\InFile;

/**
 * @package Walnut\Lib\RecordStorage
 */
interface KeyToFileNameMapper {
	public function fileNameFor(string $key): string;
}