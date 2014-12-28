<?php

namespace AndreMe\PHPReportEngine;

class TextTest extends \PHPUnit_Framework_TestCase {

	public function testTextElement() {
		$rb = $this->createTextReport();

		$rb->getReport()->add($band = new Elements\DetailBand());
			$band->add(new Elements\Text('Text'));

		$this->assertEquals("Text\n", $rb->render());
	}

	public function testTextElementWithPreText() {
		$rb = $this->createTextReport();

		$rb->getReport()->add($band = new Elements\DetailBand());
			$band->add($text = new Elements\Text('Text'));
				$text->setPreText('Pre: ');
			$band->add($text = new Elements\Text(''));
				$text->setPreText('Pre: ', true);

		$this->assertEquals("Pre: Text\n", $rb->render());
	}

	public function testTextElementWithPostText() {
		$rb = $this->createTextReport();

		$rb->getReport()->add($band = new Elements\DetailBand());
			$band->add($text = new Elements\Text('Text'));
				$text->setPostText(' Post');
			$band->add($text = new Elements\Text(''));
				$text->setPostText(' Post');

		$this->assertEquals("Text Post\n", $rb->render());
	}

	public function testFieldTextElement() {
		$rb = $this->createTextReport([['Test' => 'Text']]);

		$rb->getReport()->add($band = new Elements\DetailBand());
			$band->add(new Elements\FieldText('Test'));

		$this->assertEquals("Text\n", $rb->render());
	}

	public function testFieldTextElementWithClosure() {
		$rb = $this->createTextReport([['Test' => 'Text']]);

		$rb->getReport()->add($band = new Elements\DetailBand());
			$band->add(new Elements\FieldText(function ($context) {
				return $context->Record['Test'].'A';
			}));

		$this->assertEquals("TextA\n", $rb->render());
	}

	public function testFieldTextElementWithPreText() {
		$rb = $this->createTextReport([['Test' => 'Text', 'Empty' => null]]);

		$rb->getReport()->add($band = new Elements\DetailBand());
			$band->add($text = new Elements\FieldText('Test'));
				$text->setPreText('Pre: ');
			$band->add($text = new Elements\FieldText('Empty'));
				$text->setPreText('Pre: ', true);

		$this->assertEquals("Pre: Text\n", $rb->render());
	}

	public function testFieldTextElementWithPostText() {
		$rb = $this->createTextReport([['Test' => 'Text', 'Empty' => null]]);

		$rb->getReport()->add($band = new Elements\DetailBand());
			$band->add($text = new Elements\FieldText('Test'));
				$text->setPostText(' Post');
			$band->add($text = new Elements\FieldText('Empty'));
				$text->setPostText(' Post');

		$this->assertEquals("Text Post\n", $rb->render());
	}

	public function testFieldTextElementWithDateFormatter() {
		$rb = $this->createTextReport([['Value' => '2013-10-23']]);

		$rb->getReport()->add($band = new Elements\DetailBand());
			$band->add($text = new Elements\FieldText('Value'));
				$text->setFormatter(new Formatters\DateTime('d-m-Y'));

		$this->assertEquals("23-10-2013\n", $rb->render());
	}

	public function testFieldTextElementWithCurrencyFormatter() {
		$rb = $this->createTextReport([['Value' => '9999.123']]);

		$rb->getReport()->add($band = new Elements\DetailBand());
			$band->add($text = new Elements\FieldText('Value'));
				$text->setFormatter(new Formatters\Currency());

		$this->assertEquals("9,999.12\n", $rb->render());
	}

	public function testFieldTextElementAcceptsFormatterInConstructor() {
		$rb = $this->createTextReport([['Value' => '2013-10-23']]);

		$rb->getReport()->add($band = new Elements\DetailBand());
			$band->add($text = new Elements\FieldText('Value', new Formatters\DateTime('d-m-Y')));

		$this->assertEquals("23-10-2013\n", $rb->render());
	}

	public function testSystemTextPageNoElement() {
		$rb = $this->createTextReport();

		$rb->getReport()->add($band = new Elements\FooterBand());
			$band->add(new Elements\SystemText(Elements\SystemText::TYPE_PAGENO));

		$this->assertEquals("Page 1\n", $rb->render());
	}

	public function testSystemTextPrintTimeElement() {
		$rb = $this->createTextReport();

		$rb->getReport()->add($band = new Elements\FooterBand());
			$band->add(new Elements\SystemText(Elements\SystemText::TYPE_PRINTTIME));

		$this->assertRegExp("/\d\d\d\d-\d\d-\d\d \d\d:\d\d:\d\d\n/", $rb->render());
	}

	public function testSystemTextPageNoElementWithTwoPages() {
		$rb = $this->createTextReport([[], []], 2);

		$rb->getReport()->add($band = new Elements\DetailBand());
		$rb->getReport()->add($band = new Elements\FooterBand());
			$band->add(new Elements\SystemText(Elements\SystemText::TYPE_PAGENO));

		$this->assertEquals("\nPage 1\n\n\nPage 2\n", $rb->render());
	}

	public function testSystemTextPageNoOfPagesElement() {
		$rb = $this->createTextReport();

		$rb->getReport()->add($band = new Elements\FooterBand());
			$band->add(new Elements\SystemText(Elements\SystemText::TYPE_PAGENOOFPAGES));

		$this->assertEquals("Page 1 of 1\n", $rb->render());
	}

	public function testSystemTextPageNoOfPagesElementWithTwoPages() {
		$rb = $this->createTextReport([[], []], 2);

		$rb->getReport()->add($band = new Elements\DetailBand());
		$rb->getReport()->add($band = new Elements\FooterBand());
			$band->add(new Elements\SystemText(Elements\SystemText::TYPE_PAGENOOFPAGES));

		$this->assertEquals("\nPage 1 of 2\n\n\nPage 2 of 2\n", $rb->render());
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
