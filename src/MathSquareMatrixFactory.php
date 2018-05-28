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
        if (count($matrix) === 3) {
            return new OptimizedThreeByTheeMatrix(\SplFixedArray::fromArray(array_merge(...$matrix), false));
        }

        return new MathSquareMatrix(
            $this->linearAlgebraFactory->createMatrix($matrix),
            $this->linearAlgebraFactory
        );
    }
}
