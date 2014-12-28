<?php

namespace AndreMe\PHPReportEngine;

class StyleTest extends \PHPUnit_Framework_TestCase {

	public function testGetCSSReturnsSharedAndCSSStyles() {
		$style = new Style();
		$style->set('font-weight', 'bold', 'css', 'background-color', '#000000', 'pdf', 'color', '#ffffff');

		$this->assertEquals('font-weight:bold;background-color:#000000;', $style->getCSS());
	}

	public function testConstructorAcceptsStyles() {
		$style = new Style('css', 'background-color', '#000000');

		$this->assertEquals('background-color:#000000;', $style->getCSS());
	}

	public function testSetCopiesAttributesFromAnotherStyle() {
		$style = new Style('css', 'background-color', '#000000');

		$style->set(new Style('color', 'red'));

		$this->assertEquals('color:red;background-color:#000000;', $style->getCSS());
	}

	public function testCanUseStylesFromRepository() {
		StyleRepository::$repo = new StyleRepository();
		StyleRepository::$repo->add('RowHeight', 'height', 6);

		$style = new Style('RowHeight', 'css', 'background-color', '#000000');

		$this->assertEquals('height:6;background-color:#000000;', $style->getCSS());
	}

}
