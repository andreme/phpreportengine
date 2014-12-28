<?php

namespace AndreMe\PHPReportEngine\Elements;

class HeaderBand extends Band {

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
