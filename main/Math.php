<?php
namespace main;

use \Exception;

class Math
{
    /**
     * @var float
     */
    private const EPSILON = 0.0000000001;

    //Уравнение вида ax^2+bx+c=0, в котором a, b и c — действительные числа, и a≠0, называется квадратным уравнением.
    public function solveQuadraticEquation(float $a, float $b, float $c): array
    {
        $equationRootList = [];

        if (abs($a) < self::EPSILON) {
            throw new Exception('Var $a can not be zero');
        }

        $D = pow($b, 2) - (4 * $a * $c);
        $withoutRoots = abs($D) < self::EPSILON;

        if ($withoutRoots) {
            return [];
        }

        $x1 = ((-1 * $b) + sqrt($D)) / 2 * $a;
        $x2 = ((-1 * $b) - sqrt($D)) / 2 * $a;

        if (is_nan($x1) === false) {
            $equationRootList['x1'] = $x1;
        }

        if (is_nan($x2) === false) {
            $equationRootList['x2'] = $x2;
        }

        return $equationRootList;
    }
}