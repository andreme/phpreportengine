<?php

namespace AndreMe\PHPReportEngine\Formatters;

class DateTime implements \AndreMe\PHPReportEngine\IFormatter {

	private $format;

	public function __construct($format = 'Y-m-d') {
		$this->format = $format;
	}

	public function getFormat() {
		return $this->format;
	}

	public function setFormat($format) {
		$this->format = $format;
	}

	public function formatValue($value) {
		return date($this->format, strtotime($value));
	}

}
