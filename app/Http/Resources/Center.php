<?php

namespace App\Http\Resources;

use App\Models\LoanAccount;
use App\Models\LoanAccountMigrationFix;
use Illuminate\Http\Resources\Json\JsonResource;

class Center extends JsonResource
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
            'center_id' => $this->center_id,
            'center' => $this->center,
            'day_sched' => $this->day_sched,
            'status' => $this->status,
            'area' => $this->area,
            'deleted' => $this->deleted,
        ];
    }

}
