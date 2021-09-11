<?php

namespace Walnut\Lib\RecordStorage\ArrayDataAccessor;

use Walnut\Lib\RecordStorage\RecordStorage;

final class ArrayDataAccessorFactory {
	public function __construct(
		private /*readonly*/ RecordStorage $recordStorage,
	) { }

	public function accessor(string $recordKey): ArrayDataAccessor {
		return new ArrayDataAccessor($this->recordStorage, $recordKey);
	}

}