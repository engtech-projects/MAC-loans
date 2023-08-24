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

class LoanAccount extends Model
{
    use HasFactory;
    protected $table = 'loan_accounts';
    protected $primaryKey = 'loan_account_id';
    protected $with = ['documents', 'borrower', 'center', 'branch', 'product', 'accountOfficer', 'payments'];

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
    const LOAN_RESTRUCTED = "Restructed";
    const LOAN_RES_WO_PDI = "Res WO/PDI";
    const AMORTIZATION_PAID = "paid";
    const AMORTIZATION_UNPAID = "unpaid";
    const AMORTIZATION_PARTIALLY_PAID = "partially_paid";
    const AMORTIZATION_DELINQUENT = "delinquent";
    const MONTHLY_PAYMENT = "Monthly";
    const BIMONTHLY_PAYMENT = "Bi-monthly";
    const WEEKLY_PAYMENT = "Weekly";
    const LUMPSUM_PAYMENT = "Lumpsum";



    public static function generateAccountNum($branchCode, $productCode, $identifier = 1)
    {
        // compute for the document transaction
        /* $num = LoanAccount::where('account_num', 'LIKE', '%' . $branchCode . '-' . $productCode . '%')->get()->pluck('account_num')->last(); */

        /* $num = LoanAccount::where('account_num', 'LIKE','%' . $branchCode . '-' . $productCode . '%')->orderBy('account_num','DESC')->limit(1)->pluck('account_num');
        $num = LoanAccount::where('account_num', 'LIKE', '%-' . $productCode . '-%')->orderBy('account_num', 'DESC')->limit(1)->pluck('account_num');
        */

        $num = LoanAccount::select('account_num')
            ->where('account_num', 'LIKE', '%-' . $productCode . '-%')
            ->orderByRaw("SUBSTRING_INDEX(SUBSTRING_INDEX(account_num, '-', -1), '-', 1) DESC")
            ->limit(1)
            ->get();
        $accountNumber = $num->pluck('account_num');
        if (count($accountNumber) > 0) {
            $series = explode('-', $accountNumber);
            $identifier = (int)$series[2] + 1;
        } else {
            $identifier = 1;
        }

        return $branchCode . '-' . $productCode . '-' . str_pad($identifier, 7, '0', STR_PAD_LEFT);
    }

    public function scopeCenter($query, $value)
    {
        return $query->where('center_id', $value);
    }

    public function scopeAccountId($query)
    {
        return $query->firstWhere('loan_account_id', $this->loan_account_id);
    }


    public static function getCycleNo($id)
    {
        $cycleNo = LoanAccount::where(['borrower_id' => $id, 'status' => 'released'])->count();

        return $cycleNo + 1;
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

    public function amortizations()
    {
        return $this->hasMany(Amortization::class, 'loan_account_id', 'loan_account_id');
    }

    // public function borrower() {
    //    return Borrower::with(['businessInfo','employmentInfo','householdMembers','outstandingObligations'])->find($this->borrower_id);
    // }

    public function borrowerPhoto()
    {

        $borrower = Borrower::find($this->borrower_id);
        return $borrower->getPhoto();
    }

    public function getBranch()
    {
        $account = LoanAccount::where('loan_account_id', '=', $this->loan_account_id)->get();
        $branch_id = Branch::where('branch_code', '=', $account->branch_code)->get();
        return $branch_id;
    }

    public function borrower()
    {
        return $this->hasOne(Borrower::class, 'borrower_id', 'borrower_id');
    }

    public function documents()
    {
        return $this->hasOne(Document::class, 'loan_account_id');
    }

    public function getDocs($borrowerId, $loanAccountId)
    {

        $main = 'borrowers/';
        $identifier = $borrowerId . '/';
        $folder = $loanAccountId . '/';

        $dir = $main . $identifier . $folder;
        $files = Storage::files('public/' . $dir);
        $docs = [];

        if (count($files) > 0) {

            foreach ($files as $file) {
                $docs[] = url(Str::replace('public', 'storage', $file));
            }

            return $docs;
        }

        return false;
    }

    public function setDocs($borrowerId, $loanAccountId, $files)
    {

        $root = storage_path('app/public/');
        $main = 'borrowers/';
        $identifier = $borrowerId . '/';
        $folder = $loanAccountId . '/';

        $dir = $main . $identifier . $folder;

        // check if folder exists
        if (!File::isDirectory($root . $dir)) {
            // create folder
            File::makeDirectory($root . $dir, 0777, true, true);
        }

        foreach ($files as $file) {
            $name = $file->getClientOriginalName();
            $file->storeAs('public/' . $dir, $name);
        }
    }

    public function cashVoucher()
    {

        $glAccounts = GeneralLedger::where(['type' => 'releasing'])->get();

        $cashVoucher = [];

        foreach ($glAccounts as $gl) {

            if ($gl->loans == 'Cash') {

                if ($this->release_type == 'Cash' || $this->release_type == 'Cash Release') {
                    $cashVoucher[] = array(
                        'acct' => $gl->code,
                        'title' => $gl->accounting,
                        'reference' => $gl->loans,
                        'sl' => '',
                        'debit' => 0,
                        'credit' => 0
                    );
                    continue;
                }
                continue;
            }

            if ($gl->loans == 'Check') {

                if ($this->release_type == 'Check' || $this->release_type == 'Check Release') {
                    $cashVoucher[] = array(
                        'acct' => $gl->code,
                        'title' => $gl->accounting,
                        'reference' => $gl->loans,
                        'sl' => '',
                        'debit' => 0,
                        'credit' => 0
                    );
                    continue;
                }
                continue;
            }

            $cashVoucher[] = array(
                'acct' => $gl->code,
                'title' => $gl->accounting,
                'reference' => $gl->loans,
                'sl' => '',
                'debit' => 0,
                'credit' => 0
            );
        }

        foreach ($cashVoucher as $key => $value) {

            if ($value['reference'] == 'Loan Receivable') {
                $cashVoucher[$key]['debit'] = $this->loan_amount;
            }

            if ($value['reference'] == 'Check') {
                $cashVoucher[$key]['credit'] = $this->net_proceeds;
            }

            if ($value['reference'] == 'Cash') {
                $cashVoucher[$key]['credit'] = $this->net_proceeds;
            }

            if ($value['reference'] == 'Filing Fee') {
                $cashVoucher[$key]['credit'] = $this->filing_fee;
            }

            if ($value['reference'] == 'Documentary Stamp') {
                $cashVoucher[$key]['credit'] = $this->document_stamp;
            }

            if ($value['reference'] == 'Insurance') {
                $cashVoucher[$key]['credit'] = $this->insurance;
            }

            if ($value['reference'] == 'Notarial') {
                $cashVoucher[$key]['credit'] = $this->notarial_fee;
            }

            if ($value['reference'] == 'Prepaid') {
                $cashVoucher[$key]['credit'] = $this->prepaid_interest;
            }

            if ($value['reference'] == 'Others') {
                $cashVoucher[$key]['credit'] = $this->affidavit_fee;
            }

            if ($value['reference'] == 'Memo') {
                $cashVoucher[$key]['credit'] = $this->memo;
            }
        }

        return $cashVoucher;
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'loan_account_id')->whereIn('status', ['paid', 'cancelled']);
    }

