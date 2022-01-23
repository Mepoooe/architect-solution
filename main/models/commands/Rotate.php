<?php

namespace main\models\commands;

use main\models\interfaces\Rotable;

class Rotate
{
    private Rotable $rotableAdapter;


    public function __construct(Rotable $rotableAdapter)
    {
        $this->rotableAdapter = $rotableAdapter;
    }

    public function execute()
    {
        $newDirection = abs($this->rotableAdapter->getDirection() + $this->rotableAdapter->getAngularVelocity()) % $this->rotableAdapter->getMaxDirectionsCount();
        $this->rotableAdapter->setDirection($newDirection);
    }

    /**
     * @param Rotable $rotableAdapter
     */
    public function setRotableAdapter(Rotable $rotableAdapter): void
    {
        $this->rotableAdapter = $rotableAdapter;
    }

    /**
     * @return Rotable
     */
    public function getRotableAdapter(): Rotable
    {
        return $this->rotableAdapter;
    }
}