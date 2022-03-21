<?php

namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Borrower;
use App\Models\LoanAccount;
use App\Http\Resources\Borrower as BorrowerResource;
use App\Http\Resources\LoanAccount as LoanAccountResource;

class LoanAccountController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function showLoanAccount(LoanAccount $account) {
         return $this->sendResponse(new LoanAccountResource($account), 'Account fetched.');
    }

	/**
     * Store a newly created resource in storage.
     */
    public function createLoanAccount(Request $request, Borrower $borrower) {

        $request->merge([
            'status' => 'pending', 
            'account_num' => 'br1-00-001', 
            'borrower_num' =>  $borrower->borrower_num,
            'borrower_id' =>  $borrower->borrower_id,
        ]);

        $account = LoanAccount::create($request->input());

    	return new LoanAccountResource($account);

    }

    public function updateLoanAccount(Request $request, LoanAccount $account) {

        $account->fill($request->input());
        $loanAccount->save();

        return $this->sendResponse(new LoanAccountResource($loanAccount), 'Account Updated.');
    }

}