    public function overrideReleaseAccounts($filters = array())
    {

        $branch = Branch::find($filters['branch_id']);

        $accounts = LoanAccount::where('status', '=', 'pending')->where(['branch_code' => $branch->branch_code]);

        if (isset($filters['transaction_date']) && $filters['transaction_date'] != 'all') {
            $accounts->whereDate('loan_accounts.transaction_date', '=', $filters['transaction_date']);
        }

        if (isset($filters['ao_id']) && $filters['ao_id'] != 'all') {
            $accounts->where('loan_accounts.ao_id', '=', $filters['ao_id']);
        }

        if (isset($filters['center_id']) && $filters['center_id'] != 'all') {
            $accounts->where('loan_accounts.center_id', '=', $filters['center_id']);
        }

        if (isset($filters['product_id']) && $filters['product_id'] != 'all') {
            $accounts->where('loan_accounts.product_id', '=', $filters['product_id']);
        }

        $accounts = $accounts->get();

        foreach ($accounts as $key => $account) {
            $accounts[$key]->borrower_photo = $account->borrowerPhoto();
        }
        return $accounts;
    }

    public function releasedAccounts($filters = array())
    {

        $branch = Branch::find($filters['branch_id']);
        $accounts = LoanAccount::where('status', '=', 'released')->where(['branch_code' => $branch->branch_code]);

        if (isset($filters['date_release']) && $filters['date_release'] != 'all') {
            $accounts->whereDate('loan_accounts.date_release', '=', $filters['date_release']);
        }

        if (isset($filters['ao_id']) && $filters['ao_id'] != 'all') {
            $accounts->where('loan_accounts.ao_id', '=', $filters['ao_id']);
        }

        if (isset($filters['center_id']) && $filters['center_id'] != 'all') {
            $accounts->where('loan_accounts.center_id', '=', $filters['center_id']);
        }

        if (isset($filters['product_id']) && $filters['product_id'] != 'all') {
            $accounts->where('loan_accounts.product_id', '=', $filters['product_id']);
        }
        return $accounts->get();
    }

    public function getAmortization()
    {
        $data = (object)[];
        $transactionDateNow = transactionDate($this->branch->branch_id);
        $data->current_amortization = $this->currentAmortization();
        $data->remainingBalance = $this->remainingBalance();


        return $data;
    }

    public function getAccount($columns, $without)
    {
        $account = self::select($columns)->without($without);
        return $account;
    }
    public function getLoanAccountById($without = [], $columns = [])
    {
        $loanAccount = self::query()
            ->select($columns)
            ->without($without);

        return $loanAccount;
    }


    public function currentAmortization()
    {
        $columns = ['loan_account_id', 'branch_code', 'product_id', 'payment_mode'];
        $without = ['documents', 'borrower', 'center', 'product', 'accountOfficer', 'payments'];
        $account = $this->getAccount($columns, $columns)
            ->accountId();
        $amortization = new Amortization();
        $currentAmortization = $amortization->setCurrentamortization($account);

        return $currentAmortization;
    }

    public function currentLoanAmortization($account)
    {
        $account = $account ?? null;
        $transactionDate = transactionDate($this->branch->branch_id);
        $accountAmort = $account->with('amortizations', function ($query) use ($transactionDate) {
            $query->whereDate('amortization_date', '<=', $transactionDate)
                ->whereIn('status', ['open', 'delinquent', 'paid'])
                ->orderBy('amortization_date', "DESC")
                ->limit(1)
                ->first();
        })->accountId();
        $currentAmortization = $accountAmort->amortizations->first();
        if ((isset($currentAmortization["status"]) && $currentAmortization["status"] == 'paid') || $currentAmortization == null) {
            $accountAmort = $account->with('amortizations', function ($query) use ($transactionDate) {
                $query->whereIn('status', ['open', 'delinquent'])->first();
            })->accountId();
            return $accountAmort->amortizations->first();
        }
        return $currentAmortization ?? null;
    }
    /* public function currentAmortization()
    {

        $transactionDate = transactionDate($this->branch->branch_id);
        $account = LoanAccount::find($this->loan_account_id);
        if ($account->product->name == 'Pension Loan') {
            $transDate = $transactionDate->endOfMonth();
            $amortization = Amortization::whereDate('amortization_date', '<=', $transDate)
                ->where('loan_account_id', $this->loanAccountId)
                ->whereIn('status', ['open', 'delinquent', 'paid'])
                ->orderBy('amortization_date', 'DESC')
                ->limit(1)
                ->first();
        } else {
            $amortization = Amortization::whereDate('amortization_date', '<=', $transactionDate)
                ->where('loan_account_id', $this->loan_account_id)
                ->whereIn('status', ['open', 'delinquent', 'paid'])
                ->orderBy('amortization_date', 'DESC')
                ->limit(1)
                ->first();
        }



        if ((isset($amortization->status) && $amortization->status == 'paid') || $amortization == null) {

            $amortization = Amortization::whereDate('amortization_date', '>', $transactionDate)
                ->where('loan_account_id', $this->loan_account_id)
                ->whereIn('status', ['open', 'delinquent'])
                ->orderBy('amortization_date', 'ASC')
                ->limit(1)
                ->first();
        }


        return $amortization;
    } */


    /* public function getAmortizationMissed()
    {
        $transactionDateNow = transactionDate($this->branch->branch_id);

        if ($this->status == LoanAccount::STATUS_PENDING) {
            return false;
        }

        $hasSchedule = Amortization::where('loan_account_id', $this->loan_account_id)->get();

        if (!count($hasSchedule)) {
            return false;
        }


        if ($this->loan_status == LoanAccount::LOAN_PAID) {
            return;
        }

        $amortization = $this->currentAmortization();

        if ($amortization) {
            $amortization->missed_amort = $this->getDelinquent($this->loan_account_id, $amortization->id, $amortization->advance_principal);
        }
        return count($amortization->missed_amort ? $amortization->missed_amort : []);
    } */

    public function getLoanDetails()
    {
        $loan_details = LoanAccount::join('account_officer', 'account_officer.ao_id', '=', 'loan_accounts.ao_id')
            ->join('borrower_info', 'borrower_info.borrower_id', '=', 'loan_accounts.borrower_id')
            ->join('product', 'product.product_id', '=', 'loan_accounts.product_id')
            ->select(
                'loan_accounts.loan_account_id',
                'loan_accounts.account_num',
                'loan_accounts.co_borrower_name',
                'loan_accounts.co_borrower_address',
                'loan_accounts.co_maker_name',
                'loan_accounts.co_maker_address',
                'borrower_info.contact_number',
                'loan_accounts.date_release',
                'loan_accounts.loan_amount',
                'loan_accounts.loan_status',
                'loan_accounts.payment_status',
                'loan_accounts.interest_rate',
                'loan_accounts.interest_amount',
                'loan_accounts.due_date',
                'loan_accounts.payment_mode',
                'loan_accounts.no_of_installment',
                'loan_accounts.terms',
                'loan_accounts.type',
                'loan_accounts.cycle_no',
                'product.product_name'


            )

            ->where('loan_account_id', '=', $this->loan_account_id)->first();
        $loan_details->current_amortization = $this->getCurrentAmortization();
        $loan_details->remaining_balance = $this->remainingBalance();
        $loan_details->amortization = $this->amortization();
        $loan_details->loan_status_view =  $this->getStatusView();
        return $loan_details;
    }

    public function getFirstAmortization()
    {
        $columns = ['loan_account_id', 'loan_amount'];
        $without = ['documents', 'borrower', 'center', 'product', 'accountOfficer', 'payments'];

        $account = $this->getAccount($columns, $without)
            ->with('amortizations', function ($query) {
                $query->select('loan_account_id', 'principal', 'interest')->orderBy('id', 'DESC')->first();
            })
            ->accountId();

        /*         $amort = Amortization::where('loan_account_id', $this->loan_account_id)
            ->select('principal', 'interest')
            ->first(); */

        return $account->amortizations[0];
    }



