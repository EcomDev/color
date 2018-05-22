<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace EcomDev\Color;


final class TristimulusColorFactory
{
    public function createFromChromacity(float $x, float $y, float $luminance = 1)
    {
        $X = ($luminance / $y) * $x;
        $Z = ($luminance / $y) * (1 - $x - $y);

        return [$X, $luminance, $Z];
    }

    public function createFromValues(float $X, float $Y, float $Z)
    {
        return [$X, $Y, $Z];
    }

    public function createFromRGB(array $rgb, RGBColorSpace $colorSpace): array
    {
        throw new \LogicException('Not implemented yet');
    }
}
