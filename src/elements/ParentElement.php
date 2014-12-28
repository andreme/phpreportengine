<?php

namespace AndreMe\PHPReportEngine\Elements;

class ParentElement extends Element {

	private $elements = [];

	/**
	 *
	 * @param Element $element
	 */
	public function add($element) {
		$this->elements[] = $element;

		$element->setParent($this);

		return $element;
	}

	public function getElements() {
		return $this->elements;
	}

}
