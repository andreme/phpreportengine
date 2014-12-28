<?php

namespace AndreMe\PHPReportEngine\Elements;

class Image extends Element {

	private $handle;

	private $URL;

	public function __construct($file = null, $URL = null) {
		parent::__construct();

		if (is_resource($file)) {
			$this->handle = $file;
		} elseif ($file) {
			$this->handle = fopen($file, 'r');
		}

		$this->URL = $URL;
	}

	public function getURL() {

		if ($this->URL) {
			return $this->URL;
		}

		return $this->URL = "data:base64,".base64_encode(stream_get_contents($this->handle, -1, 0));
	}

	public function __destruct() {
		if ($this->handle) {
			fclose($this->handle);
		}
	}

}
