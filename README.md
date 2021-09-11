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

```php
use Devlop\Colours\HexColor;

$hexColor = new HexColor('#ff00ff');

$hexColor->getHue();
$hexColor->getSaturation();
$hexColor->getLightness();

```
