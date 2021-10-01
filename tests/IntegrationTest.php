<?php

use PHPUnit\Framework\TestCase;
use Walnut\Lib\RecordStorage\ArrayDataAccessor\ArrayDataAccessorFactory;
use Walnut\Lib\RecordStorage\ArrayDataSerializer\PhpArrayDataSerializer;
use Walnut\Lib\RecordStorage\KeyValueStorage\InMemoryKeyValueStorage;
use Walnut\Lib\RecordStorage\RecordStorage;
use Walnut\Lib\RecordStorage\SerializedRecordStorage;

class IntegrationTest extends TestCase {

	public const STORAGE_KEY = 'storage-key';
	public const KEY1 = 'key1';
	public const VALUE1 = ['value1'];
	public const KEY2 = 'key2';
	public const VALUE2 = ['value2'];

	private function getAccessorFactory(RecordStorage $recordStorage): ArrayDataAccessorFactory {
		return new ArrayDataAccessorFactory($recordStorage);
	}

	public function testInMemoryUsingPhpSerializer(): void {
		$storage = new SerializedRecordStorage(
			new PhpArrayDataSerializer,
			new InMemoryKeyValueStorage([self::STORAGE_KEY => 'a:0:{}'])
		);
		$accessor = $this->getAccessorFactory($storage)->accessor(self::STORAGE_KEY);

		$this->assertEmpty($accessor->all());
		$accessor->store(self::KEY1, self::VALUE1);
		$accessor->store(self::KEY2, self::VALUE2);
		$this->assertCount(2, $accessor->all());
		$this->assertCount(1, $accessor->byFilter(
			fn(array $entry): bool => $entry === IntegrationTest::VALUE2
		));

		$this->assertNotNull($accessor->byKey(self::KEY2));
		$accessor->remove(self::KEY2);
		$this->assertCount(1, $accessor->all());
		$this->assertNull($accessor->byKey(self::KEY2));
	}

}