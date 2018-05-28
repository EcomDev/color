<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace EcomDev\Color;

class CIELabConverter
{
    public function convertToTristimusValue(array $labColor, array $whitePoint): array
    {
        return $this->multiplyFractionsByWhitePoint(
            $whitePoint,
            $this->calculateLabColorFractions($labColor)
        );
    }

    private function transformLabColorFraction($fraction)
    {
        if ($fraction ** 3 > CIELab::EPSILON) {
            return $fraction ** 3;
        }

        return (116 * $fraction - 16) / CIELab::KAPPA;
    }

    private function transformLabLightness($lightness): float
    {
        if ($lightness > CIELab::EPSILON * CIELab::KAPPA) {
            return $this->calculateLabLightnessFraction($lightness) ** 3;
        }

        return $lightness / CIELab::KAPPA;
    }

    private function calculateLabLightnessFraction(float $lightness): float
    {
        return ($lightness + 16) / 116;
    }

    private function calculateLabGreenRedFraction(float $value, float $lightness): float
    {
        return $this->calculateLabLightnessFraction($lightness) + ($value / 500);
    }

    private function calculateLabBlueYellowFraction(float $value, float $lightness): float
    {
        return $this->calculateLabLightnessFraction($lightness) - ($value / 200);
    }

    private function calculateLabColorFractions(array $labColor): array
    {
        list($lightness, $greenRed, $blueYellow) = $labColor;

        $fractions = [
            $this->transformLabColorFraction(
                $this->calculateLabGreenRedFraction($greenRed, $lightness)
            ),
            $this->transformLabLightness($lightness),
            $this->transformLabColorFraction(
                $this->calculateLabBlueYellowFraction($blueYellow, $lightness)
            )
        ];

        return $fractions;
    }

    private function multiplyFractionsByWhitePoint(array $whitePoint, array $fractions): array
    {
        $tristimusColor = array_map(
            function ($left, $right) {
                return $left * $right;
            },
            $whitePoint,
            $fractions
        );

        return $tristimusColor;
    }
}
