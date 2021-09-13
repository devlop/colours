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

/**
 * @group hsl
 */
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
        }, function (InvalidColorException $exception) use ($hue) : void {
            $this->assertStringContainsString("\"{$hue}\"", $exception->getMessage());
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
        }, function (InvalidColorException $exception) use ($saturation) : void {
            $this->assertStringContainsString("\"{$saturation}\"", $exception->getMessage());
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
        }, function (InvalidColorException $exception) use ($lightness) : void {
            $this->assertStringContainsString("\"{$lightness}\"", $exception->getMessage());
        });
    }

    /**
     * @test
     * @group hex
     * @dataProvider hexStringAndExpectedHslValuesProvider
     */
    public function it_can_be_created_from_a_hexString(
        string $hexString,
        int $expectedHue,
        int $expectedSaturation,
        int $expectedLightness
    ) : void {
        $hslColor = HslColor::fromHexString($hexString);

        $this->assertInstanceOf(HslColor::class, $hslColor);
        $this->assertSame($expectedHue, $hslColor->getHue());
        $this->assertSame($expectedSaturation, $hslColor->getSaturation());
        $this->assertSame($expectedLightness, $hslColor->getLightness());
    }

    /**
     * @test
     * @group hex
     * @dataProvider hexStringAndExpectedHslValuesProvider
     */
    public function it_can_be_created_from_a_HexColor_instance(
        string $hexString,
        int $expectedHue,
        int $expectedSaturation,
        int $expectedLightness
    ) : void {
        $hslColor = HslColor::fromHexColor(
            new HexColor($hexString),
        );

        $this->assertInstanceOf(HslColor::class, $hslColor);
        $this->assertSame($expectedHue, $hslColor->getHue());
        $this->assertSame($expectedSaturation, $hslColor->getSaturation());
        $this->assertSame($expectedLightness, $hslColor->getLightness());
    }

    /**
     * @test
     * @group rgb
     * @dataProvider rgbValuesAndExpectedHslValuesProvider
     */
    public function it_can_be_created_from_a_RgbColor_instance(
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

        $this->assertInstanceOf(HslColor::class, $hslColor);
        $this->assertSame($expectedHue, $hslColor->getHue());
        $this->assertSame($expectedSaturation, $hslColor->getSaturation());
        $this->assertSame($expectedLightness, $hslColor->getLightness());
    }

    /**
     * @test
     * @dataProvider validHslValuesProvider
     */
    public function getHue_returns_hue(int $hue, int $saturation, int $lightness) : void
    {
        $this->assertSame($hue, (new HslColor($hue, $saturation, $lightness))->getHue());
    }

    /**
     * @test
     * @dataProvider validHslValuesProvider
     */
    public function getSaturation_returns_saturation(int $hue, int $saturation, int $lightness) : void
    {
        $this->assertSame($saturation, (new HslColor($hue, $saturation, $lightness))->getSaturation());
    }

    /**
     * @test
     * @dataProvider validHslValuesProvider
     */
    public function getLightness_returns_lightness(int $hue, int $saturation, int $lightness) : void
    {
        $this->assertSame($lightness, (new HslColor($hue, $saturation, $lightness))->getLightness());
    }

    /**
     * @test
     * @group rgb
     * @dataProvider validHslValuesProvider
     */
    public function it_converts_to_HexColor(int $hue, int $saturation, int $lightness) : void
    {
        $hslColor = new HslColor($hue, $saturation, $lightness);

        $this->assertInstanceOf(
            HexColor::class,
            $hslColor->toHex(),
        );
    }

    /**
     * @test
     * @group rgb
     * @dataProvider validHslValuesProvider
     */
    public function it_converts_to_RgbColor(int $hue, int $saturation, int $lightness) : void
    {
        $hslColor = new HslColor($hue, $saturation, $lightness);

        $this->assertInstanceOf(
            RgbColor::class,
            $hslColor->toRgb(),
        );
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
