<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace EcomDev\Color;


class OptimizedThreeByTheeMatrix implements SquareMatrix
{
    const M₁₁ = 0;
    const M₁₂ = 1;
    const M₁₃ = 2;
    const M₂₁ = 3;
    const M₂₂ = 4;
    const M₂₃ = 5;
    const M₃₁ = 6;
    const M₃₂ = 7;
    const M₃₃ = 8;

    /**
     * Matrix value
     *
     * @var \SplFixedArray
     */
    private $value;

    public function __construct(\SplFixedArray $value)
    {
        $this->value = $value;
    }

    public function inverse(): SquareMatrix
    {
        return new self($this->multiplyMatrixByScalar(
            1 / $this->determinant($this->value),
            $this->transposeMatrix($this->cofactorMatrix($this->value))
        ));
    }

    public function multiplyByVector(array $vector): array
    {
        list($v₁, $v₂, $v₃) = $vector;

        return [
            $this->value[self::M₁₁] * $v₁ + $this->value[self::M₁₂] * $v₂ + $this->value[self::M₁₃] * $v₃,
            $this->value[self::M₂₁] * $v₁ + $this->value[self::M₂₂] * $v₂ + $this->value[self::M₂₃] * $v₃,
            $this->value[self::M₃₁] * $v₁ + $this->value[self::M₃₂] * $v₂ + $this->value[self::M₃₃] * $v₃,
        ];
    }

    private function transposeMatrix(\SplFixedArray $matrix)
    {
        return \SplFixedArray::fromArray([
            $matrix[self::M₁₁], $matrix[self::M₂₁], $matrix[self::M₃₁],
            $matrix[self::M₁₂], $matrix[self::M₂₂], $matrix[self::M₃₂],
            $matrix[self::M₁₃], $matrix[self::M₂₃], $matrix[self::M₃₃]
        ]);
    }

    private function multiplyMatrixByScalar($scalar, \SplFixedArray $matrix)
    {

        return \SplFixedArray::fromArray([
            $matrix[self::M₁₁] * $scalar, $matrix[self::M₁₂] * $scalar, $matrix[self::M₁₃] * $scalar,
            $matrix[self::M₂₁] * $scalar, $matrix[self::M₂₂] * $scalar, $matrix[self::M₂₃] * $scalar,
            $matrix[self::M₃₁] * $scalar, $matrix[self::M₃₂] * $scalar, $matrix[self::M₃₃] * $scalar
        ]);
    }

    private function cofactorMatrix(\SplFixedArray $matrix)
    {
        $result = \SplFixedArray::fromArray([
            $this->minorDeterminant($matrix[self::M₂₂], $matrix[self::M₂₃], $matrix[self::M₃₂], $matrix[self::M₃₃]),
            -$this->minorDeterminant($matrix[self::M₂₁], $matrix[self::M₂₃], $matrix[self::M₃₁], $matrix[self::M₃₃]),
            $this->minorDeterminant($matrix[self::M₂₁], $matrix[self::M₂₂], $matrix[self::M₃₁], $matrix[self::M₃₂]),
            -$this->minorDeterminant($matrix[self::M₁₂], $matrix[self::M₁₃], $matrix[self::M₃₂], $matrix[self::M₃₃]),
            $this->minorDeterminant($matrix[self::M₁₁], $matrix[self::M₁₃], $matrix[self::M₃₁], $matrix[self::M₃₃]),
            -$this->minorDeterminant($matrix[self::M₁₁], $matrix[self::M₁₂], $matrix[self::M₃₁], $matrix[self::M₃₂]),
            $this->minorDeterminant($matrix[self::M₁₂], $matrix[self::M₁₃], $matrix[self::M₂₂], $matrix[self::M₂₃]),
            -$this->minorDeterminant($matrix[self::M₁₁], $matrix[self::M₁₃], $matrix[self::M₂₁], $matrix[self::M₂₃]),
            $this->minorDeterminant($matrix[self::M₁₁], $matrix[self::M₁₂], $matrix[self::M₂₁], $matrix[self::M₂₂])
        ]);

        return $result;
    }

    private function determinant(\SplFixedArray $matrix)
    {
        return $matrix[self::M₁₁] * $this->minorDeterminant(
                $matrix[self::M₂₂],
                $matrix[self::M₂₃],
                $matrix[self::M₃₂],
                $matrix[self::M₃₃]
            )
            - $matrix[self::M₁₂] * $this->minorDeterminant(
                $matrix[self::M₂₁],
                $matrix[self::M₂₃],
                $matrix[self::M₃₁],
                $matrix[self::M₃₃]
            )
            + $matrix[self::M₁₃] * $this->minorDeterminant(
                $matrix[self::M₂₁],
                $matrix[self::M₂₂],
                $matrix[self::M₃₁],
                $matrix[self::M₃₂]
            );
    }

    private function minorDeterminant($a, $b, $c, $d)
    {
        return $a*$d - $b*$c;
    }
}
