<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\LoanAccount as LoanAccountResource;
use App\Models\Branch;
use App\Models\LoanAccount;
use Illuminate\Http\Request;


class AccountRetaggingController extends BaseController
{

    protected $account;
    public function __construct(LoanAccount $account)
    {
        $this->account = $account;
    }
    public function index(Request $request)
    {
        $branchId = $request->branch_id;
        $accounts = $this->account->getRetaggingList($request->input());
        return $this->sendResponse($accounts, "Account fetched");
    }


    public function update(LoanAccount $account, $id, Request $request)
    {
        $collection = $account->accountRetaggingUpdate($id, $request->input());
        return $this->sendResponse($collection, "Account Updated");
    }
}
