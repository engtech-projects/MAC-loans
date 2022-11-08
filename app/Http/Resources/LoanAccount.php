<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoanAccount extends JsonResource
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
            'account_num' => $this->account_num,
            'date_release' => $this->date_release,
            'cycle_no' => $this->cycle_no,
            'product_id' => $this->product_id,
            'center_id' => $this->center_id,
            'ao_id' => $this->ao_id,
            'type' => $this->type,
            'payment_mode' => $this->payment_mode,
            'terms' => $this->terms,
            'loan_amount' => $this->loan_amount,
            'interest_rate' => $this->interest_rate,
            'interest_amount' => $this->interest_amount,
            'no_of_installment' => $this->no_of_installment,
            'due_date' => $this->due_date,
            'day_schedule' => $this->day_schedule,
            'co_borrower_name' => $this->co_borrower_name,
            'co_borrower_address' => $this->co_borrower_address,
            'co_borrower_id_type' => $this->co_borrower_id_type,
            'co_borrower_id_number' => $this->co_borrower_id_number,
            'co_borrower_id_date_issued' => $this->co_borrower_id_date_issued,
            'co_maker_name' => $this->co_maker_name,
            'co_maker_address' => $this->co_maker_address,
            'co_maker_id_type' => $this->co_maker_id_type,
            'co_maker_id_number' => $this->co_maker_id_number,
            'co_maker_id_date_issued' => $this->co_maker_id_date_issued,
            'document_stamp' => $this->document_stamp,
            'filing_fee' => $this->filing_fee,
            'insurance' => $this->insurance,
            'notarial_fee' => $this->notarial_fee,
            'prepaid_interest' => $this->prepaid_interest,
            'affidavit_fee' => $this->affidavit_fee,
            'memo' => $this->memo,
            'total_deduction' => $this->total_deduction,
            'net_proceeds' => $this->net_proceeds,
            'release_type' => $this->release_type,
            'status' => $this->status,
            // 'borrower_num' => $this->borrower_num,
            'borrower_photo' => $this->borrowerPhoto(),
            'borrower' => $this->borrower,
            'account_officer' => $this->accountOfficer,
            'center' => $this->center,
            'product' => $this->product,
            // 'branch_code' => $this->branch_code,
            'branch' => $this->branch,
            'transaction_date' => $this->transaction_date,
            'last_transaction' => null,
            'document' => $this->documents,
            'docs' => $this->getDocs($this->borrower_id, $this->loan_account_id),
            'payment_status' => $this->payment_status,
            'loan_status' => $this->loan_status,
            'payments' => $this->payments,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'cash_voucher' => $this->cashVoucher(),
            'current_amortization' => $this->getCurrentAmortization(),
            'remaining_balance' => $this->remainingBalance(),
            'collection_rate' => $this->collectionRate()
        ];
    }
}
