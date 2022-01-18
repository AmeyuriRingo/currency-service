<?php

namespace App\Enums;

use MadWeb\Enum\Enum;

/**
 * List of all currencies
 *
 * @method static StrategiesEnum LATEST()
 * @method static StrategiesEnum BY_DATE()
 */
final class StrategiesEnum extends Enum
{
    public const __default = self::LATEST;

    public const LATEST = 'Latest';
    public const BY_DATE = 'By date';
}
