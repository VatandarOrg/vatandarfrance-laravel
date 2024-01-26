<?php

namespace App\ProtectionLayers;

use App\Http\Responses\Admin\PermissionResponse;
use App\Services\Permission\PermissionService;
use Imanghafoori\HeyMan\Facades\HeyMan;

class EnsurePermissionIdExists
{
    public static function install()
    {
        HeyMan::onCheckPoint('EnsurePermissionIdExists')
            ->thisMethodShouldAllow([static::class, 'permissionIdExists'])
            ->otherwise()
            ->afterCalling([self::class, 'react'])
            ->weRespondFrom([PermissionResponse::class, 'invalidPermissionId']);
    }

    public static function permissionIdExists(): bool
    {
        $id = request()->route()->parameter('permission');
        return is_numeric($id) && PermissionService::new()->findByIdWithRelation((int)$id);
    }

    public static function react()
    {
        \Log::alert('Tried to access a non-existing Permission!', [
            'user_id' => auth()->id(),
            'route' => request()->route()->getName(),
            'permission_id' => request()->route()->parameter('permission')
        ]);
    }
}