    /* public function getLoanCurrentAmortization()
    {
        $amortization = $this->currentAmortization();
        $transactionDate = transactionDate($this->branch->branch_id);
        $lastPaidAmort = $this->getLastPaidAmortization();

        if (count($lastPaidAmort) > 0) {
            foreach ($lastPaidAmort as $amort) {
                if ($this->payment_mode === "Monthly") {
                    $endOfMonth = $transactionDate->endOfMonth();
                    if ($endOfMonth <= $amortization->amortization_date) {
                        $amortization->principal = 0;
                        $amortization->interest = 0;
                    }
                } else {
                    if ($transactionDate->startOfDay() <= $amort->amortization_date) {
                        $amortization->principal = 0;
                        $amortization->interest = 0;
                    }
                }
            }
        }
        return $amortization;
    } */

    public function isMonthlyAmortization($amortization, $transactionDate)
    {
        if ($this->payment_mode === self::MONTHLY_PAYMENT) {
            $endOfMonth = $transactionDate->endOfMonth();
            if ($endOfMonth <= $amortization->amortization_date) {
                $amortization->principal = 0;
                $amortization->interest = 0;
            }
        }
        return $amortization;
    }
    public function checkPaymentMode($amortization, $lastPaidAmort)
    {
        $transactionDate = transactionDate($this->branch->branch_id);
        if ($lastPaidAmort) {
            if ($this->payment_mode === self::MONTHLY_PAYMENT) {
                $amortization = $this->isMonthlyAmortization($amortization, $transactionDate);
            } else if ($this->payment_mode === self::LUMPSUM_PAYMENT) {
                if ($transactionDate < $amortization->amortization_date) {
                    $amortization->principal = 0;
                    $amortization->interest = 0;
                }
            } else {
                if ($transactionDate->startOfDay() <= $lastPaidAmort->amortization_date) {
                    $amortization->principal =  0;
                    $amortization->interest = 0;
                }
            }
        }
        return $amortization;
    }
    public function isAccountHasSchedule()
    {
        $accountAmortization = LoanAccount::select('loan_account_id')
            ->has('amortizations')
            ->without(['documents', 'borrower', 'center', 'product', 'accountOfficer', 'payments', 'branch'])
            ->accountId();

        return $accountAmortization;
    }

    public function updateAccount($columns)
    {
        self::find('loan_account_id', $this->loan_account_id)->update($columns);
    }

    private function setNextAmortization($account, $amortization, $transactionDateNow)
    {

        if ($this->payment_mode === self::MONTHLY_PAYMENT) {
            $endOfMonth = $transactionDateNow->endOfMonth();
            if ($endOfMonth > $amortization->amortization_date) {
                $amortization->updateAmortization($amortization->id);
                $amortization = $this->getNextAmortization($account)->first();
            }
        } else {
            if ($amortization->amortization_date < $transactionDateNow) {
                $amortization->updateAmortization($amortization->id);
                $amortization = $this->getNextAmortization($account)->first();
            }
        }

        return $amortization;
    }

    public function getNextAmortization($account)
    {
        $account = $account->with('amortizations', function ($query) {
            $query->where('status', 'open')
                ->orderBy('id')
                ->first();
        })->accountId();
        return $account->amortizations;
    }
    private function setAmortizationStatus($payment, $amortStatus, $prevAmort, $transactionDateNow)
    {
        $status = null;
        $amortPayment = null;
        if ($prevAmort) {
            $lastAmort = $prevAmort->amortizations->first();
            $prevAmortId = null;
            $prevAmortStatus = null;
            if ($lastAmort) {
                $prevAmortId = $lastAmort->id;
                $prevAmortStatus = $lastAmort->status;
            }
            $amortPayment = $prevAmort->payments->where('amortization_id', $prevAmortId)->first();
            if ($payment && ($payment->short_principal || $payment->short_interest)) {
                $status = self::AMORTIZATION_PARTIALLY_PAID;
                if (!$amortPayment && $prevAmortStatus === self::AMORTIZATION_DELINQUENT) {
                    $status = self::AMORTIZATION_UNPAID;
                }
            } else {
                $status = self::AMORTIZATION_PAID;
            }
        } else {
            $status = self::AMORTIZATION_UNPAID;
        }


        return $status;
    }

    private function setAmortizationDetails($account, $amortization, $transactionDateNow, $prevAmort = null, $partiallyPaid = null)
    {

        $firstAmortization = (object) $this->getFirstAmortization();
        $totalAmort = $firstAmortization->principal + $firstAmortization->interest;
        $dayDiff = $amortization->amortization_date->diffInDays($transactionDateNow, false);

        if ($prevAmort) {
            $lastAmort = $prevAmort->amortizations->first();
            if ($lastAmort && $lastAmort !== self::AMORTIZATION_PAID) {
                $lastAmortSched = $lastAmort->amortization_date;
                $dayDiff =  $lastAmortSched->diffInDays($transactionDateNow, false);
            }
        }

        /* $dayDiff =  $amortization->amortization_date->diffInDays($transactionDateNow, false);
        $dayDiff = $prevAmort && $prevAmort->status === self::AMORTIZATION_DELINQUENT ? $prevAmort->amortization_date->diffInDays($transactionDateNow, false) :
            $amortization->amortization_date->diffInDays($transactionDateNow, false); */

        $amortization->day_late = $dayDiff;

        $amortization->advance_principal = $this->getAdvancePrincipal($this->loan_account_id, $amortization->id);
        $amortization->advance_interest = $this->getAdvanceInterest($this->loan_account_id, $amortization->id);
        $amortization->principal = round($amortization->principal);
        $amortization->interest = round($amortization->interest);
        /*         $amortization->schedule_principal = $amortization->principal;
        $amortization->schedule_interest = $amortization->interest; */

        $amortization->pdi = $amortization->pdi ? $amortization->pdi : 0;
        $amortization->delinquent = $this->setDelinquentAmortization($account, $amortization->advance_principal, $prevAmort);

        $penaltyMissed = $amortization->delinquent['missed'];
        if ($dayDiff > 0 && $amortization->advance_principal < $amortization->short_principal + $amortization->principal) {
            $amortization->short_principal = $amortization->delinquent['principal'];
            $amortization->short_interest = $amortization->delinquent['interest'];
            if ($transactionDateNow > $amortization->amortization_date) {
                LoanAccount::find($this->loan_account_id)->update(['payment_status' => 'Delinquent']);
            }
        } else {
            $amortization->short_principal = $amortization->delinquent['principal'] - (in_array($prevAmort ? $prevAmort->id : $amortization->id, $amortization->delinquent['ids']) ? $amortization->principal : 0);
            $amortization->short_interest = $amortization->delinquent['interest'] - (in_array($prevAmort ? $prevAmort->id : $amortization->id, $amortization->delinquent['ids']) ? $amortization->interest : 0);
        }


        $amortization->short_pdi = 0;
        $amortization->short_penalty = $amortization->delinquent['penalty'];

        if ($partiallyPaid) {
            $amortization->principal = $partiallyPaid["principal"];
            $amortization->interest = $partiallyPaid["interest"];
            $amortization->short_principal = $partiallyPaid["short_principal"];
            $amortization->short_interest = $partiallyPaid["short_interest"];
            $amortization->short_penalty = $partiallyPaid["short_penalty"];
            $amortization->over_payment = $partiallyPaid["over_payment"];
        }



        if ($dayDiff > 10 && $amortization->advance_principal < $amortization->schedule_principal) {
            $penaltyMissed = array_merge(array_unique($amortization->delinquent['missed']), $amortization->delinquent['ids']);
        }


        $amortization->penalty = $this->getPenalty($penaltyMissed, $totalAmort, $transactionDateNow);
        // $amortization->penalty = $this->getPenalty($amortization->delinquent['missed'], ($amortization->principal + $amortization->interest));
        $amortization->total = ($amortization->principal + $amortization->interest) + ($amortization->short_principal + $amortization->short_interest);
        $amortization->totalPaid = $this->getPaymentTotal($account);
        $amortization->outstandingBalance = $this->outstandingBalance($this->loan_account_id);


        return $amortization;
    }
    private function getAmortizationPartiallyPaid($payment, $amortization, $prevAmort, $transactionDateNow)
    {

        if ($payment) {
            $amortization->total = $amortization->total - ($amortization->principal + $amortization->interest);


            //chec previous amortization
            if ($prevAmort) {
                $lastAmort = $prevAmort->amortizations->first();
                //check if there is previous amortization and last amortization sched
                if ($lastAmort) {
                    $isPaidLastAmort = $lastAmort->status === self::AMORTIZATION_PAID ? true : false;
                    if ($lastAmort->amortization_date > $transactionDateNow || $amortization->amortization_date < $transactionDateNow) {
                        $amortization->principal = 0;
                        $amortization->interest = 0;
                    }
                } else {
                    $amortization->principal = 0;
                    $amortization->interest = 0;
                }
            }


            /* $amortization->short_principal = $isPaidLastAmort ? 0 : $payment->short_principal;
            $amortization->short_interest = $isPaidLastAmort ? 0 : $payment->short_interest;
            $amortization->short_penalty = $isPaidLastAmort ? 0 :  $payment->short_penalty;
            $amortization->over_payment = $isPaidLastAmort ? 0 :  $payment->over_payment; */
            $amortization->short_principal = $payment->short_principal;
            $amortization->short_interest = $payment->short_interest;
            $amortization->short_penalty = $payment->short_penalty;
            $amortization->over_payment = $payment->over_payment;
        }
        return [
            "principal" => $amortization->principal,
            "interest" => $amortization->interest,
            "short_principal" => $amortization->short_principal,
            "short_interest" =>  $amortization->short_interest,
            "short_penalty" =>  $amortization->short_penalty,
            "over_payment" => $amortization->over_payment
        ];
    }


