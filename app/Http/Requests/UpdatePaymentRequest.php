<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'short_principal'           =>      'regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'advance_principal'         =>      'regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'advance_interest'          =>      'regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'rebates_approval_no'       =>      'numeric',
            'penalty_approval_no'       =>      'numeric',
            'pdi_approval_no'           =>      'numeric',
            'short_inerest'             =>      'regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'principal'                 =>      'regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'interest'                  =>      'regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'pdi'                       =>      'regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'penalty'                   =>      'regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'rebates'                   =>      'regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'amount_applied'            =>      'regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
        ];
    }
}
