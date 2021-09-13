<?php

declare(strict_types=1);

namespace Devlop\Colours\Tests;

use Devlop\Colours\CmykColor;
use Devlop\Colours\HexColor;
use Devlop\Colours\InvalidColorException;
use Devlop\Colours\RgbColor;
use Devlop\PHPUnit\ExceptionAssertions;
use PHPUnit\Framework\TestCase;

/**
 * @group cmyk
 */
final class CmykColorTest extends TestCase
{
    use ExceptionAssertions;

    /**
     * @test
     * @dataProvider validCmykValuesProvider
     */
    public function it_can_be_created_with_valid_cmyk_values(int $cyan, int $magenta, int $yellow, int $key) : void
    {
        $this->assertInstanceOf(
            CmykColor::class,
            new CmykColor($cyan, $magenta, $yellow, $key),
        );
    }

    /**
     * @test
     * @dataProvider invalidCyanProvider
     */
    public function it_cannot_be_created_with_invalid_cyan(int $cyan, int $magenta, int $yellow, int $key) : void
    {
        $this->assertExceptionThrown(InvalidColorException::class, function () use ($cyan, $magenta, $yellow, $key) : void {
            new CmykColor($cyan, $magenta, $yellow, $key);
        });
    }

    /**
     * @test
     * @dataProvider invalidMagentaProvider
     */
    public function it_cannot_be_created_with_invalid_magenta(int $cyan, int $magenta, int $yellow, int $key) : void
    {
        $this->assertExceptionThrown(InvalidColorException::class, function () use ($cyan, $magenta, $yellow, $key) : void {
            new CmykColor($cyan, $magenta, $yellow, $key);
        });
    }

    /**
     * @test
     * @dataProvider invalidYellowProvider
     */
    public function it_cannot_be_created_with_invalid_yellow(int $cyan, int $magenta, int $yellow, int $key) : void
    {
        $this->assertExceptionThrown(InvalidColorException::class, function () use ($cyan, $magenta, $yellow, $key) : void {
            new CmykColor($cyan, $magenta, $yellow, $key);
        });
    }

    /**
     * @test
     * @dataProvider invalidKeyProvider
     */
    public function it_cannot_be_created_with_invalid_key(int $cyan, int $magenta, int $yellow, int $key) : void
    {
        $this->assertExceptionThrown(InvalidColorException::class, function () use ($cyan, $magenta, $yellow, $key) : void {
            new CmykColor($cyan, $magenta, $yellow, $key);
        });
    }

    /**
     * @test
     * @dataProvider invalidCyanProvider
     */
    public function when_created_with_invalid_cyan_the_exception_message_contains_the_invalid_value(int $cyan, int $magenta, int $yellow, int $key) : void
    {
        $this->assertExceptionThrown(InvalidColorException::class, function () use ($cyan, $magenta, $yellow, $key) : void {
            new CmykColor($cyan, $magenta, $yellow, $key);
        }, function (InvalidColorException $exception) use ($cyan) : void {
            $this->assertStringContainsString("\"{$cyan}\"", $exception->getMessage());
        });
    }

    /**
     * @test
     * @dataProvider invalidMagentaProvider
     */
    public function when_created_with_invalid_magenta_the_exception_message_contains_the_invalid_value(int $cyan, int $magenta, int $yellow, int $key) : void
    {
        $this->assertExceptionThrown(InvalidColorException::class, function () use ($cyan, $magenta, $yellow, $key) : void {
            new CmykColor($cyan, $magenta, $yellow, $key);
        }, function (InvalidColorException $exception) use ($magenta) : void {
            $this->assertStringContainsString("\"{$magenta}\"", $exception->getMessage());
        });
    }

    /**
     * @test
     * @dataProvider invalidYellowProvider
     */
    public function when_created_with_invalid_yellow_the_exception_message_contains_the_invalid_value(int $cyan, int $magenta, int $yellow, int $key) : void
    {
        $this->assertExceptionThrown(InvalidColorException::class, function () use ($cyan, $magenta, $yellow, $key) : void {
            new CmykColor($cyan, $magenta, $yellow, $key);
        }, function (InvalidColorException $exception) use ($yellow) : void {
            $this->assertStringContainsString("\"{$yellow}\"", $exception->getMessage());
        });
    }

    /**
     * @test
     * @dataProvider invalidKeyProvider
     */
    public function when_created_with_invalid_key_the_exception_message_contains_the_invalid_value(int $cyan, int $magenta, int $yellow, int $key) : void
    {
        $this->assertExceptionThrown(InvalidColorException::class, function () use ($cyan, $magenta, $yellow, $key) : void {
            new CmykColor($cyan, $magenta, $yellow, $key);
        }, function (InvalidColorException $exception) use ($key) : void {
            $this->assertStringContainsString("\"{$key}\"", $exception->getMessage());
        });
    }

