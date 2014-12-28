<?php

namespace AndreMe\PHPReportEngine\Renderers;

class Text extends Element {

	/**
	 *
	 * @var \AndreMe\PHPReportEngine\Elements\Text
	 */
	protected $element;

	/**
	 *
	 * @var \AndreMe\PHPReportEngine\IFormatter
	 */
	private $formatter;

	static public function canRender($element) {
		return ($element instanceof \AndreMe\PHPReportEngine\Elements\Text);
	}

	public function __construct($element, $mainRenderer, $parent) {
		parent::__construct($element, $mainRenderer, $parent);

		$this->formatter = $this->element->getFormatter();
	}

	protected function doRenderNext($footerHeight) {
		$this->mainRenderer->write($this->getText());
	}

	protected function getText() {
		$result = null;
		$textValue = $this->getTextValue();
		if ($this->formatter) {
			$textValue = $this->formatter->formatValue($textValue);
		}

		if (!$this->element->getPreTextRequiresValue() or (($textValue !== null) and ($textValue !== ''))) {
			$result .= $this->element->getPreText();
		}

		$result .= $textValue;

		if ($textValue) {
			$result .= $this->element->getPostText();
		}

		return $result;
	}

	protected function getTextValue() {
		return $this->element->getValue();
	}

}
