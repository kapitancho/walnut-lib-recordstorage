<?php

namespace Walnut\Lib\RecordStorage;

use Walnut\Lib\TransactionContext\TransactionContext;

/**
 * @package Walnut\Lib\Persistence\RecordStorage
 */
final class TransactionalRecordStorage implements RecordStorage, TransactionContext {

	/**
	 * @var array<string, array[]>
	 */
	private array $transactionState = [];
	public function __construct(private /*readonly*/ RecordStorage $recordStorage) { }

	/**
	 * @param string $key
	 * @return array[]
	 */
	public function retrieveRecords(string $key): array {
		return $this->transactionState[$key] ?? $this->recordStorage->retrieveRecords($key);
	}

	/**
	 * @param string $key
	 * @param array[] $records
	 */
	public function storeRecords(string $key, array $records): void {
		$this->transactionState[$key] = $records;
	}
	public function saveChanges(): void {
		foreach($this->transactionState as $key => $value) {
			$this->recordStorage->storeRecords($key, $value);
		}
		$this->transactionState = [];
	}
	public function revertChanges(): void {
		$this->transactionState = [];
	}
}
