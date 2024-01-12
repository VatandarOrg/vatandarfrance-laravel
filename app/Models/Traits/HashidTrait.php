<?php

namespace App\Models\Traits;

trait HashidTrait
{
    /**
     * Find by Name, or throw an exception.
     *
     * @param $value
     *
     * @return static
     */
    public static function findByHashidOrFail($value)
    {
        $id = app('hashids')->connection(static::getHashidConnection())->decode($value);
        $id = isset($id[0]) ? $id[0] : null;

        return static::query()->where('id', $id)->firstOrFail();
    }

    /**
     * Find by Hashid
     *
     * @param  string  $value  .
     *
     * @return static|null
     */
    public static function findByHashid($value)
    {
        $id = app('hashids')->connection(static::getHashidConnection())->decode($value);
        $id = isset($id[0]) ? $id[0] : null;
        return static::query()->where('id', $id)->first();
    }

    /**
     * Find by Hashid
     *
     * @param  string  $value  .
     * @param  \Closure  $callback
     * @return static|null
     */
    public static function findByHashidOr($value, \Closure $callback)
    {
        $id = app('hashids')->connection(static::getHashidConnection())->decode($value);
        $id = isset($id[0]) ? $id[0] : null;

        return static::query()->where('id', $id)->firstOr(['*'], $callback);
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        if ($field === 'hashid') {
            $id = app('hashids')->connection(
                static::getHashidConnection()
            )->decode($value);
            $value = isset($id[0]) ? $id[0] : null;
            $field = null;
        }

        return $this->where($field ?? $this->getRouteKeyName(), $value)->first();
    }

    /**
     * @return string
     */
    public static function getHashidConnection()
    {
        return defined('static::HASHID_CONNECTION') ? static::HASHID_CONNECTION : 'main';
    }

    /**
     * Retrieve the child model for a bound value.
     *
     * @param  string  $childType
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveChildRouteBinding($childType, $value, $field)
    {
        if ($field === 'hashid') {
            $id = app('hashids')->connection(
                static::getHashidConnection()
            )->decode($value);
            $value = isset($id[0]) ? $id[0] : null;
            $field = 'id';
        }

        return $this->{Str::plural(Str::camel($childType))}()->where($field, $value)->first();
    }

    /**
     * @return mixed
     */
    public function getHashIdAttribute()
    {
        return $this->getHashid();
    }

    /**
     * @return mixed
     */
    public function getHashid()
    {
        return app('hashids')->connection(self::getHashidConnection())->encode($this->getKey());
    }

    /**
     * @return mixed
     */
    public function getHashidDecode()
    {
        return app('hashids')->connection(self::getHashidConnection())->decode($this->getHashid());
    }
}
