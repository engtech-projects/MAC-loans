<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class JournalEntryRequest extends FormRequest
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
            'book_id' => 'required',
            'branch_id' => 'required',
            'amount' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation Errors',
            'data' => $validator->errors()
        ]));
    }

    public function messages()
    {
        return [
            'book_id.required' => "Journal Book is required.",
            'branch_id.required' => "Branch is required.",
            'amount.required' => "Amount is required.",
            'amount.regex' => "Invalid amount format, must be decimal or number."
        ];
    }
}
