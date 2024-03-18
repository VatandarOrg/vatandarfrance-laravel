<?php

namespace App\Http\Resources\Api\V1\Payment;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentWithoutRelationResource extends JsonResource
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
            'id' => $this->paypal_subscription_id,
            'plan_id' => $this->plan_id,
            'status' => $this->status,
            'subscriber' => json_decode($this->subscriber),
            'detail' => json_decode($this->detail),
            'start_time' => $this->start_time,
            'expired_at' => $this->expired_at,
        ];
    }
}
