<?php

declare(strict_types=1);

namespace Devlop\Colours\Tests;

use Devlop\Colours\HexColor;
use Devlop\Colours\HslColor;
use Devlop\Colours\InvalidColorException;
use Devlop\Colours\RgbColor;
use Devlop\PHPUnit\ExceptionAssertions;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Stringable;
use Throwable;

final class HslColorTest extends TestCase
{
    use ExceptionAssertions;

    /**
     * @test
     * @dataProvider validHslValuesProvider
     */
    public function it_can_be_created_with_valid_hsl_values(int $hue, int $saturation, int $lightness) : void
    {
        $this->assertInstanceOf(
            HslColor::class,
            new HslColor($hue, $saturation, $lightness),
        );
    }

    /**
     * @test
     * @dataProvider invalidHueProvider
     */
    public function it_cannot_be_created_with_invalid_hue(int $hue, int $saturation, int $lightness) : void
    {
        $this->assertExceptionThrown(InvalidColorException::class, function () use ($hue, $saturation, $lightness) : void {
            new HslColor($hue, $saturation, $lightness);
        });
    }

    /**
     * @test
     * @dataProvider invalidSaturationProvider
     */
    public function it_cannot_be_created_with_invalid_saturation(int $hue, int $saturation, int $lightness) : void
    {
        $this->assertExceptionThrown(InvalidColorException::class, function () use ($hue, $saturation, $lightness) : void {
            new HslColor($hue, $saturation, $lightness);
        });
    }

    /**
     * @test
     * @dataProvider invalidLightnessProvider
     */
    public function it_cannot_be_created_with_invalid_lightness(int $hue, int $saturation, int $lightness) : void
    {
        $this->assertExceptionThrown(InvalidColorException::class, function () use ($hue, $saturation, $lightness) : void {
            new HslColor($hue, $saturation, $lightness);
        });
    }

    /** @test */
    public function getHue_returns_hue() : void
    {
        $this->assertSame(31, (new HslColor(31, 97, 72))->getHue());
    }

    /** @test */
    public function getSaturation_returns_saturation() : void
    {
        $this->assertSame(97, (new HslColor(31, 97, 72))->getSaturation());
    }

    /** @test */
    public function getLightness_returns_lightness() : void
    {
        $this->assertSame(72, (new HslColor(31, 97, 72))->getLightness());
    }

    /** @test */
    public function it_can_be_created_from_a_hex_string() : void
    {
        $this->assertInstanceOf(
            HslColor::class,
            HslColor::fromHexString('#ddffdd'),
        );
    }

    /** @test */
    public function it_can_be_created_from_a_HexColor_instance() : void
    {
        $hexColor = new HexColor('#ddffdd');

        $this->assertInstanceOf(
            HslColor::class,
            HslColor::fromHexColor($hexColor),
        );
    }

    /**
     * @test
     * @dataProvider hexStringAndExpectedHslValuesProvider
     */
    public function it_has_expected_values_when_created_from_a_hex_string(
        string $hexString,
        int $expectedHue,
        int $expectedSaturation,
        int $expectedLightness
    ) : void {
        $hslColor = HslColor::fromHexString($hexString);

        $this->assertSame($expectedHue, $hslColor->getHue());
        $this->assertSame($expectedSaturation, $hslColor->getSaturation());
        $this->assertSame($expectedLightness, $hslColor->getLightness());
    }

    /** @test */
    public function it_converts_to_HexColor() : void
    {
        $this->assertInstanceOf(
            HexColor::class,
            (new HslColor(0, 94, 82))->toHex(),
        );
    }

    /** @test */
    public function getHexString_returns_hex_hexString() : void
    {
        $this->assertSame('#f97415', (new HslColor(25, 95, 53))->getHexString());
    }

    /** @test */
    public function it_can_be_created_from_a_RgbColor_instance() : void
    {
        $rgbColor = new RgbColor(60, 120, 180);

        $this->assertInstanceOf(
            HslColor::class,
            HslColor::fromRgbColor($rgbColor),
        );
    }

    /**
     * @test
     * @dataProvider rgbValuesAndExpectedHslValuesProvider
     */
    public function it_has_expected_values_when_created_from_a_RgbColor_instance(
        int $r,
        int $g,
        int $b,
        int $expectedHue,
        int $expectedSaturation,
        int $expectedLightness
    ) : void {
        $hslColor = HslColor::fromRgbColor(
            new RgbColor($r, $g, $b),
        );

        $this->assertSame($expectedHue, $hslColor->getHue());
        $this->assertSame($expectedSaturation, $hslColor->getSaturation());
        $this->assertSame($expectedLightness, $hslColor->getLightness());
    }

    /** @test */
    public function it_converts_to_RgbColor() : void
    {
        $this->assertInstanceOf(
            RgbColor::class,
            (new HslColor(82, 32, 52))->toRgb(),
        );
    }

    /** @test */
    public function getRed_returns_rgb_red() : void
    {
        $this->assertSame(73, (new HslColor(143, 36, 45))->getRed());
    }

    /** @test */
    public function getGreen_returns_rgb_green() : void
    {
        $this->assertSame(156, (new HslColor(143, 36, 45))->getGreen());
    }

    /** @test */
    public function getBlue_returns_rgb_blue() : void
    {
        $this->assertSame(105, (new HslColor(143, 36, 45))->getBlue());
    }

    public function validHslValuesProvider() : array
    {
        return [
            [0, 0, 0],
            [-0, 0, 0],
            [50, 50, 50],
            [360, 0, 0],
        ];
    }

    public function invalidHueProvider() : array
    {
        return [
            [-10, 11, 11],
            [500, 11, 11],
            [361, 11, 11],
        ];
    }

    public function invalidSaturationProvider() : array
    {
        return [
            [50, -10, 11],
            [50, 101, 11],
            [50, 200, 11],
        ];
    }

    public function invalidLightnessProvider() : array
    {
        return [
            [50, 11, -10],
            [50, 11, 101],
            [50, 11, 200],
        ];
    }

    public function hexStringAndExpectedHslValuesProvider() : array
    {
        return [
            ['#FCA5A5', 0, 94, 82],
            ['#ddffdd', 120, 100, 93],
            ['#E5E7EB', 220, 13, 91],
            ['#6366F1', 239, 84, 67],
            ['#ffffff', 0, 0, 100],
            ['#000000', 0, 0, 0],
        ];
    }

    public function rgbValuesAndExpectedHslValuesProvider() : array
    {
        return [
            [255, 0, 0, 0, 100, 50],
            [0, 0, 0, 0, 0, 0],
            [255, 255, 255, 0, 0, 100],
            [100, 100, 0, 60, 100, 20],
            [171, 51, 18, 13, 81, 37],
        ];
    }
}
