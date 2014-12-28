<?php

namespace AndreMe\PHPReportEngine\Elements;

class TableFooterBand extends TableBand {

	public function getPosition() {
		return self::POSITION_FOOTER;
	}

	public function getPrintBeforePageBreak() {
		return parent::getPrintBeforePageBreak();
	}

	public function setPrintBeforePageBreak($printBeforePageBreak) {
		return parent::setPrintBeforePageBreak($printBeforePageBreak);
	}

}
