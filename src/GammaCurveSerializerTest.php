<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace EcomDev\Color;

use PHPUnit\Framework\TestCase;

class GammaCurveSerializerTest extends TestCase
{
    /**
     * @test
     * @testWith [[127, 127, 127], [0.49804, 0.49804, 0.49804]]
     *           [[26, 51, 77], [0.10196, 0.2, 0.30196]]
     */
    public function decodesIntoLinearRGBValueWhenGammaIsLinear(array $rgbCode, array $rgbLinear)
    {
        $this->assertEquals(
            $rgbLinear,
            $this->createSerializer()->decode($rgbCode),
            '',
            0.00001
        );
    }

    /**
     * @test
     * @testWith [[0.49804, 0.49804, 0.49804], [127, 127, 127]]
     *           [[0.10196, 0.2, 0.30196], [26, 51, 77]]
     */
    public function encodesIntoRGBCodeFromLinearValueWhenGammaIsLinear(array $rgbLinear, array $rgbCode)
    {
        $this->assertEquals(
            $rgbCode,
            $this->createSerializer()->encode($rgbLinear),
            '',
            0.00001
        );
    }

    /**
     * @test
     * @testWith [[127, 127, 127], [0.215764, 0.215764, 0.215764]]
     *           [[26, 51, 77], [0.006585, 0.028991, 0.071762]]
     */
    public function decodesRGBCodeIntoLinearWithStandardGammaValue(array $rgbCode, array $rgbLinear)
    {
        $this->assertEquals(
            $rgbLinear,
            $this->createSerializer(2.2)->decode($rgbCode),
            '',
            0.00001
        );
    }

    /**
     * @test
     * @testWith [[0.215764, 0.215764, 0.215764], [127, 127, 127]]
     *           [[0.006585, 0.028991, 0.071762], [26, 51, 77]]
     */
    public function encodesIntoRGBCodeFromLinearValueWithStandardGamma(array $rgbLinear, array $rgbCode)
    {
        $this->assertEquals(
            $rgbCode,
            $this->createSerializer(2.2)->encode($rgbLinear),
            '',
            0.00001
        );
    }

    /**
     * @test
     * @testWith [[0.215764, 0.215764, 0.215764], [32639, 32639, 32639]]
     *           [[0.006585, 0.028991, 0.071762], [6682, 13107, 19789]]
     */
    public function encodesInto16BitRGBCodeFromLinearValueWithStandardGamma(array $rgbLinear, array $rgbCode)
    {
        $this->assertEquals(
            $rgbCode,
            $this->createSerializer(2.2)->encode($rgbLinear, ColorSerializer::COLOR_DEPTH_16BIT),
            '',
            0.00001
        );
    }

    /**
     * @test
     * @testWith [[32639, 32639, 32639], [0.215764, 0.215764, 0.215764]]
     *           [[6682, 13107, 19789], [0.006585, 0.028991, 0.071762]]
     */
    public function decodes16BitRGBCodeIntoLinearWithStandardGammaValue(array $rgbCode, array $rgbLinear)
    {
        $this->assertEquals(
            $rgbLinear,
            $this->createSerializer(2.2)->decode($rgbCode, ColorSerializer::COLOR_DEPTH_16BIT),
            '',
            0.00001
        );
    }

    protected function createSerializer($gamma = null): GammaCurveSerializer
    {
        return $gamma ? new GammaCurveSerializer($gamma) : new GammaCurveSerializer();
    }
}
