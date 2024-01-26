<?php
namespace App\Services\Section;
use App\Models\Section;
use App\Services\ModelService;
use Imanghafoori\Helpers\Nullable;
class SectionService extends ModelService
{
    public function __construct(Section $section)
    {
        $this->setModel($section);
    }
    public static function new()
    {
        return static::make(new Section());
    }
    public static function make(Section $section)
    {
        return new static($section);
    }
    public function create(array $data = []): ?Nullable
    {
        return parent::create($data);
    }
    public function update($data = []): Nullable
    {
        return parent::update($data);
    }
    public function delete(): ?Nullable
    {
        return parent::delete();
    }
}
