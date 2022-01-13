<?php

namespace main\models\commands;

use main\models\interfaces\Rotable;

class Rotate
{
    public function execute(Rotable $r )
    {
        $r->setDirection(abs($r->getDirection() + $r->getAngularVelocity()) % $r->getMaxDirectionsCount());
    }
}