<?php


namespace main\models\adapters;


use main\events\interfaces\Rotable;
use main\models\UObject;

class RotableAdapter implements Rotable
{
    protected const ROTABLE_DIRECTION_PROP_NAME = 'rotableDirection';
    protected const ROTABLE_ANGULAR_VELOCITY_PROP_NAME = 'rotableAngularVelocity';

    protected const ROTABLE_MAX_DIRECTION_COUNT = 12;

    protected UObject $uObject;


    public function __construct(UObject $uObject)
    {
        $this->uObject = $uObject;
    }

    public function setDirection(int $newDirection)
    {
        $this->uObject->setProperty(self::ROTABLE_DIRECTION_PROP_NAME, $newDirection);
    }

    public function getDirection()
    {
        return $this->uObject->getProperty(self::ROTABLE_DIRECTION_PROP_NAME);
    }

    public function setAngularVelocity(float $newAngularVelocity)
    {
        $this->uObject->setProperty(self::ROTABLE_ANGULAR_VELOCITY_PROP_NAME, $newAngularVelocity);
    }

    public function getAngularVelocity()
    {
        return $this->uObject->getProperty(self::ROTABLE_ANGULAR_VELOCITY_PROP_NAME);
    }

    public function getMaxDirectionsCount(): int
    {
        return self::ROTABLE_MAX_DIRECTION_COUNT;
    }
}