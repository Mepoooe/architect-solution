<?php
namespace main\models;


class UObject
{
    protected array $propertyList = [];

    /**
     * @param string $propertyName
     * @param mixed $newValue
     */
    public function setProperty(string $propertyName, $newValue): void
    {
        $this->propertyList[$propertyName] = $newValue;
    }

    /**
     * @param string $propertyName
     * @return mixed
     * @throws \Exception
     */
    public function getProperty(string $propertyName)
    {
        if (array_key_exists($propertyName, $this->propertyList)) {
            return $this->propertyList[$propertyName];
        }

        throw new \Exception("Property '{$propertyName}' not set!");
    }
}