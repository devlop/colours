<?php

declare(strict_types=1);

namespace Devlop\Colours;

use Devlop\Colours\HslColor;
use Devlop\Colours\InvalidColorException;

final class RgbColor
{
    private int $red;

    private int $green;

    private int $blue;

    public function __construct(int $red, int $green, int $blue)
    {
        if ($red < 0 || $red > 255) {
            throw new InvalidColorException(sprintf(
                '"%1$u" is not a supported value, red must be between 0 and 255.',
                $red,
            ));
        }

        if ($green < 0 || $green > 255) {
            throw new InvalidColorException(sprintf(
                '"%1$u" is not a supported value, green must be between 0 and 255.',
                $green,
            ));
        }

        if ($blue < 0 || $blue > 255) {
            throw new InvalidColorException(sprintf(
                '"%1$u" is not a supported value, blue must be between 0 and 255.',
                $blue,
            ));
        }

        $this->red = $red;

        $this->green = $green;

        $this->blue = $blue;
    }

    /**
     * Create a new instance from a hex string, example: #fe02dc
     */
    public static function fromHexString(string $hexString) : RgbColor
    {
        $hexColor = new HexColor($hexString);

        return static::fromHexColor($hexColor);
    }

    /**
     * Create a new instance from a HexColor instance.
     */
    public static function fromHexColor(HexColor $hexColor) : RgbColor
    {
        ['r' => $r, 'g' => $g, 'b' => $b] = $hexColor->getParts();

        return new static(
            intval($r, 16),
            intval($g, 16),
            intval($b, 16),
        );
    }

    /**
     * Get the value for red.
     */
    public function getRed() : int
    {
        return $this->red;
    }

    /**
     * Get the value for green.
     */
    public function getGreen() : int
    {
        return $this->green;
    }

    /**
     * Get the value for blue.
     */
    public function getBlue() : int
    {
        return $this->blue;
    }

    /**
     * Convert to HslColor.
     */
    public function toHsl() : HslColor
    {
        return HslColor::fromRgbColor($this);
    }

    /**
     * Get the HSL hue.
     */
    public function getHue() : int
    {
        return $this->toHsl()->getHue();
    }

    /**
     * Get the HSL saturation.
     */
    public function getSaturation() : int
    {
        return $this->toHsl()->getSaturation();
    }

    /**
     * Get the HSL lightness.
     */
    public function getLightness() : int
    {
        return $this->toHsl()->getLightness();
    }

    /**
     * Convert to HexColor.
     */
    public function toHex() : HexColor
    {
        return HexColor::fromRgbColor($this);
    }

    /**
     * Get the hex string.
     */
    public function getHexString() : string
    {
        return $this->toHex()->getHexString();
    }
}
