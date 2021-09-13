<?php

declare(strict_types=1);

namespace Devlop\Colours;

use Devlop\Colours\CmykColor;
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
                '"%1$d" is not a supported value, red must be between 0 and 255.',
                $red,
            ));
        }

        if ($green < 0 || $green > 255) {
            throw new InvalidColorException(sprintf(
                '"%1$d" is not a supported value, green must be between 0 and 255.',
                $green,
            ));
        }

        if ($blue < 0 || $blue > 255) {
            throw new InvalidColorException(sprintf(
                '"%1$d" is not a supported value, blue must be between 0 and 255.',
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
     * Create a new instance from a HslColor instance.
     */
    public static function fromHslColor(HslColor $hslColor) : RgbColor
    {
        $hue = $hslColor->getHue();
        $saturation = $hslColor->getSaturation() / 100;
        $lightness = $hslColor->getLightness() / 100;

        $chroma = (1 - abs((2 * $lightness) - 1)) * $saturation;
        $secondComponent = $chroma * (1 - abs(fmod(($hue / 60), 2) - 1));

        if ($hue < 60) {
            [$r, $g, $b] = [$chroma, $secondComponent, 0];
        } elseif ($hue < 120) {
            [$r, $g, $b] = [$secondComponent, $chroma, 0];
        } elseif ($hue < 180) {
            [$r, $g, $b] = [0, $chroma, $secondComponent];
        } elseif ($hue < 240) {
            [$r, $g, $b] = [0, $secondComponent, $chroma];
        } elseif ($hue < 300) {
            [$r, $g, $b] = [$secondComponent, 0, $chroma];
        } else {
            [$r, $g, $b] = [$chroma, 0, $secondComponent];
        }

        $lightnessModifier = $lightness - ($chroma / 2);

        $r = (int) round(($r + $lightnessModifier) * 255);
        $g = (int) round(($g + $lightnessModifier) * 255);
        $b = (int) round(($b + $lightnessModifier) * 255);

        return new static($r, $g, $b);
    }

    /**
     * Create a new instance from a CmykColor instance.
     */
    public static function fromCmykColor(CmykColor $cmykColor) : RgbColor
    {
        $cyan = $cmykColor->getCyan() / 100;
        $magenta = $cmykColor->getMagenta() / 100;
        $yellow = $cmykColor->getYellow() / 100;
        $key = $cmykColor->getKey() / 100;

        $r = 255 * (1 - $cyan) * (1 - $key);
        $g = 255 * (1 - $magenta) * (1 - $key);
        $b = 255 * (1 - $yellow) * (1 - $key);

        return new static(
            (int) round($r),
            (int) round($g),
            (int) round($b),
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
     * Convert to HexColor.
     */
    public function toHex() : HexColor
    {
        return HexColor::fromRgbColor($this);
    }

    /**
     * Convert to CmykColor.
     */
    public function toCmyk() : CmykColor
    {
        return CmykColor::fromRgbColor($this);
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
     * Get the hex string.
     */
    public function getHexString() : string
    {
        return $this->toHex()->getHexString();
    }

    /**
     * Get the CMYK cyan value.
     */
    public function getCyan() : int
    {
        return $this->toCmyk()->getCyan();
    }

    /**
     * Get the CMYK magenta value.
     */
    public function getMagenta() : int
    {
        return $this->toCmyk()->getMagenta();
    }

    /**
     * Get the CMYK yellow value.
     */
    public function getYellow() : int
    {
        return $this->toCmyk()->getYellow();
    }

    /**
     * Get the CMYK key value.
     */
    public function getKey() : int
    {
        return $this->toCmyk()->getKey();
    }
}
