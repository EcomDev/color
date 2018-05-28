<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace EcomDev\Color;


final class RGBColorSpace
{
    const TRUE_COLOR = 255;
    const DEEP_COLOR = 65535;

    /**
     * @var float[]
     */
    private $redPrimary;

    /**
     * @var float[]
     */
    private $greenPrimary;

    /**
     * @var float[]
     */
    private $bluePrimary;

    /**
     * @var float[]
     */
    private $whitePoint;

    /**
     * @var ColorSerializer
     */
    private $colorSerializer;

    /**
     * @var SquareMatrixFactory
     */
    private $squareMatrixFactory;

    public function __construct(
        array $redPrimary,
        array $greenPrimary,
        array $bluePrimary,
        array $whitePoint,
        ColorSerializer $colorSerializer,
        SquareMatrixFactory $squareMatrixFactory
    ) {

        $this->redPrimary = $redPrimary;
        $this->greenPrimary = $greenPrimary;
        $this->bluePrimary = $bluePrimary;
        $this->whitePoint = $whitePoint;
        $this->colorSerializer = $colorSerializer;
        $this->squareMatrixFactory = $squareMatrixFactory;
    }

    public function rgbToTristimulusMatix(): SquareMatrix
    {
        list($whiteRedRatio, $whiteGreenRatio, $whiteBlueRatio) = $this->squareMatrixFactory
            ->createFromArray([
                [$this->redPrimary[0], $this->greenPrimary[0], $this->bluePrimary[0]],
                [$this->redPrimary[1], $this->greenPrimary[1], $this->bluePrimary[1]],
                [$this->redPrimary[2], $this->greenPrimary[2], $this->bluePrimary[2]],
            ])
            ->inverse()
            ->multiplyByVector($this->whitePoint)
        ;

        $matrix = [
            [
                $this->redPrimary[0] * $whiteRedRatio,
                $this->greenPrimary[0] * $whiteGreenRatio,
                $this->bluePrimary[0] * $whiteBlueRatio,
            ],
            [
                $this->redPrimary[1] * $whiteRedRatio,
                $this->greenPrimary[1] * $whiteGreenRatio,
                $this->bluePrimary[1] * $whiteBlueRatio,
            ],
            [
                $this->redPrimary[2] * $whiteRedRatio,
                $this->greenPrimary[2] * $whiteGreenRatio,
                $this->bluePrimary[2] * $whiteBlueRatio,
            ]
        ];

        return $this->squareMatrixFactory->createFromArray($matrix);
    }


    public function tristimulusToRgbMatrix(): SquareMatrix
    {
        return $this->rgbToTristimulusMatix()->inverse();
    }

    public function encodeColor(array $rgb, $depth = self::TRUE_COLOR): array
    {
        return $this->colorSerializer->encode($rgb, $depth);
    }

    public function decodeColor(array $rgb, $depth = self::TRUE_COLOR): array
    {
        return $this->colorSerializer->decode($rgb, $depth);
    }
}
