<?php

namespace AndreMe\PHPReportEngine\Elements;

class Element {

	const POSITION_NORMAL = 1;
	const POSITION_HEADER = 2;
	const POSITION_DETAIL = 3;
	const POSITION_FOOTER = 4;

	/**
	 *
	 * @var \AndreMe\PHPReportEngine\IRecordProvider
	 */
	private $recordProvider;

	/**
	 *
	 * @var Element
	 */
	protected $parent;

	/**
	 *
	 * @var \AndreMe\PHPReportEngine\Style
	 */
	private $style;

	public function __construct() {
		$this->initStyle();
	}

	protected function initStyle() {
		$this->style = new \AndreMe\PHPReportEngine\Style();
	}

	public function getParent() {
		return $this->parent;
	}

	public function setParent($parent) {
		$this->parent = $parent;
	}

	public function getStyle() {
		return $this->style;
	}

	public function setStyle() {
		$args = func_get_args();
		call_user_func_array([$this->style, 'set'], $args);
	}

	public function getPosition() {
		return self::POSITION_NORMAL;
	}

	public function getRecordFromParent() {
		if (!$this->recordProvider) {
			$el = $this->getParent();

			while (!($el instanceof \AndreMe\PHPReportEngine\IRecordProvider)) {
				$el = $el->getParent();
			}

			$this->recordProvider = $el;
		}

		return $this->recordProvider->getRecord();
	}

}
