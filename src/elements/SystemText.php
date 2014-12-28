<?php

namespace AndreMe\PHPReportEngine\Elements;

class SystemText extends Text {

	const TYPE_PAGENO = 'PageNo';
	const TYPE_PAGENOOFPAGES = 'PageNoOfPages';
	const TYPE_PRINTTIME = 'PrintTime';

	private $type;

	public function __construct($type) {
		parent::__construct();

		$this->type = $type;

		if ($this->type == self::TYPE_PRINTTIME) {
			$this->setFormatter($this->createDefaultPrintTimeFormatter());
		}
	}

	public function getText() {
	}

	public function setText($text) {
		throw new \Exception('SystemText::setText not allowed.');
	}

	public function getType() {
		return $this->type;
	}

	protected function createDefaultPrintTimeFormatter() {
		return new \AndreMe\PHPReportEngine\Formatters\DateTime('Y-m-d H:i:s');
	}

}
