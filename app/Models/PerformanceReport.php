<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EndTransaction;
use Illuminate\Http\Request;
use App\Models\Reports;


class PerformanceReport extends Model
{
    use HasFactory;

    protected $table = 'performance_reports';
    protected $primaryKey = 'report_id';
    protected $fillable = [
        'branch_id',
        'account_officer',
        'transaction_date'
    ];

    public function getTransactionDate($branc_id)
    {
        $transDate = new EndTransaction();
        $currentTransDate = $transDate->getTransactionDate($branc_id)->date_end;
        return $currentTransDate;
    }
    public function storeAOPerformanceReport($accOfficer = [])
    {
        $ao = self::create([
            'branch_id' => $accOfficer['branch_id'],
            'account_officer' => $accOfficer['account_officer'],
            'transaction_date' => $accOfficer['transaction_date']
        ]);
        return $ao;
    }

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

        foreach ($accountOfficers as $accountOfficer) {
            $aoPerformanceReport = $this->storeAOPerformanceReport([
                'branch_id' => $request->input('branch_id'),
                'transaction_date' => $transactionDate,
                'account_officer' => $accountOfficer->name
            ]);
            if (isset($accountOfficer->products)) {
                foreach ($accountOfficer->products as $product) {
                    $performanceReportDetails->storeAOPerformanceReportDetail($product, $aoPerformanceReport->report_id);
                }
            }
        }

        return response()->json(['data' => $accountOfficers]);
    }
}
