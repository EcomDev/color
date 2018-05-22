<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace EcomDev\Color;

final class TristimulusValue
{
    /**
     * X plot value of color
     *
     * @var float
     */
    private $X;

    /**
     * Y plot value of color
     *
     * @var float
     */
    private $Y;

    /**
     * Luminance of the color
     *
     * @var float
     */
    private $Z;

    public function __construct(float $X, float $Y, float $Z)
    {
        $this->X = $X;
        $this->Y = $Y;
        $this->Z = $Z;
    }

    public function toVector(): array
    {
        return [$this->X, $this->Y, $this->Z];
    }

    public function multiply(TristimulusValue $color): TristimulusValue
    {
        return new self($this->X * $color->X, $this->Y * $color->Y, $this->Z * $color->Z);
    }

    public function divide(TristimulusValue $color): TristimulusValue
    {
        return new self($this->X / $color->X, $this->Y / $color->Y, $this->Z / $color->Z);
    }

    public function subtract(TristimulusValue $color): TristimulusValue
    {
        return new self($this->X-$color->X, $this->Y - $color->Y, $this->Z - $color->Z);
    }

    public function add(TristimulusValue $color): TristimulusValue
    {
        return new self($this->X + $color->X, $this->Y + $color->Y, $this->Z + $color->Z);
    }
}
