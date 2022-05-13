<?php

use PHPUnit\Framework\TestCase;
use Walnut\Lib\FileAccessor\FileAccessor;
use Walnut\Lib\RecordStorage\KeyValueStorage\InFile\InFileKeyValueStorage;
use Walnut\Lib\RecordStorage\KeyValueStorage\InFile\KeyToFileNameMapper;
use Walnut\Lib\RecordStorage\KeyValueStorage\InFile\PerFileKeyToFileNameMapper;

final class MockKeyToFileNameMapper implements KeyToFileNameMapper {

	public function fileNameFor(string $key): string {
		return $key;
	}
}

final class MockFileAccessor implements FileAccessor {

	public function __construct(
		private /*readonly*/ TestCase $testCase
	) {}

	public function writeToFile(string $file, string $content): void {
		$this->testCase->assertEquals(InFileKeyValueStorageTest::KEY, $file);
		$this->testCase->assertEquals(InFileKeyValueStorageTest::VALUE, $content);
	}

	public function readFromFile(string $file): string {
		$this->testCase->assertEquals(InFileKeyValueStorageTest::KEY, $file);
		return InFileKeyValueStorageTest::VALUE;
	}

	public function removeFile(string $file): void {
		// TODO: Implement removeFile() method.
	}

	public function fileExists(string $file): bool {
		// TODO: Implement fileExists() method.
	}

	public function appendToFile(string $file, string $content): void {
	}

}

final class InFileKeyValueStorageTest extends TestCase {

	public const KEY = 'key';
	public const VALUE = 'value';

	private function getStorage(): InFileKeyValueStorage {
		return new InFileKeyValueStorage(
			new MockKeyToFileNameMapper,
			new MockFileAccessor($this)
		);
	}

	public function testStore(): void {
		$this->getStorage()->store(self::KEY, self::VALUE);
	}

	public function testRetrieve(): void {
		$this->assertEquals(self::VALUE, $this->getStorage()->retrieve(self::KEY));
	}

}
