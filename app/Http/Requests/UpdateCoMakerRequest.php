<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCoMakerRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'co_maker_name' => 'required|max:255',
            'co_maker_address' => 'required|max:255',
            'co_maker_id_type' => 'required|max:255',
            'co_maker_id_number' => 'required|max:100',
            'co_maker_id_date_issued' => 'nullable|date'

        ];
    }
}
