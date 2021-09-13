<?php

declare(strict_types=1);

namespace Devlop\Colours\Tests;

use Devlop\Colours\CmykColor;
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
 * @group rgb
 */
final class RgbColorTest extends TestCase
{
    use ExceptionAssertions;

    /**
     * @test
     * @dataProvider validRgbValuesProvider
     */
    public function it_can_be_created_with_valid_rgb_values(int $red, int $green, int $blue) : void
    {
        $this->assertInstanceOf(
            RgbColor::class,
            new RgbColor($red, $green, $blue),
        );
    }

    /**
     * @test
     * @dataProvider invalidRedProvider
     */
    public function it_cannot_be_created_with_invalid_red(int $red, int $green, int $blue) : void
    {
        $this->assertExceptionThrown(InvalidColorException::class, function () use ($red, $green, $blue) : void {
            new RgbColor($red, $green, $blue);
        }, function (InvalidColorException $exception) use ($red) : void {
            $this->assertStringContainsString("\"{$red}\"", $exception->getMessage());
        });
    }

    /**
     * @test
     * @dataProvider invalidGreenProvider
     */
    public function it_cannot_be_created_with_invalid_green(int $red, int $green, int $blue) : void
    {
        $this->assertExceptionThrown(InvalidColorException::class, function () use ($red, $green, $blue) : void {
            new RgbColor($red, $green, $blue);
        }, function (InvalidColorException $exception) use ($green) : void {
            $this->assertStringContainsString("\"{$green}\"", $exception->getMessage());
        });
    }

    /**
     * @test
     * @dataProvider invalidBlueProvider
     */
    public function it_cannot_be_created_with_invalid_blue(int $red, int $green, int $blue) : void
    {
        $this->assertExceptionThrown(InvalidColorException::class, function () use ($red, $green, $blue) : void {
            new RgbColor($red, $green, $blue);
        }, function (InvalidColorException $exception) use ($blue) : void {
            $this->assertStringContainsString("\"{$blue}\"", $exception->getMessage());
        });
    }

    /**
     * @test
     * @group hex
     * @dataProvider hexStringAndExpectedRgbValuesProvider
     */
    public function it_can_be_created_from_a_hexString(
        string $hexString,
        int $expectedRed,
        int $expectedGreen,
        int $expectedBlue
    ) : void {
        $rgbColor = RgbColor::fromHexString($hexString);

        $this->assertSame($expectedRed, $rgbColor->getRed());
        $this->assertSame($expectedGreen, $rgbColor->getGreen());
        $this->assertSame($expectedBlue, $rgbColor->getBlue());
    }

    /**
     * @test
     * @group hex
     * @dataProvider hexStringAndExpectedRgbValuesProvider
     */
    public function it_can_be_created_from_a_HexColor_instance(
        string $hexString,
        int $expectedRed,
        int $expectedGreen,
        int $expectedBlue
    ) : void {
        $rgbColor = RgbColor::fromHexColor(
            new HexColor($hexString),
        );

        $this->assertSame($expectedRed, $rgbColor->getRed());
        $this->assertSame($expectedGreen, $rgbColor->getGreen());
        $this->assertSame($expectedBlue, $rgbColor->getBlue());
    }

    /**
     * @test
     * @group hsl
     * @dataProvider hslValuesAndExpectedRgbValuesProvider
     */
    public function it_can_be_created_from_a_HslColor_instance(
        int $hue,
        int $saturation,
        int $lightness,
        int $expectedRed,
        int $expectedGreen,
        int $expectedBlue
    ) : void {
        $rgbColor = RgbColor::fromHslColor(
            new HslColor($hue, $saturation, $lightness),
        );

        $this->assertSame($expectedRed, $rgbColor->getRed());
        $this->assertSame($expectedGreen, $rgbColor->getGreen());
        $this->assertSame($expectedBlue, $rgbColor->getBlue());
    }

