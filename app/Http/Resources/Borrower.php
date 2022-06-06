<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Borrower extends JsonResource
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
			'date_registered' => $this->date_registered,
            'borrower_id' => $this->borrower_id,
            'borrower_num' => $this->borrower_num,
            'firstname' => $this->firstname,
            'middlename' => $this->middlename,
            'lastname' => $this->lastname,
            'fullname' => $this->fullname($this),
            'suffix' => $this->suffix,
            'address' => $this->address,
            'birthdate' => $this->birthdate,
            'gender' => $this->gender,
            'status' => $this->status,
            'contact_number' => $this->contact_number,
            'id_type' => $this->id_type,
            'id_no' => $this->id_no,
            'id_date_issued' => $this->id_date_issued,
            'spouse_firstname' => $this->spouse_firstname,
            'spouse_middlename' => $this->spouse_middlename,
            'spouse_lastname' => $this->spouse_lastname,
            'spouse_address' => $this->spouse_address,
            'spouse_birthdate' => $this->spouse_birthdate,
            'spouse_contact_number' => $this->spouse_contact_number,
            'spouse_id_type' => $this->spouse_id_type,
            'spouse_id_no' => $this->spouse_id_no,
            'spouse_id_date_issued' => $this->spouse_id_date_issued,
            'employmentInfo' => $this->employmentInfo,
            'householdMembers' => $this->householdMembers,
            'businessInfo' => $this->businessInfo,
            'outstandingObligations' => $this->outstandingObligations,
            'created_at' => $this->created_at->format('m/d/Y'),
            'updated_at' => $this->updated_at->format('m/d/Y'),
            'loan_accounts' => $this->getloanAccounts(isset($request->accountStatus)? $request->accountStatus:'released'),
        ];
    }
}
