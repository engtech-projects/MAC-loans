<?php

namespace App\Models;

use App\Http\Resources\PerformaceReport;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceReportDetail extends Model
{
    use HasFactory;

    protected $table = 'performance_report_details';

    protected $fillable = [
        'report_id',
        'product_id',
        'portfolio_accounts',
        'portfolio',
        'delinquent_accounts',
        'delinquent',
        'delinquent_rate',
        'pastdue_accounts',
        'pastdue',
        'pastdue_rate'
    ];

    public function performanceReport() {
        return $this->belongsTo(PerformaceReport::class,'report_id');
    }
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
    public function storeAOPerformanceReportDetail($product, $reportId)
    {
            if ($product) {
                $aoDetails = self::create([
                    'report_id' => $reportId,
                    'product_id' => $product["product_id"],
                    'portfolio_accounts' => $product["all"]["count"],
                    'portfolio' => $product["all"]["amount"],
                    'delinquent_accounts' => $product["delinquent"]["count"],
                    'delinquent' => $product["delinquent"]["amount"],
                    'delinquent_rate' => $product["delinquent"]["rate"],
                    'pastdue_accounts' => $product["pastdue"]["count"],
                    'pastdue' => $product["pastdue"]["amount"],
                    'pastdue_rate' => $product["pastdue"]["rate"]
                ]);
                return $aoDetails;
            }


    }
}
