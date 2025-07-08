<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\LoanAccount as LoanAccountResource;
use App\Models\Branch;
use App\Models\LoanAccount;
use Illuminate\Http\Request;

class AccountRetaggingController extends BaseController {

	public function retagList($branchId) {
        $branch = Branch::find($branchId);
        $accounts = LoanAccount::getRetagList($branch);
        return $this->sendResponse($accounts, "Account fetched");

    }


}