    private function getLoanAmortization($account)
    {
        $lastPaidAmort = $this->getLastpaidAmortization();
        $transactionDateNow = transactionDate($this->branch->branch_id);
        $amortization = $this->currentLoanAmortization($account);

        if ($amortization) {

            $prevAmort = $this->getPrevAmort($account);
            $accountPayments = $this->getLastPayment($account);
            $payment = $accountPayments->last() ?? null;
            $amortizationStatus = $this->setAmortizationStatus(
                $payment,
                $amortization->status,
                $prevAmort,
                $transactionDateNow,
            );

            $this->setDelinquent($this->loan_account_id, $amortization->id, $transactionDateNow);
            if ($amortizationStatus === self::AMORTIZATION_PAID) {
                $amortization = $this->checkPaymentMode($amortization, $lastPaidAmort);
                $amortization = $this->setNextAmortization($account, $amortization, $transactionDateNow);

                $amortization->schedule_principal = $amortization->principal;
                $amortization->schedule_interest = $amortization->interest;

                $partiallyPaid = $this->getAmortizationPartiallyPaid(
                    $payment,
                    $amortization,
                    $prevAmort,
                    $transactionDateNow
                );
                $amortization = $this->setAmortizationDetails(
                    $account,
                    $amortization,
                    $transactionDateNow,
                    $prevAmort,
                    $partiallyPaid
                );
            } else if ($amortizationStatus === self::AMORTIZATION_PARTIALLY_PAID) {
                $amortization = $this->checkPaymentMode($amortization, $lastPaidAmort);
                $amortization = $this->setNextAmortization($account, $amortization, $transactionDateNow);

                $amortization->schedule_principal = $amortization->principal;
                $amortization->schedule_interest = $amortization->interest;

                $partiallyPaid = $this->getAmortizationPartiallyPaid(
                    $payment,
                    $amortization,
                    $prevAmort,
                    $transactionDateNow
                );
                $amortization = $this->setAmortizationDetails(
                    $account,
                    $amortization,
                    $transactionDateNow,
                    $prevAmort,
                    $partiallyPaid
                );
            } else {
                $amortization = $this->checkPaymentMode($amortization, $lastPaidAmort);
                $amortization = $this->setNextAmortization($account, $amortization, $transactionDateNow);

                $amortization->schedule_principal = $amortization->principal;
                $amortization->schedule_interest = $amortization->interest;

                $partiallyPaid = $this->getAmortizationPartiallyPaid(
                    $payment,
                    $amortization,
                    $prevAmort,
                    $transactionDateNow
                );
                $amortization = $this->setAmortizationDetails(
                    $account,
                    $amortization,
                    $transactionDateNow,
                    $prevAmort,
                    $transactionDateNow
                );
            }
        }

        return $amortization;
    }

