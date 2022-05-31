<?php

namespace VendingMachine\Item;

require_once 'ItemCollectionInterface.php';

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
        foreach($this->collection as $value)
            if($value->getCode() == $itemCode)
                return $value;

        throw new ItemNotFoundException("Item Not Found", 1);
    }

    public function count(ItemCodeInterface $itemCode): int {
        try {
            $value = $this->get($itemCode);
            return $value->getCount();
        }
        catch(ItemNotFoundException $e) {
            return 0;
        }
    }

    public function empty(): void {
        $this->collection = array();
    }
}
