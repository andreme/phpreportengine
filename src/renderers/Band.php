<?php

namespace AndreMe\PHPReportEngine\Renderers;

class Band extends ParentElement {

	static public function canRender($element) {
		return ($element instanceof \AndreMe\PHPReportEngine\Elements\Band);
	}

	public function renderNext($footerHeight) {
		if ($this->element->getRecordFromParent() === false) {
			return MainRenderer::RENDER_STAGE_DONE;
		}

		return parent::renderNext($footerHeight);
	}

}