    public function getCurrentAmortization()
    {

        $columns = ['loan_account_id', 'branch_code', 'product_id', 'payment_mode'];
        $without = ['documents', 'borrower', 'center', 'product', 'accountOfficer', 'payments'];
        $account = $this->getAccount($columns, $without);
        /* $account = $this->getLoanAccountById($without, $columns); */


        if ($this->status == LoanAccount::STATUS_PENDING || !$this->isAccountHasSchedule() || $this->loan_status == LoanAccount::LOAN_PAID) {
            return false;
        }
        $amortization = null;
        if ($account) {
            $amortization = $this->getLoanAmortization($account);
        }
        return $amortization ?? null;


        /* $this->setDelinquent($this->loan_account_id, $amortization->id, $transactionDateNow);

        $firstAmortization = (object) $this->getFirstAmortization(); */


        /* $isPastDue = $this->checkPastDue($this->due_date, $transactionDateNow); */

        /* if ($isPastDue && $amortization) {
            if ($this->loan_status == LoanAccount::LOAN_ONGOING) {

                $columns = [
                    'loan_status' => LoanAccount::LOAN_PASTDUE,
                    'payment_status' => LoanAccount::PAYMENT_DELINQUENT,
                ];
                $this->updateAccount($columns);

            }
            $amortization->status = 'delinquent';
            $amortization->save();

            $amortization->pdi = $this->getPDI($this->loan_amount, $this->interest_rate, $isPastDue);
        }
 */

        /* if ($amortization) {
            $amortId = $amortization->id;
            $prevAmort = null;
            if ($amortization->amortization_date < $transactionDateNow) {
                $amortization->updateAmortization($amortization->id);
                $amortization = $this->getNextAmortization($account)->first();
                $prevAmort = $this->getPrevAmort($account);
                $amortId = $prevAmort->id;
            }
            $dateSched = $amortization->amortization_date;
            if ($prevAmort) {
                if ($prevAmort->amortization_date < $transactionDateNow) {
                    $dateSched =  $prevAmort->amortization_date;
                }
            }


            $dayDiff = $dateSched->diffInDays($transactionDateNow, false);

            $amortization->principal = round($amortization->principal);
            $amortization->interest = round($amortization->interest);
            $amortization->schedule_principal = $amortization->principal;
            $amortization->schedule_interest = $amortization->interest;


            if ($this->payment_mode == 'Lumpsum' && $transactionDateNow < $dateSched) {
                $amortization->principal = 0;
                $amortization->interest = 0;
            }


            $totalAmort = $firstAmortization->principal + $firstAmortization->interest;
            $amortization->pdi = $amortization->pdi ? $amortization->pdi : 0;



            $amortization->advance_principal = $this->getAdvancePrincipal($this->loan_account_id, $amortization->id);
            $amortization->advance_interest = $this->getAdvanceInterest($this->loan_account_id, $amortization->id);

            $amortization->day_late = $dayDiff;
            $dayDiff = $dateSched->diffInDays($transactionDateNow, false);


            $amortization->delinquent = $this->setDelinquentAmortization($account, $amortization->advance_principa);
            $penaltyMissed = $amortization->delinquent['missed'];




            if ($dayDiff > 0 && $amortization->advance_principal < $amortization->short_principal + $amortization->principal) {
                $amortization->short_principal = $amortization->delinquent['principal'];
                $amortization->short_interest = $amortization->delinquent['interest'];
                if ($transactionDateNow > $amortization->amortization_date) {
                    LoanAccount::find($this->loan_account_id)->update(['payment_status' => 'Delinquent']);
                }
            } else {
                $amortization->short_principal = $amortization->delinquent['principal'] - (in_array($prevAmort ? $prevAmort->id : $amortization->id, $amortization->delinquent['ids']) ? $amortization->principal : 0);
                $amortization->short_interest = $amortization->delinquent['interest'] - (in_array($prevAmort ? $prevAmort->id : $amortization->id, $amortization->delinquent['ids']) ? $amortization->interest : 0);
            }




            $amortization->short_pdi = 0;
            $amortization->short_penalty = $amortization->delinquent['penalty'];

            $accountPayments = $this->getLastPayment($account, $amortization->id);
            $payment = $accountPayments->last();

            if ($payment && ($payment->short_principal || $payment->short_interest)) {
                $amortization->total = $amortization->total - ($amortization->principal + $amortization->interest);
                if ($prevAmort) {
                    if ($prevAmort->amortization_date > $transactionDateNow) {
                        $amortization->principal = 0;
                        $amortization->interest = 0;
                    }
                } else {
                    $amortization->principal = 0;
                    $amortization->interest = 0;
                }


                $amortization->short_principal = $payment->short_principal;
                $amortization->short_interest = $payment->short_interest;
                $amortization->short_penalty = $payment->short_penalty;
                $amortization->over_payment = $payment->over_payment;
            }
            if ($lastPaidAmort->status === 'paid') {
                $amortization->short_principal = 0;
                $amortization->short_interest = 0;
            }

            $amortization = $this->checkPaymentMode($amortization, $lastPaidAmort);


            if ($dayDiff > 10 && $amortization->advance_principal < $amortization->schedule_principal) {
                $penaltyMissed = array_merge(array_unique($amortization->delinquent['missed']), $amortization->delinquent['ids']);
            }


            $amortization->penalty = $this->getPenalty($penaltyMissed, $totalAmort, $transactionDateNow);

            $amortization->total = ($amortization->principal + $amortization->interest) + ($amortization->short_principal + $amortization->short_interest);
            $amortization->totalPaid = $this->getPaymentTotal($account);
            $amortization->outstandingBalance = $this->outstandingBalance($this->loan_account_id);
        } */

        //return $amortization ?? null;
    }

    private function setPrevAmort($prevAmort)
    {
        $amortization = null;
        $payments = null;
        if ($prevAmort) {
            if ($prevAmort->amortizations) {
                $amortization = $prevAmort->amortizations->first();
            }
            if ($prevAmort->payments) {
                $payments = $prevAmort->payments->first();
            }
        }
        return [
            "amortization" => $amortization,
            "payments" => $payments
        ];
    }
    public function getPrevAmort($account)
    {
        $account = $account->with([
            'payments',
            'amortizations' => function ($query) {
                $query->whereIn('status', ['paid', 'delinquent'])
                    ->orderBy('id', 'DESC');
            }
        ])->accountId();
        return $account;
    }
    public function getPrevAmortization($loanAccountId, $amortizationId, $status = ['open'], $refId = null, $single = false, $order = 'ASC')
    {

        $cond = '<';
        $current = Amortization::find($amortizationId);
        if ($current) {
            if ($current->status === 'delinquent') {
                $cond = '<=';
            }
        }

        $amortizations = Amortization::where('loan_account_id', $loanAccountId)
            ->whereIn('status', $status)
            ->where('id', $cond, $amortizationId);

        if ($refId) {

            $amortizations->where('id', '>=', $refId);
        }

        $amortizations->orderBy('id', $order);

        if ($single) {

            return $amortizations->first();
        }

        return $amortizations->get();
    }

    public function getDelinquent($loanAccountId, $amortizationId, $advancePrincipal = 0)
    {


        $delinquents = null;
        $lastPaidAmort = $this->getPrevAmortization($loanAccountId, $amortizationId, ['paid'], null, true, 'DESC');
        if ($lastPaidAmort) {
            $delinquents = $this->getPrevAmortization($loanAccountId, $amortizationId, ['delinquent'], $lastPaidAmort->id, false, 'DESC');
        } else {
            $delinquents = $this->getPrevAmortization($loanAccountId, $amortizationId, ['delinquent'], null, false, 'DESC');
        }


        /* if ($lastPaidAmort) {
            $delinquents = $this->getPrevAmortization($loanAccountId, $amortizationId, ['delinquent'], $lastPaidAmort->id, false, 'DESC');
        }
        $delinquents = $this->getPrevAmortization($loanAccountId, $amortizationId, ['delinquent'], null, false, 'DESC'); */


        $balance = 0;
        $ids = [];
        $missed = [];
        $totalPrincipal = 0;
        $totalInterest = 0;
        $totalPdi = 0;
        $totalPenalty = 0;

        // identify missed payments
        if ($delinquents) {
            foreach ($delinquents as $delinquent) {

                $ids[] = $delinquent->id;
                $payments = $this->getDelinquentPayment($loanAccountId, $delinquent->id);
                /* $payments = $this->getDelinquentPayment($loanAccountId, $delinquent->id); */
                $delinquent->payments = $payments;
                if (isset($delinquent->payments) && count($delinquent->payments) > 0) {
                    $isNotAdvancePayment = true;
                    foreach ($delinquent->payments as $payment) {
                        $totalPrincipal += $payment->short_principal;
                        $totalInterest += $payment->short_interest;
                        $totalPdi += $payment->short_pdi;
                        $totalPenalty += $payment->short_penalty;
                        $isNotAdvancePayment = (bool)$payment->total_payable;

                        break;
                    }
                    if (!$isNotAdvancePayment) { // if advanced payment only add principal and interest
                        $totalPrincipal += round($delinquent->principal);
                        $totalInterest += round($delinquent->interest);
                    }
                    break;
                } else {

                    $missed[] = $delinquent->id;
                }

                $totalPrincipal += round($delinquent->principal);
                $totalInterest += round($delinquent->interest);
            }
        }

        if ($advancePrincipal) {
            if (count($missed) > 0) {
                $balance = $advancePrincipal;
                // $balance = 0;
                $missedAmortizations = Amortization::whereIn('id', $missed)->orderBy('id', 'ASC')->get();
                foreach ($missedAmortizations as $key => $missedAmortization) {
                    if ($balance >=  $missedAmortization->principal) {
                        $balance -= $missedAmortization->principal;
                        $pos = array_search($missedAmortization->id, $missed);
                        unset($missed[$pos]);
                    } else {
                        LoanAccount::find($loanAccountId)->update(['payment_status' => 'Delinquent']);
                        break;
                    }
                }
            }
        } else {
            if (count($ids)) {
                LoanAccount::find($loanAccountId)->update(['payment_status' => 'Delinquent']);
            }
        }



        return [
            'ids' => $ids,
            'principal' => $totalPrincipal,
            'interest' => $totalInterest,
            'penalty' => $totalPenalty,
            'balance' => $balance,
            'pdi' => $totalPdi,
            'advance' => $advancePrincipal,
            'missed' => array_values($missed)
        ];
    }

