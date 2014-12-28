<?php

namespace AndreMe\PHPReportEngine;

class HTMLRendererTest extends \PHPUnit_Framework_TestCase {

	const TestImageBase64 = 'iVBORw0KGgoAAAANSUhEUgAAAAQAAAAECAIAAAAmkwkpAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAAZSURBVBhXY2BgYPgPBkAGlAXlQyh0SaAqAKS5I92QiZPKAAAAAElFTkSuQmCC';

	public function testNoRecordReport() {
		$rb = $this->createHTMLReport([]);

		$rb->getReport()->add($band = new Elements\TableDetailBand());

		$this->assertEquals('<table class="Report"></table>', $rb->render());
	}

	public function testOneRecordReport() {
		$rb = $this->createHTMLReport([[]]);

		$rb->getReport()->add($band = new Elements\TableDetailBand());

		$this->assertEquals('<table class="Report"><tr></tr></table>', $rb->render());
	}

	public function testBreakBetween2Pages() {
		$rb = $this->createHTMLReport([[], []], 1);

		$rb->getReport()->add($band = new Elements\TableDetailBand());

		$this->assertEquals('<table class="Report"><tr></tr><tr class="PageBreak"></tr><tr></tr></table>', $rb->render());
	}

	public function testTextElementWithoutStyle() {
		$rb = $this->createHTMLReport([[]]);

		$rb->getReport()->add($band = new Elements\TableDetailBand());
			$band->add(new Elements\Text('Unstyled'));

		$this->assertContains('<td>Unstyled</td>', $rb->render());
	}

	public function testTextElementWithStyle() {
		$rb = $this->createHTMLReport([[]]);

		$rb->getReport()->add($band = new Elements\TableDetailBand());
			$band->add($text = new Elements\Text('Styled'));
				$text->setStyle('font-weight', 'bold');

		$this->assertContains('<td><span style="font-weight:bold;">Styled</span></td>', $rb->render());
	}

	public function testStyleOnTableCell() {
		$rb = $this->createHTMLReport([[]]);

		$rb->getReport()->add($band = new Elements\TableDetailBand());
			$cell = $band->add(new Elements\Text('Styled'));
				$cell->setStyle('text-align', 'right');

		$this->assertContains('<td style="text-align:right;">Styled</td>', $rb->render());
	}

	public function testTableCellColSpan() {
		$rb = $this->createHTMLReport([[]]);

		$rb->getReport()->add($band = new Elements\TableDetailBand());
			$cell = $band->add(new Elements\Text('Text'));
				$cell->setColSpan(2);

		$this->assertContains('<td colspan="2">Text</td>', $rb->render());
	}

	public function testStyleCanBeAddedToTableBandAdd() {
		$rb = $this->createHTMLReport([[]]);

		$cellStyle = new Style('text-align', 'center');

		$rb->getReport()->add($band = new Elements\TableDetailBand());
			$band->add(new Elements\Text('Styled'), $cellStyle);

		$this->assertContains('<td style="text-align:center;">Styled</td>', $rb->render());
	}

	public function testSystemTextElementWithStyle() {
		$rb = $this->createHTMLReport([[]]);

		$rb->getReport()->add($band = new Elements\TableDetailBand());
			$band->add($text = new Elements\SystemText(Elements\SystemText::TYPE_PAGENO));
				$text->setStyle('font-weight', 'bold');

		$this->assertContains('<span style="font-weight:bold;">Page 1</span>', $rb->render());
	}

	public function testFieldTextElementWithStyle() {
		$rb = $this->createHTMLReport([['c' => 2]]);

		$rb->getReport()->add($band = new Elements\TableDetailBand());
			$band->add($field = new Elements\FieldText('c'));
				$field->setStyle('font-weight', 'bold');

		$this->assertContains('<span style="font-weight:bold;">2</span>', $rb->render());
	}

	public function testOnlySharedAndCSSStyleIsApplied() {
		$rb = $this->createHTMLReport();

		$rb->getReport()->add($band = new Elements\TableDetailBand());
			$band->add($field = new Elements\Text('A'));
				$field->setStyle('font-weight', 'bold');
				$field->setStyle('css', 'background-color', '#000000');
				$field->setStyle('pdf', 'color', '#ffffff');

		$this->assertContains('<span style="font-weight:bold;background-color:#000000;">A</span>', $rb->render());
	}

	public function testTableHeaderBand() {
		$rb = $this->createHTMLReport([[], []]);

		$rb->getReport()->add($band = new Elements\TableHeaderBand());
			$band->add($field = new Elements\Text('Header'));
		$rb->getReport()->add($band = new Elements\TableDetailBand());

		$this->assertEquals('<table class="Report"><tr><td>Header</td></tr><tr></tr><tr></tr></table>', $rb->render());
	}

