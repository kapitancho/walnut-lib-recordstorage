<?php

use PHPUnit\Framework\TestCase;
use Walnut\Lib\RecordStorage\CacheableRecordStorage;
use Walnut\Lib\RecordStorage\RecordStorage;

final class MockRecordStorage implements RecordStorage {

	private int $counter = 0;

	public function retrieveRecords(string $key): array {
		return [$this->counter++];
	}

	public function storeRecords(string $key, array $records): void {
		// TODO: Implement storeRecords() method.
	}
}

final class CacheableRecordStorageTest extends TestCase {

	private const KEY = 'key';
	private const VALUE = ['value'];

	private function getStorage(): CacheableRecordStorage {
		return new CacheableRecordStorage(
			new MockRecordStorage
		);
	}

	public function testRetrieveOk(): void {
		$storage = $this->getStorage();

		$value1 = $storage->retrieveRecords(self::KEY);
		$value2 = $storage->retrieveRecords(self::KEY);

		$this->assertEquals($value1, $value2);
	}

	public function testStoreOk(): void {
		$storage = $this->getStorage();

		$storage->storeRecords(self::KEY, self::VALUE);
		$value = $storage->retrieveRecords(self::KEY);

		$this->assertEquals(self::VALUE, $value);
	}

}
