<?php

namespace AndreMe\PHPReportEngine\Elements;

class TableBand extends Band {

	/**
	 *
	 * @param Element $element
	 * @return TableCell
	 */
	public function add($element) {

		$args = func_get_args();

		$cell = ((isset($args[0]) and ($args[0] instanceof TableCell)) ? array_shift($args) : new TableCell());

		call_user_func_array([$cell, 'add'], $args);

		return parent::add($cell);
	}

}
