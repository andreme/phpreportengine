<?php

namespace AndreMe\PHPReportEngine;

class BandTest extends \PHPUnit_Framework_TestCase {

	public function testNoPageHeaderForEmptyReport() {
		$rb = $this->createTextReport([]);

		$testText = 'foo';

		$rb->getReport()->add($band = new Elements\HeaderBand());
			$band->add(new Elements\Text($testText));

		$this->assertEquals("", $rb->render());
	}

	public function testOnePageHeaderForOneRecordReport() {
		$rb = $this->createTextReport([[]]);

		$testText = 'Header';

		$rb->getReport()->add($band = new Elements\HeaderBand());
			$band->add(new Elements\Text($testText));

		$this->assertEquals("$testText\n", $rb->render());
	}

	public function testOnePageHeaderForTwoRecordReport() {
		$rb = $this->createTextReport([[], []]);

		$testText = 'Header';

		$rb->getReport()->add($band = new Elements\HeaderBand());
			$band->add(new Elements\Text($testText));

		$this->assertEquals("$testText\n", $rb->render());
	}

	public function testNoPageFooterForEmptyReport() {
		$rb = $this->createTextReport([]);

		$rb->getReport()->add($band = new Elements\FooterBand());
			$band->add(new Elements\Text('foo'));

		$this->assertEquals("", $rb->render());
	}

	public function testOnePageFooterForOneRecordReport() {
		$rb = $this->createTextReport([[]]);

		$rb->getReport()->add($band = new Elements\FooterBand());
			$band->add(new Elements\Text('Footer'));

		$this->assertEquals("Footer\n", $rb->render());
	}

	public function testOnePageFooterForTwoRecordReport() {
		$rb = $this->createTextReport([[], []]);

		$testText = 'Footer';

		$rb->getReport()->add($band = new Elements\FooterBand());
			$band->add(new Elements\Text($testText));

		$this->assertEquals("$testText\n", $rb->render());
	}

	public function testPageHeaderAndFooterOnEachPage() {
		$rb = $this->createTextReport([[], []], 3);

		$rb->getReport()->add($band = new Elements\HeaderBand());
			$band->add(new Elements\Text('Header'));

		$rb->getReport()->add($band = new Elements\DetailBand());
			$band->add(new Elements\Text('Detail'));

		$rb->getReport()->add($band = new Elements\FooterBand());
			$band->add(new Elements\Text('Footer'));

		$this->assertEquals("Header\nDetail\nFooter\n\nHeader\nDetail\nFooter\n", $rb->render());
	}

	public function testPageHeaderDoesntPrintAfterPageBreakIfRequested() {
		$rb = $this->createTextReport([[], []], 2);

		$rb->getReport()->add($band = new Elements\HeaderBand());
			$band->setPrintAfterPageBreak(false);
			$band->add(new Elements\Text('Header'));

		$rb->getReport()->add($band = new Elements\DetailBand());
			$band->add(new Elements\Text('Detail'));

		$this->assertEquals("Header\nDetail\n\nDetail\n", $rb->render());
	}

	public function testGroupHeaderDoesntPrintAfterPageBreakIfRequested() {
		$rb = $this->createTextReport([['a' => 1], ['a' => 1]], 2);

		$rb->getReport()->add($group = new Elements\Group('a'));
			$group->add($band = new Elements\HeaderBand());
				$band->setPrintAfterPageBreak(false);
				$band->add(new Elements\Text('Header'));

			$group->add($band = new Elements\DetailBand());
				$band->add(new Elements\Text('Detail'));


		$this->assertEquals("Header\nDetail\n\nDetail\n", $rb->render());
	}

	public function testPageFooterDoesntPrintBeforePageBreakIfRequested() {
		$rb = $this->createTextReport([[], []], 2);

		$rb->getReport()->add($band = new Elements\DetailBand());
			$band->add(new Elements\Text('Detail'));

		$rb->getReport()->add($band = new Elements\FooterBand());
			$band->setPrintBeforePageBreak(false);
			$band->add(new Elements\Text('Footer'));

		/* TODO currently space is wasted because the page break happens even if the footer does not get printed */
		$this->assertEquals("Detail\n\nDetail\nFooter\n", $rb->render());
	}

	public function testGroupFooterDoesntPrintBeforePageBreakIfRequested() {
		$rb = $this->createTextReport([['a' => 1], ['a' => 1]], 2);

		$rb->getReport()->add($group = new Elements\Group('a'));
			$group->add($band = new Elements\DetailBand());
				$band->add(new Elements\Text('Detail'));

			$group->add($band = new Elements\FooterBand());
				$band->setPrintBeforePageBreak(false);
				$band->add(new Elements\Text('Footer'));

		/* TODO currently space is wasted because the page break happens even if the footer does not get printed */
		$this->assertEquals("Detail\n\nDetail\nFooter\n", $rb->render());
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