	public function testTableFooterBand() {
		$rb = $this->createHTMLReport([[], []]);

		$rb->getReport()->add($band = new Elements\TableDetailBand());
		$rb->getReport()->add($band = new Elements\TableFooterBand());
			$band->add($field = new Elements\Text('Footer'));

		$this->assertEquals('<table class="Report"><tr></tr><tr></tr><tr><td>Footer</td></tr></table>', $rb->render());
	}

	public function testImageFromFileHandle() {
		$rb = $this->createHTMLReport([[]]);

		$handle = fopen("data:text/plain;base64,".self::TestImageBase64, 'r');

		$rb->getReport()->add($band = new Elements\TableDetailBand());
			$band->add($field = new Elements\Image($handle));

		$this->assertContains('<td><img src="data:base64,'.self::TestImageBase64.'" /></td>', $rb->render());
	}

	public function testImageFromFileName() {
		$rb = $this->createHTMLReport([[]]);

		$fileName = "data:text/plain;base64,".self::TestImageBase64;

		$rb->getReport()->add($band = new Elements\TableDetailBand());
			$band->add($image = new Elements\Image($fileName));

		$this->assertContains('<td><img src="data:base64,'.self::TestImageBase64.'" /></td>', $rb->render());
	}

	public function testImageFromURL() {
		$rb = $this->createHTMLReport([[]]);

		$fileName = "data:text/plain;base64,".self::TestImageBase64;

		$rb->getReport()->add($band = new Elements\TableDetailBand());
			$band->add($image = new Elements\Image($fileName, 'x/test.png'));

		$this->assertContains('<td><img src="x/test.png" /></td>', $rb->render());
	}

	public function testImageWithStyle() {
		$rb = $this->createHTMLReport([[]]);

		$fileName = "data:text/plain;base64,".self::TestImageBase64;

		$rb->getReport()->add($band = new Elements\TableDetailBand());
			$band->add($image = new Elements\Image($fileName));
				$image->setStyle('css', 'width', '20px');

		$this->assertContains('<td><img src="data:base64,'.self::TestImageBase64.'" style="width:20px;" /></td>', $rb->render());
	}

	public function testBandWithStyle() {
		$rb = $this->createHTMLReport([[]]);

		$rb->getReport()->add($band = new Elements\TableDetailBand());
			$band->add($image = new Elements\Text('Text'));
			$band->setStyle('text-weight', 'bold');

		$this->assertContains('<tr style="text-weight:bold;"><td>Text</td></tr>', $rb->render());
	}

	public function testTableHeaderBandDoesntPrintAfterPageBreakIfRequested() {
		$rb = $this->createHTMLReport([[], []], 2);

		$rb->getReport()->add($band = new Elements\TableHeaderBand());
			$band->setPrintAfterPageBreak(false);
			$band->add(new Elements\Text('Header'));

		$rb->getReport()->add($band = new Elements\TableDetailBand());
			$band->add(new Elements\Text('Detail'));

		$this->assertContains("<tr><td>Header</td></tr><tr><td>Detail</td></tr><tr class=\"PageBreak\"></tr><tr><td>Detail</td></tr>", $rb->render());
	}

	public function testTableFooterBandDoesntPrintBeforePageBreakIfRequested() {
		$rb = $this->createHTMLReport([[], []], 2);

		$rb->getReport()->add($band = new Elements\TableDetailBand());
			$band->add(new Elements\Text('Detail'));

		$rb->getReport()->add($band = new Elements\TableFooterBand());
			$band->setPrintBeforePageBreak(false);
			$band->add(new Elements\Text('Footer'));

		$this->assertContains("<tr><td>Detail</td></tr><tr class=\"PageBreak\"></tr><tr><td>Detail</td></tr><tr><td>Footer</td></tr>", $rb->render());
	}

	public function testNormalBandIsAutomaticallyWrappedInCell() {
		$rb = $this->createHTMLReport([[]]);

		$rb->getReport()->add($band = new Elements\DetailBand());
			$band->add($field = new Elements\Text('Detail'));

		$this->assertEquals('<table class="Report"><tr><td colspan="99">Detail</td></tr></table>', $rb->render());
	}

	/* ********************************************************************** */

	/**
	 *
	 * @return \AndreMe\PHPReportEngine\ReportBuilder
	 */
	private function createHTMLReport($data = null, $pageHeight = null) {
		$rb = new ReportBuilder();
		$rb->setRenderer(new Renderers\HTML\HTMLRenderer($pageHeight));

		if ($data !== null) {
			$rb->setDataSource(new DataSources\ArrayDataSource($data));
		}

		return $rb;
	}

}
