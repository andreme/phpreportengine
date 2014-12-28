<?php

namespace AndreMe\PHPReportEngine\Renderers;

class Report extends ControlStructure {

	/**
	 *
	 * @var \AndreMe\PHPReportEngine\Elements\Report
	 */
	protected $element;

	private $riDataSource;
	private $riStage = 'Start';

	private $footerHeight;

	static public function canRender($element) {
		return ($element instanceof \AndreMe\PHPReportEngine\Elements\Report);
	}

	protected function doRenderNext($footerHeight) {
		if (($setupResult = $this->setupRenderStage())) {
			return $setupResult;
		}

		return $this->renderQueue($footerHeight + $this->footerHeight) ?: MainRenderer::RENDER_STAGE_NEXT;
	}

	private function setupRenderStage() {
		if ($this->riQueue) {
			return;
		}

		switch ($this->riStage) {
			case 'Start':
				return $this->renderStart();
				break;
			case 'Details':
				$this->riPrevRecord = $this->riRecord;
				$this->riRecord = $this->riDataSource->next();

				if ($this->riRecord === false) {
					$this->riStage = 'Finished';
				}

				$this->element->setRecord($this->riRecord);

				$this->riQueue = $this->getDetails();

				break;
			case 'Finished':
				return $this->renderFinish();
			default:
				throw new \Exception('Unknown');
		}
	}

	protected function renderStart() {
		$this->riDataSource = $this->element->getDataSource();

		$this->riRecord = $this->riDataSource->next();

		if ($this->riRecord === false) {
			return MainRenderer::RENDER_STAGE_DONE;
		}

		$this->riPrevRecord = $this->riRecord;

		$this->element->setRecord($this->riRecord);

		$this->riStage = 'Details';
		$this->riQueue = array_merge(
			$this->getHeaders(),
			$this->getDetails()
		);

		$this->footerHeight = $this->getFooterHeight();
	}

	protected function renderFinish() {
		$this->element->setRecord($this->riPrevRecord);

		$this->renderFooters();

		return MainRenderer::RENDER_STAGE_DONE;
	}

}
