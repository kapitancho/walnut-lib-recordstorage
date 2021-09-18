<?php

use PHPUnit\Framework\TestCase;
use Walnut\Lib\RecordStorage\CacheableRecordStorage;
use Walnut\Lib\RecordStorage\RecordStorage;
use Walnut\Lib\RecordStorage\TransactionalRecordStorage;

final class MockTransactionalRecordStorage implements RecordStorage {

	private int $value = 0;

	public function retrieveRecords(string $key): array {
		return [$this->value];
	}

	public function storeRecords(string $key, array $records): void {
		$this->value = $records[0];
	}
}

final class TransactionalRecordStorageTest extends TestCase {

	private const KEY = 'key';

	private function getStorage(): TransactionalRecordStorage {
		return new TransactionalRecordStorage(
			new MockTransactionalRecordStorage
		);
	}

	public function testSaveOk(): void {
		$storage = $this->getStorage();

		$value1 = $storage->retrieveRecords(self::KEY);
		$storage->storeRecords(self::KEY, [1]);
		$value2 = $storage->retrieveRecords(self::KEY);
		$storage->saveChanges();
		$value3 = $storage->retrieveRecords(self::KEY);

		$this->assertNotEquals($value1, $value2);
		$this->assertEquals($value2, $value3);
	}

	public function testRevertOk(): void {
		$storage = $this->getStorage();

		$value1 = $storage->retrieveRecords(self::KEY);
		$storage->storeRecords(self::KEY, [1]);
		$value2 = $storage->retrieveRecords(self::KEY);
		$storage->revertChanges();
		$value3 = $storage->retrieveRecords(self::KEY);

		$this->assertEquals($value1, $value3);
		$this->assertNotEquals($value2, $value3);
	}

}
