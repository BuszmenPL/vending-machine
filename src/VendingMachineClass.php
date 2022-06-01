<?php

namespace VendingMachine;

require_once 'VendingMachineInterface.php';
require_once __DIR__.'/Item/ItemCollectionClass.php';
require_once __DIR__.'/Item/ItemClass.php';
require_once __DIR__.'/Money/MoneyCollectionClass.php';

use VendingMachine\Item\ItemCodeInterface;
use VendingMachine\Item\ItemInterface;
use VendingMachine\Item\ItemCollection;
use VendingMachine\Item\Item;
use VendingMachine\Money\MoneyCollectionInterface;
use VendingMachine\Money\MoneyInterface;
use VendingMachine\Money\MoneyCollection;


class VendingMachine implements VendingMachineInterface
{
    private MoneyCollection $moneys;
    private ItemCollection $items;

    public function __construct() {
        $this->moneys = new MoneyCollection();
        $this->items = new ItemCollection();
    }

    public function addItem(ItemInterface $item): void {
        $this->items->add($item);
    }

    public function dropItem(ItemCodeInterface $itemCode): void {
        $item = $this->items->get($itemCode);
        $n = $item->getCount() - 1;

        if($n > 0)
            $this->addItem(new Item($item->getPrice(), $n, $item->getCode()));

        $this->moneys->empty();
    }

    public function insertMoney(MoneyInterface $money): void {
        $this->moneys->add($money);
    }

    public function getCurrentTransactionMoney(): MoneyCollectionInterface {
        return $this->moneys;
    }

    public function getInsertedMoney(): MoneyCollectionInterface {
        $tmp = clone $this->moneys;
        $this->moneys->empty();
        return $tmp;
    }
}
