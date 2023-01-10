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

				break;
            case 'insurance':
                $filters = [
                    'date_from' => $request->input('date_from'),
                    'date_to' => $request->input('date_to'),
                    'branch_id' => $request->input('branch_id'),
                ];
                break;
            case 'dst':
                $filters = [
                    'date_from' => $request->input('date_from'),
                    'date_to' => $request->input('date_to'),
                ];
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
					'account_officer' => $request->input('account_officer'),
					'center' => $request->input('center'),
					'branch_id' => $request->input('branch_id'),
				];

				$branchReport = $report->branchCollectionReport($filters);
				// return $this->sendResponse('Invalid Parameters', 'Could not load data');
				break;
			case 'maturity':

				$filters = [
					'due_from' => $request->input('date_from'),
					'due_to' => $request->input('date_to'),
					'account_officer' => $request->input('account_officer'),
					'center' => $request->input('center'),
					'branch_id' => $request->input('branch_id')
				];
				if($request->input('due_from')){
					$filters["due_from"] = $request->input('due_from');
				}
				if($request->input('due_to')){
					$filters["due_to"] = $request->input('due_to');
				}
				if($filters['center'] == "all"){
					unset($filters['center']);
				}
				if($filters['account_officer'] == "all"){
					unset($filters['account_officer']);
				}

				$branchReport = $report->branchMaturityReport($filters);

				break;
			case 'client_payment_status':
				# code...
				break;
			case 'account_officer':
				$filters = [
					'branch_id' => $request->input("branch_id"),
					'group' => $request->input("group"),
					'account_officer' => $request->input('account_officer'),
				];
				if($filters['account_officer'] == "all"){
					unset($filters['account_officer']);
				}
				$branchReport = $report->branchAOReport($filters);
				break;
			case 'loan_listing':
				$filters = [
					'branch_id' => $request->input("branch_id"),
					'account_officer' => $request->input('account_officer'),
					'product' => $request->input('account_officer'),
					'center' => $request->input('account_officer'),
				];
				if($filters['account_officer'] == "all"){
					unset($filters['account_officer']);
				}
				if($filters['center'] == "all"){
					unset($filters['center']);
				}
				if($filters['product'] == "all"){
					unset($filters['product']);
				}
				$branchReport = $report->branchLoanListingReport($filters);
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

		return $this->sendResponse($branchReport,"Branch Report");
	}

	public function microReports(Request $request){
		/*
		{
			date : "2022-11",
			branch_id : 1
		}
		*/
		$type = $request->input("type");
		$filters = [
			'date' => $request->input('date'),
			'branch_id' => $request->input('branch_id'),
		];

        $weeksOfMonth = [];
        $day = Carbon::createFromFormat('Y-m-d', ($filters['date']."-1") );
        $monthNow = $day->month;
        $monthStart = $day->format("Y-m-d");
        $weekOfMonth = 1;
        while($monthNow == $day->month){
            if($day->dayOfWeek == Carbon::SUNDAY && $day->day != 1){
                $weekOfMonth += 1;
                if(!isset($weeksAndDays[$weekOfMonth]['start'])){
                    $weeksAndDays[$weekOfMonth]["start"] = $day->format("Y-m-d");
                }
                if(!isset($weeksAndDays[$weekOfMonth]['end'])){
                    $weeksAndDays[$weekOfMonth]["end"] = $day->format("Y-m-d");
                }else{
                    $weeksAndDays[$weekOfMonth]["end"] = $day->format("Y-m-d");
                }
            }
            if(!isset($weeksAndDays[$weekOfMonth]['start'])){
                $weeksAndDays[$weekOfMonth] = ["start" => $day->format("Y-m-d")];
            }
            if(!isset($weeksAndDays[$weekOfMonth]['end'])){
                $weeksAndDays[$weekOfMonth]["end"] = $day->format("Y-m-d");
            }else{
                $weeksAndDays[$weekOfMonth]["end"] = $day->format("Y-m-d");
            }
            $monthEnd = $day->format("Y-m-d");
            $day = $day->addDays(1);
        }
        $weeksOfMonth = $weeksAndDays;
        $weeksOfMonth["start"] = $monthStart;
        $weeksOfMonth["end"] = $monthEnd;

		$report = new Reports();

		$group = $report->microGroup($filters, $weeksAndDays, $monthStart, $monthEnd);
		$individual = $report->microIndividual($filters, $weeksAndDays, $monthStart, $monthEnd);
		$data = [
			"schedule" => $weeksOfMonth,
			"group" => $group,
			"individual" => $individual
		];
		return $this->sendResponse($data, '');

	}

	public function consolidatedReports(Request $request) {

		$type = $request->input('type');
		$filters = [];
		$report = new Reports();

		$branchReport = NULL;
		switch ($type) {

			case 'maturity':

				$filters = [
					'due_from' => $request->input('date_from'),
					'due_to' => $request->input('date_to'),
					'account_officer' => $request->input('account_officer'),
					'center' => $request->input('center')
				];
				if($request->input('due_from')){
					$filters["due_from"] = $request->input('due_from');
				}
				if($request->input('due_to')){
					$filters["due_to"] = $request->input('due_to');
				}
				if($filters['center'] == "all"){
					unset($filters['center']);
				}
				if($filters['account_officer'] == "all"){
					unset($filters['account_officer']);
				}

				$branchReport = $report->branchMaturityReport($filters);

				break;
			case 'client_payment_status':
				# code...
				break;
			case 'account_officer':
				$filters = [
					'group' => $request->input("group"),
					'account_officer' => $request->input('account_officer'),
				];
				if($filters['account_officer'] == "all"){
					unset($filters['account_officer']);
				}
				$branchReport = $report->branchAOReport($filters);
				break;
			case 'loan_listing':
				$filters = [
					'account_officer' => $request->input('account_officer'),
					'product' => $request->input('account_officer'),
					'center' => $request->input('account_officer'),
				];
				if($filters['account_officer'] == "all"){
					unset($filters['account_officer']);
				}
				if($filters['center'] == "all"){
					unset($filters['center']);
				}
				if($filters['product'] == "all"){
					unset($filters['product']);
				}
				$branchReport = $report->branchLoanListingReport($filters);
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

		return $this->sendResponse($branchReport,"Branch Report");
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
