<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountOfficer extends Model
{
    use HasFactory;

    protected $table = 'account_officer';
    protected $primaryKey = 'ao_id';
    protected $with = ['branch','branch_registered'];
    public $timestamps = false;

    protected $fillable = [
    	'name', 'status', 'deleted', 'branch_id'
    ];

    const STATUS_ACTIVE = "active";
    const STATUS_INACTIVE = "inactive";

    public function branch() {
    	return $this->hasOne(Branch::class, 'branch_id', 'branch_id');
    }

    public function accounts() {
        return $this->hasMany(LoanAccount::class,'ao_id')
        ->without(['documents', 'branch','borrower', 'accountOfficer', 'payments'])
        ->whereIn('loan_status', [LoanAccount::LOAN_ONGOING, LoanAccount::LOAN_PASTDUE,LoanAccount::LOAN_RESTRUCTED, LoanAccount::LOAN_RES_WO_PDI]);
    }

    public function loanAccounts() {
        return $this->hasMany(LoanAccountMigrationFix::class,'ao_id','ao_id')
        ->whereIn('loan_status', [LoanAccount::LOAN_ONGOING, LoanAccount::LOAN_PASTDUE,LoanAccount::LOAN_RESTRUCTED, LoanAccount::LOAN_RES_WO_PDI]);
    }

    public function product() {

        // return $this->pivot(Product::class);
        // return $this->belongsToMany(Product::class);
        return Product::select('*')->crossjoin('product');
        // return $this->hasMany(Product::class, ' ', ' ');
    }
    public function center() {
        return $this->hasMany(Center::class,'center_id','center_id');
    }

    public function branch_registered() {
        return $this->hasManyThrough(
            Branch::class,
            AccountOfficerBranch::class, 'ao_id', 'branch_id', 'ao_id', 'branch_id'
        );
    }
}
