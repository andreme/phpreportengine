<?php

namespace AndreMe\PHPReportEngine\Renderers\HTML;

class Image extends \AndreMe\PHPReportEngine\Renderers\Element {

	/**
	 *
	 * @var \AndreMe\PHPReportEngine\Elements\Image
	 */
	protected $element;

	public static function canRender($element) {
		return $element instanceof \AndreMe\PHPReportEngine\Elements\Image;
	}

	protected function doRenderNext($footerHeight) {

		$style = $this->element->getStyle()->getCSS();
		if ($style) {
			$style = " style=\"$style\"";
		}

		$this->write('<img src="'.$this->element->getURL().'"'.$style.' />');
	}

}
