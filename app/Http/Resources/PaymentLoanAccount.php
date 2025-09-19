<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentLoanAccount extends JsonResource
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
            // loan account
            'loan_account_id' => $this->loan_account_id,
            'account_num' => $this->account_num,
            'date_release' => $this->date_release,
            'cycle_no' => $this->cycle_no,
            'type' => $this->type,
            'payment_mode' => $this->payment_mode,
            'terms' => $this->terms,
            'loan_amount' => $this->loan_amount,
            'interest_rate' => $this->interest_rate,
            'interest_amount' => $this->interest_amount,
            'no_of_installment' => $this->no_of_installment,
            'due_date' => $this->due_date,
            'day_schedule' => $this->day_schedule,
            // borrower
            'borrower_id' => $this->borrower_id,
            'borrower_num' => $this->borrower_num,
            'firstname' => $this->firstname,
            'middlename' => $this->middlename,
            'lastname' => $this->lastname,
            'suffix' => $this->suffix,
            'address' => $this->address,

        ];
    }
}