    public function setDelinquent($loanAccountId, $amortizationId, $currentDay)
    {
        $currentDay = $currentDay;

        $amortizations = $this->getPrevAmortization($loanAccountId, $amortizationId);
        if (count($amortizations) > 0) {

            foreach ($amortizations as $amortization) {

                $schedDate = $amortization->amortization_date;

                if ($amortization->id > $amortizationId) {
                    continue;
                }

                if ($schedDate < $currentDay) {
                    $amortization->status = 'delinquent';
                    $amortization->save();
                }
            }
        }
        return $amortizations;
    }


    public function setDelinquentAmortization($account, $advancePrincipal = 0, $prevAmort)
    {
        $delinquents = $this->getDelinquentAmortization($account);
        $ids = [];
        $missed = [];
        $totalPrincipal = 0;
        $totalInterest = 0;
        $totalPdi = 0;
        $totalPenalty = 0;
        $balance = 0;



        if ($prevAmort) {
            $lastAmort = $prevAmort->amortizations->first();
            if ($lastAmort && $lastAmort->status !== self::AMORTIZATION_PAID) {
                if ($delinquents) {
                    foreach ($delinquents as $delinquent) {

                        $ids[] = $delinquent->id;

                        /* $payments = $this->getDelinquentPayment($this->loan_account_id, $delinquent->id); */
                        $payments = $this->getPaymentDelinquents($account, $delinquent->id);

                        $delinquent->payments = $payments;
                        if (isset($delinquent->payments) && count($delinquent->payments) > 0) {
                            $isNotAdvancePayment = true;
                            foreach ($delinquent->payments as $payment) {
                                $totalPrincipal += $payment->short_principal;
                                $totalInterest += $payment->short_interest;
                                $totalPdi += $payment->short_pdi;
                                $totalPenalty += $payment->short_penalty;
                                $isNotAdvancePayment = (bool)$payment->total_payable;
                                //break;
                            }
                            if (!$isNotAdvancePayment) {
                                $totalPrincipal += round($delinquent->principal);
                                $totalInterest += round($delinquent->interest);
                            }
                            //break;
                        } else {
                            $missed[] = $delinquent->id;
                        }

                        $totalPrincipal += round($delinquent->principal);
                        $totalInterest += round($delinquent->interest);
                    }
                }
            }
        }

        if ($advancePrincipal) {
            if (count($missed) > 0) {
                $balance = $advancePrincipal;
                // $balance = 0;
                $missedAmortizations = Amortization::whereIn('id', $missed)->orderBy('id', 'ASC')->get();
                foreach ($missedAmortizations as $key => $missedAmortization) {

                    if ($balance >=  $missedAmortization->principal) {
                        $balance -= $missedAmortization->principal;
                        $pos = array_search($missedAmortization->id, $missed);
                        unset($missed[$pos]);
                    } else {
                        LoanAccount::find($this->loan_account_id)->update(['payment_status' => 'Delinquent']);
                        break;
                    }
                }
            }
        } else {

            if (count($ids)) {
                LoanAccount::find($this->loan_account_id)->update(['payment_status' => 'Delinquent']);
            }
        }

        return [
            'ids' => $ids,
            'principal' => $totalPrincipal,
            'interest' => $totalInterest,
            'penalty' => $totalPenalty,
            'balance' => $balance,
            'pdi' => $totalPdi,
            'advance' => $advancePrincipal,
            'missed' => array_values($missed)
        ];
    }
    public function getDelinquentAmortization($account)
    {
        $account = $account->with('amortizations', function ($query) {
            $query->delinquent();
        })->accountId();
        return $account->amortizations;
    }

    public function getLastPaidAmortization()
    {
        $columns = ['loan_account_id', 'branch_code', 'product_id', 'payment_mode'];
        $without = ['documents', 'borrower', 'center', 'product', 'accountOfficer', 'payments'];
        $lastpaidAmort = $this->getAccount($columns, $without)
            ->with('amortizations', function ($query) {
                $query->where('status', 'paid')->orderBy('id', 'DESC')->first();
            })
            ->accountId();

        return $lastpaidAmort->amortizations->first();
    }


    /*     public function getLastPaidAmort($amortizationId = null)
    {
        $columns = ['loan_account_id', 'branch_code', 'product_id', 'payment_mode'];
        $without = ['documents', 'borrower', 'center', 'product', 'accountOfficer', 'payments'];
        $lastPaidAmort = $this->getAccount($columns, $without)
            ->with('amortizations', function ($query) use ($amortizationId) {
                $query->when($amortizationId, function ($query, $amortizationId) {
                    $query->where('id', $amortizationId)
                        ->delinquent();
                }, function ($query) {
                    $query->where('status', 'paid')->orderBy('id', 'DESC');
                });
            })
            ->accountId();
        return $lastPaidAmort->amortizations->first();
    } */


    public function getPaymentDelinquents($account, $amortizationId = null)
    {
        $account = $account->with('payments', function ($query) use ($amortizationId) {
            $query->when($amortizationId, function ($query, $amortizationId) {
                $query->select([
                    'loan_account_id',
                    'amortization_id',
                    'short_principal',
                    'short_pdi',
                    'short_penalty',
                    'total_payable'
                ])->where('amortization_id', $amortizationId);
            }, function ($query) {
                $query->select([
                    'loan_account_id',
                    'amortization_id',
                    'short_principal',
                    'short_pdi',
                    'short_penalty',
                    'total_payable'
                ]);
            })->paid();
        })->accountId();
        return $account->payments;
    }

    public function getDelinquentPayment($loan_account_id, $amortization_id = null)
    {
        if (!$amortization_id) {
            return Payment::where(['loan_account_id' => $loan_account_id, 'status' => 'paid'])
                ->select(
                    'short_principal',
                    'short_interest',
                    'short_pdi',
                    'short_penalty',
                    'total_payable'
                )->orderBy('payment_id', 'DESC')->get();
        }

        return Payment::where(['loan_account_id' => $loan_account_id, 'status' => 'paid', 'amortization_id' => $amortization_id])
            ->select(
                'short_principal',
                'short_interest',
                'short_pdi',
                'short_penalty',
                'total_payable'
            )->orderBy('payment_id', 'DESC')->get();
    }


    public function getPayment($loanAccountId, $amortizationId = null)
    {

        if (!$amortizationId) {

            return Payment::where(['loan_account_id' => $loanAccountId, 'status' => 'paid'])->get();
        }
        return Payment::where(['loan_account_id' =>  $loanAccountId, 'status' => 'paid', 'amortization_id' => $amortizationId])->get();
    }

