<?php

namespace VendingMachine\Item;

require_once 'ItemCodeInterface.php';

class ItemCode implements ItemCodeInterface
{
	private string $code;

	public function __construct(string $c) {
		$this->code = $c;
	}

    public function __toString(): string {
    	return $this->code;
    }
}