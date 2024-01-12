<?php

namespace App\Models\Traits;

use Closure;

trait FindByEmailTrait
{

    /**
     * @param  string  $email
     *
     * @return static|null|object
     * @author Arash Farahani <arashmf71@gmail.com>
     *
     */
    public static function findByEmail(string $email): ?self
    {
        return static::query()->where('email', $email)->first();
    }

    /**
     * @param  string  $email
     * @param  Closure  $callback
     *
     * @return static|null|object
     * @author Arash Farahani <arashmf71@gmail.com>
     *
     */
    public static function findByEmailOr(string $email, Closure $callback = null)
    {
        return static::query()->where('email', $email)->firstOr($callback);
    }

    /**
     * @param  string  $email
     *
     * @return static|object
     * @author Arash Farahani <arashmf71@gmail.com>
     *
     */
    public static function findByEmailOrFail(string $email): self
    {
        return static::query()->where('email', $email)->firstOrFail();
    }
}
