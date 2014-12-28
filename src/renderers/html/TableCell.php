<?php

namespace AndreMe\PHPReportEngine\Renderers\HTML;

class TableCell extends \AndreMe\PHPReportEngine\Renderers\TableCell {

	protected function doRenderNext($footerHeight) {
		$style = $this->element->getStyle()->getCSS();

		$colSpan = null;
		if ($this->element->getColSpan()) {
			$colSpan = " colspan=\"{$this->element->getColSpan()}\"";
		}

		$this->write('<td'.$colSpan.($style ? " style=\"$style\"" : '').'>');

		parent::doRenderNext($footerHeight);

		$this->write('</td>');
	}

}
