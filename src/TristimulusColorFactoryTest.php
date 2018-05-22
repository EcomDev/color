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

    protected function setUp()
    {
        $this->colorFactory = new TristimulusColorFactory();
    }

    /** @test */
    public function createsFromChromaticityValueForD65()
    {
        $this->assertEquals(
            [.95043, 1, 1.0889],
            $this->colorFactory->createFromChromacity(...CIEIlluminant::D65),
            '',
            0.00001
        );
    }

    /** @test */
    public function createsFromChromaticityValueForD50()
    {
        $this->assertEquals(
            [.96421, 1,  .82519],
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
}
