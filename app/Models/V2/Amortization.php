<?php
namespace App\Models\V2;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Amortization extends Model
{
    use HasFactory;

    protected $table = 'amortization';
    protected $primaryKey = 'id';

    const AMORTIZATION_DELINQUENT = "delinquent";

    protected $fillable = [
        'loan_account_id',
        'amortization_date',
        'principal',
        'interest',
        'total',
        'principal_balance',
        'interest_balance',
        'status'
    ];

    protected $casts = [
        'total' => 'float',
        'interest' => 'float',
        'principal_balance' => 'float',
        'interest_balance' => 'float',
        'status' => 'string',
        'principal' => 'float',
        'amortization_date' => "date:Y-m-d"
    ];
    protected $appends = [
        "delinquent_date",
        "soa_status"
    ];


    public function account()
    {
        return $this->belongsTo(LoanAccount::class, 'loan_account_id', 'loan_account_id');
    }
    public function getDelinquentDateAttribute()
    {
        if ($this->account->product_id == 3) {
            return Carbon::parse($this->amortization_date)->addMonth()->startOfMonth();
        }
        return Carbon::parse($this->amortization_date)->addDay();
    }
}
