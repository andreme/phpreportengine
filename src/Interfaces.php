<?php

namespace AndreMe\PHPReportEngine;

interface IRecordProvider {

	public function getRecord();

}

interface IFormatter {

	public function formatValue($value);

}