    /**
     * @test
     * @group cmyk
     * @dataProvider cmykValuesAndExpectedRgbValuesProvider
     */
    public function it_can_be_created_from_a_CmykColor_instance(
        int $cyan,
        int $magenta,
        int $yellow,
        int $key,
        int $expectedRed,
        int $expectedGreen,
        int $expectedBlue
    ) : void {
        $rgbColor = RgbColor::fromCmykColor(
            new CmykColor($cyan, $magenta, $yellow, $key),
        );

        $this->assertSame($expectedRed, $rgbColor->getRed());
        $this->assertSame($expectedGreen, $rgbColor->getGreen());
        $this->assertSame($expectedBlue, $rgbColor->getBlue());
    }

    /**
     * @test
     * @dataProvider validRgbValuesProvider
     */
    public function getRed_returns_red(int $red, int $green, int $blue) : void
    {
        $this->assertSame($red, (new RgbColor($red, $green, $blue))->getRed());
    }

    /**
     * @test
     * @dataProvider validRgbValuesProvider
     */
    public function getGreen_returns_green(int $red, int $green, int $blue) : void
    {
        $this->assertSame($green, (new RgbColor($red, $green, $blue))->getGreen());
    }

    /**
     * @test
     * @dataProvider validRgbValuesProvider
     */
    public function getBlue_returns_blue(int $red, int $green, int $blue) : void
    {
        $this->assertSame($blue, (new RgbColor($red, $green, $blue))->getBlue());
    }

    /**
     * @test
     * @group hex
     * @dataProvider validRgbValuesProvider
     */
    public function it_converts_to_HexColor(int $red, int $green, int $blue) : void
    {
        $this->assertInstanceOf(
            HexColor::class,
            (new RgbColor($red, $green, $blue))->toHex(),
        );
    }

    /**
     * @test
     * @group hsl
     * @dataProvider validRgbValuesProvider
     */
    public function it_converts_to_HslColor(int $red, int $green, int $blue) : void
    {
        $this->assertInstanceOf(
            HslColor::class,
            (new RgbColor($red, $green, $blue))->toHsl(),
        );
    }

    /**
     * @test
     * @group cmyk
     * @dataProvider validRgbValuesProvider
     */
    public function it_converts_to_CmykColor(int $red, int $green, int $blue) : void
    {
        $this->assertInstanceOf(
            CmykColor::class,
            (new RgbColor($red, $green, $blue))->toCmyk(),
        );
    }

    public function validRgbValuesProvider() : array
    {
        return [
            [0, 0, 0],
            [255, 255, 255],
            [50, 50, 50],
            [60, 120, 180],
        ];
    }

    public function invalidRedProvider() : array
    {
        return [
            [-1, 66, 66],
            [-10, 66, 66],
            [256, 66, 66],
            [512, 66, 66],
        ];
    }

    public function invalidGreenProvider() : array
    {
        return [
            [66, -1, 66],
            [66, -10, 66],
            [66, 256, 66],
            [66, 512, 66],
        ];
    }

    public function invalidBlueProvider() : array
    {
        return [
            [66, 66, -1],
            [66, 66, -10],
            [66, 66, 256],
            [66, 66, 512],
        ];
    }

    public function hexStringAndExpectedRgbValuesProvider() : array
    {
        return [
            ['#36E149', 54, 225, 73],
            ['#965D52', 150, 93, 82],
            ['#30ECD8', 48, 236, 216],
            ['#E0A280', 224, 162, 128],
            ['#ffffff', 255, 255, 255],
            ['#000000', 0, 0, 0],
        ];
    }

    public function hslValuesAndExpectedRgbValuesProvider() : array
    {
        return [
            [0, 0, 100, 255, 255, 255],
            [0, 0, 0, 0, 0, 0],
            [336, 73, 49, 216, 34, 107],
            [69, 50, 78, 219, 227, 171],
            [159, 33, 34, 58, 115, 95],
        ];
    }

    public function cmykValuesAndExpectedRgbValuesProvider() : array
    {
        return [
            [0, 0, 0, 0, 255, 255, 255],
            [100, 100, 100, 100, 0, 0, 0],
            [50, 50, 50, 50, 64, 64, 64],
            [25, 62, 40, 65, 67, 34, 54],
            [0, 62, 40, 86, 36, 14, 21],
            [100, 62, 40, 55, 0, 44, 69],
        ];
    }
}
