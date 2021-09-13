<?php

declare(strict_types=1);

namespace Devlop\Colours;

use Devlop\Colours\Enums\CssColors;
use Devlop\Colours\HexColor;
use Devlop\Colours\InvalidColorException;
use Devlop\Colours\RgbColor;
use Stringable;

/**
 * @link https://developer.mozilla.org/en-US/docs/Web/CSS/color_value#color_keywords
 */
final class CssColor implements Stringable
{
    private string $name;

    private string $hexString;

    public function __construct(string $name)
    {
        // check if valid color name
        if (false) {
            throw new InvalidColorException(sprintf(
                '"%1$s" is not a valid CSS color.',
                $name,
            ));
        }

        $this->name = $name;

        // $this->hexString = // find hex string;
    }

    /**
     * Find the nearest match for a hex string.
     * Exact match is required in strict mode.
     *
     * @link https://stackoverflow.com/questions/1847092/given-an-rgb-value-what-would-be-the-best-way-to-find-the-closest-match-in-the-d
     */
    public static function createFromHexString(string $hexString, bool $strict = false) : CssColor
    {
        // find the nearest color (how?)
    }

    /**
     * Check if the name is a valid CSS color name.
     */
    public static function isValid(string $name) : bool
    {
        // check if the color name is a valid css color
    }

    /**
     * Get the hex string.
     */
    public function getHexString() : string
    {
        return $this->hexString;
    }

    /**
     * Get the string representation of the HexColor.
     */
    public function __toString() : string
    {
        return $this->getHexString();
    }

    /**
     * Convert to HexColor.
     */
    public function toHex() : HexColor
    {
        return new HexColor($this->hexString);
    }

    /**
     * Convert to RgbColor.
     */
    public function toRgb() : RgbColor
    {
        return $this->toHex()->toRgb();
    }
}
