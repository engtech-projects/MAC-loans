<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Payment extends JsonResource
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
            'payment_id' => $this->payment_id,
            'loan_account_id' => $this->loan_account_id,
            'branch_id' => $this->branch_id,
            'payment_type' => $this->payment_type, 
            'or_no' => $this->or_no,
            'cheque_no' => $this->cheque_no,
            'bank_name' => $this->bank_name,
            'reference_no' => $this->reference_no,
            'memo_type' => $this->memo_type,
            'amortization_id' => $this->amortization_id,
            'principal' => $this->principal,
            'interest' => $this->interest,
            'short_principal' => $this->short_principal,
            'advance_principal' => $this->advance_principal,
            'short_interest' => $this->short_interest,
            'advance_interest' => $this->advance_interest,
            'pdi' => $this->pdi,
            'pdi_approval_no' => $this->pdi_approval_no,
            'penalty' => $this->penalty,
            'penalty_approval_no' => $this->penalty_approval_no,
            'rebates' => $this->rebates,
            'rebates_approval_no' => $this->rebates_approval_no,
            'total_payable' => $this->total_payable,
            'amount_applied' => $this->amount_applied,
            'status' => $this->status,
        
        ];
    }
}