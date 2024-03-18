<?php

namespace App\ProtectionLayers;

use App\Http\Responses\User\SubscriptionResponse;
use Illuminate\Http\Response;
use Imanghafoori\HeyMan\Facades\HeyMan;

class EnsureUserCanBuySubscription
{
    public static function install()
    {
        HeyMan::onCheckPoint('EnsureUserCanBuySubscription')
            ->thisMethodShouldAllow([static::class, 'check'])
            ->otherwise()
            ->afterCalling([self::class, 'react'])
            ->response()->json(["status" => "error", "message" => 'User cannot buy a subscription'], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public static function check(): bool
    {
        $user = auth()->user();

        return !$user->has_subscription;
    }
    public static function react()
    {
        \Log::alert('Tried to buy subscription', [
            'user_id' => auth()->id(),
            'route' => request()->route()->getName(),
        ]);
    }
}
