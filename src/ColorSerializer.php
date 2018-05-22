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
    const COLOR_DEPTH_16BIT = 65535;
    const COLOR_DEPTH_8BIT = 255;

    /**
     * Encodes linear RGB into corrected RGB code
     *
     * @param float[] $rgb
     * @param int $colorDepth
     *
     * @return int[]
     */
    public function encode(array $rgb, int $colorDepth = self::COLOR_DEPTH_8BIT): array;

    /**
     * Decodes gamma corrected RGB code into linear value
     *
     * @param int[] $rgb
     * @param int $colorDepth
     *
     * @return float[]
     */
    public function decode(array $rgb, int $colorDepth = self::COLOR_DEPTH_8BIT): array;
}
