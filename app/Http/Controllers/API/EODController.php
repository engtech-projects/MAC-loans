<?php

namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\GeneralLedger;
use App\Models\loanAccount;
use App\Models\Payment;
use App\Models\JournalEntry;
use App\Models\JournalEntryDetails;
use App\Models\EndTransaction;
use App\Http\Resources\GL as GLResource;



class EODController extends BaseController
{
    

	public function endOfTransaction($branchId) {


		$endTransaction = new EndTransaction();

		$dateEnd = $endTransaction->getTransactionDate($branchId);

		$endTransaction->releasing($dateEnd, $branchId);
		$endTransaction->repayment($dateEnd, $branchId);
		
		return $this->sendResponse('End of day Transaction', 'The End');

	}

}