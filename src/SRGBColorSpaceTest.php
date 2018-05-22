<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace EcomDev\Color;

use PHPUnit\Framework\TestCase;

class SRGBColorSpaceTest extends TestCase
{
    /** @var RGBColorSpace */
    private $colorSpace;

    protected function setUp()
    {
        $factory = new RGBColorSpaceFactory();
        $this->colorSpace = $factory->createSRGB();
    }

    /** @test */
    public function generatesRGBToTristimulusConversionMatrix()
    {
        $matrixFactory = new MathSquareMatrixFactory();

        $this->assertThat(
            $this->colorSpace->rgbToTristimusMatix(),
            $this->equalTo(
                $matrixFactory->createFromArray([
                    [.4123866, .3575915, .1804505],
                    [.2126368, .7151830, .0721802],
                    [.0193306, .1191972, .9503726]
                ]),
                0.0000001
            )
        );
    }

    /** @test */
    public function generatesTristimulusToRGBConversionMatrix()
    {
        $matrixFactory = new MathSquareMatrixFactory();
        $this->assertThat(
            $this->colorSpace->tristimusToRgbMatrix(),
            $this->equalTo(
                $matrixFactory->createFromArray([
                    [ 3.2410032, -1.5373990, -0.4986159],
                    [-0.9692243,  1.8759300,  0.0415542],
                    [ 0.0556394, -0.2040112,  1.0571490]
                ]),
                0.0000001
            )
        );
    }

    /**
     * @test
     * @testWith [[0.212231, 0.212231, 0.212231], [127, 127, 127]]
     *           [[0.010330, 0.033105, 0.074214], [26, 51, 77]]
     *           [[0.002125, 0.002125, 0.002125], [7, 7, 7]]
     *           [[0.000304, 0.001821, 0.031896], [1, 6, 50]]
     */
    public function encodesRGBColorFromLinear(array $rgbLinear, array $rgbCode)
    {
        $this->assertEquals(
            $rgbCode,
            $this->colorSpace->encodeColor($rgbLinear)
        );
    }

    /**
     * @test
     * @testWith [[127, 127, 127], [0.212231, 0.212231, 0.212231]]
     *           [[26, 51, 77], [0.010330, 0.033105, 0.074214]]
     *           [[7, 7, 7], [0.002125, 0.002125, 0.002125]]
     *           [[1, 6, 50], [0.000304, 0.001821, 0.031896]]
     */
    public function decodesLinearFromRGBColor(array $rgbCode, array $rgbLinear)
    {
        $this->assertThat(
            $this->colorSpace->decodeColor($rgbCode),
            $this->equalTo($rgbLinear, 0.000001)
        );
    }

    /**
     * @test
     * @testWith [[0.212231, 0.212231, 0.212231], [32639, 32639, 32639]]
     *           [[0.010330, 0.033105, 0.074214], [6682, 13107, 19789]]
     *           [[0.002125, 0.002125, 0.002125], [1799, 1799, 1799]]
     *           [[0.000304, 0.001821, 0.031896], [257, 1542, 12850]]
     */
    public function encodesDeepRGBColorFromLinear(array $rgbLinear, array $rgbCode)
    {
        $this->assertEquals(
            $rgbCode,
            $this->colorSpace->encodeColor($rgbLinear, RGBColorSpace::DEEP_COLOR)
        );
    }

    /**
     * @test
     * @testWith [[32639, 32639, 32639], [0.212231, 0.212231, 0.212231]]
     *           [[6682, 13107, 19789], [0.010330, 0.033105, 0.074214]]
     *           [[1799, 1799, 1799], [0.002125, 0.002125, 0.002125]]
     *           [[257, 1542, 12850], [0.000304, 0.001821, 0.031896]]
     */
    public function decodesLinearFromDeepRGBColor(array $rgbCode, array $rgbLinear)
    {
        $this->assertThat(
            $this->colorSpace->decodeColor($rgbCode, RGBColorSpace::DEEP_COLOR),
            $this->equalTo($rgbLinear, 0.000001)
        );
    }
}
