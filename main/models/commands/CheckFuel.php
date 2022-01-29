<?php

namespace main\models\commands;


use main\models\adapters\CheckFuelAdapter;
use main\models\interfaces\Checkable;

class CheckFuel implements Command
{
    private CheckFuelAdapter $checkableAdapter;


    public function __construct(Checkable $checkableAdapter)
    {
        $this->checkableAdapter = $checkableAdapter;
    }

    public function execute(): void
    {
        $this->checkableAdapter->check();
    }
}