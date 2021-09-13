<?php

declare(strict_types=1);

namespace Devlop\Colours;

use Devlop\Colours\HslColor;
use Devlop\Colours\InvalidColorException;

final class CmykColor
{
    private int $cyan;

    private int $magenta;

    private int $yellow;

    private int $key;

    public function __construct(int $cyan, int $magenta, int $yellow, int $key)
    {
        if ($cyan < 0 || $cyan > 100) {
            throw new InvalidColorException(sprintf(
                '"%1$d" is not a supported value, cyan must be between 0 and 100.',
                $cyan,
            ));
        }

        if ($magenta < 0 || $magenta > 100) {
            throw new InvalidColorException(sprintf(
                '"%1$d" is not a supported value, magenta must be between 0 and 100.',
                $magenta,
            ));
        }

        if ($yellow < 0 || $yellow > 100) {
            throw new InvalidColorException(sprintf(
                '"%1$d" is not a supported value, yellow must be between 0 and 100.',
                $yellow,
            ));
        }

        if ($key < 0 || $key > 100) {
            throw new InvalidColorException(sprintf(
                '"%1$d" is not a supported value, key must be between 0 and 100.',
                $key,
            ));
        }

        $this->cyan = $cyan;

        $this->magenta = $magenta;

        $this->yellow = $yellow;

        $this->key = $key;
    }

    /**
     * Get the value for cyan.
     */
    public function getCyan() : int
    {
        return $this->cyan;
    }

    /**
     * Get the value for magenta.
     */
    public function getMagenta() : int
    {
        return $this->magenta;
    }

    /**
     * Get the value for yellow.
     */
    public function getYellow() : int
    {
        return $this->yellow;
    }

    /**
     * Get the value for key.
     */
    public function getKey() : int
    {
        return $this->key;
    }
}
