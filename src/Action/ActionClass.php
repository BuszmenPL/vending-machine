<?php

namespace VendingMachine\Action;

require_once __DIR__.'/../VendingMachineInterface.php';
require_once __DIR__.'/../Response/ResponseClass.php';
require_once __DIR__.'/../Item/ItemCodeClass.php';
require_once __DIR__.'/../Money/MoneyCollectionInterface.php';

use VendingMachine\VendingMachineInterface;
use VendingMachine\Response\ResponseInterface;
use VendingMachine\Response\Response;
use VendingMachine\Exception\ItemNotFoundException;
use VendingMachine\Item\ItemCode;
use VendingMachine\Money\MoneyCollectionInterface;

class Action implements ActionInterface
{
    private string $name;
    private array $items;

    public function __construct(string $n, array $i) {
        $this->name = $n;
        $this->items = $i;
    }

    public function getName(): string {
        return $this->name;
    }

    public function handle(VendingMachineInterface $vendingMachine): ResponseInterface {
        if($this->name == "RETURN-MONEY") {
            $money = $this->moneyToString($vendingMachine->getInsertedMoney());
            return new Response($money);
        }

        try {
            $transactionsSum = $vendingMachine->getCurrentTransactionMoney()->sum();
            $itemPrice = $this->getItemPrice();
            $itemCode = $this->getItemCode();

            if($itemPrice == $transactionsSum) {
                $vendingMachine->dropItem($itemCode);
                return new Response($itemCode);
            }
            else
                return new Response("Item \"" . $itemCode . "\" costs " . number_format($itemPrice, 2));

        }
        catch(ItemNotFoundException $e) {
            return new Response("Item not found. Please choose another item.");
        }
    }

    private function getItemCode(): ItemCode {
        $tab = explode("-", $this->name);

        return new ItemCode($tab[1]);
    }

    private function getItemPrice(): float {
        $code = $this->getItemCode();

        foreach($this->items as $value)
            if($value->getCode() == $code)
                return $value->getPrice();
    }

    private function moneyToString(MoneyCollectionInterface $money): string {
        $tab = array();

        foreach($money->toArray() as $value)
            $tab[] = $value->getCode();

        return implode(", ", $tab);
    }
}
