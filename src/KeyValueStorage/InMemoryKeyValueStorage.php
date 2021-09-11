<?php

namespace Walnut\Lib\RecordStorage\KeyValueStorage;

/**
 * @package Walnut\Lib\RecordStorage
 */
final class InMemoryKeyValueStorage implements KeyValueStorage {
	/**
	 * @param string[] $inMemoryStorage
	 */
	public function __construct(
		private array $inMemoryStorage = []
	) {}

	public function store(string $key, string $value): void {
		$this->inMemoryStorage[$key] = $value;
	}

	public function retrieve(string $key): string {
		return $this->inMemoryStorage[$key] ?? throw new KeyNotFoundException;
	}
}