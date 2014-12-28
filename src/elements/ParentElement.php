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

	public function getChildElements($stopOnClass = null) {
		$result = $this->getElements();

		foreach ($this->getElements() as $element) {
			if ($stopOnClass and ($element instanceof $stopOnClass)) {
				continue;
			}

			if (($element instanceof ParentElement)) {
				$result = array_merge($result, $element->getChildElements());
			}
		}

		return $result;
	}

}
