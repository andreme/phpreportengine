<?php

namespace AndreMe\PHPReportEngine\Elements;

class Text extends Element {

	private $text;

	private $preText;
	private $preTextRequiresValue = false;

	private $postText;

	/**
	 *
	 * @var \AndreMe\PHPReportEngine\IFormatter
	 */
	private $formatter;

	public function __construct($text = null) {
		parent::__construct();

		$this->text = $text;
	}

	public function getText() {
		return $this->text;
	}

	public function setText($text) {
		$this->text = $text;
	}

	public function getPreText() {
		return $this->preText;
	}

	public function setPreText($preText, $requiresValue = false) {
		$this->preText = $preText;
		$this->preTextRequiresValue = $requiresValue;
	}

	public function getPreTextRequiresValue() {
		return $this->preTextRequiresValue;
	}

	public function getValue() {
		return $this->text;
	}

	/**
	 *
	 * @return \AndreMe\PHPReportEngine\IFormatter
	 */
	public function getFormatter() {
		return $this->formatter;
	}

	public function setFormatter($formatter) {
		$this->formatter = $formatter;
	}

	public function getPostText() {
		return $this->postText;
	}

	public function setPostText($postText) {
		$this->postText = $postText;
	}

}
