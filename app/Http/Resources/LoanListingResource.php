<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoanListingResource extends JsonResource
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
            "borrower_name" => $this->borrower->fullname(),
            "account_num" => $this->account_num,
            "date_loan" => $this->date_release,
            "maturity" => $this->due_date,
            "amount_loan" => $this->loan_amount,
            "amount_due" => $this->outstandingBalance($this->loan_account_id),
            "principal_balance" => $this->remainingBalance()["principal"]["balance"],
            "interest_balance" => $this->remainingBalance()["interest"]["balance"] - $this->remainingBalance()["rebates"]["credit"],
            "amortization" => $this->amortization()["principal"] + $this->amortization()["interest"],
            "type" => $this->payment_mode,
            "loan_status" => $this->loan_status,
            "status" => $this->payment_status
        ];
    }
}
