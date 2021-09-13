<?php

declare(strict_types=1);

namespace Devlop\Colours;

use Devlop\Colours\HexColor;
use Devlop\Colours\InvalidColorException;
use Devlop\Colours\RgbColor;

final class CmykColor
{
    private int $cyan;

    private int $magenta;

    private int $yellow;

    private int $key;

    public function __construct(int $cyan, int $magenta, int $yellow, int $key)
    {
        if ($cyan < 0 || $cyan > 100) {
            throw new InvalidColorException(sprintf(
                '"%1$d" is not a supported value, cyan must be between 0 and 100.',
                $cyan,
            ));
        }

        if ($magenta < 0 || $magenta > 100) {
            throw new InvalidColorException(sprintf(
                '"%1$d" is not a supported value, magenta must be between 0 and 100.',
                $magenta,
            ));
        }

        if ($yellow < 0 || $yellow > 100) {
            throw new InvalidColorException(sprintf(
                '"%1$d" is not a supported value, yellow must be between 0 and 100.',
                $yellow,
            ));
        }

        if ($key < 0 || $key > 100) {
            throw new InvalidColorException(sprintf(
                '"%1$d" is not a supported value, key must be between 0 and 100.',
                $key,
            ));
        }

        $this->cyan = $cyan;

        $this->magenta = $magenta;

        $this->yellow = $yellow;

        $this->key = $key;
    }

    /**
     * Create a new instance from a hex string.
     */
    public static function fromHexString(string $hexString) : CmykColor
    {
        $hexColor = new HexColor($hexString);

        return static::fromHexColor($hexColor);
    }

    /**
     * Create a new instance from a HexColor instance.
     */
    public static function fromHexColor(HexColor $hexColor) : CmykColor
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
    public static function fromRgbColor(RgbColor $rgbColor) : CmykColor
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
    private static function fromRgbValues($r, $g, $b) : CmykColor
    {
        $key = 1 - max($r, $g, $b);
        $cyan = $key < 1
            ? (1 - $r - $key) / (1 - $key)
            : 0;
        $magenta = $key < 1
            ? (1 - $g - $key) / (1 - $key)
            : 0;
        $yellow = $key < 1
            ? (1 - $b - $key) / (1 - $key)
            : 0;

        return new static(
            (int) round($cyan * 100),
            (int) round($magenta * 100),
            (int) round($yellow * 100),
            (int) round($key * 100),
        );
    }

    /**
     * Get the value for cyan.
     */
    public function getCyan() : int
    {
        return $this->cyan;
    }

    /**
     * Get the value for magenta.
     */
    public function getMagenta() : int
    {
        return $this->magenta;
    }

    /**
     * Get the value for yellow.
     */
    public function getYellow() : int
    {
        return $this->yellow;
    }

    /**
     * Get the value for key.
     */
    public function getKey() : int
    {
        return $this->key;
    }

    /**
     * Convert to HexColor.
     */
    public function toHex() : HexColor
    {
        return HexColor::fromCmykColor($this);
    }

    /**
     * Convert to RgbColor.
     */
    public function toRgb() : RgbColor
    {
        return RgbColor::fromCmykColor($this);
    }
}
