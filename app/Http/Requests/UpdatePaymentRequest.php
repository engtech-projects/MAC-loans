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
            'principal'     =>      'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'interest'      =>      'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'pdi'           =>      'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'penalty'       =>      'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'rebates'       =>      'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'total_payable' =>      'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
        ];
    }
}
