<?php

namespace App\Http\Resources\Api\V1\Box;

use Illuminate\Http\Resources\Json\JsonResource;

class BoxWithoutRelationResource extends JsonResource
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
            'name' => $this->name,
            'image' => $this->getFirstMediaUrl(),
            'web_view' => (bool)$this->web_view,
            'link' => $this->link,
            'color' => $this->color,
        ];
    }
}
