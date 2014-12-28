<?php

namespace AndreMe\PHPReportEngine\Elements;

class CalcField extends FieldText implements \AndreMe\PHPReportEngine\IDatasourceUpdateListener {

	const TYPE_SUM = 'Sum';
	const TYPE_COUNT = 'Count';

	protected $type;

	private $value;

	public function __construct($field = null, $formatter = null, $type = self::TYPE_SUM) {
		parent::__construct($field, $formatter);

		$this->type = $type;
	}

	public function getType() {
		return $this->type;
	}

	public function getValue() {
		return $this->value;
	}

	public function onNextRecord($record) {
		switch ($this->type) {
			case self::TYPE_SUM:
				$this->value += parent::getValue();
				break;
			case self::TYPE_COUNT:
				$this->value++;
				break;
			default:
				throw new \Exception('Unknown CalcField type: '.$this->type);
		}
	}

	public function onReset() {
		$this->value = null;
	}

}
