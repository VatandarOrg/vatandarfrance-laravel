<?php

namespace App\Models\Traits;

use Closure;

trait FindByCodeTrait
{

    /**
     *
     * @param  string|null  $code
     * @return static|null|object
     * @author Arash Farahani <arashmf71@gmail.com>
     */
    public static function findByCode(?string $code): ?self
    {
        return static::query()->where('code', $code)->first();
    }

    /**
     * @param  string  $code
     * @param  Closure  $callback
     *
     * @return static|null|object
     * @author Arash Farahani <arashmf71@gmail.com>
     *
     */
    public static function findByCodeOr(string $code, Closure $callback = null)
    {
        return static::query()->where('code', $code)->firstOr($callback);
    }

    /**
     * @param  string  $code
     *
     * @return static|object
     * @author Arash Farahani <arashmf71@gmail.com>
     *
     */
    public static function findByCodeOrFail(string $code): self
    {
        return static::query()->where('code', $code)->firstOrFail();
    }
}
