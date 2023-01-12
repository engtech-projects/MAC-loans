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

	public function releaseInsurance(){
		return view('reports.release.insurance')->with([
			'nav' => ['reports', 'insurance',''],
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

	public function branchLoanStatusSummary(){
		return view('reports.branch.loan_status_summary')->with([
			'nav' => ['reports', 'branch','loan status summary'],
			'title' => 'Reports - Branch Loan Status Summary',
		]);
	}

	public function branchLoanAgingSummary(){
		return view('reports.branch.loan_aging_summary')->with([
			'nav' => ['reports', 'branch','loan aging summary'],
			'title' => 'Reports - Branch Loan aging Summary',
		]);
	}

	public function branchRevenueReport(){
		return view('reports.branch.revenue_report')->with([
			'nav' => ['reports', 'branch','revenue report'],
			'title' => 'Reports - Branch Revenue Report',
		]);
	}

	public function consolidatedLoanSummaryReport(){
		return view('reports.consolidated.loan_summary_report')->with([
			'nav' => ['reports', 'consolidated','loan summary report'],
			'title' => 'Reports - consolidated Loan Summary Report',
		]);
	}

	public function consolidatedLoanAgingReport(){
		return view('reports.consolidated.loan_aging_report')->with([
			'nav' => ['reports', 'consolidated','loan aging report'],
			'title' => 'Reports - consolidated Loan Aging Report',
		]);
	}

	public function consolidatedLoanPerformanceReport(){
		return view('reports.consolidated.loan_performance_report')->with([
			'nav' => ['reports', 'consolidated','loan performance report'],
			'title' => 'Reports - consolidated Loan Performance Report',
		]);
	}
	
	public function reportsMicroMonitoring(){
		return view('reports.micro_monitoring')->with([
			'nav' => ['reports', 'micro monitoring',''],
			'title' => 'Reports - Micro Monitoring',
		]);
	}

	public function reportsPrepaidInterest(){
		return view('reports.prepaid_interest')->with([
			'nav' => ['reports', 'prepaid interest',''],
			'title' => 'Reports - Prepaid Interest',
		]);
	}

	public function reportsPerformanceReport(){
		return view('reports.performance_report')->with([
			'nav' => ['reports', 'performance report',''],
			'title' => 'Reports - Performance Report',
		]);
	}
}
