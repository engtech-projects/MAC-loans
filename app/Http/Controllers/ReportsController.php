<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function transactionProduct(){
		$this->checkAccess('view transaction report');
		return view('reports.transaction')->with([
			'nav' => ['reports', 'transaction',''],
			'title' => 'Reports - Transaction',
		]);
	}

	public function releaseSummary(){
		$this->checkAccess('view release report');
		return view('reports.release.summary')->with([
			'nav' => ['reports', 'release',''],
			'title' => 'Reports - Release',
		]);
	}

	public function releaseProduct(){
		$this->checkAccess('view releases reports by product');
		return view('reports.release.product')->with([
			'nav' => ['reports', 'release','by product'],
			'title' => 'Reports - Release',
		]);
	}

	public function releaseClient(){
		$this->checkAccess('view releases reports by client');
		return view('reports.release.client')->with([
			'nav' => ['reports', 'release','by client'],
			'title' => 'Reports - Release',
		]);
	}

	public function releaseAo(){
		$this->checkAccess('view releases reports by AO');
		return view('reports.release.ao')->with([
			'nav' => ['reports', 'release','by account officer'],
			'title' => 'Reports - Release',
		]);
	}

	public function releaseInsurance(){
		$this->checkAccess('view BIR report');
		return view('reports.release.insurance')->with([
			'nav' => ['reports', 'insurance',''],
			'title' => 'Reports - Release',
		]);
	}

	public function repaymentProduct(){
		$this->checkAccess('view repayment reports by product');
		return view('reports.repayment.product')->with([
			'nav' => ['reports', 'repayment','by product'],
			'title' => 'Reports - Repayment',
		]);
	}

	public function repaymentClient(){
		$this->checkAccess('view repayment reports by client');
		return view('reports.repayment.client')->with([
			'nav' => ['reports', 'repayment','by client'],
			'title' => 'Reports - Repayment',
		]);
	}

	public function repaymentCancelled(){
		$this->checkAccess('view cancelled payments report');
		return view('reports.repayment.cancelled')->with([
			'nav' => ['reports', 'cancelled payments',''],
			'title' => 'Reports - Cancelled Payments',
		]);
	}

	public function collectionClient(){
		$this->checkAccess('view collection reports by client');
		return view('reports.collection.client')->with([
			'nav' => ['reports', 'collection','group by client status'],
			'title' => 'Reports - Collection',
		]);
	}

	public function collectionProduct(){
		$this->checkAccess('view collection reports by product');
		return view('reports.collection.product')->with([
			'nav' => ['reports', 'collection','group by product status'],
			'title' => 'Reports - Collection',
		]);
	}

	public function collectionAo(){
		$this->checkAccess('view collection reports by AO');
		return view('reports.collection.ao')->with([
			'nav' => ['reports', 'collection','group by account officer'],
			'title' => 'Reports - Collection',
		]);
	}

	public function branchCollectionReport(){
		$this->checkAccess('view collection branch reports');
		return view('reports.branch.collection_report')->with([
			'nav' => ['reports', 'branch','collection report'],
			'title' => 'Reports - Branch Collection Report',
		]);
	}

	public function branchMaturityReport(){
		$this->checkAccess('view maturity branch reports');
		return view('reports.branch.maturity_report')->with([
			'nav' => ['reports', 'branch','maturity report'],
			'title' => 'Reports - Branch Maturity Report',
		]);
	}
	
	public function branchPaymentStatus(){
		$this->checkAccess('view client payment status branch reports');
		return view('reports.branch.client_payment_status')->with([
			'nav' => ['reports', 'branch','client payment status'],
			'title' => 'Reports - Branch Client Payment Status',
		]);
	}

	public function branchAccountOfficer(){
		$this->checkAccess('view AO branch reports');
		return view('reports.branch.account_officer')->with([
			'nav' => ['reports', 'branch','account officer'],
			'title' => 'Reports - Branch Account Officer',
		]);
	}

	public function branchLoanListing(){
		$this->checkAccess('view loan listing branch reports');
		return view('reports.branch.loan_listing')->with([
			'nav' => ['reports', 'branch','loan listing'],
			'title' => 'Reports - Branch Loan Listing',
		]);
	}

	public function branchLoanStatusSummary(){
		$this->checkAccess('view loan status summary branch reports');
		return view('reports.branch.loan_status_summary')->with([
			'nav' => ['reports', 'branch','loan status summary'],
			'title' => 'Reports - Branch Loan Status Summary',
		]);
	}

	public function branchLoanAgingSummary(){
		$this->checkAccess('view loan aging summary branch reports');
		return view('reports.branch.loan_aging_summary')->with([
			'nav' => ['reports', 'branch','loan aging summary'],
			'title' => 'Reports - Branch Loan aging Summary',
		]);
	}

	public function branchRevenueReport(){
		$this->checkAccess('view revenue branch reports');
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

	public function consolidatedRevenueReport(){
		return view('reports.consolidated.revenue_report')->with([
			'nav' => ['reports', 'consolidated','revenue report'],
			'title' => 'Reports - Consolidated Revenue Report',
		]);
	}

	public function consolidatedGenerateDst(){
		return view('reports.consolidated.generate_dst')->with([
			'nav' => ['reports', 'consolidated','generate dst'],
			'title' => 'Reports - Consolidated Generate DST',
		]);
	}

	public function consolidatedAccountOfficer(){
		return view('reports.consolidated.account_officer')->with([
			'nav' => ['reports', 'consolidated','account officer'],
			'title' => 'Reports - Consolidated Account Officer',
		]);
	}
	
	public function reportsMicroMonitoring(){
		$this->checkAccess('view micro monitoring report');
		return view('reports.micro_monitoring')->with([
			'nav' => ['reports', 'micro monitoring',''],
			'title' => 'Reports - Micro Monitoring',
		]);
	}

	public function reportsPrepaidInterest(){
		$this->checkAccess('view prepaid interest report');
		return view('reports.prepaid_interest')->with([
			'nav' => ['reports', 'prepaid interest',''],
			'title' => 'Reports - Prepaid Interest',
		]);
	}

	public function reportsPerformanceReport(){
		$this->checkAccess('view performance report');
		return view('reports.performance_report')->with([
			'nav' => ['reports', 'performance report',''],
			'title' => 'Reports - Performance Report',
		]);
	}

	public function birReport(){
		$this->checkAccess('view BIR report');
		return view('reports.bir')->with([
			'nav' => ['reports', 'bir',''],
			'title' => 'Reports - Bir',
		]);
	}

	public function amortSched($id){
		return \App\Models\Amortization::where('loan_account_id',$id)->orderBy('amortization_date', 'ASC')->get();
	}
}
