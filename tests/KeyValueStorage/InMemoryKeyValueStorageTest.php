<?php

use PHPUnit\Framework\TestCase;
use Walnut\Lib\RecordStorage\KeyValueStorage\InMemoryKeyValueStorage;
use Walnut\Lib\RecordStorage\KeyValueStorage\KeyNotFoundException;

final class InMemoryKeyValueStorageTest extends TestCase {

	public const KEY = 'key';
	public const VALUE = 'value';

	private function getStorage(array $storage = []): InMemoryKeyValueStorage {
		return new InMemoryKeyValueStorage(
			$storage
		);
	}

	public function testRetrieveOk(): void {
		$this->assertEquals(self::VALUE,
			$this->getStorage([
				self::KEY => self::VALUE
			])->retrieve(self::KEY));
	}

	public function testRetrieveError(): void {
		$this->expectException(KeyNotFoundException::class);
		$this->getStorage()->retrieve(self::KEY);
	}

	public function testStoreOk(): void {
		$storage = $this->getStorage();
		$storage->store(self::KEY, self::VALUE);
		$this->assertEquals(self::VALUE,
			$storage->retrieve(self::KEY)
		);
	}

}