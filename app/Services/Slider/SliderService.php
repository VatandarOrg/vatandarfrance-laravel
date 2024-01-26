<?php
namespace App\Services\Slider;
use App\Models\Slider;
use App\Services\ModelService;
use Imanghafoori\Helpers\Nullable;
class SliderService extends ModelService
{
    public function __construct(Slider $slider)
    {
        $this->setModel($slider);
    }
    public static function new()
    {
        return static::make(new Slider());
    }
    public static function make(Slider $slider)
    {
        return new static($slider);
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
