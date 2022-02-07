<?php

namespace main\components;

class Fuel
{
    private int $fuelVolume;


    public function __construct(int $fuelState)
    {
        $this->fuelVolume = $fuelState;
    }

    public function setFuelVolume(int $fuelVolume): void
    {
        $this->fuelVolume = $fuelVolume;
    }

    public function getFuelVolume(): int
    {
        return $this->fuelVolume;
    }
}