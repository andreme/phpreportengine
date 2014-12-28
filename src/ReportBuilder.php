<?php

namespace AndreMe\PHPReportEngine;

class ReportBuilder {

	/**
	 *
	 * @var Renderers\MainRenderer
	 */
	private $renderer;

	/**
	 *
	 * @var Elements\Report
	 */
	private $report;

	/**
	 *
	 * @var DataSources\DataSource
	 */
	private $dataSource;

	public function setRenderer($renderer) {
		$this->renderer = $renderer;
	}

	/**
	 *
	 * @return Elements\Report
	 */
	public function getReport() {
		return ($this->report ?: $this->report = new Elements\Report());
	}

	public function render() {
		$report = $this->getReport();

		$report->setDataSource($this->dataSource ?: new DataSources\ArrayDataSource([[]]));

		$this->renderer->setReport($report);

		$this->renderer->loadRendererClasses();

		$output = new Output();
		$output->open('php://memory');

		$this->renderer->setOutput($output);

		$this->renderer->render();

		return $output->get();
	}

	public function getDataSource() {
		return $this->dataSource;
	}

	public function setDataSource($dataSource) {
		$this->dataSource = $dataSource;
	}

	public static function registerAutoloader() {
		require_once __DIR__.'/Interfaces.php';

		spl_autoload_register(function ($classname) {
			$namespace = __NAMESPACE__.'\\';
			if (strncmp($classname, $namespace, strlen($namespace)) === 0) {
				$classname = substr($classname, strlen($namespace));
				$classname = str_replace('\\', DIRECTORY_SEPARATOR, $classname);

				$filename = strtolower(dirname($classname)).DIRECTORY_SEPARATOR.basename($classname).'.php';
				$filename = __DIR__.DIRECTORY_SEPARATOR.$filename;

				{ require $filename; }

				return true;
			}
		});
	}

}

ReportBuilder::registerAutoloader();
