<?php

namespace AndreMe\PHPReportEngine\Formatters;

class Currency implements \AndreMe\PHPReportEngine\IFormatter {

	public function formatValue($value) {

		if (($value === null) or ($value === '')) {
			return null;
		}

		return number_format($value, 2);
	}

}
