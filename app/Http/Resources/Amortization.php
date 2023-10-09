<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Amortization extends JsonResource
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
            'loan_account_id' => $this->loan_account_id,
            'amortization_date' => $this->amortization_date,
            'principal' => $this->principal,
            'interest' => $this->interest,
            'total' => $this->total,
            'principal_balance' => $this->principal_balance,
            'interest_balance' => $this->interest_balance,
            'status' => $this->status,
        ];
    }
}
