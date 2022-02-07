<?php

namespace main\models\commands;


use main\models\interfaces\Movable;

class Move implements Command
{
    private Movable $movableAdapter;


    public function __construct(Movable $movableAdapter)
    {
        $this->movableAdapter = $movableAdapter;
    }

    public function execute(): void
    {
        $position = $this->movableAdapter->getPosition();
        $velocity = $this->movableAdapter->getVelocity();

        $position->setX($position->getX() + $velocity->getX());
        $position->setY($position->getY() + $velocity->getY());

        $this->movableAdapter->setPosition($position);
    }

    /**
     * @return Movable
     */
    public function getMovableAdapter(): Movable
    {
        return $this->movableAdapter;
    }

    /**
     * @param Movable $movableAdapter
     */
    public function setMovableAdapter(Movable $movableAdapter): void
    {
        $this->movableAdapter = $movableAdapter;
    }
}