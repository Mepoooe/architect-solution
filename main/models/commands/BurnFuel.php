<?php

namespace main\models\commands;


use main\models\adapters\BurnFuelAdapter;
use main\models\interfaces\Consumable;

class BurnFuel implements Command
{
    private BurnFuelAdapter $burnFuelAdapter;


    public function __construct(Consumable $burnFuelAdapter)
    {
        $this->burnFuelAdapter = $burnFuelAdapter;
    }

    public function execute(): void
    {
        $this->burnFuelAdapter->consume();
    }
}