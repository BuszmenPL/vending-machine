<?php

namespace VendingMachine\Action;

require_once __DIR__.'/../VendingMachineInterface.php';
require_once __DIR__.'/../Response/ResponseInterface.php';

use VendingMachine\Response\ResponseInterface;
use VendingMachine\VendingMachineInterface;

class Action implements ActionInterface
{
    private string $name;

    public function __construct(string $n) {
        $this->name = $n;
    }

    public function getName(): string {
        return $this->name;
    }

    public function handle(VendingMachineInterface $vendingMachine): ResponseInterface {

    }
}
