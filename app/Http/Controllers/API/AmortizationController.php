<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Amortization;
use App\Models\LoanAccount;
use Illuminate\Http\Request;

class AmortizationController extends BaseController
{

    public function getAmortizations(LoanAccount $account) {
        $amortizations = Amortization::where(['loan_account_id' => $account->loan_account_id])->get();
        return $this->sendResponse($amortizations,'Loan Account amortizations fetched.');
    }

    public function update(Request $request, Amortization $amortization) {
        $validated = $request->validate([
            'status' => 'required',
            'total' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'interest' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'principal_balance' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'interest_balance' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'amortization_date' => 'required',
            'principal' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/'
        ]);

        $amortization->fill($validated);
        $amortization->save();
        return $this->sendResponse($amortization,'Amortization updated');


    }
}