    /**
     * @test
     * @dataProvider validCmykValuesProvider
     */
    public function getCyan_returns_cyan(int $cyan, int $magenta, int $yellow, int $key) : void
    {
        $this->assertSame($cyan, (new CmykColor($cyan, $magenta, $yellow, $key))->getCyan());
    }

    /**
     * @test
     * @dataProvider validCmykValuesProvider
     */
    public function getMagenta_returns_magenta(int $cyan, int $magenta, int $yellow, int $key) : void
    {
        $this->assertSame($magenta, (new CmykColor($cyan, $magenta, $yellow, $key))->getMagenta());
    }

    /**
     * @test
     * @dataProvider validCmykValuesProvider
     */
    public function getYellow_returns_yellow(int $cyan, int $magenta, int $yellow, int $key) : void
    {
        $this->assertSame($yellow, (new CmykColor($cyan, $magenta, $yellow, $key))->getCyan());
    }

    /**
     * @test
     * @dataProvider validCmykValuesProvider
     */
    public function getKey_returns_key(int $cyan, int $magenta, int $yellow, int $key) : void
    {
        $this->assertSame($key, (new CmykColor($cyan, $magenta, $yellow, $key))->getKey());
    }

    /**
     * @test
     * @dataProvider rgbValuesAndExpectedCmykValuesProvider
     */
    public function it_has_expected_values_when_created_from_a_RgbColor_instance(
        int $r,
        int $g,
        int $b,
        int $expectedCyan,
        int $expectedMagenta,
        int $expectedYellow,
        int $expectedKey
    ) : void {
        $cmykColor = CmykColor::fromRgbColor(
            new RgbColor($r, $g, $b),
        );

        $this->assertSame($expectedCyan, $cmykColor->getCyan());
        $this->assertSame($expectedMagenta, $cmykColor->getMagenta());
        $this->assertSame($expectedYellow, $cmykColor->getYellow());
        $this->assertSame($expectedKey, $cmykColor->getKey());
    }

    /**
     * @test
     * @dataProvider hexStringAndExpectedCmykValuesProvider
     */
    public function it_has_expected_values_when_created_from_a_hex_string(
        string $hexString,
        int $expectedCyan,
        int $expectedMagenta,
        int $expectedYellow,
        int $expectedKey
    ) : void {
        $cmykColor = CmykColor::fromHexString($hexString);

        $this->assertSame($expectedCyan, $cmykColor->getCyan());
        $this->assertSame($expectedMagenta, $cmykColor->getMagenta());
        $this->assertSame($expectedYellow, $cmykColor->getYellow());
        $this->assertSame($expectedKey, $cmykColor->getKey());
    }

    /**
     * @test
     * @dataProvider hexStringAndExpectedCmykValuesProvider
     */
    public function it_has_expected_values_when_created_from_a_HexColor_instance(
        string $hexString,
        int $expectedCyan,
        int $expectedMagenta,
        int $expectedYellow,
        int $expectedKey
    ) : void {
        $cmykColor = CmykColor::fromHexColor(
            new HexColor($hexString),
        );

        $this->assertSame($expectedCyan, $cmykColor->getCyan());
        $this->assertSame($expectedMagenta, $cmykColor->getMagenta());
        $this->assertSame($expectedYellow, $cmykColor->getYellow());
        $this->assertSame($expectedKey, $cmykColor->getKey());
    }

    public function validCmykValuesProvider() : array
    {
        return [
            [0, 0, 0, 0],
            [-0, 0, 0, 0],
            [50, 50, 50, 50],
            [100, 100, 100, 100],
        ];
    }

    public function invalidCyanProvider() : array
    {
        return [
            [-10, 50, 50, 50],
            [110, 50, 50, 50],
            [500, 50, 50, 50],
            [101, 50, 50, 50],
        ];
    }

    public function invalidMagentaProvider() : array
    {
        return [
            [50, -10, 50, 50],
            [50, 110, 50, 50],
            [50, 500, 50, 50],
            [50, 101, 50, 50],
        ];
    }

    public function invalidYellowProvider() : array
    {
        return [
            [50, 50, -10, 50],
            [50, 50, 110, 50],
            [50, 50, 500, 50],
            [50, 50, 101, 50],
        ];
    }

    public function invalidKeyProvider() : array
    {
        return [
            [50, 50, 50, -10],
            [50, 50, 50, 110],
            [50, 50, 50, 500],
            [50, 50, 50, 101],
        ];
    }

    public function hexStringAndExpectedCmykValuesProvider() : array
    {
        return [
            ['#ffffff', 0, 0, 0, 0],
            ['#000000', 0, 0, 0, 100],
            ['#ff0000', 0, 100, 100, 0],
            ['#646400', 0, 0, 100, 61],
            ['#AB3312', 0, 70, 89, 33],
        ];
    }

    public function rgbValuesAndExpectedCmykValuesProvider() : array
    {
        return [
            [255, 255, 255, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 100],
            [255, 0, 0, 0, 100, 100, 0],
            [100, 100, 0, 0, 0, 100, 61],
            [171, 51, 18, 0, 70, 89, 33],
        ];
    }
}
