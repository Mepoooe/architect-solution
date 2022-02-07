<?php

namespace main\models\commands;


use main\components\Fuel;
use main\models\adapters\BurnFuelAdapter;
use main\models\exceptions\BaseException;
use main\models\exceptions\CommandException;
use main\models\UObject;
use test\TestCase;

/*
 * Реализовать класс BurnFuelCommand и тесты к нему.
 * */
class BurnFuelTest extends TestCase
{
    public function testExecute()
    {
        $burnFuelAdapter = new BurnFuelAdapter(new Fuel(100), 5);
        $tank = new UObject();
        $tank->setProperty(BurnFuelAdapter::BURN_FUEL_PROP_NAME, $burnFuelAdapter);
        $tankBurnFuelAdapter = $tank->getProperty(BurnFuelAdapter::BURN_FUEL_PROP_NAME);

        $commandCheckFuel = new BurnFuel($tankBurnFuelAdapter);
        $commandCheckFuel->execute();

        $this->assertSame(95, $tankBurnFuelAdapter->getFuel()->getFuelVolume());
    }

    public function testOnNotEnoughFuel()
    {
        $burnFuelAdapter = new BurnFuelAdapter(new Fuel(4), 5);
        $commandCheckFuel = new BurnFuel($burnFuelAdapter);

        try {
            $commandCheckFuel->execute();

            $this->assertTrue(false, 'test should go to catch');
        }
        catch (BaseException $exception) {
            $this->assertTrue($exception instanceof CommandException);
            $this->assertSame(CommandException::CODE, $exception->getCode());
        }
        finally {
            $this->assertTrue($burnFuelAdapter->getFuel()->getFuelVolume() < $burnFuelAdapter->getFuelConsumption());
        }

        $burnFuelAdapter->getFuel()->setFuelVolume(5);
        $commandCheckFuel->execute();

        $this->assertSame(0, $burnFuelAdapter->getFuel()->getFuelVolume());
    }

    public function testBurnFuelInObjectWithoutFuel()
    {
        $this->expectException(\TypeError::class);
        $burnFuelAdapter = new BurnFuelAdapter(null, 5);
    }

    public function testBurnFuelObjectWhichImpossibleChangeFuel()
    {
        $burnFuelAdapter = new BurnFuelAdapter(new Fuel(10), 4);

        $this->expectException(\TypeError::class);
        $burnFuelAdapter->getFuel()->setFuelVolume('five');
    }
}
