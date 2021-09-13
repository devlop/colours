<?php

declare(strict_types=1);

namespace Devlop\Colours;

use Devlop\Colours\HexColor;
use Devlop\Colours\InvalidColorException;
use Devlop\Colours\RgbColor;

final class HslColor
{
    private int $hue;

    private int $saturation;

    private int $lightness;

    public function __construct(int $hue, int $saturation, int $lightness)
    {
        if ($hue < 0 || $hue > 360) {
            throw new InvalidColorException(sprintf(
                '"%1$d" is not a supported hue, must be between 0 and 360.',
                $hue,
            ));
        }

        if ($saturation < 0 || $saturation > 100) {
            throw new InvalidColorException(sprintf(
                '"%1$d" is not a supported saturation, must be between 0 and 100.',
                $saturation,
            ));
        }

        if ($lightness < 0 || $lightness > 100) {
            throw new InvalidColorException(sprintf(
                '"%1$d" is not a supported lightness, must be between 0 and 100.',
                $lightness,
            ));
        }

        $this->hue = $hue;

        $this->saturation = $saturation;

        $this->lightness = $lightness;
    }

    /**
     * Create a new instance from a hex string, example: #fe02dc
     */
    public static function fromHexString(string $hexString) : HslColor
    {
        $hexColor = new HexColor($hexString);

        return static::fromHexColor($hexColor);
    }

    /**
     * Create a new instance from a HexColor instance.
     */
    public static function fromHexColor(HexColor $hexColor) : HslColor
    {
        ['r' => $r, 'g' => $g, 'b' => $b] = $hexColor->getParts();

        $r = intval($r, 16) / 255;
        $g = intval($g, 16) / 255;
        $b = intval($b, 16) / 255;

        return static::fromRgbValues($r, $g, $b);
    }

    /**
     * Create a new instance from a RgbColor instance.
     */
    public static function fromRgbColor(RgbColor $rgbColor) : HslColor
    {
        $r = $rgbColor->getRed() / 255;
        $g = $rgbColor->getGreen() / 255;
        $b = $rgbColor->getBlue() / 255;

        return static::fromRgbValues($r, $g, $b);
    }

    /**
     * Create a new instance from RGB values.
     *
     * @param  int|float  $r
     * @param  int|float  $b
     * @param  int|float  $g
     */
    private static function fromRgbValues($r, $g, $b) : HslColor
    {
        $max = max($r, $g, $b);
        $min = min($r, $g, $b);

        $delta = $max - $min;

        if (! ($delta > 0)) {
            $hue = 0;
        } elseif ($max === $r) {
            $hue = ($g - $b) / $delta + ($g < $b ? 6 : 0);
        } elseif ($max === $g) {
            $hue = ($b - $r) / $delta + 2;
        } else {
            $hue = ($r - $g) / $delta + 4;
        }

        $lightness = ($max + $min) / 2;
        $saturation = $delta !== 0
            ? $delta / (1 - abs(2 * $lightness - 1))
            : 0;

        return new static(
            (int) round(($hue / 6) * 360),
            (int) round($saturation * 100),
            (int) round($lightness * 100),
        );
    }

    /**
     * Get the hue.
     */
    public function getHue() : int
    {
        return $this->hue;
    }

    /**
     * Get the saturation.
     */
    public function getSaturation() : int
    {
        return $this->saturation;
    }

    /**
     * Get the lightness.
     */
    public function getLightness() : int
    {
        return $this->lightness;
    }

    /**
     * Convert to HexColor.
     */
    public function toHex() : HexColor
    {
        return HexColor::fromHslColor($this);
    }

    /**
     * Convert to RgbColor.
     */
    public function toRgb() : RgbColor
    {
        return RgbColor::fromHslColor($this);
    }
}
