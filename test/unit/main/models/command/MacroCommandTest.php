<?php

namespace main\models\commands;


use main\components\Fuel;
use main\components\Position;
use main\components\Velocity;
use main\models\adapters\BurnFuelAdapter;
use main\models\adapters\CheckFuelAdapter;
use main\models\adapters\MovableAdapter;
use main\models\UObject;
use test\TestCase;

class MacroCommandTest extends TestCase
{
    /**
     *  Для объекта, находящегося в направлении (12) и с угловой скоростью (3) движение меняет положение объекта на (3)
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
    }
}
