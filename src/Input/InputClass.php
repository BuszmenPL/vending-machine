<?php

namespace VendingMachine\Input;

require_once 'InputInterface.php';
require_once __DIR__.'/../Action/ActionInterface.php';
require_once __DIR__.'/../Money/MoneyCollectionInterface.php';

use VendingMachine\Action\ActionInterface;
use VendingMachine\Money\MoneyCollectionInterface;

class Input implements InputInterface
{
	private ActionInterface $action;
	private MoneyCollectionInterface $collection;

	public function __construct(ActionInterface $a, MoneyCollectionInterface $c) {
		$this->action = $a;
		$this->collection = $c;
	}

	public function getAction(): ActionInterface {
		return $this->action;
	}

	public function getMoneyCollection(): MoneyCollectionInterface {
		return $this->collection;
	}
}
