<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Center extends Model
{
    use HasFactory;
    protected $table = 'center';
    protected $primaryKey = 'center_id';

    protected $fillable = [
    	'center', 'day_sched', 'status', 'deleted', 'area'

    ];

    public function remainingBalance() {
        $loanAcccounts = new LoanAccount();
        return $loanAcccounts->remainingBalance();
    }
    public function accounts() {
        return $this->hasMany(LoanAccount::class,'center_id','center_id')
        ->without(['documents','branch','borrower', 'accountOfficer', 'payments'])
        ->where('loan_status','!=',LoanAccount::LOAN_PAID);

    }
    public function product() {
        return $this->hasMany(Product::class,'product_id','product_id');
    }

    public static function fetchCenters() {
        //fetch all cenrters order by center name
        $centers = Center::orderBy('center')->get();
        return $centers;
    }
}
