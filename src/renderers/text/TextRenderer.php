<?php

namespace AndreMe\PHPReportEngine\Renderers\Text;

class TextRenderer extends \AndreMe\PHPReportEngine\Renderers\MainRenderer {

	public function loadRendererClasses() {
		parent::loadRendererClasses();

		$this->addRendererClass(__NAMESPACE__.'\Band');
	}

	public function addPageBreak() {
		parent::addPageBreak();

		$this->write("\n");
	}

}
