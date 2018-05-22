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

    public function rgbToTristimusMatix(): SquareMatrix
    {
        list($whiteRedRatio, $whiteGreenRatio, $whiteBlueRatio) = $this->squareMatrixFactory
            ->createFromVectors(
                $this->redPrimary,
                $this->greenPrimary,
                $this->bluePrimary
            )
            ->inverse()
            ->multiplyByVector($this->whitePoint)
        ;


        return $this->squareMatrixFactory->createFromVectors(
            $this->multiplyPrimary($this->redPrimary, $whiteRedRatio),
            $this->multiplyPrimary($this->greenPrimary, $whiteGreenRatio),
            $this->multiplyPrimary($this->bluePrimary, $whiteBlueRatio)
        );
    }


    public function tristimusToRgbMatrix(): SquareMatrix
    {
        return $this->rgbToTristimusMatix()->inverse();
    }

    public function encodeColor(array $rgb, $depth = self::TRUE_COLOR): array
    {
        return $this->colorSerializer->encode($rgb, $depth);
    }

    public function decodeColor(array $rgb, $depth = self::TRUE_COLOR): array
    {
        return $this->colorSerializer->decode($rgb, $depth);
    }

    private function multiplyPrimary(array $primary, float $multiplier): array
    {
        $result = [];
        foreach ($primary as $index => $value) {
            $result[$index] = $value * $multiplier;
        }

        return $result;
    }
}
