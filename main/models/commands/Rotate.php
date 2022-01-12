<?php

namespace main\models\commands;


use main\events\interfaces\Rotable;

class Rotate
{
    public function execute(Rotable $r )
    {
        $r->setDirection(($r->getDirection() + $r->getAngularVelocity()) % $r->getMaxDirectionsCount());
    }
}