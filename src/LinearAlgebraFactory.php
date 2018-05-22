<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace EcomDev\Color;


use MathPHP\LinearAlgebra\Matrix;
use MathPHP\LinearAlgebra\MatrixFactory;
use MathPHP\LinearAlgebra\Vector;

class LinearAlgebraFactory
{
    public function createMatrix(array $literal): Matrix
    {
        return MatrixFactory::create($literal);
    }

    public function createVector(array $literal): Vector
    {
        return new Vector($literal);
    }

    public function createFromVectors(Vector ...$vectors): Matrix
    {
        return MatrixFactory::create($vectors);
    }
}
