<?php

namespace App\Http\Resources\Api\V1\Post;

use Illuminate\Http\Resources\Json\JsonResource;

class PostWithoutRelationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'image' => $this->getFirstMediaUrl(),
            'description' => $this->description,
            'web_view' => (bool)$this->web_view,
            'link' => $this->link,
        ];
    }
}
