<?php

namespace AndreMe\PHPReportEngine\Renderers\HTML;

class HTMLRenderer extends \AndreMe\PHPReportEngine\Renderers\MainRenderer {

	public function loadRendererClasses() {
		parent::loadRendererClasses();

		$this->addRendererClass(__NAMESPACE__.'\Band');
		$this->addRendererClass(__NAMESPACE__.'\TableCell');
		$this->addRendererClass(__NAMESPACE__.'\Text');
		$this->addRendererClass(__NAMESPACE__.'\SystemText');
		$this->addRendererClass(__NAMESPACE__.'\Image');
	}

	public function addPageBreak() {
		parent::addPageBreak();

		$this->write('<tr class="PageBreak"></tr>');
	}

	protected function startReport() {
		$this->write('<table class="Report">');
	}

	protected function endReport() {
		$this->write('</table>');
	}

}
