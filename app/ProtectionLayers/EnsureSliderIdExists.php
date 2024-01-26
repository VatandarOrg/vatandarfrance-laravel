<?php
namespace App\ProtectionLayers;
use App\Http\Responses\Admin\SliderResponse;
use App\Services\Slider\SliderService;
use Imanghafoori\HeyMan\Facades\HeyMan;
class EnsureSliderIdExists
{
    public static function install()
    {
        HeyMan::onCheckPoint('EnsureSliderIdExists')
            ->thisMethodShouldAllow([static::class, 'check'])
            ->otherwise()
            ->afterCalling([self::class, 'react'])
            ->weRespondFrom([SliderResponse::class, 'invalidSliderId']);
    }
    public static function check(): bool
    {
        $id = request()->route()->parameter('slider');
        return is_numeric($id) && SliderService::new()->findByIdWithRelation((int)$id);
    }
    public static function react()
    {
        \Log::alert('Tried to access a non-existing slider!', [
            'user_id' => auth()->id(),
            'route' => request()->route()->getName(),
            'slider_id' => request()->route()->parameter('slider')
        ]);
    }
}
