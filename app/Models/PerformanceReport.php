<?php

namespace App\Models;

use App\Http\Resources\PerformaceReport;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EndTransaction;
use Illuminate\Http\Request;
use App\Models\Reports;
use Carbon\Carbon;

class PerformanceReport extends Model
{
    use HasFactory;

    protected $table = 'performance_reports';
    protected $primaryKey = 'report_id';
    protected $fillable = [
        'branch_id',
        'ao_id',
        'transaction_date',
    ];

    public function scopeTransactionDate($query, $value)
    {
        return $query->whereDate('transaction_date', '=', $value);
    }

    public function scopeBranch($query, $value)
    {
        return $query->where('branch_id', '=', $value);
    }
    public function accountOfficer()
    {
        return $this->belongsTo(AccountOfficer::class, 'ao_id', 'ao_id');
    }
    public function performanceDetails()
    {
        return $this->hasMany(PerformanceReportDetail::class, 'report_id', 'report_id');
    }
    public function products()
    {
        return $this->hasMany(PerformanceReportDetail::class, 'report_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    //GET LIST OF DATES AVAILABLE IN AO PERFORMANCE REPORTS

    public function getDateReports($branchId)
    {
        $transDate = $this->getTransactionDate($branchId);
        $maxDate = self::branch($branchId)->orderBy("transaction_date", "DESC")->pluck("transaction_date")->first();
        $minDate = self::branch($branchId)->pluck("transaction_date")->first();
        $dateRange = [
            'min_date' => $minDate,
            'max_date' => $transDate
        ];
        if (count($dateRange) > 0) {
            return $dateRange;
        }
        return "No dates found";
    }
    //GET PERFORMANCE REPORT FROM PERFORMANCE REPORT MODEL
    public function getAOPerformanceReport($request)
    {
        $performanceReport = self::with(['products', 'accountOfficer' => function ($query) {
            $query->select([
                'ao_id',
                'name'
            ])
                ->without(['branch_registered', 'branch']);
        }, 'products.product' => function ($query) {
            $query->select(['product_id', 'product_name', 'product_code']);
        }])
            ->transactionDate($request->input("transaction_date"))
            ->branch($request->input("branch_id"))
            ->get();
        $aoReports = [];
        if (count($performanceReport) > 0) {
            foreach ($performanceReport as $aoKey => $accOfficer) {
                $aoReports[] = [
                    'ao_id' => $accOfficer->accountOfficer->ao_id,
                    'name' => $accOfficer->accountOfficer->name,
                ];
                foreach ($accOfficer["products"] as $prodKey => $product) {
                    $aoReports[$aoKey]["products"][] = [
                        "product_id" => $product["product_id"],
                        "product_code" => $product->product["product_code"],
                        "product_name" => $product->product["product_name"],
                        "all" => [
                            "count" => $product["portfolio_accounts"],
                            "amount" => $product["portfolio"],
                        ],
                        "delinquent" => [
                            "count" => $product["delinquent_accounts"],
                            "amount" => $product["delinquent"],
                            "rate" => $product["delinquent_rate"]
                        ],
                        "pastdue" => [
                            "count" => $product["pastdue_accounts"],
                            "amount" => $product["pastdue"],
                            "rate" => $product["pastdue_rate"]
                        ]
                    ];
                }
            }
            return $aoReports;
        }
        return "No reports found.";
    }

    //GET TRANSACTION DATE FROM ENDTRANSACTION MODEL
    public function getTransactionDate($branc_id)
    {
        $transDate = new EndTransaction();
        $currentTransDate = $transDate->getTransactionDate($branc_id)->date_end;
        return $currentTransDate;
    }

    //STORE AO PERFORMANCEREPORT TO PERFORMANCE REPORT TABLE
    public function storeAOPerformanceReport($accOfficer = [])
    {
        $ao = self::create([
            'branch_id' => $accOfficer['branch_id'],
            'ao_id' => $accOfficer['ao_id'],
            'transaction_date' => $accOfficer['transaction_date']
        ]);
        return $ao;
    }

    //GET AO PERFORMANCE REPORT FROM REPORTS MODEL
    public function getPerformanceReport(Request $request)
    {
        $report = new Reports();
        $performanceReportDetails = new PerformanceReportDetail();
        $transactionDate = $this->getTransactionDate($request->input('branch_id'));
        $filters = [
            'branch_id' => $request->input('branch_id'),
            'group' => "performance_report",
            'account_officer' => "all",
        ];
        $accountOfficers = $report->branchAOReport($filters);
        foreach ($accountOfficers as $aoKey => $accountOfficer) {
            $aoPerformanceReport = $this->storeAOPerformanceReport([
                'branch_id' => $request->input('branch_id'),
                'transaction_date' => $transactionDate,
                'ao_id' => $accountOfficer["ao_id"]
            ]);
            if (isset($accountOfficer["products"])) {
                foreach ($accountOfficer["products"] as $product) {
                    $performanceReportDetails->storeAOPerformanceReportDetail($product, $aoPerformanceReport->report_id);
                }
            }
        }

        return $accountOfficers;
    }


    public function getPerformancePortfolio($date)
    {
        $date = $date ? Carbon::createFromFormat('Y-m-d', $date) : null;
        $months = getMonths();
        $branchePerformanceReport = Branch::query()
            ->select('branch_id', 'branch_name')
            ->with([
                'performanceReports' => function ($query) use ($date) {
                    $query->selectRaw('YEAR(transaction_date) as year, MONTH(transaction_date) as month,report_id,branch_id')
                        ->groupBy('year', 'month', 'branch_id', 'report_id')
                        ->when($date, function ($query,$date) {
                            $query->whereMonth('transaction_date', $date->month)
                                ->whereYear('transaction_date', $date->year);
                        })
                        ->orderBy('year','DESC')
                        ->orderBy('month','DESC');
                },
                'performanceReports.performanceDetails' => function ($query) {
                    $query->selectRaw('SUM(portfolio_accounts) as no_of_accounts,
                    SUM(portfolio) as total_portfolio,
                    SUM(delinquent_accounts) no_of_delinquent,
                    SUM(delinquent) as total_delinquent,
                    SUM(pastdue_accounts) no_of_pastdue,
                    SUM(pastdue) as total_pastdue,
                    report_id')->groupBy('report_id');
                }
            ])->get();



        $performandaceReport = [];
        foreach ($branchePerformanceReport as $branch) {
            foreach ($branch->performanceReports as $prKey => $report) {
                $year = $report->year;
                $month = $report->month;
                $monthName = $months[$month - 1];
                foreach ($report->performanceDetails as $pdKey => $reportDetail) {

                    if (!isset($performandaceReport[$branch->branch_name][$year])) {
                        $performandaceReport[$branch->branch_name][$year] = array_fill_keys($months, [
                            'no_of_accounts' => 0,
                            'total_portfolio' => 0,
                            'no_of_delinquent' => 0,
                            'total_delinquent' => 0,
                            'no_of_pastdue' => 0,
                            'total_pastdue' => 0,
                        ]);
                    }
                    $performandaceReport[$branch->branch_name][$year][$monthName] = [
                        'no_of_accounts' => $reportDetail->no_of_accounts,
                        'total_portfolio' => $reportDetail->total_portfolio,
                        'no_of_delinquent' => $reportDetail->no_of_delinquent,
                        'total_delinquent' => $reportDetail->total_delinquent,
                        'no_of_pastdue' => $reportDetail->no_of_pastdue,
                        'total_pastdue' => $reportDetail->total_pastdue,

                    ];
                }
            }
        }

        return $performandaceReport;
    }
}
