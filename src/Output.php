<?php

namespace AndreMe\PHPReportEngine;

class Output {

	private $streamHandle;

	public function open($stream) {
		$this->streamHandle = fopen($stream, 'r+');
	}

	public function get() {
		rewind($this->streamHandle);

		return stream_get_contents($this->streamHandle);
	}

	public function write($data) {
		fwrite($this->streamHandle, $data);
	}

	public function replace($search, $replace) {
		$data = str_replace($search, $replace, $this->get());

		ftruncate($this->streamHandle, 0);

		$this->write($data);
	}

}
