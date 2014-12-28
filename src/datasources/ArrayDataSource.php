<?php

namespace AndreMe\PHPReportEngine\DataSources;

class ArrayDataSource extends DataSource {

	private $array;

	private $beforeFirst;

	public function __construct($array) {
		$this->array = ($array ?: []);

		$this->reset();
	}

	public function next() {
		if ($this->beforeFirst) {
			$this->beforeFirst = false;
			return current($this->array);
		}

		return next($this->array);
	}

	public function reset() {
		parent::reset();

		reset($this->array);
		$this->beforeFirst = true;
	}

}
