<?php

namespace Walnut\Lib\RecordStorage\ArrayDataSerializer;

use Walnut\Lib\JsonSerializer\JsonSerializer;

/**
 * @package Walnut\Lib\RecordStorage
 */
final class JsonArrayDataSerializer implements ArrayDataSerializer {
	public function __construct(
		private /*readonly*/ JsonSerializer $jsonSerializer
	) { }

	public function serialize(array $source): string {
		return $this->jsonSerializer->encode($source);
	}

	public function unserialize(string $source): array {
		return (array)($this->jsonSerializer->decode($source, true));
	}
}
