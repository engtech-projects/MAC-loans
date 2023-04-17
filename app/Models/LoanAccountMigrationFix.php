<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use PhpParser\Node\Expr\Cast\Object_;

class LoanAccountMigrationFix extends Model
{
    use HasFactory;
    protected $table = 'loan_accounts';
    protected $primaryKey = 'loan_account_id';
    // protected $with = ['documents', 'borrower', 'center', 'branch', 'product', 'accountOfficer', 'payments'];

    protected $fillable = [
        'account_num',
        'date_release',
        'cycle_no',
        'ao_id',
        'product_id',
        'center_id',
        'type',
        'payment_mode',
        'terms',
        'loan_amount',
        'interest_rate',
        'interest_amount',
        'no_of_installment',
        'due_date',
        'day_schedule',
        'borrower_num',
        'borrower_id',
        'co_borrower_name',
        'co_borrower_address',
        'co_borrower_id_type',
        'co_borrower_id_number',
        'co_borrower_id_date_issued',
        'co_maker_name',
        'co_maker_address',
        'co_maker_id_type',
        'co_maker_id_number',
        'co_maker_id_date_issued',
        'document_stamp',
        'filing_fee',
        'insurance',
        'notarial_fee',
        'prepaid_interest',
        'affidavit_fee',
        'memo',
        'total_deduction',
        'net_proceeds',
        'release_type',
        'status',
        'branch_code',
        'transaction_date',
        'payment_status',
        'loan_status',
    ];

    const STATUS_RELEASED = "released";
    const STATUS_PENDING = "pending";
    const PAYMENT_PAID = "Paid";
    const PAYMENT_CURRENT = "Current";
    const PAYMENT_DELINQUENT = "Delinquent";
    const LOAN_ONGOING = "Ongoing";
    const LOAN_PAID = "Paid";
    const LOAN_PASTDUE = "Past Due";
    const LOAN_WRITEOFF = "Write-Off";

    public function amortizations(){
        return $this->hasMany(Amortization::class, 'loan_account_id', 'loan_account_id');
    }

    public function center()
    {
        return $this->hasOne(Center::class, 'center_id', 'center_id');
        // return Center::find($this->center_id);
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'product_id', 'product_id');
        // return Product::find($this->product_id);
    }

    public function branch()
    {
        return $this->hasOne(Branch::class, 'branch_code', 'branch_code');
    }

    public function accountOfficer()
    {
        return $this->hasOne(AccountOfficer::class, 'ao_id', 'ao_id');
    }

    public function borrower()
    {
        return $this->hasOne(Borrower::class, 'borrower_id', 'borrower_id');
    }

    public function documents()
    {
        return $this->hasOne(Document::class, 'loan_account_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'loan_account_id')->where('status', 'paid');
    }

    public function lastPayment()
    {
        return $this->hasOne(Payment::class, 'loan_account_id')->where('status', 'paid')->orderBy('transaction_date', 'desc');
    }

}
