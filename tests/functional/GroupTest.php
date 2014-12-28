<?php

namespace AndreMe\PHPReportEngine;

class GroupTest extends \PHPUnit_Framework_TestCase {

	public function testUseParentDataSource() {
		$rb = $this->createTextReport([['Cond' => 1], ['Cond' => 1]]);

		$rb->getReport()->add($group = new Elements\Group('Cond'));

			$group->add($band = new Elements\DetailBand());
				$band->add(new Elements\Text('Detail'));

		$this->assertEquals("Detail\nDetail\n", $rb->render());
	}

	public function testSharedDataSourceParentUsesCorrectRecordForFootersOnAutomaticPageBreaks() {
		$rb = $this->createTextReport([['Cond' => 1], ['Cond' => 2], ['Cond' => 2]], 2);

		$rb->getReport()->add($group = new Elements\Group('Cond'));

			$group->add($band = new Elements\DetailBand());
				$band->add(new Elements\Text('Detail'));

		$rb->getReport()->add($band = new Elements\FooterBand());
			$band->add(new Elements\FieldText('Cond'));

		$this->assertEquals("Detail\n1\n\nDetail\n2\n\nDetail\n2\n", $rb->render());
	}

	public function testSharedDataSourceParentUsesCorrectRecordForFootersOnForcedPageBreaks() {
		$rb = $this->createTextReport([['Cond' => 1], ['Cond' => 2], ['Cond' => 2]]);

		$rb->getReport()->add($group = new Elements\Group('Cond'));
			$group->setPageBreakBetweenGroups(true);

			$group->add($band = new Elements\DetailBand());
				$band->add(new Elements\Text('Detail'));

		$rb->getReport()->add($band = new Elements\FooterBand());
			$band->add(new Elements\FieldText('Cond'));

		$this->assertEquals("Detail\n1\n\nDetail\nDetail\n2\n", $rb->render());
	}

	public function testPageBreakBetweenGroups() {
		$rb = $this->createTextReport([['Cond' => 1], ['Cond' => 2]]);

		$rb->getReport()->add($group = new Elements\Group('Cond'));
			$group->setPageBreakBetweenGroups(true);

			$group->add($band = new Elements\DetailBand());
				$band->add(new Elements\Text('Detail'));

		$this->assertEquals("Detail\n\nDetail\n", $rb->render());
	}

	public function testHeadersAndFootersArePrintedForGroup() {
		$rb = $this->createTextReport([['Cond' => 1], ['Cond' => 2]]);

		$rb->getReport()->add($group = new Elements\Group('Cond'));

			$group->add($band = new Elements\HeaderBand());
				$band->add(new Elements\FieldText('Cond'));

			$group->add($band = new Elements\DetailBand());
				$band->add(new Elements\Text('Detail'));

			$group->add($band = new Elements\FooterBand());
				$band->add(new Elements\FieldText('Cond'));

		$this->assertEquals("1\nDetail\n1\n2\nDetail\n2\n", $rb->render());
	}

	public function testLastSubGroupFooterIsDisplayed() {
		$rb = $this->createTextReport([['Cond' => 1, 'OuterCond' => 2]]);

		$rb->getReport()->add($outerGroup = new Elements\Group('OuterCond'));

		$outerGroup->add($group = new Elements\Group('Cond'));

			$group->add($band = new Elements\FooterBand());
				$band->add(new Elements\Text('InnerGroupFooter'));

		$this->assertEquals("InnerGroupFooter\n", $rb->render());
	}

	public function testDetailDataSource() {
		$rb = $this->createTextReport([['Cond' => 1], ['Cond' => 2]]);

		$detailDS = new DataSources\ArrayDataSource([['Cond' => 2, 'Rec' => 'Rec2'], ['Cond' => 1, 'Rec' => 'Rec1']]);

		$rb->getReport()->add($group = new Elements\Group('Cond', $detailDS));

			$group->add($band = new Elements\DetailBand());
				$band->add(new Elements\FieldText('Rec'));

		$this->assertEquals("Rec1\nRec2\n", $rb->render());
	}

	public function testDetailDataSourceWithMissingValue() {
		$rb = $this->createTextReport([['Cond' => 1], ['Cond' => 2]]);

		$detailDS = new DataSources\ArrayDataSource([['Cond' => 2, 'Rec' => 'Rec2']]);

		$rb->getReport()->add($group = new Elements\Group('Cond', $detailDS));

			$group->add($band = new Elements\DetailBand());
				$band->add(new Elements\FieldText('Rec'));

		$this->assertEquals("Rec2\n", $rb->render());
	}

	public function testHeadersAndFootersArePrintedForGroupDetailDS() {
		$rb = $this->createTextReport([['Cond' => 1], ['Cond' => 2]]);

		$detailDS = new DataSources\ArrayDataSource([['Cond' => 2, 'Rec' => 'Rec2']]);

		$rb->getReport()->add($group = new Elements\Group('Cond', $detailDS));

			$group->add($band = new Elements\HeaderBand());
				$band->add(new Elements\FieldText('Rec'));

			$group->add($band = new Elements\DetailBand());
				$band->add(new Elements\Text('Detail'));

			$group->add($band = new Elements\FooterBand());
				$band->add(new Elements\FieldText('Rec'));

		$this->assertEquals("Rec2\nDetail\nRec2\n", $rb->render());
	}

	public function testDetailDataSourceHeaderFooterOnAutomaticPageBreaks() {
		$rb = $this->createTextReport([['Cond' => 1], ['Cond' => 2]], 3);

		$detailDS = new DataSources\ArrayDataSource([
			['Cond' => 2, 'Rec' => 'Rec2'],
			['Cond' => 2, 'Rec' => 'Rec3'],
			['Cond' => 1, 'Rec' => 'Rec1'],
		]);

		$rb->getReport()->add($group = new Elements\Group('Cond', $detailDS));

			$group->add($band = new Elements\HeaderBand());
				$band->add(new Elements\FieldText('Rec'));

			$group->add($band = new Elements\DetailBand());
				$band->add(new Elements\Text('Detail'));

			$group->add($band = new Elements\FooterBand());
				$band->add(new Elements\FieldText('Rec'));

		$this->assertEquals("Rec1\nDetail\nRec1\n\nRec2\nDetail\nRec2\n\nRec3\nDetail\nRec3\n", $rb->render());
	}

	public function testDetailDataSourceHeaderFooterOnForcedPageBreaks() {
		$rb = $this->createTextReport([['Cond' => 1], ['Cond' => 2]]);

		$detailDS = new DataSources\ArrayDataSource([
			['Cond' => 2, 'Rec' => 'Rec2'],
			['Cond' => 2, 'Rec' => 'Rec3'],
			['Cond' => 1, 'Rec' => 'Rec1'],
		]);

		$rb->getReport()->add($group = new Elements\Group('Cond', $detailDS));
			$group->setPageBreakBetweenGroups(true);

			$group->add($band = new Elements\HeaderBand());
				$band->add(new Elements\FieldText('Rec'));

			$group->add($band = new Elements\DetailBand());
				$band->add(new Elements\Text('Detail'));

			$group->add($band = new Elements\FooterBand());
				$band->add(new Elements\FieldText('Rec'));

		$this->assertEquals("Rec1\nDetail\nRec1\n\nRec2\nDetail\nDetail\nRec3\n", $rb->render());
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
