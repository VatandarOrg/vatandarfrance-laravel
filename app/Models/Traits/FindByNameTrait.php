<?php

namespace App\Models\Traits;

use Closure;

trait FindByNameTrait
{

    /**
     * @param  string  $name
     *
     * @return static|null|object
     * @author Arash Farahani <arashmf71@gmail.com>
     *
     */
    public static function findByName($name): ?self
    {
        return static::query()->where('name', $name)->first();
    }

    /**
     * @param  string  $name
     * @param  Closure  $callback
     *
     * @return self|null|object
     * @author Arash Farahani <arashmf71@gmail.com>
     *
     */
    public static function findByNameOr($name, Closure $callback = null)
    {
        return static::query()->where('name', $name)->firstOr($callback);
    }

    /**
     * @param  string  $name
     *
     * @return self|object
     * @author Arash Farahani <arashmf71@gmail.com>
     *
     */
    public static function findByNameOrFail($name): self
    {
        return static::query()->where('name', $name)->firstOrFail();
    }
}
