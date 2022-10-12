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
		$account = new LoanAccount();
		$payment = new Payment();
		# get transaction date
		$dateEnd = $endTransaction->getTransactionDate($branchId)->date_end;

		$accounts = $account->overrideReleaseAccounts([ 'branch_id' => $branchId, 'created_at' => $dateEnd ]);
		$payments = $payment->overridePaymentAccounts([ 'branch_id' => $branchId, 'created_at' => $dateEnd ]);


		$accountsToOverrideCount = count($accounts);
		$paymentToOverrideCount = count($payments);
		
		$msg = null;
		$msg .= "{$accountsToOverrideCount} pending Loan Account/s";
		$msg .= " & ";
		$msg .= "{$paymentToOverrideCount} pending Repayment/s";

		return $this->sendResponse(($accountsToOverrideCount + $paymentToOverrideCount), 
			"You have {$msg} to Override"
		);

		// $dateEnd = '2022-10-03';
		// return $dateEnd;
		// // // dd($branchId);
		// $endTransaction->releasing($dateEnd, $branchId);
		// $endTransaction->repayment($dateEnd, $branchId);
		
		// return $this->sendResponse('End of day Transaction', 'The End');
	}

}
