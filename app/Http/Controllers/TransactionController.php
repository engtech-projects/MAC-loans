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
	public function overrideRelease(){
		return view('transaction.override_release')->with([
			'nav' => ['transaction', 'override release'],
			'title' => 'Override Release',
		]);
	}
<<<<<<< HEAD
	
=======

>>>>>>> 2df7fb2b0253fad08a2686dc0a3f581ad39fc121
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
<<<<<<< HEAD

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
=======
>>>>>>> 2df7fb2b0253fad08a2686dc0a3f581ad39fc121
}
