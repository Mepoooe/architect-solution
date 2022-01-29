<?php

namespace main\models\commands;


use main\components\Fuel;
use main\models\adapters\CheckFuelAdapter;
use main\models\exceptions\BaseException;
use main\models\exceptions\CommandException;
use main\models\UObject;
use test\TestCase;

/*
 * Реализовать класс CheckFuelComamnd и тесты к нему.
 * */
class CheckFuelTest extends TestCase
{
    public function testExecute()
    {
        $checkFuelAdapter = new CheckFuelAdapter(new Fuel(100));
        $tank = new UObject();
        $tank->setProperty(CheckFuelAdapter::CHECK_FUEL_PROP_NAME, $checkFuelAdapter);
        $tankCheckFuelAdapter = $tank->getProperty(CheckFuelAdapter::CHECK_FUEL_PROP_NAME);

        $commandCheckFuel = new CheckFuel($tankCheckFuelAdapter);
        $commandCheckFuel->execute();

        $this->assertTrue($tankCheckFuelAdapter->isFuelExist());
    }

    public function testOnEmptyFuel()
    {
        $checkFuelAdapter = new CheckFuelAdapter(new Fuel(0));
        $tank = new UObject();
        $tank->setProperty(CheckFuelAdapter::CHECK_FUEL_PROP_NAME, $checkFuelAdapter);
        $tankCheckFuelAdapter = $tank->getProperty(CheckFuelAdapter::CHECK_FUEL_PROP_NAME);

        $commandCheckFuel = new CheckFuel($tankCheckFuelAdapter);

        try {
            $tankCheckFuelAdapter->getFuel()->setFuelVolume(-5);
            $commandCheckFuel->execute();
        }
        catch (BaseException $exception) {
            $this->assertTrue($exception instanceof CommandException);
            $this->assertSame(CommandException::CODE, $exception->getCode());
        }
        finally {
            $this->assertFalse($tankCheckFuelAdapter->isFuelExist());
        }

        $this->assertFalse($tankCheckFuelAdapter->isFuelExist());

        $tankCheckFuelAdapter->getFuel()->setFuelVolume(-5);
        try {
            $tankCheckFuelAdapter->getFuel()->setFuelVolume(-5);
            $commandCheckFuel->execute();
        }
        catch (BaseException $exception) {
            $this->assertTrue($exception instanceof CommandException);
            $this->assertSame(CommandException::CODE, $exception->getCode());
        }
        finally {
            $this->assertFalse($tankCheckFuelAdapter->isFuelExist());
        }
    }

    public function testCheckFuelInObjectWithoutFuel()
    {
        $this->expectException(\ArgumentCountError::class);
        $checkFuelAdapter = new CheckFuelAdapter();
    }

    public function testCheckFuelObjectWhichImpossibleChangeFuel()
    {
        $checkFuelAdapter = new CheckFuelAdapter(new Fuel(10));
        $tank = new UObject();
        $tank->setProperty(CheckFuelAdapter::CHECK_FUEL_PROP_NAME, $checkFuelAdapter);
        $tankCheckFuelAdapter = $tank->getProperty(CheckFuelAdapter::CHECK_FUEL_PROP_NAME);

        $this->expectException(\TypeError::class);
        $tankCheckFuelAdapter->getFuel()->setFuelVolume('five');
    }
}
