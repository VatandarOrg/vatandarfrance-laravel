<?php

namespace App\Models\Traits;

trait ConfirmedTrait
{
    /**
     * @param  mixed  $query
     * @return bool
     * @author Arash Farahani <arashmf71@gmail.com>
     *
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status_id', config('statuses.confirmed'));
    }
}
