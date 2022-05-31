<?php

namespace VendingMachine\Money;

require_once 'MoneyInterface.php';

class Money implements MoneyInterface  
{
	private float $value;
	private string $code;

	public function __construct(float $v, string $c) {
		$this->value = $v;
		$this->code = $c;
	}

    public function getValue(): float {
    	return $this->value;
    }

    public function getCode(): string {
    	return $this->code;
    }
}