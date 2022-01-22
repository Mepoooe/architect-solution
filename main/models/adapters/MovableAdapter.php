<?php

namespace main\models\adapters;

use main\components\Position;
use main\components\Velocity;
use main\models\interfaces\Movable;
use main\models\UObject;

class MovableAdapter implements Movable
{
    const MOVABLE_POSITION_PROP_NAME = 'movablePosition';
    const MOVABLE_VELOCITY_PROP_NAME = 'movableVelocity';

    protected UObject $uObject;


    public function __construct(UObject $uObject)
    {
        $this->uObject = $uObject;
    }

    /**
     * @param Position $newPosition
     */
    public function setPosition(Position $newPosition)
    {
        $this->uObject->setProperty(self::MOVABLE_POSITION_PROP_NAME, $newPosition);
    }

    /**
     * @param Velocity $newVelocity
     */
    public function setVelocity(Velocity $newVelocity)
    {
        $this->uObject->setProperty(self::MOVABLE_VELOCITY_PROP_NAME, $newVelocity);
    }

    public function getPosition(): Position
    {
       return $this->uObject->getProperty(self::MOVABLE_POSITION_PROP_NAME);
    }

    public function getVelocity(): Velocity
    {
        return $this->uObject->getProperty(self::MOVABLE_VELOCITY_PROP_NAME);
    }
}