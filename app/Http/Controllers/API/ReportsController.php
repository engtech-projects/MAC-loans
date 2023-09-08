<?php

namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\EndTransaction;
use App\Models\JournalEntry;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Reports;
use XBase\Enum\FieldType;
use XBase\Enum\TableType;
use XBase\Header\Column;
use XBase\Header\HeaderFactory;
use XBase\TableCreator;
use XBase\TableEditor;


class ReportsController extends BaseController
{

    public function transactionReports(Request $request)
    {

        $filters = [
            'date_from' => $request->input('date_from'),
            'date_to' => $request->input('date_to'),
            'branch_id' => $request->input('branch_id'),
            'report' => 'release'
        ];


        $report = new Reports();
        return $this->sendResponse($report->transactionReports($filters), '');
    }

    public function releaseReports(Request $request)
    {

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
                    'branch_id' => $request->input('branch_id'),
                    'report' => 'release'

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
                    'account_officer' => $request->input('account_officer'),
                    'report' => 'release'
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
                    'report' => 'release'
                ];

                break;
            case 'insurance':
                $filters = [
                    'date_from' => $request->input('date_from'),
                    'date_to' => $request->input('date_to'),
                    'branch_id' => $request->input('branch_id'),
                    'report' => 'release'
                ];
                break;
            case 'dst':
                $filters = [
                    'date_from' => $request->input('date_from'),
                    'date_to' => $request->input('date_to'),
                    'report' => 'release'
                ];
                break;
        }

        $report = new Reports();

        return $this->sendResponse($report->releaseReports($filters, $category), '');
    }

    public function repaymentReports(Request $request)
    {

        $category = $request->input('category');

        $filters = [
            'date_from' => Carbon::createFromFormat('Y-m-d', $request->input('date_from')),
            'date_to' => Carbon::createFromFormat('Y-m-d', $request->input('date_to')),
            'branch_id' => $request->input('branch_id'),
            'category' => $request->input('category'),
            'type' => $request->input('type'),
            'spec' => $request->input('spec'),
        ];

        $report = new Reports();

        if ($category == 'client') {
            return $report->repaymentByClient($filters);
        } elseif ($category == 'product') {
            return $report->repaymentByProduct($filters);
        } elseif ($category == 'cancelled') {
            return $report->cancelledRepaymentByClient($filters);
        }
    }

    public function collectionReports()
    {
    }

    public function branchReports(Request $request)
    {

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
                if ($request->input('due_from')) {
                    $filters["due_from"] = $request->input('due_from');
                }
                if ($request->input('due_to')) {
                    $filters["due_to"] = $request->input('due_to');
                }
                if ($filters['center'] == "all") {
                    unset($filters['center']);
                }
                if ($filters['account_officer'] == "all") {
                    unset($filters['account_officer']);
                }

                $branchReport = $report->branchMaturityReport($filters);

                break;
            case 'client_payment_status':
                # code...
                $filters = [
                    "borrower_id" => $request->input("borrower_id"),
                    "as_of" => $request->input("as_of")
                ];
                $branchReport = $report->clientPaymentStatus($filters);
                break;
            case 'account_officer':
                $filters = [
                    'branch_id' => $request->input("branch_id"),
                    'group' => $request->input("group"),
                    'account_officer' => $request->input('account_officer'),
                ];
                if ($filters['account_officer'] == "all") {
                    unset($filters['account_officer']);
                }
                $branchReport = $report->branchAOReport($filters);
                break;
            case 'loan_listing':
                $filters = [
                    'branch_id' => $request->input("branch_id"),
                    'account_officer' => $request->input('account_officer'),
                    'product' => $request->input('product'),
                    'center' => $request->input('center'),
                    'loan_status' => $request->input("loan_status"),
                    'report' => $request->input("report"),
                    'payment_status' => $request->input("payment_status")
                ];
                if ($filters['account_officer'] == "all") {
                    unset($filters['account_officer']);
                }
                if ($filters['center'] == "all") {
                    unset($filters['center']);
                }
                if ($filters['product'] == "all") {
                    unset($filters['product']);
                }
                $branchReport = $report->branchLoanListingReport($filters);
                break;
            case 'loan_aging_summary':
                $filters = [
                    'branch_id' => $request->input('branch_id'),
                    'account_officer' => $request->input('account_officer'),
                    'product' => $request->input('product'),
                    'as_of' => $request->input('as_of'),
                ];
                if ($filters['account_officer'] == "all") {
                    unset($filters['account_officer']);
                }
                if ($filters['product'] == "all") {
                    unset($filters['product']);
                }
                $branchReport = $report->loanAgingReport($filters);
                break;
            case 'revenue':
                $filters = [
                    'branch_id' => $request->input("branch_id"),
                    'date_from' => $request->input('date_from'),
                    'date_to' => $request->input('date_to'),
                ];
                $branchReport = $report->aoRevenueReport($filters);
                break;
            default:
                return $this->sendResponse('Invalid Parameters', 'Could not load data');
                break;
        }

        return $this->sendResponse($branchReport, "Branch Report");
    }

    public function microReports(Request $request)
    {
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
        $day = Carbon::createFromFormat('Y-m-d', ($filters['date'] . "-1"));
        $monthNow = $day->month;
        $monthStart = $day->format("Y-m-d");
        $weekOfMonth = 1;
        while ($monthNow == $day->month) {
            if ($day->dayOfWeek == Carbon::SUNDAY && $day->day != 1) {
                $weekOfMonth += 1;
                if (!isset($weeksAndDays[$weekOfMonth]['start'])) {
                    $weeksAndDays[$weekOfMonth]["start"] = $day->format("Y-m-d");
                }
                if (!isset($weeksAndDays[$weekOfMonth]['end'])) {
                    $weeksAndDays[$weekOfMonth]["end"] = $day->format("Y-m-d");
                } else {
                    $weeksAndDays[$weekOfMonth]["end"] = $day->format("Y-m-d");
                }
            }
            if (!isset($weeksAndDays[$weekOfMonth]['start'])) {
                $weeksAndDays[$weekOfMonth] = ["start" => $day->format("Y-m-d")];
            }
            if (!isset($weeksAndDays[$weekOfMonth]['end'])) {
                $weeksAndDays[$weekOfMonth]["end"] = $day->format("Y-m-d");
            } else {
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

    public function performanceReport(Request $request)
    {
        $date = null;
        if (isset($request["date"])) {
            $date = Carbon::createFromFormat('Y-m-d', $request["date"])->format('Y-m-d');
        }
        $reports = new Reports();
        $performanceReport = $reports->performanceReport($date);
        return $this->sendResponse($performanceReport, "Performance Report");
    }

    public function consolidatedReports(Request $request)
    {
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
                if ($request->input('due_from')) {
                    $filters["due_from"] = $request->input('due_from');
                }
                if ($request->input('due_to')) {
                    $filters["due_to"] = $request->input('due_to');
                }
                if ($filters['center'] == "all") {
                    unset($filters['center']);
                }
                if ($filters['account_officer'] == "all") {
                    unset($filters['account_officer']);
                }

                $branchReport = $report->branchMaturityReport($filters);

                break;
            case 'client_payment_status':
                # code...
                //  no consolidated client payment status
                break;
            case 'account_officer':
                $filters = [
                    'group' => $request->input("group"),
                    'account_officer' => $request->input('account_officer'),
                ];
                if ($filters['account_officer'] == "all") {
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
                if ($filters['account_officer'] == "all") {
                    unset($filters['account_officer']);
                }
                if ($filters['center'] == "all") {
                    unset($filters['center']);
                }
                if ($filters['product'] == "all") {
                    unset($filters['product']);
                }
                $branchReport = $report->branchLoanListingReport($filters);
                break;
            case 'loan_aging_summary':
                $filters = [
                    'account_officer' => $request->input('account_officer'),
                    'product' => $request->input('product'),
                    'as_of' => $request->input('as_of'),
                ];
                if ($filters['account_officer'] == "all") {
                    unset($filters['account_officer']);
                }
                if ($filters['product'] == "all") {
                    unset($filters['product']);
                }
                $branchReport = $report->loanAgingReport($filters);
                break;
            case 'revenue':
                $filters = [
                    'date_from' => $request->input('date_from'),
                    'date_to' => $request->input('date_to'),
                ];
                $branchReport = $report->aoRevenueReport($filters);
                break;

            default:
                return $this->sendResponse('Invalid Parameters', 'Could not load data');
                break;
        }

        return $this->sendResponse($branchReport, "Consolidated Report");
    }

    public function birTaxReport(Request $request)
    {
        //TEST USING hisamu/php-xbase
        // you can specify any other database version from TableType
        $header = HeaderFactory::create(TableType::DBASE_III_PLUS_NOMEMO);
        $filename = 'BIR_' . Carbon::now()->timestamp . '.dbf';
        $filepath = 'bir_reports/' . $filename;
        // $filepath = "BIR.dbf";

        $tableCreator = new TableCreator($filepath, $header);
        $tableCreator->addColumn(new Column([
            'name'   => 'TAX_MONTH',
            'type'   => FieldType::CHAR,
            'length' => 20,
        ]))
            ->addColumn(new Column([
                'name'   => 'SEQ_NO',
                'type'   => FieldType::CHAR,
                'length' => 20,
            ]))
            ->addColumn(new Column([
                'name'   => 'LAST_NAME',
                'type'   => FieldType::CHAR,
                'length' => 20,
            ]))
            ->addColumn(new Column([
                'name'   => 'FIRST_NAME',
                'type'   => FieldType::CHAR,
                'length' => 20,
            ]))
            ->addColumn(new Column([
                'name'   => 'MIDDLE_NAM',
                'type'   => FieldType::CHAR,
                'length' => 20,
            ]))
            ->addColumn(new Column([
                'name'   => 'ADDRESS',
                'type'   => FieldType::CHAR,
                'length' => 20,
            ]))
            ->addColumn(new Column([
                'name'   => 'ADDRESS2',
                'type'   => FieldType::CHAR,
                'length' => 20,
            ]))
            ->addColumn(new Column([
                'name'   => 'GSALES',
                'type'   => FieldType::CHAR,
                'length' => 20,
            ]))
            ->addColumn(new Column([
                'name'   => 'GESALES',
                'type'   => FieldType::CHAR,
                'length' => 20,
            ]))
            ->addColumn(new Column([
                'name'   => 'TOUTTAX',
                'type'   => FieldType::CHAR,
                'length' => 20,
            ]))
            ->addColumn(new Column([
                'name'   => 'TAX_RATE',
                'type'   => FieldType::CHAR,
                'length' => 20,
            ]))
            ->addColumn(new Column([
                'name'   => 'GTSALES',
                'type'   => FieldType::CHAR,
                'length' => 20,
            ]))
            ->save(); //creates file

        $table = new TableEditor($filepath);
        $report = new Reports();
        $taxEntries = $report->birTaxReport($request);
        $totalGtSales = 0;
        $totalGSales = 0;
        $totalTouttax = 0;
        foreach ($taxEntries as $seqNo => $taxEntry) {
            $totalGSales += $taxEntry['GSALES'];
            $totalTouttax += $taxEntry['TOUTTAX'];
            $totalGtSales += $taxEntry['GTSALES'];
            $record = $table->appendRecord();
            $record->set('TAX_MONTH', Carbon::createFromDate($request->input("date_to"))->format('Y/m/d'));
            $record->set('SEQ_NO', $seqNo);
            foreach ($taxEntry as $title => $value) {
                $record->set($title, $value);
            }
            $table->writeRecord();
        }
        $record = $table->appendRecord();
        $record->set('TAX_MONTH', "TOTAL ");
        $record->set('SEQ_NO', null);
        $record->set('GSALES', $totalGSales);
        $record->set('TOUTTAX', $totalTouttax);
        $record->set('GTSALES', $totalGtSales);
        $table->writeRecord();
        $table->save()->close();
        return $this->sendResponse(["entries" => $taxEntries, "downloadURL" => url('/' . $filepath)], "BIR Tax Report");
    }

    public function prepaidReport(Request $request)
    {
        $dueDate = new Carbon($request->input('due_from'));
        $filters = [
            'due_from' => $dueDate->firstOfMonth(),
            'type' => "prepaid",
            'branch_id' => $request->input("branch") ? $request->input("branch") : $request->input("branch_id")
        ];
        $report = new Reports();
        $prepaid = $report->prepaidReport($filters);
        return $this->sendResponse($prepaid, "Consolidated Report");
    }

    public function saveJournalEntry(Request $request)
    {
        $eod = new EndTransaction();
        $journalEntry = new JournalEntry();
        $journals = $journalEntry->getJounalBookById();
        return $journals;
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
