<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Branch as BranchResource;

class AccountOfficer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
         // return parent::toArray($request);
        return [
            'ao_id' => $this->ao_id,
            'name' => $this->name,
            'status' => $this->status,
            'branch_id' => $this->branch_id,
            'branch' => $this->branch,
            'branch_registered' => $this->branches,
            'deleted' => $this->deleted
        ];
    }
}
