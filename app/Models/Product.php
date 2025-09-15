<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';
    protected $primaryKey = 'product_id';
    const STATUS_ACTIVE = "active";
    const STATUS_INACTIVE = "inactive";

    protected $attributes = [
        'interest_rate' 
    ];

    protected $fillable = [
    	'product_code', 'product_name', 'interest_rate', 'status', 'deleted'
    ];

    public function loanAccounts() {
        return $this->hasMany(LoanAccountMigrationFix::class,'loan_account_id','loan_account_id');
    }

}
