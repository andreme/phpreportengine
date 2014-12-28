<?php

namespace AndreMe\PHPReportEngine\Renderers;

class RendererList {

	private $renderers;

	public function __construct() {
		$this->renderers = [
			\AndreMe\PHPReportEngine\Elements\Element::POSITION_NORMAL => [],
			\AndreMe\PHPReportEngine\Elements\Element::POSITION_HEADER => [],
			\AndreMe\PHPReportEngine\Elements\Element::POSITION_DETAIL => [],
			\AndreMe\PHPReportEngine\Elements\Element::POSITION_FOOTER => [],
		];
	}

	/**
	 *
	 * @param Element $renderer
	 */
	public function add($renderer) {
		$this->renderers[$renderer->getRenderPosition()][] = $renderer;
	}

	public function get($renderPosition = \AndreMe\PHPReportEngine\Elements\Element::POSITION_NORMAL) {
		return $this->renderers[$renderPosition];
	}

	public function getAll() {
		return call_user_func_array('array_merge', $this->renderers);
	}

}
