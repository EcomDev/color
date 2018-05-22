<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace EcomDev\Color;

use MathPHP\LinearAlgebra\Matrix;
use MathPHP\LinearAlgebra\MatrixFactory;

final class MathSquareMatrix implements SquareMatrix
{
    /**
     * @var Matrix
     */
    private $matrix;

    /**
     * @var MatrixFactory
     */
    private $matrixFactory;

    public function __construct(Matrix $matrix, LinearAlgebraFactory $matrixFactory)
    {
        $this->matrix = $matrix;
        $this->matrixFactory = $matrixFactory;
    }

    public function inverse(): SquareMatrix
    {
        return new self($this->matrix->inverse(), $this->matrixFactory);
    }

    public function multiplyByVector(array $vector): array
    {
        return $this->matrix->vectorMultiply($this->matrixFactory->createVector($vector))->jsonSerialize();
    }
}
