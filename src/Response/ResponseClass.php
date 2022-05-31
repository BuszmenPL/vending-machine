<?php

namespace VendingMachine\Response;

require_once 'ResponseInterface.php';

class Response implements ResponseInterface
{
	private string $response;

	public function __construct(string $r) {
		$this->response = $r;
	}

	public function __toString(): string {
		return $this->response;
	}
}
