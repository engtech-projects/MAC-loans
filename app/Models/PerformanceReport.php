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

    public function scopeBranch($query,$value)
    {
        return $query->where('branch_id','=',$value);
    }
    public function accountOfficer() {
        return $this->belongsTo(AccountOfficer::class,'ao_id','ao_id');
    }
    public function products()
    {
        return $this->hasMany(PerformanceReportDetail::class, 'report_id');
    }

    //GET LIST OF DATES AVAILABLE IN AO PERFORMANCE REPORTS

    public function getDateReports($branchId) {
        $maxDate = self::branch($branchId)->orderBy("transaction_date","DESC")->pluck("transaction_date")->first();
        $minDate = self::branch($branchId)->pluck("transaction_date")->first();
        $dateRange = [
            'min_date' => $minDate,
            'max_date' => $maxDate
        ];
        if(count($dateRange) > 0) {
            return $dateRange;
        }
        return "No dates found";
    }
    //GET PERFORMANCE REPORT FROM PERFORMANCE REPORT MODEL
    public function getAOPerformanceReport($request)
    {
        $performanceReport = self::with(['products','accountOfficer' => function($query){
            $query->select([
                'ao_id',
                'name'
            ])
            ->without(['branch_registered','branch']);
        }, 'products.product' => function ($query) {
            $query->select(['product_id', 'product_name', 'product_code']);
        }])
        ->transactionDate($request->input("transaction_date"))
        ->branch($request->input("branch_id"))
        ->get();
        $aoReports = [];
        if (count($performanceReport)>0) {
            foreach ($performanceReport as $aoKey => $accOfficer) {
                $aoReports[] = [
                    'ao_id' => $accOfficer->accountOfficer->ao_id,
                    'name' => $accOfficer->accountOfficer->name,
                ];
                foreach($accOfficer["products"] as $prodKey => $product) {
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
