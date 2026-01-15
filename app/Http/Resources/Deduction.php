<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Deduction extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'rate' => $this->rate,
            'product_id' => $this->product_id,
            'term_start' => $this->term_start,
            'term_end' => $this->term_end,
            'age_start' => $this->age_start,
            'age_end' => $this->age_end,
            'deleted' => $this->deleted,
            'status' => $this->status,
        ];
    }
}
