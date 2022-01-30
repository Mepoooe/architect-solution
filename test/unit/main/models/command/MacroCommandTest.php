<?php

namespace main\models\commands;


use main\components\Fuel;
use main\components\Position;
use main\components\Velocity;
use main\models\adapters\BurnFuelAdapter;
use main\models\adapters\CheckFuelAdapter;
use main\models\adapters\MovableAdapter;
use main\models\exceptions\BaseException;
use main\models\exceptions\CommandException;
use main\models\UObject;
use test\TestCase;

class MacroCommandTest extends TestCase
{
    /**
     *  Реализовать команду движения по прямой с расходом топлива, используя команды с предыдущих шагов.
     * */
    public function testExecute()
    {
        $positionMock = new Position(12, 5);
        $velocityMock = new Velocity(-7, 3);
        $fuel = new Fuel(100);
        $tank = new UObject();

        $burnFuelAdapter = new BurnFuelAdapter($fuel, 5);
        $checkFuelAdapter = new CheckFuelAdapter($burnFuelAdapter->getFuel());
        $movableAdapter = new MovableAdapter($tank);

        $movableAdapter->setPosition($positionMock);
        $movableAdapter->setVelocity($velocityMock);

        $commandMove = new Move($movableAdapter);
        $commandCheckFuel = new CheckFuel($checkFuelAdapter);
        $commandBurnFuel = new BurnFuel($burnFuelAdapter);

        $macroCommand = new MacroCommand([
            $commandCheckFuel,
            $commandMove,
            $commandBurnFuel,
        ]);

        $macroCommand->execute();

        $this->assertSame(95, $fuel->getFuelVolume());
        $this->assertSame(5, $movableAdapter->getPosition()->getX());
        $this->assertSame(8, $movableAdapter->getPosition()->getY());
    }

    /**
     *  Реализовать простейшую макрокоманду и тесты к ней. Здесь простейшая - это значит, что при выбросе исключения
     *  вся последовательность команд приостанавливает свое выполнение, а макрокоманда выбрасывает CommandException.
     * */
    public function testOnEmptyFuel()
    {
        $positionMock = new Position(12, 5);
        $velocityMock = new Velocity(-7, 3);
        $fuel = new Fuel(9);
        $tank = new UObject();

        $burnFuelAdapter = new BurnFuelAdapter($fuel, 5);
        $checkFuelAdapter = new CheckFuelAdapter($burnFuelAdapter->getFuel());
        $movableAdapter = new MovableAdapter($tank);

        $movableAdapter->setPosition($positionMock);
        $movableAdapter->setVelocity($velocityMock);

        $commandMove = new Move($movableAdapter);
        $commandCheckFuel = new CheckFuel($checkFuelAdapter);
        $commandBurnFuel = new BurnFuel($burnFuelAdapter);
        $commandList = [
            $commandCheckFuel,
            $commandMove,
            $commandBurnFuel,
        ];

        $macroCommand = new MacroCommand($commandList);

        $macroCommand->execute();

        $this->assertSame(4, $fuel->getFuelVolume());
        $this->assertSame(5, $movableAdapter->getPosition()->getX());
        $this->assertSame(8, $movableAdapter->getPosition()->getY());

        $macroCommand->setCommandList($commandList);

        try {
            $macroCommand->execute();
            $this->assertTrue(false, 'test should go to catch');
        }
        catch (BaseException $exception) {
            $this->assertTrue($exception instanceof CommandException);
            $this->assertSame(CommandException::CODE, $exception->getCode());
        }
    }
}
