<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class TransactionController extends Controller
{
	public function releaseEntry(){
		return view('transaction.release_entry')->with([
			'nav' => ['transaction', 'release entry'],
			'title' => 'Release Entry',
		]);
	}

	public function releaseAccounts(Request $request){
		return \App\Models\LoanAccount::where('borrower_id', $request->borrower)->get();
	}

	public function overrideRelease(){
		return view('transaction.override_release')->with([
			'nav' => ['transaction', 'override release'],
			'title' => 'Override Release',
		]);
	}
	
	public function rejectedRelease(){
		return view('transaction.rejected_release')->with([
			'nav' => ['transaction', 'rejected release'],
			'title' => 'Rejected Release',
		]);
	}

	public function rejectedReleaseEdit($id, Request $request){
		return view('transaction.rejected_release_edit')->with([
			'nav' => ['transaction', 'rejected release'],
			'title' => 'Rejected Release Edit',
		]);
	}

	public function repaymentEntry(){
		return view('transaction.repayment_entry')->with([
			'nav' => ['transaction', 'repayment entry'],
			'title' => 'Repayment Entry',
		]);
	}

	public function overridePayment(){
		return view('transaction.override_payment')->with([
			'nav' => ['transaction', 'override payment'],
			'title' => 'Override Payment',
		]);
	}

	public function overridePaymentDates(){
		return \App\models\Payment::where('status','open')->orderBy('created_at', 'DESC')->select('created_at')->get();
	}

	public function todaysRelease(){
		return \App\Models\LoanAccount::whereDate('date_release', Carbon::today())->get();
	}
}
