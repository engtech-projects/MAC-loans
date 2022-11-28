<?php

namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Reports;


class ReportsController extends BaseController
{
   
	public function transactionReports(Request $request) {

		$filters = [ 
			'date_from' => $request->input('date_from'),
			'date_to' => $request->input('date_to'),
			'branch_id' => $request->input('branch_id')
		];


		$report = new Reports();
		return $this->sendResponse($report->transactionReports($filters), '');

	}

	public function releaseReports(Request $request) {

		$category = $request->input('category');
		$filters = [];
		$report = new Reports();

		switch ($category) {
			case 'product':
				
				// {
				//     "date_from" : "2022-09-26",
				//     "date_to" : "2022-10-27",
				//     "branch_id" : 1,
				//     "category" : "product"
				// }

				$filters = [
					'date_from' => $request->input('date_from'),
					'date_to' => $request->input('date_to'),
					'branch_id' => $request->input('branch_id')

				];

				break;
			case 'account_officer':

				// {
				//     "date_from" : "2022-11-21",
				//     "date_to" : "2022-11-21",
				//     "branch_id" : 1,
				//     "account_officer" : 1,
				//     "category" : "account_officer"
				// }
				
				$filters = [
					'date_from' => $request->input('date_from'),
					'date_to' => $request->input('date_to'),
					'branch_id' => $request->input('branch_id'),
					'account_officer' => $request->input('account_officer')
				];


				break;
			case 'client':

				// {
				//     "date_from" : "2022-11-21",
				//     "date_to" : "2022-11-21",
				//     "branch_id" : 1,
				//     "type" : all, new, center, product, account_officer
				//     "spec" : product_id, center_id, account_officer_id
				//     "category" : "client"
				// }

				$filters = [
					'date_from' => $request->input('date_from'),
					'date_to' => $request->input('date_to'),
					'branch_id' => $request->input('branch_id'),
					'type' => $request->input('type'),
					'spec' => $request->input('spec'),
				];

				# code...
				break;
		}

		$report = new Reports();

		return $this->sendResponse($report->releaseReports($filters, $category), '');
	}

	public function repaymentReports(Request $request) {

		$type = $request->input('type');

		$filters = [
			'date_from' => Carbon::createFromFormat('Y-m-d', $request->input('date_from')),
			'date_to' => Carbon::createFromFormat('Y-m-d', $request->input('date_to')),
			'branch_id' => $request->input('branch_id'),
			'type' => $request->input('type')
		];
		
		$report = new Reports();

		if( $type == 'client' ){
			return $report->repaymentByClient($filters);
		}elseif( $type == 'product' ){
			return $report->repaymentByProduct($filters);
		}elseif( $type == 'cancelled' ){
			return $report->cancelledRepaymentByClient($filters);
		}
	}

	public function collectionReports() {}

	public function branchReports(Request $request) {

		$type = $request->input('type');
		$filters = [];
		$report = new Reports();

		$branchReport = NULL;
		switch ($type) {

			case 'collection':
				
				$filters = [
					'transaction_date' => $request->input('transaction_date'),
					'account_officer' => $request->input('account_officer'),
					'center' => $request->input('center'),
					'branch_id' => $request->input('branch_id'),
					'group' => $request->input('group')
				];

				$branchReport = $report->branchCollectionReport($filters);
				// return $this->sendResponse('Invalid Parameters', 'Could not load data');
				break;
			case 'maturity':
				
				$filters = [
					'date_from' => $request->input('date_from'),
					'date_to' => $request->input('date_to'),
					'account_officer' => $request->input('account_officer'),
					'center' => $request->input('center'),
					'branch_id' => $request->input('branch_id')
				];

				$branchReport = $report->branchMaturityReport($filters);

				break;
			case 'client_payment_status':
				# code...
				break;
			case 'account_officer':
				# code...
				break;
			case 'loan_listing':
				# code...
				break;
			case 'loan_aging_summary':
				# code...
				break;
			case 'revenue':
				# code...
				break;

			default:
				return $this->sendResponse('Invalid Parameters', 'Could not load data');
				break;
		}

		return $branchReport;
	}



	// public function releaseByClientReports(Request $request) {

	// 	$filters = [ 
	// 		'date_from' => Carbon::createFromFormat('Y-m-d', $request->input('date_from')),
	// 		'date_to' => Carbon::createFromFormat('Y-m-d', $request->input('date_to')),
	// 		'type' => $request->input('type'),

	// 	];
	// }

	// public function repaymentReports(Request $request) {

	// 	$filters = [ 
	// 		'date_from' => Carbon::createFromFormat('Y-m-d', $request->input('date_from')),
	// 		'date_to' => Carbon::createFromFormat('Y-m-d', $request->input('date_to')),
	// 		'type' => '',
	// 		'spec' => ''
	// 	];


	// 	$report = new Reports();

	// 	return $this->sendResponse($report->transactionReports($filters), '');

	// }

}
