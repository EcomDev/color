<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace EcomDev\Color;

use PHPUnit\Framework\TestCase;

class TristimulusValueTest extends TestCase
{
    /** @test */
    public function exportsColorAsVector()
    {
        $color = new TristimulusValue(1, 2, 3);

        $this->assertEquals([1, 2, 3], $color->toVector());
    }

    /** @test */
    public function canMultiplyTwoColors()
    {
        $color = new TristimulusValue(.2, .5, 0.35);
        $multiplier = new TristimulusValue(3, .8, 0.7);

        $this->assertEquals(
            new TristimulusValue(.6, .4, 0.245),
            $color->multiply($multiplier)
        );
    }

    /** @test */
    public function canDivideTwoColors()
    {
        $color = new TristimulusValue(.6, .4, 0.245);
        $divider = new TristimulusValue(3, .8, 0.7);

        $this->assertEquals(
            new TristimulusValue(.2, .5, 0.35),
            $color->divide($divider)
        );
    }

    /** @test */
    public function canSubtractColors()
    {
        $color = new TristimulusValue(1, 1, 1);
        $subtraction = new TristimulusValue(.6, .4, 0.245);

        $this->assertEquals(
            new TristimulusValue(0.4, 0.6, 0.755),
            $color->subtract($subtraction)
        );
    }

    /** @test */
    public function canAddColors()
    {
        $color = new TristimulusValue(0.4, 0.6, 0.755);
        $addition = new TristimulusValue(.6, .4, 0.245);

        $this->assertEquals(
            new TristimulusValue(1, 1, 1),
            $color->add($addition)
        );
    }
}
