<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace EcomDev\Color;


final class TristimulusValueFactory
{
    public function createFromChromacity(float $x, float $y, float $luminance = 1)
    {
        $X = ($luminance / $y) * $x;
        $Z = ($luminance / $y) * (1 - $x - $y);

        return new TristimulusValue($X, $luminance, $Z);
    }

    public function createFromTristimulusValues(float $X, float $Y, float $Z)
    {
        return new TristimulusValue($X, $Y, $Z);
    }
}
