<?php

namespace App\ProtectionLayers;

use App\Http\Responses\Admin\RoleResponse;
use App\Services\Role\RoleService;
use Imanghafoori\HeyMan\Facades\HeyMan;

class EnsureRoleIdExists
{
    public static function install()
    {
        HeyMan::onCheckPoint('EnsureRoleIdExists')
            ->thisMethodShouldAllow([static::class, 'roleIdExists'])
            ->otherwise()
            ->afterCalling([self::class, 'react'])
            ->weRespondFrom([RoleResponse::class, 'invalidRoleId']);
    }

    public static function roleIdExists(): bool
    {
        $id = request()->route()->parameter('role');
        return is_numeric($id) && RoleService::new()->findByIdWithRelation((int)$id);
    }

    public static function react()
    {
        \Log::alert('Tried to access a non-existing role!', [
            'user_id' => auth()->id(),
            'route' => request()->route()->getName(),
            'role_id' => request()->route()->parameter('role')
        ]);
    }
}
