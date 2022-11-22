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
			'date_from' => Carbon::createFromFormat('Y-m-d', $request->input('date_from')),
			'date_to' => Carbon::createFromFormat('Y-m-d', $request->input('date_to')),
			'branch_id' => $request->input('branch_id')
		];

		$report = new Reports();
		return $this->sendResponse($report->transactionReports($filters), '');

	}

	public function releaseReports(Request $request) {

		$filters = [ 
			'date_from' => Carbon::createFromFormat('Y-m-d', $request->input('date_from')),
			'date_to' => Carbon::createFromFormat('Y-m-d', $request->input('date_to')),
			'type' => $request->input('type'),
			'spec' => $request->input('spec'),
			'branch_id' => $request->input('branch_id')
		];

		$category = $request->input('category');
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

		switch ($type) {

			case 'collection':
				
				$filters = [
					'type' => $request->input('type'),
					'transaction_date' => $request->input('transaction_date'),
					'account_officer' => $request->input('account_officer'),
					'center' => $request->input('center'),
					'branch_id' => $request->input('branch_id'),
					'group' => $request->input('group')
				];

				$collectionReport = $report->branchCollectionReport($filters);
				return $collectionReport;
				// return $this->sendResponse('Invalid Parameters', 'Could not load data');
				break;
			case 'maturity':
				# code...
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

		return $filters;
	}

	public function microReports(Request $request){
		$type = $request->input("type");
		$filters = [
			'date' => $request->input('date'),
			'branch_id' => $request->input('branch_id'),
			'type' => $request->input('type')
		];
		$report = new Reports();

		if( $type == 'group' ){
			return $report->microGroup($filters);
		}elseif( $type == 'individual' ){
			return $report->microIndividual($filters);
		}

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
