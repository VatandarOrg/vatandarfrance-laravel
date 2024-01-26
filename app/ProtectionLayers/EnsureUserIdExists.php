<?php

namespace App\ProtectionLayers;

use App\Http\Responses\Admin\UserResponse;
use App\Services\User\UserService;
use Imanghafoori\HeyMan\Facades\HeyMan;

class EnsureUserIdExists
{
    public static function install()
    {
        HeyMan::onCheckPoint('EnsureUserIdExists')
            ->thisMethodShouldAllow([static::class, 'userIdExists'])
            ->otherwise()
            ->afterCalling([self::class, 'react'])
            ->weRespondFrom([UserResponse::class, 'invalidUserId']);
    }

    public static function userIdExists(): bool
    {
        $id = request()->route()->parameter('user');
        return is_numeric($id) && UserService::new()->findByIdWithRelation((int)$id);
    }

    public static function react()
    {
        \Log::alert('Tried to access a non-existing user!', [
            'user_id' => auth()->id(),
            'route' => request()->route()->getName(),
            'user_id' => request()->route()->parameter('user')
        ]);
    }
}
