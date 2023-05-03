<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Amortization;
use App\Models\Branch;
use App\Models\LoanAccount;
use Illuminate\Http\Request;

class AmortizationController extends BaseController
{

    public function getAmortizations(LoanAccount $account) {
        $amortizations = Amortization::where(['loan_account_id' => $account->loan_account_id])->get();
        return $this->sendResponse($amortizations,'Loan Account amortizations fetched.');
    }

    public function getCurrentAmortization(Request $request) {
        $branch = Branch::find($request->branch_id);
        $accounts = LoanAccount::where([
            'status'        =>  'released',
            'branch_code'   =>  $branch->branch_code
        ])
        ->whereIn('loan_status',[LoanAccount::LOAN_ONGOING,LoanAccount::LOAN_PASTDUE])
        ->without([
            'documents',
            'borrower',
            'center',
            'accountOfficer',
            'payments'
        ])
        ->get();

        foreach($accounts as $account) {
            $account->getCurrentAmortization();
        }

        return $this->sendResponse($accounts,'Accounts successfully validated.');
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
