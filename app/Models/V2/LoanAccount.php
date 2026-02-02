<?php

namespace App\Models\V2;

use App\Models\AccountOfficer;
use App\Models\V2\Amortization;
use App\Models\Borrower;
use App\Models\Branch;
use App\Models\Center;
use App\Models\Document;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class LoanAccount extends Model
{
    use HasFactory;
    protected $table = 'loan_accounts';
    protected $primaryKey = 'loan_account_id';

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

    protected $attributes = [
        'payment_status' => 'Current',
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
    const LOAN_RESTRUCTED = "Restructed";
    const LOAN_RES_WO_PDI = "Res WO/PDI";
    const AMORTIZATION_PAID = "paid";
    const AMORTIZATION_UNPAID = "unpaid";
    const AMORTIZATION_PARTIALLY_PAID = "partially_paid";
    const AMORTIZATION_DELINQUENT = "delinquent";
    const MONTHLY_PAYMENT = "Monthly";
    const BIMONTHLY_PAYMENT = "Bi-Monthly";
    const WEEKLY_PAYMENT = "Weekly";
    const LUMPSUM_PAYMENT = "Lumpsum";
    const STATUS_RELEASE = "released";
    /*    
    ** RELATIONSHIPS
    */
    public function center()
    {
        return $this->hasOne(Center::class, 'center_id', 'center_id');
    }
    public function product()
    {
        return $this->hasOne(Product::class, 'product_id', 'product_id');
    }
    public function branch()
    {
        return $this->hasOne(Branch::class, 'branch_code', 'branch_code');
    }
    public function accountOfficer()
    {
        return $this->hasOne(AccountOfficer::class, 'ao_id', 'ao_id');
    }
    public function amortizations()
    {
        return $this->hasMany(Amortization::class, 'loan_account_id', 'loan_account_id');
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
        return $this->hasMany(Payment::class, 'loan_account_id')->whereIn('status', ['paid', 'cancelled']);
    }
    public function paidPayments()
    {
        return $this->hasMany(Payment::class, 'loan_account_id')->where('status', 'paid');
    }
    public function paidPaymentsAsOf($date)
    {
        return $this->hasMany(Payment::class, 'loan_account_id')->where('status', 'paid')->whereDate("transaction_date", "<=", $date);
    }
    public function rmemo()
    {
        return $this->hasOne(Payment::class, 'reference_id')->whereIn('status', ['rejected']);
    }
    /*    
    ** SCOPES
    */
    public function scopeCenter($query, $value)
    {
        return $query->where('center_id', $value);
    }
    public function scopeAccountId($query)
    {
        return $query->firstWhere('loan_account_id', $this->loan_account_id);
    }
    public function scopeInProgress($query)
    {
        // return $query->where('loan_status', '!=', self::LOAN_PAID);
        return $query->whereIn('loan_status', [LoanAccount::LOAN_ONGOING, LoanAccount::LOAN_PASTDUE, LoanAccount::LOAN_RESTRUCTED, LoanAccount::LOAN_RES_WO_PDI]);
    }
    public function scopeDelinquent($query)
    {
        return $query->where('payment_status', self::PAYMENT_DELINQUENT);
    }
    public function scopePastdue($query)
    {
        return $query->where('loan_status', self::LOAN_PASTDUE);
    }
    public function scopeReleased($query)
    {
        return $query->where('status', self::STATUS_RELEASED);
    }
    public function scopeReleasedBefore($query, $date)
    {
        return $query->whereDate('date_release', '<=', $date);
    }
    public function scopeInBranchId($query, $branchId)
    {
        return $query->where('branch_id', $branchId);
    }
    public function scopeInBranchCode($query, $branchCode)
    {
        return $query->where('branch_code', $branchCode);
    }
    public function scopeByAccountOfficerId($query, $aoId)
    {
        return $query->where('ao_id', $aoId);
    }
    /*    
    ** ATTRIBUTES
    */
    public function getCurrentTotalPrincipalPaymentsAttribute()
    {
        return $this->paidPayments()->sum("principal");
    }

    public function getCurrentPrincipalBalanceAttribute()
    {
        return $this->loan_amount - $this->current_total_principal_payments;
    }

    public function getCurrentTotalInterestPaymentsAttribute()
    {
        return $this->paidPayments()->sum("interest");
    }
    public function getCurrentInterestBalanceAttribute()
    {
        return $this->interest_amount - $this->current_total_interest_payments;
    }
    
}
