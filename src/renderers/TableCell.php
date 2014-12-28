<?php

namespace AndreMe\PHPReportEngine\Renderers;

class TableCell extends ParentElement {

	/**
	 *
	 * @var \AndreMe\PHPReportEngine\Elements\TableCell
	 */
	protected $element;

	static public function canRender($element) {
		return ($element instanceof \AndreMe\PHPReportEngine\Elements\TableCell);
	}

}
