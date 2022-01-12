<?php

namespace main\models\interfaces;

use main\components\Position;
use main\components\Velocity;

interface Movable
{
    public function setPosition(Position $newPosition);
    public function setVelocity(Velocity $newVelocity);
    public function getPosition(): Position;
    public function getVelocity(): Velocity;
}