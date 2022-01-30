<?php

namespace main\models\adapters;

use main\components\Fuel;
use main\models\interfaces\Checkable;

class CheckFuelAdapter implements Checkable
{
    const CHECK_FUEL_PROP_NAME = 'checkFuel';

    protected Fuel $fuel;
    private bool $fuelExist;


    public function __construct(Fuel $fuel)
    {
        $this->fuel = $fuel;
    }

    public function check(): bool
    {
        $this->fuelExist = $this->fuel->getFuelVolume() > 0;
        return $this->fuelExist;
    }

    public function setFuel(Fuel $fuel)
    {
        $this->fuel = $fuel;
    }

    public function getFuel(): Fuel
    {
        return $this->fuel;
    }

    public function isFuelExist(): bool
    {
        return $this->fuelExist;
    }
}