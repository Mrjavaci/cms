<?php

namespace VirtaraCase\Traits;

trait UseMakeTrait
{
    private static array $instances = [];

    public static function make(): self
    {
        if (array_key_exists(static::class, self::$instances)) {
            return self::$instances[static::class];
        }

        return self::$instances[static::class] = new static();
    }
}