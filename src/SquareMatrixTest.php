<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace EcomDev\Color;

use PHPUnit\Framework\TestCase;

class SquareMatrixTest extends TestCase
{
    /**
     * @var MathSquareMatrixFactory
     */
    private $squareMatrixFactory;

    protected function setUp()
    {
        $this->squareMatrixFactory = new MathSquareMatrixFactory();
    }

    /** @test */
    public function invertsTwoByTwoMatrix()
    {
        $matrix = $this->squareMatrixFactory->createFromArray([
            [1, 2],
            [3, 4]
        ]);

        $this->assertEquals(
            $this->squareMatrixFactory->createFromArray([
                [-2, 1],
                [1.5, -0.5]
            ]),
            $matrix->inverse()
        );
    }

    /** @test */
    public function invertsThreeByThreeMatrix()
    {
        $matrix = $this->squareMatrixFactory->createFromArray([
            [0.5,  0.1,  0.2],
            [0.4,  0.8,  0.5],
            [0.6,  0.6,  0.5]
        ]);

        $this->assertEquals(
            $this->squareMatrixFactory->createFromArray([
                [8.33333333, 5.83333333, -9.16666667],
                [8.33333333, 10.83333333, -14.16666667],
                [-20, -20,  30]
            ]),
            $matrix->inverse(),
            '',
            0.000001
        );
    }

    /** @test */
    public function multipliesThreeByThreeMatrixByVector()
    {
        $matrix = $this->squareMatrixFactory->createFromArray([
            [0.5,  0.1,  0.2],
            [0.4,  0.8,  0.5],
            [0.6,  0.6,  0.5]
        ]);

        $this->assertEquals(
            [6.1, 9.5, 10.5],
            $matrix->multiplyByVector([10, 5, 3])
        );
    }

    /** @test */
    public function multipliesTwoByTwoMatrixByVector()
    {
        $matrix = $this->squareMatrixFactory->createFromArray([
            [0.5,  0.1],
            [0.4,  0.8],
        ]);

        $this->assertEquals(
            [5.5, 8.0],
            $matrix->multiplyByVector([10, 5])
        );
    }
}
