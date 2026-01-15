<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
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
            'product_id' => $this->product_id,
            'product_code' => $this->product_code,
            'product_name' => $this->product_name,
            'interest_rate' => $this->interest_rate,
            'filing_fee' => $this->filing_fee,
            'status' => $this->status,
            'deleted' => $this->deleted,
        ];
    }
}
