<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace EcomDev\Color;

interface SquareMatrixFactory
{
    public function createFromArray(array $matrix): SquareMatrix;
}
