<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace EcomDev\Color;


class SRGBSerializer implements ColorSerializer
{

    /**
     * Encodes linear RGB into corrected RGB code
     *
     * @param float[] $rgb
     * @param int $colorDepth
     *
     * @return int[]
     */
    public function encode(array $rgb, int $colorDepth = self::TRUE_COLOR): array
    {
        return array_map(
            function (float $linear) use ($colorDepth) : int {
                $sRGBLinear = $this->forwardSRGBTransformation($linear);

                return (int)round($sRGBLinear * $colorDepth);
            },
            $rgb
        );
    }

    /**
     * Decodes gamma corrected RGB code into linear value
     *
     * @param int[] $rgb
     * @param int $colorDepth
     *
     * @return float[]
     */
    public function decode(array $rgb, int $colorDepth = self::TRUE_COLOR): array
    {
        return array_map(
            function (int $code) use ($colorDepth) : float {
                $sRGBLinear = $code / $colorDepth;

                $linear = $this->reverseSRGBTransformation($sRGBLinear);

                return (float)$linear;
            },
            $rgb
        );
    }

    private function forwardSRGBTransformation(float $linear): float
    {
        if ($linear <= 0.0031308) {
            return $linear * 12.92;
        }

        return 1.055 * ($linear ** (1 / 2.4)) - .055;
    }

    private function reverseSRGBTransformation(float $sRGBLinear): float
    {
        if ($sRGBLinear <= 0.04045) {
            return $sRGBLinear / 12.92;
        }

        return (($sRGBLinear + .055) / 1.055) ** 2.4;
    }
}
