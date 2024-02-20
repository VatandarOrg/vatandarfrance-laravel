<?php
namespace App\Services\Post;
use App\Models\Post;
use App\Services\ModelService;
use Imanghafoori\Helpers\Nullable;
class PostService extends ModelService
{
    public function __construct(Post $post)
    {
        $this->setModel($post);
    }
    public static function new()
    {
        return static::make(new Post());
    }
    public static function make(Post $post)
    {
        return new static($post);
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
