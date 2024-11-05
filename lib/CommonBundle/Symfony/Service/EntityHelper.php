<?php

declare(strict_types=1);

namespace Common\Symfony\Service;

use Common\Utils\StringUtils;

class EntityHelper
{
    public static function generateTokenString(string $prefix, $keyLength): string
    {
        return $prefix . mb_strtoupper(StringUtils::randomKey($keyLength));
    }
}
