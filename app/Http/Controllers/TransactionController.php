<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class TransactionController extends Controller
{
	public function releaseEntry(){
		$this->checkAccess('view release entry');
		return view('transaction.release_entry')->with([
			'nav' => ['transaction', 'release entry'],
			'title' => 'MAC | Release Entry',
		]);
	}

	public function releaseAccounts(Request $request){
		return \App\Models\LoanAccount::where('borrower_id', $request->borrower)->get();
	}

	public function overrideRelease(){
		$this->checkAccess('view override release');
		return view('transaction.override_release')->with([
			'nav' => ['transaction', 'override release'],
			'title' => 'MAC | Override Release',
		]);
	}

	public function rejectedRelease(){
		$this->checkAccess('view rejected release');
		return view('transaction.rejected_release')->with([
			'nav' => ['transaction', 'rejected release'],
			'title' => 'MAC | Rejected Release',
		]);
	}

	public function rejectedReleaseEdit($id, Request $request){
		$this->checkAccess('view rejected release');
		return view('transaction.rejected_release_edit')->with([
			'nav' => ['transaction', 'rejected release'],
			'title' => 'MAC | Rejected Release Edit',
		]);
	}

	public function repaymentEntry(){
		$this->checkAccess('view repayment entry');
		return view('transaction.repayment_entry')->with([
			'nav' => ['transaction', 'repayment entry'],
			'title' => 'MAC | Repayment Entry',
		]);
	}

	public function overridePayment(){
		$this->checkAccess('view override payment');
		return view('transaction.override_payment')->with([
			'nav' => ['transaction', 'override payment'],
			'title' => 'MAC | Override Payment',
		]);
	}

	public function overridePaymentDates(){
		return \App\models\Payment::where('status','open')->orderBy('transaction_date', 'DESC')->select('transaction_date')->get();
	}

	public function todaysRelease(){
		return \App\Models\LoanAccount::whereDate('date_release', Carbon::today())->get();
	}

	public function openPayments(Request $request){
		$payments['payments'] = \App\Models\Payment::with('loanDetails')->where('status','open')->where('branch_id', $request->branch_id)->whereDate('transaction_date', '=', date($request->transaction_date))->get();
		$payments['base'] = \App\Models\Payment::with('loanDetails')->where('status','open')->where('branch_id', $request->branch_id)->get();
		foreach ($payments['payments'] as $key => $value) {
			$payments['payments'][$key]->photo = $value->loanDetails->borrowerPhoto();
			if($value->reference_id){
				$payments['payments'][$key]['reference'] = \App\Models\LoanAccount::find($value->reference_id);
			}else{
				$payments['payments'][$key]['reference'] = null;
			}
		}
		return $payments;
	}

	public function paidTodayPayments(Request $request){
		$payments = \App\Models\Payment::with('loanDetails')->where(['status'=>'paid', 'branch_id'=>$request->branch_id])->whereDate('transaction_date', '=', date($request->transaction_date))->get();
		return $payments;
	}

	public function amortSched(Request $request){
		$amorts = $request->all();
		foreach ($request->all() as $key => $value) {
			$amortization = new \App\Models\Amortization();
			$dateRelease = $value['date_release']? $value['date_release'] : date('Y-m-d');
			$account = \App\Models\LoanAccount::find($value['loan_account_id']);
			$amorts[$key]['current_amortization'] = $amortization->createAmortizationSched($account, $dateRelease);
		}
		return $amorts;
	}

}
