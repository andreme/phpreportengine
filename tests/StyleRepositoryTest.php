<?php

namespace AndreMe\PHPReportEngine;

class StyleRepositoryTest extends \PHPUnit_Framework_TestCase {

	protected function setUp() {
		parent::setUp();

		StyleRepository::$repo = new StyleRepository();
	}

	public function testCanRetrieveStyle() {
		StyleRepository::$repo->add('Test');

		$this->assertNotNull(StyleRepository::$repo->get('Test'));
	}

	public function testCanAddStyleObject() {
		$style = new Style('height', '20px');
		StyleRepository::$repo->add('Test', $style);

		$this->assertEquals($style, StyleRepository::$repo->get('Test'));
	}

	public function testCanNotAddStyleWithSameNameTwice() {
		StyleRepository::$repo->add('Test');

		$this->setExpectedException('Exception', 'A style with the name Test already exists.');

		StyleRepository::$repo->add('Test');
	}

}
