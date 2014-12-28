<?php

namespace AndreMe\PHPReportEngine\Renderers;

class Element {

	const EVENT_REPORT_FINISHED = 1;

	/**
	 *
	 * @var \AndreMe\PHPReportEngine\Elements\Element
	 */
	protected $element;

	/**
	 *
	 * @var MainRenderer
	 */
	protected $mainRenderer;

	/**
	 *
	 * @var Element
	 */
	private $parent;

	public function __construct($element, $mainRenderer, $parent) {
		$this->element = $element;
		$this->mainRenderer = $mainRenderer;
		$this->parent = $parent;
	}

	public static function canRender($element) {
		return false;
	}

	public function getRenderPosition() {
		return $this->element->getPosition();
	}

	public function renderNext($footerHeight) {
		return $this->doRenderNext($footerHeight);
	}

	protected function doRenderNext($footerHeight) {
	}

	protected function write($data) {
		$this->mainRenderer->write($data);
	}

	public function getHeight() {
	}

	public function event($event) {
	}

	public function getElement() {
		return $this->element;
	}

}
