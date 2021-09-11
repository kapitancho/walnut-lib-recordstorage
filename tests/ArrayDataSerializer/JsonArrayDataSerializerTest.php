<?php

use PHPUnit\Framework\TestCase;
use Walnut\Lib\JsonSerializer\JsonSerializer;
use Walnut\Lib\RecordStorage\ArrayDataSerializer\JsonArrayDataSerializer;

final class MockJsonSerializer implements JsonSerializer {

	public function encode(float|object|int|bool|array|string|null $value): string {
		return $value[0] . $value[0];
	}

	public function decode(string $value, bool $associative): array|object|string|int|float|bool|null {
		return [substr($value, 0, (int)(strlen($value) / 2))];
	}
}

final class JsonArrayDataSerializerTest extends TestCase {

	private const KEY = 'key';

	private function getSerializer(): JsonArrayDataSerializer {
		return new JsonArrayDataSerializer(
			new MockJsonSerializer
		);
	}

	public function testSerializeOk(): void {
		$this->assertEquals(
			self::KEY . self::KEY,
			$this->getSerializer()->serialize([self::KEY])
		);
	}

	public function testUnserializeOk(): void {
		$this->assertEquals(
			[self::KEY],
			$this->getSerializer()->unserialize(self::KEY . self::KEY)
		);
	}

}
