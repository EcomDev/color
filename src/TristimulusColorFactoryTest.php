<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace EcomDev\Color;

use PHPUnit\Framework\TestCase;

class TristimulusColorFactoryTest extends TestCase
{
    /** @var TristimulusValueFactory */
    private $colorFactory;

    protected function setUp()
    {
        $this->colorFactory = new TristimulusValueFactory();
    }

    /** @test */
    public function createsFromChromaticityValueForD65()
    {
        $this->assertEquals(
            new TristimulusValue(.95043, 1, 1.0889),
            $this->colorFactory->createFromChromacity(...CIEIlluminant::D65),
            '',
            0.00001
        );
    }

    /** @test */
    public function createsFromChromaticityValueForD50()
    {
        $this->assertEquals(
            new TristimulusValue(.96421, 1,  .82519),
            $this->colorFactory->createFromChromacity(...CIEIlluminant::D50),
            '',
            0.00001
        );
    }

    /** @test */
    public function createsFromTristimulusValues()
    {
        $this->assertEquals(
            new TristimulusValue(0.95047, 1, 1.0883),
            $this->colorFactory->createFromTristimulusValues(0.95047, 1, 1.0883)
        );
    }
}
