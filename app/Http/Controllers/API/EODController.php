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

	public function endOfTransaction(Request $request) {

		$branchId = $request->input('branch_id');
		$status = $request->input('status');

		$endTransaction = new EndTransaction();
		$eod = $endTransaction->getTransactionDate($branchId);


		if( $eod->status == 'open' ) {

			$hasRelease = $endTransaction->releasing($eod->date_end, $branchId, $status);
			$hasRepayment = $endTransaction->repayment($eod->date_end, $branchId, $status);

			if( !$hasRelease && !$hasRepayment ){
				return $this->sendResponse(
					'false',
					'No Transaction'
				);
			}

			# eod
			// return $dateEnd;
			$message = ($endTransaction->close($branchId)) ? 'successful' : 'unsuccessful';

			return $this->sendResponse(
				'End of day Transaction',
				$message
			);

		}else{

			return $this->sendResponse(
				'closed',
				'End of Day Transaction is closed'
			);

		}
	}

	public function checkPendingTransctions(Request $request) {

		$branchId = $request->input('branch_id');

		$endTransaction = new EndTransaction();
		$account = new LoanAccount();
		$payment = new Payment();
		# get transaction date
		$dateEnd = $endTransaction->getTransactionDate($branchId)->date_end;

		$accounts = $account->overrideReleaseAccounts([ 'branch_id' => $branchId, 'transaction_date' => $dateEnd ]);
		$payments = $payment->overridePaymentAccounts([ 'branch_id' => $branchId, 'transaction_date' => $dateEnd ]);


		$accountsToOverrideCount = count($accounts);
		$paymentToOverrideCount = count($payments);

		$msg = null;
		$msg .= "{$accountsToOverrideCount} pending Loan Account/s";
		$msg .= " & ";
		$msg .= "{$paymentToOverrideCount} pending Repayment/s";

		return $this->sendResponse(
			($accountsToOverrideCount + $paymentToOverrideCount),
			"You have {$msg} to Override"
		);

	}

	public function createTransactionDate(Request $request) {

		$transactionDate = $request->transaction_date;
		$branchId = $request->branch_id;

		$endTransaction = new EndTransaction();
		if( $endTransaction->validate($transactionDate, $branchId) ){
			return $this->sendError(
				"Error!",
				"Current Transaction date is still active. Cannot create Transaction date",
				400
			);
		}else if($endTransaction->existOld($transactionDate, $branchId) ){
			return $this->sendError(
				"Error!",
				"Date supplied is a previous date. Cannot create Transaction date before ".$endTransaction->getTransactionDate($branchId)->date_end,
				400
			);
		}else{
			$data = EndTransaction::create([
				'branch_id' => $branchId,
				'date_end' => $transactionDate,
				'status' => 'open'
			]);
			return $this->sendResponse($data, "Transaction date has been created");
		}

	}

	public function getTransactionDate($branchId) {

		$endTransaction = new EndTransaction();
		$dateEnd = $endTransaction->getTransactionDate($branchId);

		return $this->sendResponse($dateEnd,
			"Transaction Date"
		);

	}


}
