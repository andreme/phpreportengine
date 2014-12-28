<?php

namespace AndreMe\PHPReportEngine\Elements;

class TableHeaderBand extends TableBand {

	public function getPosition() {
		return self::POSITION_HEADER;
	}

	public function getPrintAfterPageBreak() {
		return parent::getPrintAfterPageBreak();
	}

	public function setPrintAfterPageBreak($printAfterPageBreak) {
		return parent::setPrintAfterPageBreak($printAfterPageBreak);
	}

}
