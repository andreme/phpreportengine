<?php

namespace AndreMe\PHPReportEngine;

class Style {

	public static $types = ['shared', 'css', 'pdf'];

	private $values = ['shared' => [], 'css' => []];

	public function __construct() {
		if (func_num_args()) {
			call_user_func_array([$this, 'set'], func_get_args());
		}
	}

	public function set() {
		$args = func_get_args();

		$type = 'shared';

		$length = count($args);
		for ($i = 0; $i < $length; $i++) {

			// switch type
			if (in_array($args[$i], self::$types, true)) {
				$type = $args[$i];
				continue;
			}

			// copy from style
			if ($args[$i] instanceof self) {
				$args[$i]->copyTo($this);
				continue;
			}

			// copy from style in repository
			$repoStyle = StyleRepository::$repo->get($args[$i]);
			if ($repoStyle) {
				$repoStyle->copyTo($this);
				continue;
			}

			if (!isset($this->values[$type])) {
				$this->values[$type] = [];
			}

			$this->values[$type][$args[$i]] = $args[++$i];
		}
	}

	public function getCSS() {
		$result = '';

		foreach (array_merge($this->values['shared'], $this->values['css']) as $name => $value) {
			$result .= "$name:$value;";
		}

		return $result;
	}

	/**
	 *
	 * @param Style $destStyle
	 *
	 */
	public function copyTo($destStyle) {
		$attr = [];

		foreach ($this->values as $type => $values) {
			if ($values) {
				$attr[] = $type;
				foreach ($values as $name => $value) {
					$attr[] = $name;
					$attr[] = $value;
				}
			}
		}

		call_user_func_array([$destStyle, 'set'], $attr);
	}

	public function addClass($class) {
		// TODO
	}

}
