<?php

namespace Walnut\Lib\RecordStorage\ArrayDataSerializer;

/**
 * @package Walnut\Lib\RecordStorage
 */
final class PhpArrayDataSerializer implements ArrayDataSerializer {
	public function serialize(array $source): string {
		return serialize($source);
	}
	public function unserialize(string $source): array {
		return (array)unserialize($source, ['allowed_classes' => []]);
	}
}
