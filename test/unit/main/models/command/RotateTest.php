<?php

namespace main\models\commands;


use main\models\adapters\RotableAdapter;
use main\models\UObject;
use test\TestCase;

class RotateTest extends TestCase
{
    /**
     *  Для объекта, находящегося в направлении (12) и с угловой скоростью (3) движение меняет положение объекта на (3)
     * */
    public function testExecute()
    {
        $directionMock = 3;

        $tank = new UObject();
        $commandRotate = new Rotate();
        $rotateAdapter = new RotableAdapter($tank);

        $rotateAdapter->setDirection(12);
        $rotateAdapter->setAngularVelocity(3);

        $commandRotate->execute($rotateAdapter);

        $this->assertSame($directionMock, $rotateAdapter->getDirection());

        $rotateAdapter->setDirection(12);
        $rotateAdapter->setAngularVelocity(30);

        $commandRotate->execute($rotateAdapter);

        $this->assertSame(6, $rotateAdapter->getDirection());

        $rotateAdapter->setDirection(12);
        $rotateAdapter->setAngularVelocity(-3);

        $commandRotate->execute($rotateAdapter);

        $this->assertSame(9, $rotateAdapter->getDirection());

        $rotateAdapter->setDirection(12);
        $rotateAdapter->setAngularVelocity(-30);

        $commandRotate->execute($rotateAdapter);

        $this->assertSame(6, $rotateAdapter->getDirection());
    }

    /**
     *  Попытка повернуть объект, у которого невозможно прочитать направление в пространстве, приводит к ошибке
     * */
    public function testRotateObjectWithoutDirection()
    {
        $tank = new UObject();
        $commandRotate = new Rotate();
        $rotateAdapter = new RotableAdapter($tank);
        $propName = RotableAdapter::ROTABLE_DIRECTION_PROP_NAME;

        $rotateAdapter->setAngularVelocity(3);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Property '{$propName}' not set!");
        $commandRotate->execute($rotateAdapter);
    }

    /**
     *  Попытка повернуть объект, у которого невозможно прочитать значение угловой скорости, приводит к ошибке
     * */
    public function testRotateObjectWithoutAngularVelocity()
    {
        $tank = new UObject();
        $commandRotate = new Rotate();
        $rotateAdapter = new RotableAdapter($tank);
        $propName = RotableAdapter::ROTABLE_ANGULAR_VELOCITY_PROP_NAME;

        $rotateAdapter->setDirection(12);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Property '{$propName}' not set!");
        $commandRotate->execute($rotateAdapter);
    }

    /**
     *  Попытка повернуть объект, у которого невозможно изменить положение в пространстве, приводит к ошибке
     * */
    public function testRotateObjectWhichImpossibleChangeDirection()
    {
        $tank = new UObject();
        $rotateAdapter = new RotableAdapter($tank);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Direction should be less then '{$rotateAdapter->getMaxDirectionsCount()}'.");

        $rotateAdapter->setDirection(50);
    }

    /**
     *  Попытка повернуть объект, у которого невозможно изменить угловую скорость, приводит к ошибке
     * */
    public function testOnSetWrongTypeForAngularVelocity()
    {
        $tank = new UObject();
        $rotateAdapter = new RotableAdapter($tank);

        $this->expectException(\TypeError::class);
        $rotateAdapter->setAngularVelocity('one');
    }
}
