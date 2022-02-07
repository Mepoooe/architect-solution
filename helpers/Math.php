<?php

namespace helpers;

use \Exception;

class Math
{
    /**
     * @var float
     */
    const EPSILON = 0.0000000001;

    //Уравнение вида ax^2+bx+c=0, в котором a, b и c — действительные числа, и a≠0, называется квадратным уравнением.
    public function solveQuadraticEquation(float $a, float $b, float $c, bool $strict = true): array
    {
        $equationRootList = [];

        if (abs($a) < self::EPSILON) {
            throw new Exception('Var $a can not be zero');
        }

        $D = pow($b, 2) - (4.0 * $a * $c);

        $withoutRoots = abs($D) < self::EPSILON;
        $oneRoots = round(abs($D), 2) === 0.0;

        if ($withoutRoots === true && $oneRoots === false) {
            return [];
        }

        $x1 = ((-1 * $b) + sqrt($D)) / 2 * $a;
        $x2 = ((-1 * $b) - sqrt($D)) / 2 * $a;

        if (is_nan($x1) === false) {
            if ($strict === false) {
                $x1 = round($x1);
            }
            $equationRootList['x1'] = $x1;
        }

        if (is_nan($x2) === false) {
            if ($strict === false) {
                $x2 = round($x2);
            }
            $equationRootList['x2'] = $x2;
        }

        return $equationRootList;
    }

    public static function isLowThenZero(float $value): bool
    {
        $value = round($value, 2);
        return $value <= 0.0;
    }
}