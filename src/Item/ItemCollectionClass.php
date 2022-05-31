<?php

namespace VendingMachine\Item;

require_once __DIR__.'/../ItemNotFoundException.php';
require_once 'ItemCollectionInterface.php';
require_once 'ItemInterface.php';
require_once 'ItemCodeInterface.php';

use VendingMachine\Exception\ItemNotFoundException;

class ItemCollection implements ItemCollectionInterface
{
    private array $collection;

    public function __construct() {
        $this->empty();
    }

    public function add(ItemInterface $item): void {
        $this->collection[] = $item;
    }

    /**
     * @throws ItemNotFoundException
     */
    public function get(ItemCodeInterface $itemCode): ItemInterface {
        $index = $this->findItem($itemCode);
        $value = clone $this->collection[$index];
        unset($this->collection[$index]);

        return $value;
    }

    public function count(ItemCodeInterface $itemCode): int {
        try {
            $value = $this->collection[$this->findItem($itemCode)];
            return $value->getCount();
        }
        catch(ItemNotFoundException $e) {
            return 0;
        }
    }

    public function empty(): void {
        $this->collection = array();
    }

    private function findItem(ItemCodeInterface $itemCode): int {
        $i = 0;
        $n = count($this->collection);

        while(($i != $n) && ($this->collection[$i]->getCode() != $itemCode))
            $i++;

        if($i == $n)
            throw new ItemNotFoundException("Item Not Found", 1);

        return $i;
    }
}
