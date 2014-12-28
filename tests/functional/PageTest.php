<?php

namespace AndreMe\PHPReportEngine;

class PageTest extends \PHPUnit_Framework_TestCase {

	public function testBreakBetween2Pages() {
		$rb = $this->createTextReport([[], []], 1);

		$rb->getReport()->add($band = new Elements\DetailBand());
			$band->add(new Elements\Text('foo'));

		$this->assertEquals("foo\n\nfoo\n", $rb->render());
	}

	/* ********************************************************************** */

	/**
	 *
	 * @return \AndreMe\PHPReportEngine\ReportBuilder
	 */
	private function createTextReport($data = null, $pageHeight = null) {
		$rb = new ReportBuilder();
		$rb->setRenderer(new Renderers\Text\TextRenderer($pageHeight));

		if ($data !== null) {
			$rb->setDataSource(new DataSources\ArrayDataSource($data));
		}

		return $rb;
	}

}
