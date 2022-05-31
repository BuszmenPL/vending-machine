<?php

namespace VendingMachine\Input;

require_once 'InputHandlerInterface.php';
require_once __DIR__.'/../Exception/InvalidInputException.php';
require_once __DIR__.'/../Money/MoneyCollectionClass.php';
require_once __DIR__.'/../Money/MoneyClass.php';
require_once __DIR__.'/../Input/InputClass.php';
require_once __DIR__.'/../Action/ActionClass.php';

use VendingMachine\Exception\InvalidInputException;
use VendingMachine\Money\MoneyCollection;
use VendingMachine\Money\Money;
use VendingMachine\Input\Input;
use VendingMachine\Action\Action;

class InputHandler implements InputHandlerInterface
{
    private MoneyCollection $collection;
    private array $items;

    public function __construct(array $i) {
        $this->collection = new MoneyCollection();
        $this->items = $i;
    }

    /**
     * @throws InvalidInputException
     */
	public function getInput(): InputInterface {
        $this->collection->empty();

        while(true) {
            $commend = strtoupper(readline('Input: '));
            $value = $this->getValue($commend);

            if($value != 0.0) {
                $this->collection->add(new Money($value, $commend));
                echo "Current balance: " . $this->collection->sum() . $this->moneyToString() . "\n";
            }
            elseif($this->check($commend))
                return new Input(new Action($commend, $this->items), $this->collection);
            else
                throw new InvalidInputException("Invalid Input", 1);
        }
    }

    private function getValue(string $s): float {
        $value  = 0.0;

        switch($s) {
            case "DOLLAR": $value = 1.0; break;
            case "Q": $value = 0.25; break;
            case "D": $value = 0.1; break;
            case "N": $value = 0.05; break;
        }

        return $value;
    }

    private function check(string $s): bool {
        if($s == 'RETURN-MONEY')
            return true;
        else {
            $tab = explode("-", $s);
            return ($tab[0] == "GET");
        }
    }

    private function moneyToString(): string {
        $tab = array();

        foreach($this->collection->toArray() as $value)
            $tab[] = $value->getCode();

        return " (" . implode(", ", $tab) . ")";
    }
}
