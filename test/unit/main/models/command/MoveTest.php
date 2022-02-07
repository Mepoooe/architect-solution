<?php

namespace main\models\commands;


use main\components\Position;
use main\components\Velocity;
use main\models\adapters\MovableAdapter;
use main\models\UObject;
use test\TestCase;

class MoveTest extends TestCase
{
    /**
     *  Для объекта, находящегося в точке (12, 5) и движущегося со скоростью (-7, 3) движение меняет положение объекта на (5, 8)
     * */
    public function testExecute()
    {
        $positionMock = new Position(12, 5);
        $velocityMock = new Velocity(-7, 3);

        $tank = new UObject();
        $movableAdapter = new MovableAdapter($tank);
        $movableAdapter->setPosition($positionMock);
        $movableAdapter->setVelocity($velocityMock);

        $commandMove = new Move($movableAdapter);
        $commandMove->execute();

        $this->assertSame(5, $movableAdapter->getPosition()->getX());
        $this->assertSame(8, $movableAdapter->getPosition()->getY());
    }

    /**
     *  Попытка сдвинуть объект, у которого невозможно прочитать положение в пространстве, приводит к ошибке
     * */
    public function testMoveObjectWithoutPosition()
    {
        $velocityMock = new Velocity(-7, 3);

        $tank = new UObject();
        $movableAdapter = new MovableAdapter($tank);
        $propName = MovableAdapter::MOVABLE_POSITION_PROP_NAME;
        $movableAdapter->setVelocity($velocityMock);

        $commandMove = new Move($movableAdapter);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Property '{$propName}' not set!");
        $commandMove->execute();
    }

    /**
     *  Попытка сдвинуть объект, у которого невозможно прочитать значение мгновенной скорости, приводит к ошибке
     * */
    public function testMoveObjectWithoutVelocity()
    {
        $positionMock = new Position(12, 5);

        $tank = new UObject();
        $movableAdapter = new MovableAdapter($tank);
        $propName = MovableAdapter::MOVABLE_VELOCITY_PROP_NAME;
        $movableAdapter->setPosition($positionMock);

        $commandMove = new Move($movableAdapter);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Property '{$propName}' not set!");
        $commandMove->execute();
    }

    /**
     *  Попытка сдвинуть объект, у которого невозможно изменить положение в пространстве, приводит к ошибке
     * */
    public function testMoveObjectWhichImpossibleChangePosition()
    {
        $position = new Position(12, 5);
        $tank = new UObject();
        $movableAdapter = new MovableAdapter($tank);

        $movableAdapter->setPosition($position);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Position x should be less then '{$position->maxY}'.");
        $movableAdapter->getPosition()->setX(200);
    }

    /**
     *  Попытка сдвинуть объект, у которого невозможно изменить положение в пространстве, приводит к ошибке
     * */
    public function testOnSetWrongTypeForPosition()
    {
        $position = new Position(50, 5);
        $velocityMock = new Velocity(-7, 3);

        $tank = new UObject();
        $movableAdapter = new MovableAdapter($tank);
        $movableAdapter->setVelocity($velocityMock);

        $commandMove = new Move($movableAdapter);

        $this->expectException(\TypeError::class);
        $position->setX('one');
        $commandMove->execute();
    }
}
