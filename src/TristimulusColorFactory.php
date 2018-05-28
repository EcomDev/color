<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace EcomDev\Color;

final class TristimulusColorFactory
{
    /** @var CIELabConverter */
    private $labConverter;

    public function __construct(CIELabConverter $labConverter = null)
    {
        $this->labConverter = $labConverter ?? new CIELabConverter();
    }

    public function createFromChromacity(float $x, float $y, float $luminance = 1)
    {
        $z = 1 - $x - $y;
        $X = ($x * $luminance) / $y;
        $Z = ($z * $luminance) / $y;

        return [$X, $luminance, $Z];
    }

    public function createFromValues(float $X, float $Y, float $Z)
    {
        return [$X, $Y, $Z];
    }

    public function createFromRGB(array $rgb, RGBColorSpace $colorSpace): array
    {
        $rgbLinear = $colorSpace->decodeColor($rgb);
        return $colorSpace->rgbToTristimulusMatix()->multiplyByVector($rgbLinear);
    }

    public function createFrom16BitRGB(array $rgb, RGBColorSpace $colorSpace): array
    {
        $rgbLinear = $colorSpace->decodeColor($rgb, RGBColorSpace::DEEP_COLOR);
        return $colorSpace->rgbToTristimulusMatix()->multiplyByVector($rgbLinear);
    }

    public function createFromLab(array $labColor, array $whiteChromacity): array
    {
        $whitePoint = $this->createFromChromacity(...$whiteChromacity);
        return $this->labConverter->convertToTristimusValue($labColor, $whitePoint);
    }
}
