<?php

namespace App\Models\Traits;

use Closure;

trait FindByTypeTrait
{

    /**
     * @param  string  $type
     *
     * @return static|null|object
     * @author Arash Farahani <arashmf71@gmail.com>
     *
     */
    public static function findByType(string $type): ?self
    {
        return static::query()->where('type', $type)->first();
    }

    /**
     * @param  string  $type
     * @param  Closure  $callback
     *
     * @return static|null|object
     * @author Arash Farahani <arashmf71@gmail.com>
     *
     */
    public static function findByTypeOr(string $type, Closure $callback = null)
    {
        return static::query()->where('type', $type)->firstOr($callback);
    }

    /**
     * @param  string  $type
     *
     * @return static|object
     * @author Arash Farahani <arashmf71@gmail.com>
     *
     */
    public static function findByTypeOrFail(string $type): self
    {
        return static::query()->where('type', $type)->firstOrFail();
    }
}
