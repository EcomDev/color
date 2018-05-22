<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace EcomDev\Color;

/**
 * Interface ColorSerializer
 */
interface ColorSerializer
{
    const DEEP_COLOR = RGBColorSpace::DEEP_COLOR;
    const TRUE_COLOR = RGBColorSpace::TRUE_COLOR;

    /**
     * Encodes linear RGB into corrected RGB code
     *
     * @param float[] $rgb
     * @param int $colorDepth
     *
     * @return int[]
     */
    public function encode(array $rgb, int $colorDepth = self::TRUE_COLOR): array;

    /**
     * Decodes gamma corrected RGB code into linear value
     *
     * @param int[] $rgb
     * @param int $colorDepth
     *
     * @return float[]
     */
    public function decode(array $rgb, int $colorDepth = self::TRUE_COLOR): array;
}
