<?php

namespace main\models\adapters;

use main\components\Fuel;
use main\models\exceptions\CommandException;
use main\models\interfaces\Consumable;

class BurnFuelAdapter implements Consumable
{
    const BURN_FUEL_PROP_NAME = 'burnFuel';

    private Fuel $fuel;
    private int $fuelConsumption;


    public function __construct(Fuel $fuel, int $fuelConsumption)
    {
        $this->fuel = $fuel;
        $this->fuelConsumption = $fuelConsumption;
    }

    public function consume(): void
    {
        $fuelVolume = $this->getFuel()->getFuelVolume() - $this->fuelConsumption;

        if ($fuelVolume < 0) {
            throw new CommandException('Not enough fuel');
        }

        $this->getFuel()->setFuelVolume($fuelVolume);
    }

    public function setFuel(Fuel $fuel)
    {
        $this->fuel = $fuel;
    }

    public function getFuel(): Fuel
    {
        return $this->fuel;
    }

    public function getFuelConsumption(): int
    {
        return $this->fuelConsumption;
    }

    public function setFuelConsumption(int $fuelConsumption): void
    {
        $this->fuelConsumption = $fuelConsumption;
    }
}