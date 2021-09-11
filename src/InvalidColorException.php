<?php

declare(strict_types=1);

namespace Devlop\Colours;

use InvalidArgumentException;

final class InvalidColorException extends InvalidArgumentException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
