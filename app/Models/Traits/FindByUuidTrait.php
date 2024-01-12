<?php

namespace App\Models\Traits;

use Closure;

trait FindByUuidTrait
{

    /**
     * @param  string  $uuid
     *
     * @return static|null|object
     * @author Arash Farahani <arashmf71@gmail.com>
     *
     */
    public static function findByUuid($uuid): ?self
    {
        return static::query()->where('uuid', $uuid)->first();
    }

    /**
     * @param  string  $uuid
     * @param  Closure  $callback
     *
     * @return static|null|object
     * @author Arash Farahani <arashmf71@gmail.com>
     *
     */
    public static function findByUuidOr($uuid, Closure $callback = null)
    {
        return static::query()->where('uuid', $uuid)->firstOr($callback);
    }

    /**
     * @param  string  $uuid
     *
     * @return static|object
     * @author Arash Farahani <arashmf71@gmail.com>
     *
     */
    public static function findByUuidOrFail($uuid): self
    {
        return static::query()->where('uuid', $uuid)->firstOrFail();
    }
}
