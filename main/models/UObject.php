<?php
namespace main\models;

use main\components\Position;
use main\components\Velocity;

class UObject
{
    protected array $propertyList = [];

    /**
     * @param string $propertyName
     * @param Position|Velocity $newValue
     */
    public function setProperty(string $propertyName, $newValue): void
    {
        $this->propertyList[$propertyName] = $newValue;
    }

    /**
     * @param string $propertyName
     * @return Position|Velocity
     * @throws \Exception
     */
    public function getProperty(string $propertyName): object
    {
        if (array_key_exists($propertyName, $this->propertyList)) {
            return $this->propertyList[$propertyName];
        }

        throw new \Exception("Property '{$propertyName}' not set!");
    }
}