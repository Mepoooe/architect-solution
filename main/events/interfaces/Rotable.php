<?php

namespace main\events\interfaces;

interface Rotable
{
    public function setDirection(int $newValue);
    public function getDirection();
    public function getAngularVelocity();
    public function getMaxDirectionCount(): int;
}