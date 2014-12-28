<?php

namespace AndreMe\PHPReportEngine\Elements;

class FieldText extends Text {

	private $field;
	private $fieldIsClosure;

	public function __construct($field = null, $formatter = null) {
		parent::__construct();

		$this->field = $field;
		$this->fieldIsClosure = $field instanceof \Closure;
		$this->setFormatter($formatter);
	}

	public function getValue() {
		$record = $this->getRecordFromParent();

		if ($this->fieldIsClosure) {
			$cntxt = new \stdClass();
			$cntxt->Record = $record;

			return call_user_func($this->field, $cntxt);
		} else {
			return $record[$this->field];
		}
	}

	public function setText($text) {
		throw new \Exception('FieldText::setText not allowed.');
	}

}
