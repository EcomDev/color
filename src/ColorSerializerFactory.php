<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace EcomDev\Color;


class ColorSerializerFactory
{
    public function createGammaCurveSerializer(float $gamma = null): GammaCurveSerializer
    {
        return $gamma ? new GammaCurveSerializer($gamma) : new GammaCurveSerializer();
    }

    public function createSRGBSerializer(): SRGBSerializer
    {
        return new SRGBSerializer();
    }
}
