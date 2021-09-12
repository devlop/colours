<p align="center">
    <a href="https://packagist.org/packages/devlop/colours"><img src="https://img.shields.io/packagist/v/devlop/colours" alt="Latest Stable Version"></a>
    <a href="https://github.com/devlop/colours/blob/master/LICENSE.md"><img src="https://img.shields.io/packagist/l/devlop/colours" alt="License"></a>
</p>

# Colours

Collection of color classes to simplify working and converting colors in PHP.

# Installation

```bash
composer require devlop/colours
```

# Usage

## HexColor

```php
use Devlop\Colours\HexColor;

// check validity
HexColor::isValid('#fff'); // bool(true)
HexColor::isValid('#0B33B1'); // bool(true)
HexColor::isValid('#19b9cd'); // bool(true)
HexColor::isValid('#b9cd'); // bool(false)
HexColor::isValid('red'); // bool(false)
HexColor::isValid('19b9cd'); // bool(true)

// check validity (strict mode)
HexColor::isValid('19b9cd'); // bool(false)

// creating from hex string
$hexColor = new HexColor('#f0f');

// creating from other formats
$hexColor = HexColor::fromHslColor($hslColorInstance);
$hexColor = HexColor::fromRgbColor($rgbColorInstance);

// get hex string
(string) $hexColor;
$hexColor->getHexString();

// converting to other formats
$hslColor = $rgbColor->toHsl();
$rgbColor = $rgbColor->toRgb();

// get HSL properties without ->toHsl()
$hexColor->getHue(); // int(300)
$hexColor->getSaturation(); // int(100)
$hexColor->getLightness(); // int(50)

// get RGB properties without ->toRgb()
$hexColor->getRed(); // int(255)
$hexColor->getSaturation(); // int(0)
$hexColor->getLightness(); // int(255)
```

## HslColor

```php
use Devlop\Colours\HslColor;

// creating from HSL values
$hslColor = new HslColor(180, 96, 77);

// creating from other formats
$hslColor = HslColor::fromHexString('#b187F5');
$hslColor = HslColor::fromHexColor($hexColorInstance);
$hslColor = HslColor::fromRgbColor($rgbColorInstance);

// get HSL properties
$hslColor->getHue(); // int(180)
$hslColor->getSaturation(); // int(96)
$hslColor->getLightness(); // int(77)

// converting to other formats
$hexColor = $rgbColor->toHex();
$rgbColor = $rgbColor->toRgb();

// get RGB properties without ->toRgb()
$hslColor->getRed(); // int(140)
$hslColor->getSaturation(); // int(253)
$hslColor->getLightness(); // int(253)

// get hex string without ->toHex()
$hslColor->getHexString(); // string('#8CFDFD')
```

## RgbColor

```php
use Devlop\Colours\RgbColor;

// creating from RGB values
$rgbColor = new RgbColor(221, 186, 146);

// creating from other formats
$rgbColor = HslColor::fromHexString('#f3840c');
$rgbColor = HslColor::fromHexColor($hexColorInstance);
$rgbColor = HslColor::fromHslColor($hslColorInstance);

// get RGB properties
$rgbColor->getRed(); // int(221)
$rgbColor->getSaturation(); // int(186)
$rgbColor->getLightness(); // int(146)

// converting to other formats
$hexColor = $rgbColor->toHex();
$hslColor = $rgbColor->toHsl();

// get HSL properties without ->toHsl()
$rgbColor->getHue(); // int(32)
$rgbColor->getSaturation(); // int(52)
$rgbColor->getLightness(); // int(72)

// get hex string without ->toHex()
$rgbColor->getHexString(); // string('#DDBA92')
```
