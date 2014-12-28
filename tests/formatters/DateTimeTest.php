<?php

namespace AndreMe\PHPReportEngine\Formatters;

class DateTimeTest extends \PHPUnit_Framework_TestCase {

	public function testFormatValueDefaultFormat() {

		$formatter = new DateTime();

		$result = $formatter->formatValue('2013-10-23');

		$this->assertEquals('2013-10-23', $result);
	}

	public function testFormatValueWithSetFormat() {

		$formatter = new DateTime('d/m/y');

		$result = $formatter->formatValue('2013-10-23');

		$this->assertEquals('23/10/13', $result);
	}

}
