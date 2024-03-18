<?php

namespace App\ProtectionLayers;

use App\Models\SubscriptionPayment;
use Imanghafoori\HeyMan\Facades\HeyMan;
use Illuminate\Http\Response;

class EnsureSubscriptionPaymentIdExists
{
    public static function install()
    {
        HeyMan::onCheckPoint('EnsureSubscriptionPaymentIdExists')
            ->thisMethodShouldAllow([static::class, 'check'])
            ->otherwise()
            ->afterCalling([self::class, 'react'])
            ->response()->json(["status" => "error", "message" => 'Something went wrong.'], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public static function check(): bool
    {
        $id = request()->subscription_id;
        return is_string($id) && SubscriptionPayment::where('paypal_subscription_id', $id)->first();
    }
    public static function react()
    {
        \Log::alert('Tried to access a non-existing subscription_id!', [
            'user_id' => auth()->id(),
            'route' => request()->route()->getName(),
            'subscription_id' => request()->route()->parameter('subscription_id')
        ]);
    }
}
