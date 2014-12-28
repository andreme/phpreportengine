<?php

namespace AndreMe\PHPReportEngine\Renderers\Text;

class Band extends \AndreMe\PHPReportEngine\Renderers\Band {

	protected function doRenderNext($footerHeight) {

		if ($this->getHeight() + $footerHeight > $this->mainRenderer->getPageSpaceLeft()) {
			return \AndreMe\PHPReportEngine\Renderers\MainRenderer::RENDER_STAGE_PAGEBREAK;
		}

		parent::doRenderNext($footerHeight);

		$this->write("\n");

		$this->mainRenderer->addPageSpaceUsed($this->getHeight());
	}

	public function getHeight() {
		return 1;
	}

}
