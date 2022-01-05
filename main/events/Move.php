<?php

namespace main\events;

use main\events\interfaces\Movable;

class Move
{
    public function execute(Movable $m )
    {
        $m.setPosition($m.getPosition(), $m.getVelocity());
    }
}