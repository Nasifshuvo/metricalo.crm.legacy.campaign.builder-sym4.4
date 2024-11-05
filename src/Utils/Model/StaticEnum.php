<?php

declare(strict_types=1);

namespace App\Utils\Model;

class StaticEnum
{
    protected static array $enum = [];

    public static function toArray(): array
    {
        return static::$enum;
    }

    public static function getLabel($key)
    {
        static::checkKey($key);

        return static::$enum[$key];
    }

    public static function getKey($label)
    {
        return array_search($label, static::$enum, true);
    }

    public static function getKeys(): array
    {
        return array_keys(static::$enum);
    }

    public static function hasKey($key)
    {
        return isset(static::$enum[$key]);
    }

    public static function checkKey($key): void
    {
        if (!static::hasKey($key)) {
            throw new \InvalidArgumentException(sprintf('bad key "%s"', $key));
        }
    }
}
