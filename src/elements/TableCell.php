<?php

namespace AndreMe\PHPReportEngine\Elements;

class TableCell extends ParentElement {

	private $colSpan;

	public function add($element) {
		$args = func_get_args();

		foreach ($args as $arg) { // apply styles to the cell, and not the element
			if ($arg instanceof \AndreMe\PHPReportEngine\Style) {
				$this->setStyle($arg);
			} else {
				parent::add($arg);
			}
		}
	}

	public function getColSpan() {
		return $this->colSpan;
	}

	public function setColSpan($colSpan) {
		$this->colSpan = $colSpan;
	}

}
