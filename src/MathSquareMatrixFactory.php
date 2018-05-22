<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace EcomDev\Color;

use MathPHP\LinearAlgebra\Matrix;
use MathPHP\LinearAlgebra\MatrixFactory;

final class MathSquareMatrixFactory implements SquareMatrixFactory
{
    /**
     * @var MatrixFactory
     */
    private $linearAlgebraFactory;

    public function __construct(LinearAlgebraFactory $linearAlgebraFactory = null)
    {
        $this->linearAlgebraFactory = $algebraFactory ?? new LinearAlgebraFactory();
    }

    public function createFromArray(array $matrix): SquareMatrix
    {
        return $this->createMatrix(
            $this->linearAlgebraFactory->createMatrix($matrix)
        );
    }

    public function createFromVectors(array ...$vectors): SquareMatrix
    {
        return $this->createMatrix(
            $this->linearAlgebraFactory->createFromVectors(
                ...array_map([$this->linearAlgebraFactory, 'createVector'], $vectors)
            )
        );
    }

    protected function createMatrix(Matrix $mathMatrix): MathSquareMatrix
    {
        return new MathSquareMatrix(
            $mathMatrix,
            $this->linearAlgebraFactory
        );
    }


}
