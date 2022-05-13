<?php

namespace Walnut\Lib\RecordStorage;

use Walnut\Lib\RecordStorage\ArrayDataSerializer\ArrayDataSerializer;
use Walnut\Lib\RecordStorage\KeyValueStorage\KeyValueStorage;

/**
 * @package Walnut\Lib\RecordStorage
 */
final class SerializedRecordStorage implements RecordStorage {

	public function __construct(
		private readonly ArrayDataSerializer $dataSerializer,
		private readonly KeyValueStorage     $keyValueStorage
	) { }

	/**
	 * @param string $key
	 * @return array[]
	 */
	public function retrieveRecords(string $key): array {
		/**
		 * @var array[]
		 */
		return $this->dataSerializer->unserialize(
			$this->keyValueStorage->retrieve($key)
		);
	}

	/**
	 * @param string $key
	 * @param array[] $records
	 */
	public function storeRecords(string $key, array $records): void {
		$this->keyValueStorage->store($key,
			$this->dataSerializer->serialize($records)
		);
	}
}
