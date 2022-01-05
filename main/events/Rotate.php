<?php

namespace main\events;

use main\events\interfaces\Movable;

class Rotate
{
    public function execute(Movable $r )
    {
        $r.setDirection(($r.getDirection() + $r.getAngularVelocity()) % $r.getMaxDiractionCount());
    }
}