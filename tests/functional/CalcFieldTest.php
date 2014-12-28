<?php

namespace AndreMe\PHPReportEngine;

class CalcFieldTest extends \PHPUnit_Framework_TestCase {

	public function testSumCalcFieldWithOneRecord() {
		$rb = $this->createTextReport([['A' => 1.25]]);

		$rb->getReport()->add($band = new Elements\FooterBand());
			$band->add(new Elements\CalcField('A'));

		$this->assertEquals("1.25\n", $rb->render());
	}

	public function testSumCalcFieldWithTwoRecords() {
		$rb = $this->createTextReport([['A' => 1.61], ['A' => 1.50]]);

		$rb->getReport()->add($band = new Elements\FooterBand());
			$band->add(new Elements\CalcField('A'));

		$this->assertEquals("3.11\n", $rb->render());
	}

	public function testCountCalcFieldWithOneRecord() {
		$rb = $this->createTextReport([[]]);

		$rb->getReport()->add($band = new Elements\FooterBand());
			$band->add(new Elements\CalcField(null, null, Elements\CalcField::TYPE_COUNT));

		$this->assertEquals("1\n", $rb->render());
	}

	public function testCountCalcFieldWithTwoRecords() {
		$rb = $this->createTextReport([[], []]);

		$rb->getReport()->add($band = new Elements\FooterBand());
			$band->add(new Elements\CalcField(null, null, Elements\CalcField::TYPE_COUNT));

		$this->assertEquals("2\n", $rb->render());
	}

	public function testCalcFieldsAreResetBeforeGroup() {
		$rb = $this->createTextReport([['Cond' => 1], ['Cond' => 2], ['Cond' => 2]]);

		$rb->getReport()->add($group = new Elements\Group('Cond'));

			$group->add($band = new Elements\FooterBand());
				$band->add(new Elements\CalcField('Cond'));

		$this->assertEquals("1\n4\n", $rb->render());
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
