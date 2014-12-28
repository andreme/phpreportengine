<?php

namespace AndreMe\PHPReportEngine;

class StyleRepository {

	/**
	 *
	 * @var StyleRepository
	 */
	public static $repo;

	private $styles = [];

	public function add($name) {
		$args = func_get_args();

		array_shift($args);

		if (isset($this->styles[$name])) {
			throw new \Exception("A style with the name $name already exists.");
		}

		$this->styles[$name] = $style = new Style();

		call_user_func_array([$style, 'set'], $args);
	}

	public function get($name) {
		if (isset($this->styles[$name])) {
			return $this->styles[$name];
		}

		return null;
	}

}

StyleRepository::$repo = new StyleRepository();
