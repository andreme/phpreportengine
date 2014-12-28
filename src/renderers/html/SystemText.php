<?php

namespace AndreMe\PHPReportEngine\Renderers\HTML;

class SystemText extends \AndreMe\PHPReportEngine\Renderers\SystemText {

	protected function doRenderNext($footerHeight) {
		$style = $this->element->getStyle()->getCSS();

		if ($style) {
			$this->write("<span style=\"$style\">");
		}

		parent::doRenderNext($footerHeight);

		if ($style) {
			$this->write("</span>");
		}
	}

}
