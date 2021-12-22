<?php

use main\Math;
use test\TestCase;

class MathTest extends TestCase
{
    /**
     * Написать тест, который проверяет, что для уравнения x^2+1 = 0 корней нет (возвращается пустой массив)
     */
    public function testOnEmptySolveQuadraticEquation(): void
    {
        $math = new Math();
        
        $mock = $this->getMockForEmptyArray();
        $result = $math->solveQuadraticEquation($mock['a'], $mock['b'], $mock['c']);

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    /**
     * Написать тест, который проверяет, что коэффициент a не может быть равен 0. В этом случае solve выбрасывает исключение.
     * Примечание. Учесть, что a имеет тип double и сравнивать с 0 через == нельзя.
     * @expected Exception
     */
    public function testOnZeroSolveQuadraticEquation(): void
    {
        $math = new Math();

        $mock = $this->getMockOnZero();
        $this->expectException(Exception::class);
        $math->solveQuadraticEquation($mock['a'], $mock['b'], $mock['c']);
    }

    /**
     * Написать тест, который проверяет, что коэффициент a не может быть равен 0. В этом случае solve выбрасывает исключение.
     * Примечание. Учесть, что a имеет тип double и сравнивать с 0 через == нельзя.
     * @expected TypeError
     */
    public function testOnWrongParamsSolveQuadraticEquation(): void
    {
        $math = new Math();

        $mock = $this->getMockOnTypeParamsErrors();
        $this->expectException(TypeError::class);
        $math->solveQuadraticEquation($mock['a'], $mock['b'], $mock['c']);
    }

    /**
     * Написать тест, который проверяет, что для уравнения x^2+2x+1 = 0 есть один корень кратности 2 (x1= x2 = -1).
     */
    public function testOnOneRootSolveQuadraticEquation(): void
    {
        $math = new Math();

        $mock = $this->getMockOnOneRoot();
        $result = $math->solveQuadraticEquation($mock['a'], $mock['b'], $mock['c']);

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertArrayHasKey('x1', $result);
        $this->assertArrayHasKey('x2', $result);
//        $this->assertSame($result['x1'], $result['x2']);
    }

    /**
     * Написать тест, который проверяет, что для уравнения x^2-1 = 0 есть два корня кратности 1 (x1=1, x2=-1)
     */
    public function testOnTwoRootOfMultiplicitySolveQuadraticEquation(): void
    {
        $math = new Math();

        $mock = $this->getMockForTwoRootOfMultiplicity();

        $result = $math->solveQuadraticEquation($mock['a'], $mock['b'], $mock['c']);

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertArrayHasKey('x1', $result);
        $this->assertArrayHasKey('x2', $result);
//        $this->assertSame(1, $result['x1']);
//        $this->assertArrayHasKey(-1, $result['x2']);
    }

    private function getMockForEmptyArray(): array
    {
        return [
            'a' => 4,
            'b' => -3,
            'c' => 1,
        ];
    }

    private function getMockOnZero(): array
    {
        return [
            'a' => 0,
            'b' => -3,
            'c' => 1,
        ];
    }

    private function getMockOnTypeParamsErrors(): array
    {
        return [
            'a' => 'sdas',
            'b' => NAN,
            'c' => null,
        ];
    }

    private function getMockOnOneRoot(): array
    {
        return [
            'a' => 0.81,
            'b' => 4,
            'c' => -1,
        ];
    }

    private function getMockForTwoRootOfMultiplicity(): array
    {
        return [
            'a' => 1,
            'b' => 10,
            'c' => 1,
        ];
    }
}