    public function getLastPayment($account, $amortizationId = null)
    {
        $accountPayments = $account->without('amortizations')
            ->with('payments', function ($query) {
                $query->paid();
            })
            ->accountId();
        return $accountPayments->payments;
    }

    public function getPaymentTotal($account)
    {

        $account = $account->with('payments', function ($query) {
            $query->select('loan_account_id')
                ->selectRaw('SUM(amount_applied) as total_payment');
        })
            ->accountId();
        $totalPayment = $account->payments->first();
        return $totalPayment->total_payment ?? 0;
    }

    public function getPaymentTotalPrincipalInterest($loanAccountId)
    {

        $paymentTotal = 0;
        $payments = $this->getPayment($loanAccountId);

        foreach ($payments as $payment) {
            $paymentTotal += $payment->principal;
            $paymentTotal += $payment->interest;
            $paymentTotal += $payment->rebates;
        }

        return $paymentTotal;
    }

    public function checkPastDue($dueDate, $dateNow)
    {

        $currentDay = $dateNow;
        $dDate = Carbon::createFromFormat('Y-m-d', $dueDate);

        if ($dDate->lt($currentDay)) {

            return $currentDay->diffInDays($dDate);
        }

        return 0;
    }

    public function getAdvancePrincipal($loanAccountId, $amortizationId)
    {
        $principal = 0;
        $paymentInfo = Payment::where(['loan_account_id' => $loanAccountId, 'status' => 'paid'])
            ->orderBy('payment_id', 'DESC')
            ->first();
        return $paymentInfo ? $paymentInfo->advance_principal : 0;
    }

    public function getAdvanceInterest($loanAccountId, $amortizationId)
    {
        $principal = 0;
        $paymentInfo = Payment::where(['loan_account_id' => $loanAccountId, 'status' => 'paid'])
            ->orderBy('payment_id', 'DESC')
            ->first();
        return $paymentInfo ? $paymentInfo->advance_interest : 0;
    }

    public function getPDI($amount, $rate, $days)
    {

        $balance = $this->outstandingBalance($this->loan_account_id);

        $perDay = ($balance * ($rate / 100)) * 12 / 365;
        return round($perDay * $days);
    }

    public function getPenalty($missed = [], $totalAmortization, $dateNow, $percent = 2)
    {

        $penalty = 0;


        if (count($missed)) {

            $currentDay = $dateNow;
            $amortizations = Amortization::whereIn('id', $missed)->orderBy('id', 'ASC')->get();
            $counter = 0;

            foreach ($amortizations as $amortization) {

                $dateSched = $amortization->amortization_date->startOfDay();
                $dayDiff = $currentDay->diffInDays($dateSched);
                if ($dayDiff > 10) {
                    $counter++;
                }
            }

            $penalty = ($totalAmortization * ($percent / 100)) * $counter;
        }


        return $penalty;
    }

    public function daysMissed($missed = [], $dateNow = '', $firstOnly = false)
    {
        $dateNow = $dateNow ? $dateNow : Carbon::now()->format('Y-m-d');
        $missedDays = 0;

        if (count($missed)) {

            $currentDay = Carbon::createFromFormat('Y-m-d', $dateNow);
            $amortizations = Amortization::whereIn('id', $missed)->orderBy('id', 'ASC')->get();

            foreach ($amortizations as $amortization) {

                $dateSched = $amortization->amortization_date;
                $dayDiff = $currentDay->diffInDays($dateSched);

                if ($dayDiff > 10) {
                    $missedDays += $dayDiff;
                    if ($firstOnly) {
                        return $dayDiff;
                    }
                }
            }
        }

        return $missedDays;
    }

    public function outstandingBalance($loanAccountId)
    {

        $account = LoanAccount::where(['loan_account_id' => $loanAccountId])->first();
        $payment = $this->getPaymentTotalPrincipalInterest($loanAccountId);

        if ($account->type == 'Prepaid') {
            $bal = ($account->loan_amount) - $payment;
        } else {
            $bal = ($account->loan_amount + $account->interest_amount) - $payment;
        }
        return floatval(number_format($bal, 2, ".", ""));
    }

    public function amortization()
    {
        $account = LoanAccount::where(['loan_account_id' => $this->loan_account_id])->first();
        return [
            "principal" => ceil($account->loan_amount / $account->no_of_installment),
            "interest" => ceil($account->interest_amount / $account->no_of_installment),
            "total" => ceil($account->interest_amount / $account->no_of_installment) + ceil($account->loan_amount / $account->no_of_installment),
        ];
    }

    public function showLoanDetails()
    {
        $loan_account = new LoanAccount();
        $account = $loan_account->select(
            'loan_accounts.loan_account_id',
            'loan_accounts.co_borrower_name',
            'loan_accounts.co_maker_name',
            'loan_accounts.co_maker_address',
            'loan_accounts.date_release',
            'loan_accounts.interest_amount',
            'loan_accounts.type',
            'loan_accounts.loan_status',
            'loan_accounts.terms',
            'loan_accounts.interest_rate',
            'loan_accounts.payment_mode',
            'loan_accounts.day_schedule',
            'loan_accounts.due_date',
            'loan_accounts.loan_amount',
            'loan_accounts.cycle_no',
            'loan_accounts.account_num',
            'borrower_info.contact_number',
            'product.product_name',



        )
            ->join('borrower_info', 'borrower_info.borrower_id', '=', 'loan_accounts.borrower_id')
            ->join('product', 'product.product_id', '=', 'loan_accounts.product_id')
            ->where('loan_accounts.loan_account_id', '=', $this->loan_account_id)->first();
        $account->last_transction = null;

        return $account;
    }



    public function calculatePastDueInterest($amortization, $transactionDateNow, $pdi)
    {
        $isPastDue = $this->checkPastDue($this->due_date, $transactionDateNow);
        if ($isPastDue && $amortization) {
            // update loan status.
            // set current amortization status to delinquent/
            // var_dump($this->loan_account_id);
            if ($this->loan_status == LoanAccount::LOAN_ONGOING) {
                LoanAccount::where(['loan_account_id' => $this->loan_account_id])->update(['loan_status' => LoanAccount::LOAN_PASTDUE]);
                $this->payment_status = LoanAccount::PAYMENT_DELINQUENT;
                $this->loan_status = LoanAccount::LOAN_PASTDUE;
                // $this->save();
            }
            $amortization->status = 'delinquent';
            $amortization->save();

            $pdi = $this->getPDI($this->loan_amount, $this->interest_rate, $isPastDue);
        }

        return $pdi;
    }



