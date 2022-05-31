<?php

namespace VendingMachine\Item;

require_once 'ItemInterface.php';
require_once 'ItemCodeClass.php';

class Item implements ItemInterface
{
    private float $price;
    private int $count;
    private ItemCode $code;

    public function __construct(float $p, int $n, string $c) {
        $this->price = $p;
        $this->count = $n;
        $this->code = new ItemCode($c);
    }

    public function getPrice(): float {
        return $this->price;
    }

    public function getCount(): int {
        return $this->count;
    }

    public function getCode(): ItemCodeInterface {
        return $this->code;
    }
}
