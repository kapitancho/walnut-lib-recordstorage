<?php

namespace Walnut\Lib\RecordStorage;

/**
 * @package Walnut\Lib\RecordStorage
 */
interface RecordStorage {
	/**
	 * @param string $key
	 * @return array[]
	 */
	public function retrieveRecords(string $key): array;

	/**
	 * @param string $key
	 * @param array[] $records
	 */
	public function storeRecords(string $key, array $records): void;
}