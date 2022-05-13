<?php

namespace Walnut\Lib\RecordStorage;

/**
 * @package Walnut\Lib\RecordStorage
 */
final class CacheableRecordStorage implements RecordStorage {
	
	/**
	 * @var array[][]
	 */
	private array $cache = [];
	
	public function __construct(
		private readonly RecordStorage $recordStorage
	) {}

	/**
	 * @param string $key
	 * @return array[]
	 */
	public function retrieveRecords(string $key): array {
		return $this->cache[$key] ??= $this->recordStorage->retrieveRecords($key);
	}

	/**
	 * @param string $key
	 * @param array[] $records
	 */
	public function storeRecords(string $key, array $records): void {
		$this->cache[$key] = $records;
		$this->recordStorage->storeRecords($key, $records);
	}
	
}
