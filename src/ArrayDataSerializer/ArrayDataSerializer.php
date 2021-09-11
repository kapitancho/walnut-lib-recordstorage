<?php

namespace Walnut\Lib\RecordStorage\ArrayDataSerializer;

/**
 * @package Walnut\Lib\RecordStorage
 */
interface ArrayDataSerializer {
	public function serialize(array $source): string;
	public function unserialize(string $source): array;
}