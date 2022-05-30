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
		];

		$category = $request->input('category');
		$report = new Reports();

		return $this->sendResponse($report->releaseReports($filters, $category), '');
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
