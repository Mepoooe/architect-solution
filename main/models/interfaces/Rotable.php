<?php

namespace main\models\interfaces;

interface Rotable
{
    public function setDirection(int $newDirection);
    public function getDirection();
    public function getAngularVelocity();
    public function setAngularVelocity(float $newAngularVelocity);
    public function getMaxDirectionsCount(): int;
}