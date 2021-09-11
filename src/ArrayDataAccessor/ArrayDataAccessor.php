<?php

namespace Walnut\Lib\RecordStorage\ArrayDataAccessor;

use Walnut\Lib\RecordStorage\RecordStorage;

final class ArrayDataAccessor {
	public function __construct(
		private /*readonly*/ RecordStorage $recordStorage,
		private /*readonly*/ string $recordKey
	) { }

	/**
	 * @return array[]
	 */
	private function retrieveRecords(): array {
		return $this->recordStorage->retrieveRecords($this->recordKey);
	}

	/**
	 * @param array[] $records
	 */
	private function storeRecords(array $records): void {
		$this->recordStorage->storeRecords($this->recordKey, $records);
	}

	public function all(): array {
		return array_values($this->retrieveRecords());
	}

	public function byFilter(ArrayDataFilter $dataFilter): ?array {
		return array_values(
			array_filter($this->retrieveRecords(),
				static fn(array $entry): bool => $dataFilter->isSatisfiedBy($entry)
			)
		);
	}

	public function byKey(string $key): ?array {
		$data = $this->retrieveRecords();
		return $data[$key] ?? null;
	}

	public function remove(string $key): void {
		$data = $this->retrieveRecords();
		unset($data[$key]);
		$this->storeRecords($data);
	}

	public function store(string $key, array $entry): void {
		$data = $this->retrieveRecords();
		$data[$key] = $entry;
		$this->storeRecords($data);
	}

	public function nextKey(): int {
		return 1 + (int)max(array_keys($this->retrieveRecords() ?: [0]));
	}

}