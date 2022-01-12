<?php

namespace main\models\commands;


use main\models\interfaces\Movable;

class Move
{
    public function execute(Movable $m )
    {
        $position = $m->getPosition();
        $velocity = $m->getVelocity();

        $position->setX($position->getX() + $velocity->getX());
        $position->setY($position->getY() + $velocity->getY());

        $m->setPosition($position);
    }
}