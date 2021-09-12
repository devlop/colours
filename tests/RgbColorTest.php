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
        });
    }

    /** @test */
    public function getRed_returns_red() : void
    {
        $this->assertSame(60, (new RgbColor(60, 120, 180))->getRed());
    }

    /** @test */
    public function getGreen_returns_green() : void
    {
        $this->assertSame(120, (new RgbColor(60, 120, 180))->getGreen());
    }

    /** @test */
    public function getBlue_returns_blue() : void
    {
        $this->assertSame(180, (new RgbColor(60, 120, 180))->getBlue());
    }

    /** @test */
    public function it_converts_to_HslColor() : void
    {
        $this->assertInstanceOf(
            HslColor::class,
            (new RgbColor(60, 120, 180))->toHsl(),
        );
    }

    /** @test */
    public function getHue_returns_hsl_hue() : void
    {
        $this->assertSame(142, (new RgbColor(22, 163, 74))->getHue());
    }

    /** @test */
    public function getSaturation_returns_hsl_saturation() : void
    {
        $this->assertSame(76, (new RgbColor(22, 163, 74))->getSaturation());
    }

    /** @test */
    public function getLightness_returns_hsl_lightness() : void
    {
        $this->assertSame(36, (new RgbColor(22, 163, 74))->getLightness());
    }

    /** @test */
    public function it_converts_to_HexColor() : void
    {
        $this->assertInstanceOf(
            HexColor::class,
            (new RgbColor(126, 65, 143))->toHex(),
        );
    }

    /** @test */
    public function getHexString_returns_hex_hexString() : void
    {
        $this->assertSame('#7e418f', (new RgbColor(126, 65, 143))->getHexString());
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
}
