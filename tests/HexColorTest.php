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
use Stringable;

/**
 * @group hex
 */
final class HexColorTest extends TestCase
{
    use ExceptionAssertions;

    /**
     * @test
     * @dataProvider validLongHexStringProvider
     */
    public function it_can_be_created_with_a_long_hexString(string $hexString) : void
    {
        $this->assertInstanceOf(
            HexColor::class,
            new HexColor($hexString),
        );
    }

    /**
     * @test
     * @dataProvider validHashlessLongHexStringProvider
     */
    public function it_can_be_created_with_a_hashless_long_hexString(string $hexString) : void
    {
        $this->assertInstanceOf(
            HexColor::class,
            new HexColor($hexString),
        );
    }

    /**
     * @test
     * @dataProvider validShortHexStringProvider
     */
    public function it_can_be_created_with_a_short_hexString(string $hexString) : void
    {
        $this->assertInstanceOf(
            HexColor::class,
            new HexColor($hexString),
        );
    }

    /**
     * @test
     * @dataProvider validHashlessShortHexStringProvider
     */
    public function it_can_be_created_with_a_hashless_short_hexString(string $hexString) : void
    {
        $this->assertInstanceOf(
            HexColor::class,
            new HexColor($hexString)
        );
    }

    /**
     * @test
     * @dataProvider validHashlessLongHexStringProvider
     */
    public function it_cannot_be_created_with_a_full_hexString_without_leading_hash_in_strict_mode(string $hexString) : void
    {
        $this->assertExceptionThrown(InvalidColorException::class, function () use ($hexString) : void {
            new HexColor($hexString, true);
        }, function (InvalidColorException $exception) use ($hexString) : void {
            $this->assertStringContainsString("\"{$hexString}\"", $exception->getMessage());
        });
    }

    /**
     * @test
     * @dataProvider validHashlessShortHexStringProvider
     */
    public function it_cannot_be_created_with_a_short_hexString_without_leading_hash_in_strict_mode(string $hexString) : void
    {
        $this->assertExceptionThrown(InvalidColorException::class, function () use ($hexString) : void {
            new HexColor($hexString, true);
        }, function (InvalidColorException $exception) use ($hexString) : void {
            $this->assertStringContainsString("\"{$hexString}\"", $exception->getMessage());
        });
    }

    /**
     * @test
     * @dataProvider invalidHexStringsProvider
     */
    public function it_cannot_be_created_with_invalid_hexStrings(string $hexString) : void
    {
        $this->assertExceptionThrown(InvalidColorException::class, function () use ($hexString) : void {
            new HexColor($hexString);
        }, function (InvalidColorException $exception) use ($hexString) : void {
            $this->assertStringContainsString("\"{$hexString}\"", $exception->getMessage());
        });
    }

    /**
     * @test
     * @group hsl
     * @dataProvider hslValuesAndExpectedHexStringProvider
     */
    public function it_can_be_created_from_a_HslColor_instance(
        int $hue,
        int $saturation,
        int $lightness,
        string $expectedHexString
    ) : void {
        $hexColor = HexColor::fromHslColor(
            new HslColor($hue, $saturation, $lightness),
        );

        $this->assertInstanceOf(HexColor::class, $hexColor);
        $this->assertSame($expectedHexString, $hexColor->getHexString());
    }

    /**
     * @test
     * @group rgb
     * @dataProvider rgbValuesAndExpectedHexStringProvider
     */
    public function it_can_be_created_from_a_RgbColor_instance(
        int $r,
        int $g,
        int $b,
        string $expectedHexString
    ) : void {
        $hexColor = HexColor::fromRgbColor(
            new RgbColor($r, $g, $b),
        );

        $this->assertInstanceOf(HexColor::class, $hexColor);
        $this->assertSame($expectedHexString, $hexColor->getHexString());
    }

    /**
     * @test
     * @group cmyk
     * @dataProvider cmykValuesAndExpectedHexStringProvider
     */
    public function it_can_be_created_from_a_CmykColor_instance(
        int $cyan,
        int $magenta,
        int $yellow,
        int $key,
        string $expectedHexString
    ) : void {
        $hexColor = HexColor::fromCmykColor(
            new CmykColor($cyan, $magenta, $yellow, $key),
        );

        $this->assertInstanceOf(HexColor::class, $hexColor);
        $this->assertSame($expectedHexString, $hexColor->getHexString());
    }

    /**
     * @test
     * @dataProvider validLongHexStringProvider
     */
    public function isValid_returns_true_for_valid_long_hexStrings(string $hexString) : void
    {
        $this->assertTrue(HexColor::isValid($hexString));
    }

    /**
     * @test
     * @dataProvider validHashlessLongHexStringProvider
     */
    public function isValid_returns_true_for_valid_hashless_long_hexStrings_when_not_strict_mode(string $hexString) : void
    {
        $this->assertTrue(HexColor::isValid($hexString, false));
    }

    /**
     * @test
     * @dataProvider validHashlessLongHexStringProvider
     */
    public function isValid_returns_false_for_valid_hashless_long_hexStrings_when_in_strict_mode(string $hexString) : void
    {
        $this->assertFalse(HexColor::isValid($hexString, true));
    }

