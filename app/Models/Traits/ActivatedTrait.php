<?php

namespace App\Models\Traits;

trait ActivatedTrait
{
    /**
     * @param  mixed  $query
     * @return bool
     * @author Arash Farahani <arashmf71@gmail.com>
     *
     */
    public function scopeActivated($query)
    {
        return $query->where('status_id', config('statuses.activated'));
    }
}
