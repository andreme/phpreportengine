<?php

namespace AndreMe\PHPReportEngine\Renderers;

class SystemText extends Text {

	/**
	 *
	 * @var \AndreMe\PHPReportEngine\Elements\SystemText
	 */
	protected $element;

	private $pageNo = 0;

	private $totalPagesPlaceHolderText;

	private $printTime;

	static public function canRender($element) {
		return ($element instanceof \AndreMe\PHPReportEngine\Elements\SystemText);
	}

	public function __construct($element, $mainRenderer, $parent) {
		parent::__construct($element, $mainRenderer, $parent);
	}

	protected function getTextValue() {
		switch ($this->element->getType()) {
			case \AndreMe\PHPReportEngine\Elements\SystemText::TYPE_PAGENO:
				return 'Page '.++$this->pageNo;
			case \AndreMe\PHPReportEngine\Elements\SystemText::TYPE_PAGENOOFPAGES:
				return 'Page '.++$this->pageNo.' of '.$this->getTotalPagePlaceHolderText();
			case \AndreMe\PHPReportEngine\Elements\SystemText::TYPE_PRINTTIME:
				return $this->printTime ?: $this->printTime = date('Y-m-d H:i:s');
			default:
				throw new \Exception('Unknown SystemText type: '.$this->element->getType());
		}
	}

	private function getTotalPagePlaceHolderText() {
		return $this->totalPagesPlaceHolderText ?: $this->totalPagesPlaceHolderText = '{'.mt_rand(0, mt_getrandmax()).'#'.mt_rand(0, mt_getrandmax()).'}';
	}

	public function event($event) {
		parent::event($event);

		if (($event == Element::EVENT_REPORT_FINISHED) and $this->totalPagesPlaceHolderText) {
			$this->mainRenderer->replaceInOutput($this->totalPagesPlaceHolderText, $this->pageNo);
		}
	}

}
