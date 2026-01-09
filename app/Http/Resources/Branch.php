<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Branch extends JsonResource
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
            'branch_id' => $this->branch_id,
            'branch_code' => $this->branch_code,
            'branch_name' => $this->branch_name,
            'branch_address' => $this->branch_address,
            'branch_manager' => $this->branch_manager,
            'status' => $this->status,
            'deleted' => $this->deleted,
            'created_at' => $this->created_at->format('m/d/Y'),
            'updated_at' => $this->updated_at->format('m/d/Y'),
        ];
    }
}
