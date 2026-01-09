<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GL extends JsonResource
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
            'gl_id' => $this->gl_id,
            'loans' => $this->loans,
            'code' => $this->code,
            'accounting' => $this->accounting,
            'type' => $this->type,
        ];
    }
}
