<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace EcomDev\Color;

class RGBColorSpaceFactory
{

    private const COLOR_SPACE_SRGB = [
        [0.64, 0.33, 0.2126],
        [0.3, 0.6, 0.7152],
        [0.15, 0.06, 0.0722],
        CIEIlluminant::D65
    ];

    /**
     * @var TristimulusColorFactory
     */
    private $colorFactory;

    /**
     * @var ColorSerializerFactory
     */
    private $serializerFactory;
    /**
     * @var SquareMatrixFactory
     */
    private $matrixFactory;

    public function __construct(
        TristimulusColorFactory $colorFactory = null,
        ColorSerializerFactory $serializerFactory = null,
        SquareMatrixFactory $matrixFactory = null
    ) {
        $this->colorFactory = $colorFactory ?? new TristimulusColorFactory();
        $this->serializerFactory = $serializerFactory ?? new ColorSerializerFactory();
        $this->matrixFactory = $matrixFactory ?? new MathSquareMatrixFactory();
    }

    public function createFromPrimary(
        array $redPrimary,
        array $greenPrimary,
        array $bluePrimary,
        array $whitePoint,
        float $gamma
    ): RGBColorSpace {
        return new RGBColorSpace(
            $this->colorFactory->createFromChromacity(...$redPrimary),
            $this->colorFactory->createFromChromacity(...$greenPrimary),
            $this->colorFactory->createFromChromacity(...$bluePrimary),
            $this->colorFactory->createFromChromacity(...$whitePoint),
            $this->serializerFactory->createGammaCurveSerializer($gamma),
            $this->matrixFactory
        );
    }

    public function createSRGB(): RGBColorSpace
    {
        list($redPrimary, $greenPrimary, $bluePrimary, $whitePoint) = self::COLOR_SPACE_SRGB;

        return new RGBColorSpace(
            $this->colorFactory->createFromChromacity(...$redPrimary),
            $this->colorFactory->createFromChromacity(...$greenPrimary),
            $this->colorFactory->createFromChromacity(...$bluePrimary),
            $this->colorFactory->createFromChromacity(...$whitePoint),
            $this->serializerFactory->createSRGBSerializer(),
            $this->matrixFactory
        );
    }

    /**
     * @param float $gamma
     *
     * @return GammaCurveSerializer
     */
    protected function createColorSerializer(float $gamma): ColorSerializer
    {
        if ($gamma === null) {
            return $this->serializerFactory->createSRGBSerializer();
        }

        return $this->serializerFactory->createGammaCurveSerializer($gamma);
    }
}
