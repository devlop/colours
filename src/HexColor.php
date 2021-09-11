<?php

declare(strict_types=1);

namespace Devlop\Colors;

use InvalidArgumentException;
use Stringable;

final class HexColor implements Stringable
{
    private string $hexColor;

    public function __construct(string $hexColor)
    {
        if (! preg_match('^#[0-9a-f]{6}$')) {
            throw new InvalidArgumentException(sprintf(
                '"%1$s" is not a supported hex color.',
                $hexColor,
            ));
        }

        $this->hexColor = $hexColor;
    }
}
