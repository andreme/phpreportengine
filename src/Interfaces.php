<?php

namespace AndreMe\PHPReportEngine;

interface IRecordProvider {

	public function getRecord();

}

interface IFormatter {

	public function formatValue($value);

}

interface IDatasourceUpdateListener {

	public function onNextRecord($record);

	public function onReset();

}
