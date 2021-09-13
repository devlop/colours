<?php

declare(strict_types=1);

namespace Devlop\Colours;

use Devlop\Colours\CmykColor;
use Devlop\Colours\InvalidColorException;
use InvalidArgumentException;
use Stringable;
use const STR_PAD_LEFT;

final class HexColor implements Stringable
{
    /**
     * @readonly
     */
    private string $hexString;

    /**
     * Create a new instance from a hex string, either short or long form.
     * Leading hash is optional if unless strict is true.
     */
    public function __construct(string $input, bool $strict = false)
    {
        if (! preg_match('/^#?([0-9a-f]{3}|[0-9a-f]{6})$/i', $input)) {
            throw new InvalidColorException(sprintf(
                '"%1$s" is not a supported hex string.',
                $input,
            ));
        }

        if ($strict && ! str_starts_with($input, '#')) {
            throw new InvalidColorException(sprintf(
                '"%1$s" is not supported, leading hash is required in strict mode..',
                $input,
            ));
        }

        $hexString = str_starts_with($input, '#')
            ? $input
            : '#' . $input;

        $this->hexString = mb_strlen($hexString) === 7
            ? $hexString
            : implode('', [
                mb_substr($hexString, 0, -3),
                str_repeat(mb_substr($hexString, -3, 1), 2),
                str_repeat(mb_substr($hexString, -2, 1), 2),
                str_repeat(mb_substr($hexString, -1, 1), 2),
            ]);
    }

    /**
     * Create a new instance from a HslColor instance.
     */
    public static function fromHslColor(HslColor $hslColor) : HexColor
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

        $r = base_convert(round(($r + $lightnessModifier) * 255), 10, 16);
        $g = base_convert(round(($g + $lightnessModifier) * 255), 10, 16);
        $b = base_convert(round(($b + $lightnessModifier) * 255), 10, 16);

        return new static(implode('', [
            '#',
            str_pad($r, 2, '0', STR_PAD_LEFT),
            str_pad($g, 2, '0', STR_PAD_LEFT),
            str_pad($b, 2, '0', STR_PAD_LEFT),
        ]));
    }

    /**
     * Create a new instance from a RgbColor instance.
     */
    public static function fromRgbColor(RgbColor $rgbColor) : HexColor
    {
        $r = base_convert($rgbColor->getRed(), 10, 16);
        $g = base_convert($rgbColor->getGreen(), 10, 16);
        $b = base_convert($rgbColor->getBlue(), 10, 16);

        return new static(implode('', [
            '#',
            str_pad($r, 2, '0', STR_PAD_LEFT),
            str_pad($g, 2, '0', STR_PAD_LEFT),
            str_pad($b, 2, '0', STR_PAD_LEFT),
        ]));
    }

    /**
     * Create a new instance from a CmykColor instance.
     */
    public static function fromCmykColor(CmykColor $cmykColor) : HexColor
    {
        $cyan = $cmykColor->getCyan() / 100;
        $magenta = $cmykColor->getMagenta() / 100;
        $yellow = $cmykColor->getYellow() / 100;
        $key = $cmykColor->getKey() / 100;

        $r = base_convert(round(255 * (1 - $cyan) * (1 - $key)), 10, 16);
        $g = base_convert(round(255 * (1 - $magenta) * (1 - $key)), 10, 16);
        $b = base_convert(round(255 * (1 - $yellow) * (1 - $key)), 10, 16);

        return new static(implode('', [
            '#',
            str_pad($r, 2, '0', STR_PAD_LEFT),
            str_pad($g, 2, '0', STR_PAD_LEFT),
            str_pad($b, 2, '0', STR_PAD_LEFT),
        ]));
    }

    /**
     * Checks if a hex string is valid.
     * If strict a leading hash is required.
     */
    public static function isValid(string $value, bool $strict = false) : bool
    {
        try {
            new static($value, $strict);
        } catch (InvalidColorException $e) {
            return false;
        }

        return true;
    }

    /**
     * Get all the parts of the hex.
     */
    public function getParts() : array
    {
        return [
            'r' => mb_substr($this->hexString, 1, 2),
            'g' => mb_substr($this->hexString, 3, 2),
            'b' => mb_substr($this->hexString, 5, 2),
        ];
    }

    /**
     * Get the hex string.
     */
    public function getHexString() : string
    {
        return $this->hexString;
    }

    /**
     * Convert to HslColor.
     */
    public function toHsl() : HslColor
    {
        return HslColor::fromHexColor($this);
    }

    /**
     * Convert to RgbColor.
     */
    public function toRgb() : RgbColor
    {
        return RgbColor::fromHexColor($this);
    }

    /**
     * Convert to CmykColor.
     */
    public function toCmyk() : CmykColor
    {
        return CmykColor::fromHexColor($this);
    }

    /**
     * Get the string representation of the HexColor.
     */
    public function __toString() : string
    {
        return $this->getHexString();
    }
}