    public function remainingBalance()
    {
        $transactionDateNow = transactionDate($this->branch->branch_id);
        $transaction_date =   $transactionDateNow->startOfDay();
        $due_date = $this->due_date != null ? Carbon::createFromFormat("Y-m-d", $this->due_date)->startOfDay() : null;
        $days_late = $due_date != null ? $due_date->diffInDays($transaction_date, false) : 0;
        $account = LoanAccount::where(['loan_account_id' => $this->loan_account_id])->first();
        $payments = Payment::where(['loan_account_id' => $this->loan_account_id, 'status' => 'paid'])->orderBy('payment_id', 'DESC')->get();

        $accountSummary = [
            'memo' => [
                'account' => '',
                'balance' => 0,
            ],
            'principal' => [
                'debit' => $account->loan_amount ?? null,
                'credit' => 0,
                'balance' => 0,
            ],
            'interest' => [
                'debit' => $account->interest_amount ?? null,
                'credit' => $account->prepaid_interest ?? null,
                'balance' => 0,
            ],
            'rebates' => [
                'debit' => 0,
                'credit' => 0,
                'balance' => 0,
            ],
            'penalty' => [
                'debit' => 0,
                'credit' => 0,
                'balance' => 0,
            ],
            'pdi' => [
                'debit' => 0,
                'credit' => 0,
                'balance' => 0,
            ]
        ];
        // SET PDI AND PENALTY IN THE ACCOUNT SUMMARY
        $currentAmortization = $account->getCurrentAmortization();
        if ($currentAmortization) {
            $accountSummary['penalty']['debit'] += $currentAmortization['penalty'];
            $accountSummary['pdi']['debit'] += $currentAmortization['pdi'];
        }




        if (count($payments)) {

            foreach ($payments as $payment) {

                $accountSummary['principal']['credit'] += $payment->principal;

                $accountSummary['interest']['credit'] += $payment->interest;

                if (!$payment->penalty_approval_no) {
                    $accountSummary['penalty']['credit'] += $payment->penalty;
                }

                if (!$payment->pdi_approval_no) {
                    $accountSummary['pdi']['credit'] += $payment->pdi;
                }

                if ($payment->rebates_approval_no) {
                    $accountSummary['rebates']['credit'] += $payment->rebates;
                }
            }
        }

        $accountSummary['penalty']['debit'] += $accountSummary['penalty']['credit'];
        $accountSummary['pdi']['debit'] += $accountSummary['pdi']['credit'];
        // calculate balance

        $accountSummary['principal']['balance'] = $accountSummary['principal']['debit'] - $accountSummary['principal']['credit'];
        $accountSummary['interest']['balance'] =  $accountSummary['interest']['debit'] - $accountSummary['interest']['credit'];
        $accountSummary['penalty']['balance'] =  $accountSummary['penalty']['debit'] - $accountSummary['penalty']['credit'];
        $accountSummary['pdi']['balance'] =  $accountSummary['pdi']['debit'] - $accountSummary['pdi']['credit'];
        $accountSummary['rebates']['balance'] =  $accountSummary['rebates']['debit'] - $accountSummary['rebates']['credit'];

        $accountSummary['memo']['account'] = $account->account_num;
        $accountSummary['memo']['balance'] = $accountSummary['principal']['balance'] + $accountSummary['interest']['balance'] + $accountSummary['rebates']['balance'];


        return $accountSummary;
    }

    public function collectionRate($reamaining_balance = null)
    {
        if ($reamaining_balance != null) {
            return floor((($reamaining_balance['principal']['credit'] + $reamaining_balance['interest']['credit'] + $reamaining_balance['rebates']['credit']) / ($reamaining_balance['principal']['debit'] + $reamaining_balance['interest']['debit'])) * 100);
        }
        //return round(( ($this->remainingBalance()['principal']['credit'] + $this->remainingBalance()['interest']['credit'] + $this->remainingBalance()['rebates']['credit']) / ($this->remainingBalance()['principal']['debit'] + $this->remainingBalance()['interest']['debit']) ) * 100);
        return floor((($this->remainingBalance()['principal']['credit'] + $this->remainingBalance()['interest']['credit'] + $this->remainingBalance()['rebates']['credit']) / ($this->remainingBalance()['principal']['debit'] + $this->remainingBalance()['interest']['debit'])) * 100);
    }

    public function getStatusView()
    {
        $lAcc = LoanAccount::find($this->loan_account_id);
        if ($lAcc->loan_status == "Ongoing") {
            return $lAcc->payment_status ? $lAcc->payment_status : "Current";
        }
        return $lAcc->loan_status;
    }

    public function amortizationStatusReport($date)
    {
        $amortizations = [];
        $accAmort = Amortization::where(["loan_account_id" => $this->loan_account_id])
            ->orderBy('amortization_date', 'DESC')
            ->get();
        $payment = null;
        $paidDate = null;
        $maxDayLate = 0;
        foreach ($accAmort as $key => $amort) {
            $curPayments = Payment::where(["amortization_id" => $amort->id, "status" => "paid"])
                ->latest("payment_id")
                ->first();
            if ($curPayments) {
                $payment = $curPayments;
                // Need to process payments for partial payments
                $paidDate = Carbon::createFromFormat("Y-m-d", $payment->transaction_date)->startOfDay();
            }
            $amortDate = $amort->amortization_date->startOfDay();
            $asOfDate = $date->startOfDay();
            $dayLate = $amortDate->diffInDays($asOfDate, false); // Days Late as of now
            /* STATUSES
            Paid
            Paid Late
            Overdue
            Shorts
            Approaching
            */
            $amort_status = "";
            if ($payment) {
                // Possible dates if there is payment: Paid, Paid Late, Short
                $dayLate = $amortDate->diffInDays($paidDate, false); // Days Late as of now
                if (($payment->short_penalty + $payment->short_pdi + $payment->short_principal + $payment->short_interest) > 0) {
                    $amort_status = "Short";
                } else if ($dayLate > 0) {
                    $amort_status = "Paid Late";
                } else {
                    $amort_status = "Paid";
                }
            } else {
                // Here need to check if Overdue or Approching
                $amort_status = $dayLate > 0 ? "Overdue" : "Approaching";
            }

            $dayLate = $dayLate < 0 ? 0 : $dayLate; // Zero out if negative
            $tempAmort = [
                "amort_no" => ($this->no_of_installment - $key),
                "amort_amt" => $amort->total,
                "amort_due_date" => $amort->amortization_date,
                "amort_paid_date" => $payment ? $payment->transaction_date : "",
                "amor_status" => $amort_status,
                "days_late" => $dayLate
            ];
            $amortizations[] = $tempAmort;
        }
        return collect($amortizations)->sortBy("amort_no")->values()->all();
    }

    public function updateLoanAccount($accountNum)
    {
        $loanAccount = LoanAccount::find($this->loan_account_id);
        $loanAccount->update([
            'account_num'   =>  $accountNum
        ]);
        $loanAccount->save();
        if ($loanAccount) {
            Document::where('loan_account_id', $this->loan_account_id)->update([
                'promissory_number'   =>      $accountNum
            ]);
        }
    }

    public static function getPaymentStatus($id)
    {

        $loan_account = LoanAccount::find($id);
        return $loan_account->payment_status;
    }

    /** SCOPE PAYMENTS THAT STATUS IS OPEN */
    public function pendingPayments()
    {
        return $this->hasMany(Payment::class, 'loan_account_id')
            ->where('status', Payment::STATUS_OPEN);
    }

    /* GET LOAN ACCOUNT WITH PAYMENTS STATUS IS OPEN */
    public function getLoanAccount($id)
    {
        $account = LoanAccount::where('loan_account_id', $id)
            ->without(['payments', 'documents', 'borrower', 'branch', 'product', 'accountOfficer'])
            ->with(['pendingPayments' => function ($query) use ($id) {
                $query->where('status', Payment::STATUS_OPEN)
                    ->where('loan_account_id', $id)->first();
            }])->find($id);
        return $account;
    }

    public static function getLoanStatus($id)
    {

        $loan_account = LoanAccount::find($id);
        return $loan_account->loan_status;
    }

    public static function getRetagList($branch)
    {
        $accounts = LoanAccount::where('branch_code', '=', $branch->branch_code)
            ->where('loan_status', '!=', LoanAccount::LOAN_PAID)
            ->without('documents')
            ->without('payments')
            ->get();
        return $accounts;
    }
}
