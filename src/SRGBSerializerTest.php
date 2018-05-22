<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace EcomDev\Color;

use PHPUnit\Framework\TestCase;

class SRGBSerializerTest extends TestCase
{
    /** @var SRGBSerializer */
    private $serializer;

    protected function setUp()
    {
        $this->serializer = new SRGBSerializer();
    }

    /**
     * @test
     * @testWith [[127, 127, 127], [0.212231, 0.212231, 0.212231]]
     *           [[26, 51, 77],    [0.010330, 0.033105, 0.074214]]
     *           [[7, 7, 7],       [0.002125, 0.002125, 0.002125]]
     *           [[1, 6, 50],      [0.000304, 0.001821, 0.031896]]
     */
    public function decodesIntoLinearRGBValueWithDefaultGamma(array $rgbCode, array $rgbLinear)
    {
        $this->assertEquals(
            $rgbLinear,
            $this->serializer->decode($rgbCode),
            '',
            0.00001
        );
    }

    /**
     * @test
     * @testWith [[0.212231, 0.212231, 0.212231], [127, 127, 127]]
     *           [[0.010330, 0.033105, 0.074214], [26, 51, 77]]
     *           [[0.002125, 0.002125, 0.002125], [7, 7, 7]]
     *           [[0.000304, 0.001821, 0.031896], [1, 6, 50]]
     */
    public function encodesIntoRGBCodeFromLinear(array $rgbLinear, array $rgbCode)
    {
        $this->assertEquals(
            $rgbCode,
            $this->serializer->encode($rgbLinear),
            '',
            0.00001
        );
    }

    /**
     * @test
     * @testWith [[0.212231, 0.212231, 0.212231], [32639, 32639, 32639]]
     *           [[0.010330, 0.033105, 0.074214], [6682, 13107, 19789]]
     *           [[0.002125, 0.002125, 0.002125], [1799, 1799, 1799]]
     *           [[0.000304, 0.001821, 0.031896], [257, 1542, 12850]]
     */
    public function encodesInto16BitRGBCodeFromLinearValue(array $rgbLinear, array $rgbCode)
    {
        $this->assertEquals(
            $rgbCode,
            $this->serializer->encode($rgbLinear, ColorSerializer::COLOR_DEPTH_16BIT),
            '',
            0.00001
        );
    }

    /**
     * @test
     * @testWith [[32639, 32639, 32639], [0.212231, 0.212231, 0.212231]]
     *           [[6682, 13107, 19789], [0.010330, 0.033105, 0.074214]]
     */
    public function decodes16BitRGBCodeIntoLinear(array $rgbCode, array $rgbLinear)
    {
        $this->assertEquals(
            $rgbLinear,
            $this->serializer->decode($rgbCode, ColorSerializer::COLOR_DEPTH_16BIT),
            '',
            0.00001
        );
    }
}
