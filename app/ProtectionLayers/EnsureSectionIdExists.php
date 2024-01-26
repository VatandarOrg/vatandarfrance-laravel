<?php
namespace App\ProtectionLayers;
use App\Http\Responses\Admin\SectionResponse;
use App\Services\Section\SectionService;
use Imanghafoori\HeyMan\Facades\HeyMan;
class EnsureSectionIdExists
{
    public static function install()
    {
        HeyMan::onCheckPoint('EnsureSectionIdExists')
            ->thisMethodShouldAllow([static::class, 'check'])
            ->otherwise()
            ->afterCalling([self::class, 'react'])
            ->weRespondFrom([SectionResponse::class, 'invalidSectionId']);
    }
    public static function check(): bool
    {
        $id = request()->route()->parameter('section');
        return is_numeric($id) && SectionService::new()->findByIdWithRelation((int)$id);
    }
    public static function react()
    {
        \Log::alert('Tried to access a non-existing section!', [
            'user_id' => auth()->id(),
            'route' => request()->route()->getName(),
            'section_id' => request()->route()->parameter('section')
        ]);
    }
}
