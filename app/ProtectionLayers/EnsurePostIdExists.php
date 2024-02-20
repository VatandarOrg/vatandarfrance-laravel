<?php
namespace App\ProtectionLayers;
use App\Http\Responses\Admin\PostResponse;
use App\Services\Post\PostService;
use Imanghafoori\HeyMan\Facades\HeyMan;
class EnsurePostIdExists
{
    public static function install()
    {
        HeyMan::onCheckPoint('EnsurePostIdExists')
            ->thisMethodShouldAllow([static::class, 'check'])
            ->otherwise()
            ->afterCalling([self::class, 'react'])
            ->weRespondFrom([PostResponse::class, 'invalidPostId']);
    }
    public static function check(): bool
    {
        $id = request()->route()->parameter('post');
        return is_numeric($id) && PostService::new()->findByIdWithRelation((int)$id);
    }
    public static function react()
    {
        \Log::alert('Tried to access a non-existing post!', [
            'user_id' => auth()->id(),
            'route' => request()->route()->getName(),
            'post_id' => request()->route()->parameter('post')
        ]);
    }
}
