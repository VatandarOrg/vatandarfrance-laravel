<?php

namespace App\Models\Traits;

use Closure;

trait FindByTokenIdTrait
{

    /**
     * @param string $tokenId
     *
     * @return static|null|object
     * @author Arash Farahani <arashmf71@gmail.com>
     *
     */
    public static function findByTokenId(string $tokenId) : ?self
    {
        return static::query()->where('token_id', explode('|', $tokenId)[0])->first();
    }

    /**
     * @param string $tokenId
     * @param  Closure  $callback
     *
     * @return static|null|object
     * @author Arash Farahani <arashmf71@gmail.com>
     *
     */
    public static function findByTokenIdOr(string $tokenId, Closure $callback = null)
    {
        return static::query()->where('token_id', explode('|', $tokenId)[0])->firstOr($callback);
    }

    /**
     * @param string $tokenId
     *
     * @return static|object
     * @author Arash Farahani <arashmf71@gmail.com>
     *
     */
    public static function findByTokenIdOrFail(string $tokenId) : self
    {
        return static::query()->where('token_id', explode('|', $tokenId)[0])->firstOrFail();
    }
}
