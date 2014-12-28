<?php

namespace AndreMe\PHPReportEngine;

class ControlStructureTest extends \PHPUnit_Framework_TestCase {

	public function testNoRecordReport() {
		$rb = $this->createTextReport([]);

		$rb->getReport()->add($band = new Elements\DetailBand());
			$band->add(new Elements\Text('Record'));

		$this->assertEquals("", $rb->render());
	}

	public function testOneRecordReport() {
		$rb = $this->createTextReport([[]]);

		$rb->getReport()->add($band = new Elements\DetailBand());
			$band->add(new Elements\Text('Record'));

		$this->assertEquals("Record\n", $rb->render());
	}

	public function testTwoRecordReport() {
		$rb = $this->createTextReport([[], []]);

		$rb->getReport()->add($band = new Elements\DetailBand());
			$band->add(new Elements\Text('Record'));

		$this->assertEquals("Record\nRecord\n", $rb->render());
	}

	public function testSubReports() {
		$rb = $this->createTextReport();

		$rb->getReport()->add($subRep = new Elements\Report());
			$subRep->setDataSource(new DataSources\ArrayDataSource([[]]));

			$subRep->add($band = new Elements\DetailBand());
				$band->add(new Elements\Text('Report1'));

		$rb->getReport()->add($subRep = new Elements\Report());
			$subRep->setDataSource(new DataSources\ArrayDataSource([[]]));

			$subRep->add($band = new Elements\DetailBand());
				$band->add(new Elements\Text('Report2'));

		$this->assertEquals("Report1\nReport2\n", $rb->render());
	}

	/* ********************************************************************** */

	/**
	 *
	 * @return \AndreMe\PHPReportEngine\ReportBuilder
	 */
	private function createTextReport($data = null) {
		$rb = new ReportBuilder();
		$rb->setRenderer(new Renderers\Text\TextRenderer());

		if ($data !== null) {
			$rb->setDataSource(new DataSources\ArrayDataSource($data));
		}

		return $rb;
	}

}
