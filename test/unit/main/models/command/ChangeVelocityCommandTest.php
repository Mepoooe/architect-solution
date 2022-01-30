<?php

namespace main\models\commands;


use helpers\Math;
use main\components\Fuel;
use main\models\adapters\BurnFuelAdapter;
use main\models\adapters\CheckFuelAdapter;
use main\models\adapters\RotableAdapter;
use main\models\exceptions\BaseException;
use main\models\exceptions\CommandException;
use main\models\UObject;
use test\TestCase;

class ChangeVelocityCommandTest extends TestCase
{
    /**
     *  Реализовать команду для модификации вектора мгновенной скорости при повороте.
     *  Необходимо учесть, что не каждый разворачивающийся объект движется.
     *
     *  Реализовать команду поворота, которая еще и меняет вектор мгновенной скорости, если есть.
     * */
    public function testExecute()
    {
        $fuel = new Fuel(100);
        $tank = new UObject();

        $burnFuelAdapter = new BurnFuelAdapter($fuel, 5);
        $checkFuelAdapter = new CheckFuelAdapter($burnFuelAdapter->getFuel());
        $rotateAdapter = new RotableAdapter($tank);

        $rotateAdapter->setDirection(12);
        $rotateAdapter->setAngularVelocity(30);

        $commandRotate = new Rotate($rotateAdapter);
        $commandCheckFuel = new CheckFuel($checkFuelAdapter);
        $commandBurnFuel = new BurnFuel($burnFuelAdapter);

        $newAngularVelocity = $rotateAdapter->getAngularVelocity() / 2;
        $changeVelocityCommand = new ChangeVelocityCommand([
            $commandCheckFuel,
            $commandRotate,
            $commandBurnFuel,
        ], $newAngularVelocity);

        $changeVelocityCommand->execute();

        $this->assertSame(95, $fuel->getFuelVolume());
        $this->assertSame(6, $rotateAdapter->getDirection());
        $this->assertSame($newAngularVelocity, $rotateAdapter->getAngularVelocity());
    }

    public function testOnNotSetRotate()
    {
        $fuel = new Fuel(100);
        $tank = new UObject();

        $burnFuelAdapter = new BurnFuelAdapter($fuel, 5);
        $checkFuelAdapter = new CheckFuelAdapter($burnFuelAdapter->getFuel());
        $rotateAdapter = new RotableAdapter($tank);

        $rotateAdapter->setDirection(12);
        $rotateAdapter->setAngularVelocity(30);

        $commandCheckFuel = new CheckFuel($checkFuelAdapter);
        $commandBurnFuel = new BurnFuel($burnFuelAdapter);

        $newAngularVelocity = $rotateAdapter->getAngularVelocity() / 2;

        try {
            new ChangeVelocityCommand([
                $commandCheckFuel,
                $commandBurnFuel,
            ], $newAngularVelocity);
            $this->assertTrue(false, 'test should go to catch');
        }
        catch (BaseException $exception) {
            $this->assertTrue($exception instanceof CommandException);
            $this->assertSame(CommandException::CODE, $exception->getCode());
        }
    }

    public function testOnNotAngularVelocityLowThenEpsilon()
    {
        $tank = new UObject();

        $burnFuelAdapter = new BurnFuelAdapter(new Fuel(100), 5);
        $checkFuelAdapter = new CheckFuelAdapter($burnFuelAdapter->getFuel());
        $rotateAdapter = new RotableAdapter($tank);

        $rotateAdapter->setDirection(12);
        $rotateAdapter->setAngularVelocity(30);

        $commandRotate = new Rotate($rotateAdapter);
        $commandCheckFuel = new CheckFuel($checkFuelAdapter);
        $commandBurnFuel = new BurnFuel($burnFuelAdapter);

        $changeVelocityCommand = new ChangeVelocityCommand([
            $commandCheckFuel,
            $commandRotate,
            $commandBurnFuel,
        ], 0);

        try {
            $changeVelocityCommand->execute();
            $this->assertTrue(false, 'test should go to catch');
        }
        catch (BaseException $exception) {
            $this->assertTrue($exception instanceof CommandException);
            $this->assertSame(CommandException::CODE, $exception->getCode());
            $this->assertSame('New angular velocity should be more than ' . Math::EPSILON . '.', $exception->getMessage());
        }
    }
}
