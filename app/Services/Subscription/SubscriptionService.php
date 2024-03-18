<?php

namespace App\Services\Subscription;

use App\Models\Subscription;
use App\Services\ModelService;
use Imanghafoori\Helpers\Nullable;

class SubscriptionService extends ModelService
{
    public function __construct(Subscription $subscription)
    {
        $this->setModel($subscription);
    }
    public static function new()
    {
        return static::make(new Subscription());
    }
    public static function make(Subscription $subscription)
    {
        return new static($subscription);
    }
    public function create(array $data = []): ?Nullable
    {
        return parent::create($data);
    }
    public function update($data = []): Nullable
    {
        return parent::update($data);
    }
    public function delete(): ?Nullable
    {
        return parent::delete();
    }
}
