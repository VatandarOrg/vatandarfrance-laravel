<?php

namespace App\Services\SubscriptionPayment;

use App\Models\SubscriptionPayment;
use App\Services\ModelService;
use Imanghafoori\Helpers\Nullable;

class SubscriptionPaymentService extends ModelService
{
    public function __construct(SubscriptionPayment $subscriptionpayment)
    {
        $this->setModel($subscriptionpayment);
    }
    public static function new()
    {
        return static::make(new SubscriptionPayment());
    }
    public static function make(SubscriptionPayment $subscriptionpayment)
    {
        return new static($subscriptionpayment);
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
