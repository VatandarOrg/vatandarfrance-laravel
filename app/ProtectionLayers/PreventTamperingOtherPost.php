<?php
namespace App\ProtectionLayers;
use App\Http\Responses\User\PostResponse;
use App\Services\Post\PostService;
use Imanghafoori\HeyMan\Facades\HeyMan;
class PreventTamperingOtherPost
{
    public static function install()
    {
        HeyMan::onCheckPoint('PreventTamperingOtherPost')
            ->thisMethodShouldAllow([static::class, 'check'])
            ->otherwise()
            ->afterCalling([self::class, 'react'])
            ->weRespondFrom([PostResponse::class, 'invalidPostPossession']);
    }
    public static function check()
    {
        $id = (int) request()->route()->parameter('post');
        return PostService::new()->findByIdWithRelation((int)$id)->user_id == auth()->id();
    }
    public static function react()
    {
        \Log::alert('someone tried to access other congress posts!', [
            'user_id' => auth()->id(),
            'route' => request()->route()->getName(),
            'post_id' => request()->route()->parameter('post')
        ]);
    }
}
