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
HexColor::isValid('19b9cd', true); // bool(false)

// creating from hex string
$hexColor = new HexColor('#f0f');

// creating from other formats
$hexColor = HexColor::fromHslColor($hslColorInstance);
$hexColor = HexColor::fromRgbColor($rgbColorInstance);
$hexColor = HexColor::fromCmykColor($cmykColorInstance);

// get the hex string
$hexColor->getHexString();

// converting to other formats
$hslColor = $rgbColor->toHsl();
$rgbColor = $rgbColor->toRgb();
$cmykColor = $rgbColor->toCmyk();
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
```

## RgbColor

```php
use Devlop\Colours\RgbColor;

// creating from RGB values
$rgbColor = new RgbColor(221, 186, 146);

// creating from other formats
$rgbColor = RgbColor::fromHexString('#f3840c');
$rgbColor = RgbColor::fromHexColor($hexColorInstance);
$rgbColor = RgbColor::fromHslColor($hslColorInstance);
$cmykColor = RgbColor::fromCmykColor($cmykColorInstance);

// get RGB properties
$rgbColor->getRed(); // int(221)
$rgbColor->getGreen(); // int(186)
$rgbColor->getBlue(); // int(146)

// converting to other formats
$hexColor = $rgbColor->toHex();
$hslColor = $rgbColor->toHsl();
$cmykColor = $rgbColor->toCmyk();
```

## CmykColor

```php
use Devlop\Colours\CmykColor;

// creating from CMYK values
$rgbColor = new CmykColor(20, 80, 65, 34);

// creating from other formats
$cmykColor = CmykColor::fromHexString('#f3840c');
$cmykColor = CmykColor::fromHexColor($hexColorInstance);
$cmykColor = CmykColor::fromRgbColor($rgbColorInstance);

// get CMYK properties
$rgbColor->getCyan(); // int(20)
$rgbColor->getMagenta(); // int(80)
$rgbColor->getYellow(); // int(65)
$rgbColor->getKey(); // int(34)
```
