<?php

namespace AndreMe\PHPReportEngine\Renderers;

class MainRenderer {

	const RENDER_STAGE_DONE = 1;
	const RENDER_STAGE_NEXT = 2;
	const RENDER_STAGE_PAGEBREAK = 3;
	const RENDER_STAGE_AGAIN = 4;

	/**
	 *
	 * @var \AndreMe\PHPReportEngine\Elements\Report
	 */
	private $report;

	private $rendererClasses = [];

	/**
	 *
	 * @var \AndreMe\PHPReportEngine\Output
	 */
	private $output;

	private $pageHeight;

	private $pageSpaceLeft;

	public function __construct($pageHeight = null) {
		$this->pageHeight = $pageHeight;

		$this->pageSpaceLeft = $this->pageHeight;
	}

	public function setReport($report) {
		$this->report = $report;
	}

	public function render() {
		$reportRenderer = $this->createRenderer($this->report, null);
		$reportRenderer->init();

		$this->startReport();

		while (true) {
			switch ($reportRenderer->renderNext(0)) {
				case self::RENDER_STAGE_NEXT:
					continue;
				case self::RENDER_STAGE_DONE:
					break 2;
				case self::RENDER_STAGE_PAGEBREAK:
					$this->addPageBreak();
					continue;
				default:
					throw new \Exception('Unexpected');
			}
		}

		$reportRenderer->event(Element::EVENT_REPORT_FINISHED);

		$this->endReport();
	}

	public function loadRendererClasses() {
		$this->addRendererClass(__NAMESPACE__.'\Report');
		$this->addRendererClass(__NAMESPACE__.'\Group');
		$this->addRendererClass(__NAMESPACE__.'\Band');
		$this->addRendererClass(__NAMESPACE__.'\Text');
		$this->addRendererClass(__NAMESPACE__.'\SystemText');
	}

	protected function addRendererClass($class) {
		array_unshift($this->rendererClasses, $class);
	}

	/**
	 *
	 * @param \AndreMe\PHPReportEngine\Elements\Element $element
	 * @param Element $parent
	 * @return Element
	 */
	public function createRenderer($element, $parent) {
		foreach ($this->rendererClasses as $rendererClass) {
			if ($rendererClass::canRender($element)) {
				return new $rendererClass($element, $this, $parent);
			}
		}

		throw new \Exception('No renderer found for '.get_class($element));
	}

	public function setOutput($output) {
		$this->output = $output;
	}

	public function write($data) {
		$this->output->write($data);
	}

	public function addPageSpaceUsed($used) {
		if ($this->pageHeight !== null) {
			$this->pageSpaceLeft -= $used;
		}
	}

	public function getPageSpaceLeft() {
		return $this->pageHeight === null ? 2147483647 : $this->pageSpaceLeft;
	}

	public function addPageBreak() {
		$this->pageSpaceLeft = $this->pageHeight;
	}

	public function replaceInOutput($search, $replace) {
		$this->output->replace($search, $replace);
	}

	protected function startReport() {
	}

	protected function endReport() {
	}

}
