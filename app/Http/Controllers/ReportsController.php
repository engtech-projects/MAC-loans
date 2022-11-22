<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function transactionProduct(){
		return view('reports.transaction')->with([
			'nav' => ['reports', 'transaction',''],
			'title' => 'Reports - Transaction',
		]);
	}

	public function releaseSummary(){
		return view('reports.release.summary')->with([
			'nav' => ['reports', 'release',''],
			'title' => 'Reports - Release',
		]);
	}

	public function releaseProduct(){
		return view('reports.release.product')->with([
			'nav' => ['reports', 'release',''],
			'title' => 'Reports - Release',
		]);
	}

	public function releaseClient(){
		return view('reports.release.client')->with([
			'nav' => ['reports', 'release',''],
			'title' => 'Reports - Release',
		]);
	}

	public function releaseAo(){
		return view('reports.release.ao')->with([
			'nav' => ['reports', 'release',''],
			'title' => 'Reports - Release',
		]);
	}

	public function repaymentProduct(){
		return view('reports.repayment.product')->with([
			'nav' => ['reports', 'repayment',''],
			'title' => 'Reports - Repayment',
		]);
	}

	public function repaymentClient(){
		return view('reports.repayment.client')->with([
			'nav' => ['reports', 'repayment',''],
			'title' => 'Reports - Repayment',
		]);
	}

	public function repaymentCancelled(){
		return view('reports.repayment.cancelled')->with([
			'nav' => ['reports', 'cancelled payments',''],
			'title' => 'Reports - Cancelled Payments',
		]);
	}

	public function collectionClient(){
		return view('reports.collection.client')->with([
			'nav' => ['reports', 'collection',''],
			'title' => 'Reports - Collection',
		]);
	}

	public function collectionProduct(){
		return view('reports.collection.product')->with([
			'nav' => ['reports', 'collection',''],
			'title' => 'Reports - Collection',
		]);
	}

	public function collectionAo(){
		return view('reports.collection.ao')->with([
			'nav' => ['reports', 'collection',''],
			'title' => 'Reports - Collection',
		]);
	}

	public function branchCollectionReport(){
		return view('reports.branch.collection_report')->with([
			'nav' => ['reports', 'branch','collection report'],
			'title' => 'Reports - Branch Collection Report',
		]);
	}

	public function branchMaturityReport(){
		return view('reports.branch.maturity_report')->with([
			'nav' => ['reports', 'branch','maturity report'],
			'title' => 'Reports - Branch Maturity Report',
		]);
	}
	
	public function branchPaymentStatus(){
		return view('reports.branch.client_payment_status')->with([
			'nav' => ['reports', 'branch','client payment status'],
			'title' => 'Reports - Branch Client Payment Status',
		]);
	}

	public function branchAccountOfficer(){
		return view('reports.branch.account_officer')->with([
			'nav' => ['reports', 'branch','account officer'],
			'title' => 'Reports - Branch Account Officer',
		]);
	}

	public function branchLoanListing(){
		return view('reports.branch.loan_listing')->with([
			'nav' => ['reports', 'branch','loan listing'],
			'title' => 'Reports - Branch Loan Listing',
		]);
	}
}