    /**
     * @test
     * @dataProvider invalidHexStringsProvider
     */
    public function isValid_returns_false_for_invalid_hexStrings(string $hexString) : void
    {
        $this->assertFalse(HexColor::isValid($hexString));
    }

    /**
     * @test
     * @dataProvider validLongHexStringProvider
     */
    public function getHexString_returns_hexString(string $hexString) : void
    {
        $this->assertSame($hexString, (new HexColor($hexString))->getHexString());
    }

    /** @test */
    public function is_stringable() : void
    {
        $this->assertInstanceOf(
            Stringable::class,
            new HexColor('#abcdef'),
        );
    }

    /**
     * @test
     * @dataProvider validLongHexStringProvider
     */
    public function casting_to_string_outputs_hexString(string $hexString) : void
    {
        $hexColor = new HexColor($hexString);

        $this->assertSame(
            $hexColor->getHexString(),
            (string) $hexColor,
        );
    }

    /**
     * @test
     * @dataProvider validShortHexStringsAndExpectedEquivalentLongHexStringProvider
     */
    public function getHexString_returns_long_hexString_if_created_with_short_hexString(string $shortHexString, $expectedLongHexString) : void
    {
        $hexColor = new HexColor($shortHexString);

        $this->assertSame(
            $expectedLongHexString,
            $hexColor->getHexString(),
        );
    }

    /**
     * @test
     */
    public function getParts_returns_the_r_g_b_values_as_associative_array() : void
    {
        ['r' => $r, 'g' => $g, 'b' => $b] = (new HexColor('#D9F99D'))->getParts();

        $this->assertSame('D9', $r);
        $this->assertSame('F9', $g);
        $this->assertSame('9D', $b);
    }

    /**
     * @test
     * @group hsl
     * @dataProvider validLongHexStringProvider
     * @dataProvider validShortHexStringProvider
     */
    public function it_converts_to_HslColor(string $hexString) : void
    {
        $hexColor = new HexColor($hexString);

        $this->assertInstanceOf(
            HslColor::class,
            $hexColor->toHsl(),
        );
    }

    /**
     * @test
     * @group rgb
     * @dataProvider validLongHexStringProvider
     * @dataProvider validShortHexStringProvider
     */
    public function it_converts_to_RgbColor(string $hexString) : void
    {
        $hexColor = new HexColor($hexString);

        $this->assertInstanceOf(
            RgbColor::class,
            $hexColor->toRgb(),
        );
    }

    /**
     * @test
     * @group cmyk
     * @dataProvider validLongHexStringProvider
     * @dataProvider validShortHexStringProvider
     */
    public function it_converts_to_CmykColor(string $hexString) : void
    {
        $hexColor = new HexColor($hexString);

        $this->assertInstanceOf(
            CmykColor::class,
            $hexColor->toCmyk(),
        );
    }

    public function validLongHexStringProvider() : array
    {
        return [
            ['#DC2626'],
            ['#A1A1AA'],
            ['#ca8a04'],
            ['#499C69'],
            ['#3E733B'],
        ];
    }

    public function validHashlessLongHexStringProvider() : array
    {
        return [
            ['DC2626'],
            ['A1A1AA'],
            ['ca8a04'],
            ['499C69'],
            ['3E733B'],
        ];
    }

    public function validShortHexStringProvider() : array
    {
        return [
            ['#000'],
            ['#fff'],
            ['#f00'],
            ['#ff0'],
            ['#0f0'],
            ['#c2b'],
        ];
    }

    public function validHashlessShortHexStringProvider() : array
    {
        return [
            ['000'],
            ['fff'],
            ['f00'],
            ['ff0'],
            ['0f0'],
            ['c2b'],
        ];
    }

    public function invalidHexStringsProvider() : array
    {
        return [
            ['#ffddxx'],
            ['#ffff0'],
            ['ffff0'],
            ['#f0'],
            ['f0'],
            ['email@example.com'],
            ['random string'],
            ['#ff dcc'],
        ];
    }

    public function validShortHexStringsAndExpectedEquivalentLongHexStringProvider() : array
    {
        return [
            ['#000', '#000000'],
            ['#fff', '#ffffff'],
            ['#f00', '#ff0000'],
            ['#ff0', '#ffff00'],
            ['#0f0', '#00ff00'],
            ['#c2b', '#cc22bb'],
        ];
    }

    public function hslValuesAndExpectedHexStringProvider() : array
    {
        return [
            [222, 47, 11, '#0f1729'],
            [25, 95, 53, '#f97415'],
        ];
    }

    public function rgbValuesAndExpectedHexStringProvider() : array
    {
        return [
            [22, 163, 74, '#16a34a'],
            [103, 232, 249, '#67e8f9'],
        ];
    }

    public function cmykValuesAndExpectedHexStringProvider() : array
    {
        return [
            [0, 0, 0, 100, '#000000'],
            [0, 0, 0, 0, '#ffffff'],
            [50, 50, 50, 50, '#404040'],
            [20, 80, 65, 34, '#87223b'],
        ];
    }
}
