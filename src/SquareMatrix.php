<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace EcomDev\Color;

/**
 * Square Matrix
 *
 */
interface SquareMatrix
{
    /**
     * Inverses matrix
     *
     * @return SquareMatrix
     */
    public function inverse(): SquareMatrix;

    /**
     * Multiplies matrix by a vector
     *
     * @param array $vector
     *
     * @return array
     */
    public function multiplyByVector(array $vector): array;
}
