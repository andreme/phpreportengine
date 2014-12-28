<?php

namespace AndreMe\PHPReportEngine\DataSources;

class DataSourceFilter extends DataSource {

	/**
	 *
	 * @var DataSource
	 */
	private $dataSource;

	private $filter;

	public function __construct($dataSource, $filter) {
		$this->dataSource = $dataSource;
		$this->dataSource->reset();
		$this->filter = $filter;
	}

	public function next() {
		$filter = $this->filter;
		while ((($record = $this->dataSource->next()) !== false) and !$filter($record)) {
		}

		return $record;
	}

	public function reset() {
		parent::reset();

		$this->dataSource->reset();
	}

}
