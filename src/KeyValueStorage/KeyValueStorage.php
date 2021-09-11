<?php

namespace Walnut\Lib\RecordStorage\KeyValueStorage;

/**
 * @package Walnut\Lib\RecordStorage
 */
interface KeyValueStorage {
	/**
	 * @param string $key
	 * @param string $value
	 */
	public function store(string $key, string $value): void;
	/**
	 * @param string $key
	 * @return string
	 * @throws KeyNotFoundException
	 */
	public function retrieve(string $key): string;
}