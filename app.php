<?php

require_once 'src/VendingMachineClass.php';
require_once 'src/Input/InputHandlerClass.php';
require_once 'src/Item/ItemClass.php';
require_once 'src/Item/ItemCodeClass.php';

use VendingMachine\Input\InputHandler;
use VendingMachine\Input\Input;
use VendingMachine\Action\Action;
use VendingMachine\Exception\InvalidInputException;
use VendingMachine\Item\Item;
use VendingMachine\Item\ItemCode;
use VendingMachine\VendingMachine;

$items = array(new Item(0.65, 1, new ItemCode("A")),
				new Item(1.0, 1, new ItemCode("B")),
				new Item(1.5, 1, new ItemCode("C")));

$vendingMachine = new VendingMachine();
$inputHandler = new InputHandler($items, $vendingMachine);

foreach($items as $value)
	$vendingMachine->addItem($value);

while(true) {
	try {
		$input = $inputHandler->getInput();

		$money = $input->getMoneyCollection();
		foreach($money->toArray() as $value)
			$vendingMachine->insertMoney($value);

		$action = $input->getAction();
		$response = $action->handle($vendingMachine);
		echo $response . "\n";
	}
	catch(InvalidInputException $e) {
		echo "Specified action does not exist.\n";
	}
}