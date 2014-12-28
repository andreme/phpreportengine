<?php

namespace AndreMe\PHPReportEngine\Renderers\HTML;

class Band extends \AndreMe\PHPReportEngine\Renderers\Band {

	private $automaticTableCellStart = null;
	private $automaticTableCellEnd = null;

	public function __construct($element, $mainRenderer, $parent) {
		parent::__construct($element, $mainRenderer, $parent);

		if (!($element instanceof \AndreMe\PHPReportEngine\Elements\TableBand)) {
			$this->automaticTableCellStart = '<td colspan="99">';
			$this->automaticTableCellEnd = '</td>';
		}
	}

	protected function doRenderNext($footerHeight) {

		if ($this->getHeight() + $footerHeight > $this->mainRenderer->getPageSpaceLeft()) {
			return \AndreMe\PHPReportEngine\Renderers\MainRenderer::RENDER_STAGE_PAGEBREAK;
		}

		$style = $this->element->getStyle()->getCSS();

		$this->write('<tr'.($style ? " style=\"$style\"" : '').'>'.$this->automaticTableCellStart);

		parent::doRenderNext($footerHeight);

		$this->write($this->automaticTableCellEnd.'</tr>');

		$this->mainRenderer->addPageSpaceUsed($this->getHeight());
	}

	public function getHeight() {
		return 1;
	}

}
