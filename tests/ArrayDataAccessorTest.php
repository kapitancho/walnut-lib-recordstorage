<?php

use PHPUnit\Framework\TestCase;
use Walnut\Lib\RecordStorage\ArrayDataAccessor\ArrayDataAccessor;
use Walnut\Lib\RecordStorage\ArrayDataAccessor\ArrayDataAccessorFactory;
use Walnut\Lib\RecordStorage\ArrayDataAccessor\ArrayDataFilter;
use Walnut\Lib\RecordStorage\RecordStorage;

final class MockAccessorRecordStorage implements RecordStorage {

	public function __construct(
		private /*readonly*/ TestCase $testCase
	) {}

	public function retrieveRecords(string $key): array {
		return [$key => [$key], $key . $key => [$key . $key]];
	}

	public function storeRecords(string $key, array $records): void {
		$this->testCase->assertNotEquals(2, count($records));
	}
}

final class ArrayDataAccessorTest extends TestCase {

	public const KEY = 'key';

	public function getAccessor(): ArrayDataAccessor {
		return (new ArrayDataAccessorFactory(new MockAccessorRecordStorage($this)))
			->accessor(self::KEY);
	}

	public function testAllOk(): void {
		$this->assertCount(2, $this->getAccessor()->all());
	}

	public function testByFilter(): void {
		$this->assertEquals([[self::KEY]], $this->getAccessor()->byFilter(
			new class implements ArrayDataFilter {
				public function isSatisfiedBy(array $entry): bool {
					return $entry[0] === ArrayDataAccessorTest::KEY;
				}
			}
		));
	}

	public function testStore(): void {
		$this->getAccessor()->store(self::KEY . self::KEY . self::KEY, [1]);
	}

	public function testRemove(): void {
		$this->getAccessor()->remove(self::KEY . self::KEY);
	}

	public function testById(): void {
		$this->assertEquals([self::KEY], $this->getAccessor()->byKey(self::KEY));
		$this->assertNull( $this->getAccessor()->byKey(self::KEY . self::KEY . self::KEY));
	}

	public function testNextKey(): void {
		$this->assertEquals(1, $this->getAccessor()->nextKey());
	}

}