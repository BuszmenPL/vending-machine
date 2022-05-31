<?php

namespace VendingMachine\Money;

require_once 'MoneyCollectionInterface.php';
require_once 'MoneyInterface.php';

class MoneyCollection implements MoneyCollectionInterface
{
    private array $collection;

    public function __construct() {
        $this->empty();
    }

    public function add(MoneyInterface $money): void {
        $this->collection[] = $money;
    }

    public function sum(): float {
        $s = 0.0;

        foreach($this->collection as $value)
            $s += $value->getValue();

        return $s;
    }

    public function merge(MoneyCollectionInterface $moneyCollection): void {
        foreach($moneyCollection->toArray() as $value)
            $this->add($value);

        $moneyCollection->empty();
    }

    public function empty(): void {
        $this->collection = array();
    }

    /**
     * @return MoneyInterface[]
     */
    public function toArray(): array {
        return $this->collection;
    }
}
