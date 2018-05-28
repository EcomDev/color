<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace EcomDev\Color;

use PHPUnit\Framework\TestCase;

class AppleRGBColorSpaceTest extends TestCase
{
    /** @var RGBColorSpace */
    private $colorSpace;

    protected function setUp()
    {
        $factory = new RGBColorSpaceFactory();
        $this->colorSpace = $factory->createFromPrimary(
            [0.6250, 0.3400],
            [0.2800, 0.5950],
            [0.1550, 0.0700],
            CIEIlluminant::D65,
            1.8
        );
    }

    /** @test */
    public function generatesRGBToTristimulusConversionMatrix()
    {
        $matrixFactory = new MathSquareMatrixFactory();

        $this->assertThat(
            $this->colorSpace->rgbToTristimulusMatix(),
            $this->equalTo(
                $matrixFactory->createFromArray([
                    [.4496588, .3162637, .1845061],
                    [.2446144, .6720603, .0833253],
                    [.0251809, .1411891, .9225303]
                ]),
                .0000001
            )
        );
    }

    /** @test */
    public function generatesTristimulusToRGBConversionMatrix()
    {
        $matrixFactory = new MathSquareMatrixFactory();
        $this->assertThat(
            $this->colorSpace->tristimulusToRgbMatrix(),
            $this->equalTo(
                $matrixFactory->createFromArray([
                    [ 2.9519969, -1.2896124, -0.4739183],
                    [-1.0850577,  1.9907618,  0.0372008],
                    [ 0.0854871, -0.2694766,  1.0912176]
                ]),
                0.0000001
            )
        );
    }

    /**
     * @test
     * @testWith [[0.285151, 0.285151, 0.285151], [127, 127, 127]]
     *           [[0.016413, 0.055189, 0.115854], [26, 51, 77]]
     *           [[0.001547, 0.001547, 0.001547], [7, 7, 7]]
     *           [[0.000047, 0.001172, 0.053257], [1, 6, 50]]
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
     * @testWith [[127, 127, 127], [0.285151, 0.285151, 0.285151]]
     *           [[26, 51, 77],    [0.016413, 0.055189, 0.115854]]
     *           [[7, 7, 7],       [0.001547, 0.001547, 0.001547]]
     *           [[1, 6, 50],      [0.000047, 0.001172, 0.053257]]
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
     * @testWith [[0.285151,  0.285151, 0.285151], [32639, 32639, 32639]]
     *           [[0.016413,  0.055189, 0.115854], [6682, 13107, 19789]]
     *           [[0.001547,  0.001547, 0.001547], [1799, 1799, 1799]]
     *           [[0.0000467, 0.001172, 0.053257], [257, 1542, 12850]]
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
     * @testWith [[32639, 32639, 32639], [0.285151, 0.285151, 0.285151]]
     *           [[6682, 13107, 19789],  [0.016413, 0.055189, 0.115854]]
     *           [[1799, 1799, 1799],    [0.001547, 0.001547, 0.001547]]
     *           [[257, 1542, 12850],    [0.000047, 0.001172, 0.053257]]
     */
    public function decodesLinearFromDeepRGBColor(array $rgbCode, array $rgbLinear)
    {
        $this->assertThat(
            $this->colorSpace->decodeColor($rgbCode, RGBColorSpace::DEEP_COLOR),
            $this->equalTo($rgbLinear, 0.000001)
        );
    }
}
