<?php

namespace main\events\interfaces;

interface Movable
{
    public function getPosition();
    public function getVelocity();
}