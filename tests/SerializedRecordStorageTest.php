<?php

use PHPUnit\Framework\TestCase;
use Walnut\Lib\RecordStorage\ArrayDataSerializer\ArrayDataSerializer;
use Walnut\Lib\RecordStorage\KeyValueStorage\KeyValueStorage;
use Walnut\Lib\RecordStorage\SerializedRecordStorage;

final class MockArrayDataSerializer implements ArrayDataSerializer {

	public function serialize(array $source): string {
		return implode('|', $source[0]);
	}

	public function unserialize(string $source): array {
		return [explode('|', $source)];
	}
}

final class MockKeyValueStorage implements KeyValueStorage {

	public function __construct(
		private /*readonly*/ TestCase $testCase
	) {}

	public function store(string $key, string $value): void {
		$this->testCase->assertEquals($key, $value);
	}

	public function retrieve(string $key): string {
		return $key;
	}
}

final class SerializedRecordStorageTest extends TestCase {

	private const KEY = 'value|value';
	private const VALUE = [['value', 'value']];

	private function getStorage(): SerializedRecordStorage {
		return new SerializedRecordStorage(
			new MockArrayDataSerializer,
			new MockKeyValueStorage($this)
		);
	}


	public function testRetrieveOk(): void {
		$storage = $this->getStorage();

		$this->assertEquals(self::VALUE, $storage->retrieveRecords(self::KEY));
	}

	public function testStoreOk(): void {
		$storage = $this->getStorage();

		$storage->storeRecords(self::KEY, self::VALUE);
	}

}
