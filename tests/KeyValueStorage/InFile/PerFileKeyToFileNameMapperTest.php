<?php

use PHPUnit\Framework\TestCase;
use Walnut\Lib\RecordStorage\KeyValueStorage\InFile\PerFileKeyToFileNameMapper;

final class PerFileKeyToFileNameMapperTest extends TestCase {

	private const BASE_DIR = 'baseDir';
	private const KEY = 'key';
	private const FILE_EXTENSION = 'ext';

	public function testOk(): void {
		$mapper = new PerFileKeyToFileNameMapper(
			self::BASE_DIR,
			self::FILE_EXTENSION
		);
		$this->assertEquals(
			self::BASE_DIR . '/' . self::KEY . '.' . self::FILE_EXTENSION,
			$mapper->fileNameFor(self::KEY)
		);
	}

}
