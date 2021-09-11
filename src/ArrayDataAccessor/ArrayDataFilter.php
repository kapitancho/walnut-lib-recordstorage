<?php

namespace Walnut\Lib\RecordStorage\ArrayDataAccessor;

interface ArrayDataFilter {
	public function isSatisfiedBy(array $entry): bool;
}