<?php

namespace AndreMe\PHPReportEngine\Renderers;

class Group extends ControlStructure {

	/**
	 *
	 * @var \AndreMe\PHPReportEngine\Elements\Group
	 */
	protected $element;

	private $footerHeight;

	private $riLastValue;
	private $riStage = 'Start';
	private $riHasDetailDataSource;
	/**
	 *
	 * @var  \AndreMe\PHPReportEngine\DataSources\DataSource
	 */
	private $riFilteredDetailDataSource;
	private $riWantsPageBreak = false;

	public function __construct($element, $mainRenderer, $parent) {
		parent::__construct($element, $mainRenderer, $parent);
	}

	static public function canRender($element) {
		return ($element instanceof \AndreMe\PHPReportEngine\Elements\Group);
	}

	protected function doRenderNext($footerHeight) {
		if (($setupResult = $this->setupRenderStage())) {
			return $setupResult;
		}

		$defaultResult = (($this->riHasDetailDataSource or ($this->riStage == 'FirstGroupRecord')) ? MainRenderer::RENDER_STAGE_AGAIN : MainRenderer::RENDER_STAGE_DONE);

		return $this->renderQueue($footerHeight + $this->footerHeight) ?: $defaultResult;
	}

	private function getConditionValue($record) {
		return $record[$this->element->getCondition()];
	}

	private function setupRenderStage() {
		if ($this->riQueue) {
			return;
		}

		switch ($this->riStage) {
			case 'Start':
				$this->footerHeight = $this->getFooterHeight();

				$this->riHasDetailDataSource = !!$this->element->getDataSource();
				// fallthrough here
			case 'StartGroup':
				$masterRecord = $this->element->getRecordFromParent();
				$conditionValue = $this->getConditionValue($masterRecord);

				if ($this->riHasDetailDataSource) {
					$condition = $this->element->getCondition();

					$this->riFilteredDetailDataSource = new \AndreMe\PHPReportEngine\DataSources\DataSourceFilter(
						$this->element->getDataSource(), function ($record) use ($condition, $conditionValue) {
							return $record[$condition] === $conditionValue;
					});

					$detailRecord = $this->riFilteredDetailDataSource->next();

					if ($detailRecord === false) {
						return MainRenderer::RENDER_STAGE_DONE;
					}

					$this->riRecord = $detailRecord;
				} else {
					$this->riRecord = $masterRecord;
				}

				$this->element->setRecord($this->riRecord);
				$this->riPrevRecord = $this->riRecord;

				$this->riLastValue = $conditionValue;

				$this->riStage = 'FirstGroupRecord';
				$this->riQueue = $this->getHeaders();

				$this->dontPrintHeaderFooterOnPageBreak = true;

				if ($this->riWantsPageBreak) {
					$this->riWantsPageBreak = false;
					return MainRenderer::RENDER_STAGE_PAGEBREAK;
				}

				break;
			case 'FirstGroupRecord':
				$this->dontPrintHeaderFooterOnPageBreak = false;
				$this->riStage = 'InGroup';
				$this->riQueue = $this->getDetails();
				break;
			case 'InGroup':
				if ($this->riHasDetailDataSource) {
					$record = $this->riFilteredDetailDataSource->next();
				} else {
					$record = $this->element->getRecordFromParent();
				}

				$this->riPrevRecord = $this->riRecord;
				$this->riRecord = $record;

				$conditionValue = $this->getConditionValue($this->riRecord);

				if ($this->riLastValue !== $conditionValue) {

					if ($this->riRecord === false) {
						$this->riStage = 'End';
					} else {
						$this->riStage = 'StartGroup';
					}

					$this->renderFooters();

					if ($this->element->getPageBreakBetweenGroups()) {

						if ($this->riRecord !== false) {
							return MainRenderer::RENDER_STAGE_PAGEBREAK;
						} else {
							$this->riWantsPageBreak = true;
							return;
						}
					}

					return MainRenderer::RENDER_STAGE_AGAIN;
				}

				$this->element->setRecord($this->riRecord);

				$this->riQueue = $this->getDetails();
				break;
			case 'End':
				$this->riStage = 'StartGroup';
				return MainRenderer::RENDER_STAGE_DONE;
				break;
			default:
				throw new \Exception('Unknown');
		}
	}

}
