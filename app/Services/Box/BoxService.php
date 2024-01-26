<?php
namespace App\Services\Box;
use App\Models\Box;
use App\Services\ModelService;
use Imanghafoori\Helpers\Nullable;
class BoxService extends ModelService
{
    public function __construct(Box $box)
    {
        $this->setModel($box);
    }
    public static function new()
    {
        return static::make(new Box());
    }
    public static function make(Box $box)
    {
        return new static($box);
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
