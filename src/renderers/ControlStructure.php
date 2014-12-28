<?php

namespace AndreMe\PHPReportEngine\Renderers;

class ControlStructure extends ParentElement {

	protected $riPrevRecord;
	protected $riRecord;
	protected $dontPrintHeaderFooterOnPageBreak = false;

	protected function onRenderEvent($stage) {
		if (($stage == MainRenderer::RENDER_STAGE_PAGEBREAK) and !$this->dontPrintHeaderFooterOnPageBreak) {
			$currentQueue = array_merge(
				$this->getHeaders(true),
				$this->riQueue
			);

			$this->element->setRecord($this->riPrevRecord);

			$this->dontPrintHeaderFooterOnPageBreak = true;
			$this->renderFooters(true);
			$this->dontPrintHeaderFooterOnPageBreak = false;

			$this->riQueue = $currentQueue;
			$this->element->setRecord($this->riRecord);
		}
	}

	protected function renderFooters($pageBreak = false) {
		$this->riQueue = $this->getFooters($pageBreak);

		if ($this->renderQueue(0)) {
			throw new \Exception('Broken?');
		}
	}

	protected function getHeaders($pageBreak = false) {
		$headers = $this->childRenderers->get(\AndreMe\PHPReportEngine\Elements\Element::POSITION_HEADER);

		if ($pageBreak) {
			$headers = array_filter($headers, function ($renderer) {
				return $renderer->getElement()->getPrintAfterPageBreak();
			});
		}

		return $headers;
	}

	protected function getDetails() {
		return $this->childRenderers->get(\AndreMe\PHPReportEngine\Elements\Element::POSITION_DETAIL);
	}

	protected function getFooters($pageBreak = false) {
		$footers = $this->childRenderers->get(\AndreMe\PHPReportEngine\Elements\Element::POSITION_FOOTER);

		if ($pageBreak) {
			$footers = array_filter($footers, function ($renderer) {
				return $renderer->getElement()->getPrintBeforePageBreak();
			});
		}

		return $footers;
	}

	protected function getFooterHeight() {
		$footerHeight = 0;

		foreach ($this->getFooters() as $renderer) {
			/* @var $renderer Element */
			$footerHeight += $renderer->getHeight();
			/* TODO footers with PrintBeforePageBreak = false should be filtered
			 * here	to maximise page space use, but that leads to problems */
		}

		return $footerHeight;
	}

}