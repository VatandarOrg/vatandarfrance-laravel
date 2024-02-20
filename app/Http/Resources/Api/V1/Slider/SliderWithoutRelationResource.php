<?php

namespace App\Http\Resources\Api\V1\Slider;

use Illuminate\Http\Resources\Json\JsonResource;

class SliderWithoutRelationResource extends JsonResource
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
        ];
    }
}
