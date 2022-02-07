<?php

namespace main\models\commands;


use main\models\exceptions\CommandException;
use main\models\interfaces\Consumable;

class BurnFuel implements Command
{
    private Consumable $burnFuelAdapter;


    public function __construct(Consumable $burnFuelAdapter)
    {
        $this->burnFuelAdapter = $burnFuelAdapter;
    }

    public function execute(): void
    {
        $fuelVolume = $this->burnFuelAdapter->calcFuelVolumeAfterBurn();
        if ($fuelVolume < 0) {
            throw new CommandException('Not enough fuel');
        }
        $this->burnFuelAdapter->consume();
    }
}