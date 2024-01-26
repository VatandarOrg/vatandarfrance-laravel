<?php
namespace App\ProtectionLayers;
use App\Http\Responses\Admin\BoxResponse;
use App\Services\Box\BoxService;
use Imanghafoori\HeyMan\Facades\HeyMan;
class EnsureBoxIdExists
{
    public static function install()
    {
        HeyMan::onCheckPoint('EnsureBoxIdExists')
            ->thisMethodShouldAllow([static::class, 'check'])
            ->otherwise()
            ->afterCalling([self::class, 'react'])
            ->weRespondFrom([BoxResponse::class, 'invalidBoxId']);
    }
    public static function check(): bool
    {
        $id = request()->route()->parameter('box');
        return is_numeric($id) && BoxService::new()->findByIdWithRelation((int)$id);
    }
    public static function react()
    {
        \Log::alert('Tried to access a non-existing box!', [
            'user_id' => auth()->id(),
            'route' => request()->route()->getName(),
            'box_id' => request()->route()->parameter('box')
        ]);
    }
}
