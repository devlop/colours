<?php

declare(strict_types=1);

namespace Devlop\Colours\Tests;

use Devlop\Colours\HexColor;
use Devlop\Colours\HslColor;
use Devlop\Colours\InvalidColorException;
use Devlop\PHPUnit\ExceptionAssertions;
use PHPUnit\Framework\TestCase;
use Stringable;

final class HexColorTest extends TestCase
{
    use ExceptionAssertions;

    /** @test */
    public function is_stringable() : void
    {
        $this->assertInstanceOf(Stringable::class, new HexColor('#ffeedd'));
    }

    /** @test */
    public function it_can_be_created_with_a_full_hex_string_with_leading_hash() : void
    {
        $this->assertSame('#ff0011', (string) (new HexColor('#ff0011')));
    }

    /** @test */
    public function it_can_be_created_with_a_full_hex_string_without_leading_hash() : void
    {
        $this->assertSame('#d98ce0', (string) (new HexColor('d98ce0')));
    }

    /** @test */
    public function it_cannot_be_created_with_a_full_hex_string_without_leading_hash_in_strict_mode() : void
    {
        $this->assertExceptionThrown(InvalidColorException::class, function () : void {
            new HexColor('d98ce0', true);
        });
    }

    /** @test */
    public function it_can_be_created_with_a_short_hex_string_with_leading_hash() : void
    {
        $this->assertSame('#ffddee', (string) (new HexColor('#fde')));
    }

    /** @test */
    public function it_can_be_created_with_a_short_hex_string_without_leading_hash() : void
    {
        $this->assertSame('#aabbcc', (string) (new HexColor('abc')));
    }

    /** @test */
    public function it_cannot_be_created_with_a_short_hex_string_without_leading_hash_in_strict_mode() : void
    {
        $this->assertExceptionThrown(InvalidColorException::class, function () : void {
            new HexColor('abc', true);
        });
    }

    /**
     * @test
     * @dataProvider invalidHexStringsProvider
     */
    public function it_cannot_be_created_with_invalid_hex_strings(string $invalidHexString) : void
    {
        $this->assertExceptionThrown(InvalidColorException::class, function () use ($invalidHexString) : void {
            new HexColor($invalidHexString);
        });
    }

    /**
     * @test
     * @dataProvider validHexStringsWithLeadingHashProvider
     */
    public function isValid_returns_true_for_valid_hex_strings_with_leading_hash(string $validHexString) : void
    {
        $this->assertTrue(HexColor::isValid($validHexString));
    }

    /**
     * @test
     * @dataProvider validHexStringsWithoutLeadingHashProvider
     */
    public function isValid_returns_true_for_valid_hex_strings_without_leading_hash_without_strict_mode(string $validHexString) : void
    {
        $this->assertTrue(HexColor::isValid($validHexString, false));
    }

    /**
     * @test
     * @dataProvider validHexStringsWithoutLeadingHashProvider
     */
    public function isValid_returns_false_for_valid_hex_strings_without_leading_hash_with_strict_mode(string $validHexString) : void
    {
        $this->assertFalse(HexColor::isValid($validHexString, true));
    }

    /**
     * @test
     * @dataProvider invalidHexStringsProvider
     */
    public function isValid_returns_false_for_invalid_hex_strings(string $invalidHexString) : void
    {
        $this->assertFalse(HexColor::isValid($invalidHexString));
    }

    /** @test */
    public function getParts_returns_the_r_g_b_values_as_associative_array() : void
    {
        ['r' => $r, 'g' => $g, 'b' => $b] = (new HexColor('#D9F99D'))->getParts();

        $this->assertSame('D9', $r);
        $this->assertSame('F9', $g);
        $this->assertSame('9D', $b);
    }

    /**
     * @test
     * @dataProvider validInputAndExpectedHexStringProvider
     */
    public function getHexString_returns_formatted_hex_string(string $input, string $expectedHexString) : void
    {
        $this->assertSame($expectedHexString, (new HexColor($input))->getHexString());
    }

    /** @test */
    public function it_converts_to_HslColor() : void
    {
        $this->assertInstanceOf(
            HslColor::class,
            (new HexColor('#D9F99D'))->toHsl(),
        );
    }

    /** @test */
    public function getHue_returns_hsl_hue() : void
    {
        $this->assertSame(31, (new HexColor('#fdba74'))->getHue());
    }

    /** @test */
    public function getSaturation_returns_hsl_saturation() : void
    {
        $this->assertSame(97, (new HexColor('#fdba74'))->getSaturation());
    }

    /** @test */
    public function getLightness_returns_hsl_lightness() : void
    {
        $this->assertSame(72, (new HexColor('#fdba74'))->getLightness());
    }

    /** @test */
    public function it_can_be_created_from_a_HslColor_instance() : void
    {
        // 0F172A
        $hslColor = new HslColor(222, 47, 11);

        $this->assertInstanceOf(
            HexColor::class,
            HexColor::fromHslColor($hslColor),
        );
    }

    /**
     * @test
     * @dataProvider hslValuesAndExpectedHexStringProvider
     */
    public function it_has_expected_hex_string_when_created_from_hsl_values(
        int $hue,
        int $saturation,
        int $lightness,
        string $expectedHexString
    ) : void {
        $hslColor = new HslColor($hue, $saturation, $lightness);

        $this->assertSame($expectedHexString, (string) HexColor::fromHslColor($hslColor));
    }

    public function validHexStringsWithLeadingHashProvider() : array
    {
        return [
            ['#DC2626'],
            ['#A1A1AA'],
            ['#ca8a04'],
            ['#000'],
            ['#fff'],
        ];
    }

    public function validHexStringsWithoutLeadingHashProvider() : array
    {
        return [
            ['DC2626'],
            ['A1A1AA'],
            ['ca8a04'],
            ['000'],
            ['fff'],
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
        ];
    }

    public function hslValuesAndExpectedHexStringProvider() : array
    {
        return [
            [222, 47, 11, '#0f1729'],
            [25, 95, 53, '#f97415'],
        ];
    }

    public function validInputAndExpectedHexStringProvider() : array
    {
        return [
            ['#0f1729', '#0f1729'],
            ['f97415', '#f97415'],
            ['#000', '#000000'],
            ['fff', '#ffffff'],
        ];
    }
}
