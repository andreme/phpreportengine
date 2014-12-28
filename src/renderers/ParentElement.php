<?php

namespace AndreMe\PHPReportEngine\Renderers;

class ParentElement extends Element {

	/**
	 *
	 * @var \AndreMe\PHPReportEngine\Elements\ParentElement
	 */
	protected $element;

	/**
	 *
	 * @var RendererList
	 */
	protected $childRenderers;

	protected $riQueue;

	public function __construct($element, $mainRenderer, $parent) {
		parent::__construct($element, $mainRenderer, $parent);

		$this->childRenderers = new RendererList();
	}

	public function createRenderers() {
		foreach ($this->element->getElements() as $element) {
			$this->childRenderers->add($elRend = $this->mainRenderer->createRenderer($element, $this));

			if ($element instanceof \AndreMe\PHPReportEngine\Elements\ParentElement) {
				$elRend->createRenderers();
			}
		}
	}

	protected function doRenderNext($footerHeight) {
		if (!$this->riQueue) {
			$this->riQueue = $this->childRenderers->get(\AndreMe\PHPReportEngine\Elements\Element::POSITION_NORMAL);
		}

		return $this->renderQueue($footerHeight);
	}

	protected function renderQueue($footerHeight) {
		foreach ($this->riQueue as $key => $renderer) {
			do {
				if (($renderResult = $renderer->renderNext($footerHeight))
						and ($renderResult != MainRenderer::RENDER_STAGE_DONE)
						and ($renderResult != MainRenderer::RENDER_STAGE_AGAIN)) {
					$this->onRenderEvent($renderResult);
					return $renderResult;
				}
			} while ($renderResult == MainRenderer::RENDER_STAGE_AGAIN);

			unset($this->riQueue[$key]);
		}
	}

	protected function onRenderEvent($stage) {
	}

	public function event($event) {
		foreach ($this->childRenderers->getAll() as $renderer) {
			/* @var $renderer \AndreMe\PHPReportEngine\Renderers\Element */
			$renderer->event($event);
		}

	}

}
