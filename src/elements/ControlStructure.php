<?php

namespace AndreMe\PHPReportEngine\Elements;

class ControlStructure extends ParentElement implements \AndreMe\PHPReportEngine\IRecordProvider {

	/**
	 *
	 * @var \AndreMe\PHPReportEngine\DataSources\DataSource
	 */
	private $dataSource;

	private $record;

	public function setDataSource($dataSource) {
		$this->dataSource = $dataSource;
	}

	/**
	 *
	 * @return \AndreMe\PHPReportEngine\DataSources\DataSource
	 */
	public function getDataSource() {
		return $this->dataSource;
	}

	public function getRecord() {
		return $this->record;
	}

	public function setRecord($record) {
		$this->record = $record;
	}

	public function getPosition() {
		return self::POSITION_DETAIL;
	}

}
