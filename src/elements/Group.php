<?php

namespace AndreMe\PHPReportEngine\Elements;

class Group extends ControlStructure {

	private $pageBreakBetweenGroups = false;

	private $condition;

	public function __construct($condition = null, $dataSource = null) {
		parent::__construct();

		$this->setCondition($condition);
		$this->setDataSource($dataSource);
	}

	public function getPageBreakBetweenGroups() {
		return $this->pageBreakBetweenGroups;
	}

	public function setPageBreakBetweenGroups($pageBreakBetweenGroups) {
		$this->pageBreakBetweenGroups = $pageBreakBetweenGroups;
	}

	public function getCondition() {
		return $this->condition;
	}

	public function setCondition($condition) {
		$this->condition = $condition;
	}

}
