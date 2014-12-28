<?php

namespace AndreMe\PHPReportEngine\Elements;

class FooterBand extends Band {

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
