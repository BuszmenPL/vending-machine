<?php

namespace VendingMachine\Item;

require_once 'ItemInterface.php';
require_once 'ItemCodeInterface.php';

class Item implements ItemInterface
{
    private float $price;
    private int $count;
    private ItemCodeInterface $code;

    public function __construct(float $p, int $n, ItemCodeInterface $c) {
        $this->price = $p;
        $this->count = $n;
        $this->code = $c;
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
