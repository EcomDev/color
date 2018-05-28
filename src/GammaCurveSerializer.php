<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace EcomDev\Color;


class GammaCurveSerializer implements ColorSerializer
{
    /**
     * @var float
     */
    private $gamma;

    public function __construct(float $gamma = 1.0)
    {
        $this->gamma = $gamma;
    }

    /**
     * Encodes linear RGB into gamma corrected RGB code
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
                return (int)round($linear ** (1 / $this->gamma) * $colorDepth);
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
                return (float)($code / $colorDepth) ** $this->gamma;
            },
            $rgb
        );
    }
}
