<?php

namespace main\components;

class Position
{
    public int $maxX = 100;
    public int $maxY = 100;

    private int $x;
    private int $y;


    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @param int $x
     */
    public function setX(int $x): void
    {
        if ($this->maxX < $x) {
            throw new \Exception("Position x should be less then '{$this->maxX}'.");
        }

        $this->x = $x;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }

    /**
     * @param int $y
     */
    public function setY(int $y): void
    {
        if ($this->maxY < $y) {
            throw new \Exception("Position y should be less then '{$this->maxY}'.");
        }

        $this->y = $y;
    }
}