<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace EcomDev\Color;

use PHPUnit\Framework\TestCase;

class TristimulusColorFactoryTest extends TestCase
{
    /** @var TristimulusColorFactory */
    private $colorFactory;

    /**
     * @var RGBColorSpaceFactory
     */
    private $colorSpaceFactory;

    protected function setUp()
    {
        $this->colorFactory = new TristimulusColorFactory();
        $this->colorSpaceFactory = new RGBColorSpaceFactory();
    }

    /** @test */
    public function createsFromChromaticityValueForD65()
    {
        $this->assertEquals(
            [.95042, 1, 1.0889],
            $this->colorFactory->createFromChromacity(...CIEIlluminant::D65),
            '',
            0.00001
        );
    }

    /** @test */
    public function createsFromChromaticityValueForD50()
    {
        $this->assertEquals(
            [.96421, 1,  .82518],
            $this->colorFactory->createFromChromacity(...CIEIlluminant::D50),
            '',
            0.00001
        );
    }

    /** @test */
    public function createsFromStaticValues()
    {
        $this->assertEquals(
            [.96421, 1,  .82519],
            $this->colorFactory->createFromValues(.96421, 1,  .82519)
        );
    }

    /**
     * @test
     * @testWith [[5, 10, 50],     [0.007467, 0.004796, 0.030704]]
     *           [[50, 50, 50],    [0.030315, 0.031896, 0.034731]]
     *           [[127, 100, 200], [0.237317, 0.177960, 0.568209]]
     */
    public function createsFromColorInSRGBColorSpace(array $rgbCode, array $expectedTristimulusValue)
    {
        $this->assertThat(
            $this->colorFactory->createFromRGB($rgbCode, $this->colorSpaceFactory->createSRGB()),
            $this->equalTo($expectedTristimulusValue, 0.000001)
        );
    }

    /**
     * @test
     * @testWith [[1285,  2570, 12850],  [0.007467, 0.004796, 0.030704]]
     *           [[12850, 12850, 12850], [0.030315, 0.031896, 0.034731]]
     *           [[32639, 25700, 51400], [0.237317, 0.177960, 0.568209]]
     */
    public function createsFromDeepColorInSRGBColorSpace(array $rgbCode, array $expectedTristimulusValue)
    {
        $this->assertThat(
            $this->colorFactory->createFrom16BitRGB($rgbCode, $this->colorSpaceFactory->createSRGB()),
            $this->equalTo($expectedTristimulusValue, 0.000001)
        );
    }

    /**
     * @test
     * @testWith [[4.3322,  11.9146, -25.8198], [0.007467, 0.004796, 0.030704]]
     *           [[20.7878, -0.0021, -0.0010], [0.030315, 0.031896, 0.034731]]
     *           [[49.2477,  33.6072, -48.5237], [0.237317, 0.177960, 0.568209]]
     */
    public function createsFromLabColorWithD65Illuminant(array $labColor, array $expectedTristimulusValue)
    {
        $this->assertThat(
            $this->colorFactory->createFromLab($labColor, CIEIlluminant::D65),
            $this->equalTo($expectedTristimulusValue, 0.0001)
        );
    }
}
