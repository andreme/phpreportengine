<?php

namespace AndreMe\PHPReportEngine\Elements;

class Band extends ParentElement {

	private $printAfterPageBreak = true;

	private $printBeforePageBreak = true;

	protected function getPrintAfterPageBreak() {
		return $this->printAfterPageBreak;
	}

	protected function setPrintAfterPageBreak($printAfterPageBreak) {
		$this->printAfterPageBreak = !!$printAfterPageBreak;
	}

	protected function getPrintBeforePageBreak() {
		return $this->printBeforePageBreak;
	}

	protected function setPrintBeforePageBreak($printBeforePageBreak) {
		$this->printBeforePageBreak = !!$printBeforePageBreak;
	}

}
