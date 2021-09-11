<?php

use PHPUnit\Framework\TestCase;
use Walnut\Lib\RecordStorage\ArrayDataSerializer\PhpArrayDataSerializer;

final class PhpArrayDataSerializerTest extends TestCase {

	private const KEY = 'key';

	private function getSerializer(): PhpArrayDataSerializer {
		return new PhpArrayDataSerializer;
	}

	public function testSerializeOk(): void {
		$this->assertEquals(
			'a:1:{i:0;s:3:"key";}',
			$this->getSerializer()->serialize([self::KEY])
		);
	}

	public function testUnserializeOk(): void {
		$this->assertEquals(
			[self::KEY],
			$this->getSerializer()->unserialize('a:1:{i:0;s:3:"key";}')
		);
	}

}
