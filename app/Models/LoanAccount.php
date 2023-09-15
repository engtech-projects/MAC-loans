<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use PhpParser\Node\Expr\Cast\Object_;

use function PHPUnit\Framework\isEmpty;

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
    const BIMONTHLY_PAYMENT = "Bi-Monthly";
    const WEEKLY_PAYMENT = "Weekly";
    const LUMPSUM_PAYMENT = "Lumpsum";
    const STATUS_RELEASE = "released";



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
            $identifier = (int) $series[2] + 1;
        } else {
            $identifier = 1;
        }

        return $branchCode . '-' . $productCode . '-' . str_pad($identifier, 7, '0', STR_PAD_LEFT);
    }

    public function scopeCenter($query, $value)
    {
        return $query->where('center_id', $value);
    }

    public function scopeRelease($query)
    {
        return $query->where('status', self::STATUS_RELEASE);
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
        $data = (object) [];
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

    public function getFirstAmortization()
    {
        $columns = ['loan_account_id', 'loan_amount'];
        $without = ['documents', 'borrower', 'center', 'product', 'accountOfficer', 'payments'];

        $account = $this->getAccount($columns, $without)
            ->with('amortizations', function ($query) {
                $query->select('loan_account_id', 'principal', 'interest')->orderBy('id', 'DESC')->first();
            })
            ->accountId()
            ->first();
        return $account->amortizations[0];
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

    public function checkPaymentMode()
    {
        $isMonthlyAmortization = false;
        if ($this->payment_mode === self::MONTHLY_PAYMENT) {
            $isMonthlyAmortization = true;
        }
        return $isMonthlyAmortization;
    }



    private function getLoanAmortization()
    {
        $amortizationInstance = new Amortization();
        /*         $lastPaidAmort = $amortizationInstance->getLastPaidAmortization($this->loan_account_id); */

        $transactionDateNow = transactionDate($this->branch->branch_id);
        $this->setDelinquent($this->loan_account_id, $transactionDateNow, $this->payment_mode);
        $amortization = $amortizationInstance->currentAmortization($this->loan_account_id, $this->payment_mode, $transactionDateNow, $this->loan_status);
        $isPastDue = $this->checkPastDue($this->due_date, $transactionDateNow);
        /*         $lastPaidAmort = $this->getPrevAmortization($this->loan_account_id, $amortization->id, ['paid'], null, true, 'DESC'); */

        if ($isPastDue && $amortization) {
            if ($this->loan_status == LoanAccount::LOAN_ONGOING) {
                LoanAccount::where(['loan_account_id' => $this->loan_account_id])->update(['loan_status' => LoanAccount::LOAN_PASTDUE]);
                $this->payment_status = LoanAccount::PAYMENT_DELINQUENT;
                $this->loan_status = LoanAccount::LOAN_PASTDUE;
                // $this->save();
            }
            Amortization::find($amortization->id)->update(['status', 'delinquent']);
            $amortization->pdi = $this->getPDI($this->loan_amount, $this->interest_rate, $isPastDue);
        }


        if ($amortization) {
            $prev = null;
            $isMonthlyPayment = $this->checkPaymentMode();
            $prevAmort = $amortizationInstance->getPrevAmort($amortization->id, $this->loan_account_id);
            $prevAmortStatus = $prevAmort ? $prevAmort->status : null;
            $prevAmortId = $prevAmort ? $prevAmort->id : null;
            $prevAmortSched = $prevAmort ? $prevAmort->amortization_date : null;
            $prevAmortStatus = $prevAmort ? $prevAmort->status : null;


            $id = $amortization->id;
            if ($prevAmortStatus === 'delinquent') {
                $prev = $amortizationInstance->getPreviousAmortization($this->loan_account_id, $amortization->id, 'delinquent');
                $id = $prev->id;
            }

            $amortSched = $this->payment_mode === 'Monthly' ? $amortization->amortization_date->startOfMonth() : $amortization->amortization_date;
            $dayDiff = $amortSched->diffInDays($transactionDateNow, false);
            $amortization->day_late = $dayDiff;

            $amortization->principal = round($amortization->principal);
            $amortization->interest = round($amortization->interest);

            $amortization->schedule_principal = $amortization->principal;
            $amortization->schedule_interest = $amortization->interest;



            if ($this->payment_mode == 'Lumpsum' && $transactionDateNow < $amortSched) {
                $amortization->principal = 0;
                $amortization->interest = 0;
            }


            $amortization->advance_principal = $this->getAdvancePrincipal($this->loan_account_id, $amortization->id);
            $amortization->advance_interest = $this->getAdvanceInterest($this->loan_account_id, $amortization->id);
            $totalAmort = $this->getAmortizationDue();
            $amortization->pdi = $amortization->pdi ?? 0;
            $accountPayments = $this->getPayment($this->loan_account_id, $id);
            $isPartiallyPaid = $accountPayments->last();
            $totalPrincipal = $isPartiallyPaid ? $isPartiallyPaid->short_principal + $amortization->principal : $amortization->principal;
            $shortAdvance = $amortization->advance_principal < $totalPrincipal ? true : false;


            $amortization->delinquent = $this->getDelinquent($this->loan_account_id, $amortization->id, $amortization->advance_principal, $prevAmortId);
            if ($isMonthlyPayment) {
                if ($transactionDateNow < $amortSched->startOfMonth()) {
                    $amortization->principal = 0;
                    $amortization->interest = 0;
                }
                if ($transactionDateNow > $amortSched->endOfMonth() && $shortAdvance) {
                    /* if ($transactionDateNow > $amortization->amortization_date->endOfMonth()) {
                        LoanAccount::find($this->loan_account_id)->update(['payment_status' => 'Delinquent']);
                    } */
                }
                $endMonth = $prevAmortSched ? $prevAmortSched->endOfMonth() : $amortSched->endOfMonth();
                if ($transactionDateNow > $endMonth) {
                    $dayDiff = $endMonth->diffIndays($transactionDateNow);
                }
            } else {
                if ($transactionDateNow > $amortSched && $shortAdvance) {

                    /* if ($transactionDateNow > $amortization->amortization_date->startOfDay()) {
                        LoanAccount::find($this->loan_account_id)->update(['payment_status' => 'Delinquent']);
                    } */
                }

                if ($transactionDateNow <= $prevAmortSched && $prevAmortStatus === 'paid') {
                    $amortization->principal = 0;
                    $amortization->interest = 0;
                }
            }

            $amortization->short_principal = $amortization->delinquent['principal']; // - (in_array($id, $amortization->delinquent['ids']) ? $amortization->principal : 0);
            $amortization->short_interest = $amortization->delinquent['interest']; //- (in_array($id, $amortization->delinquent['ids']) ? $amortization->interest : 0);
            $amortization->short_pdi = 0;
            $amortization->short_penalty = $amortization->delinquent['penalty'];


            if ($isPartiallyPaid && ($isPartiallyPaid->short_principal || $isPartiallyPaid->short_interest)) {
                if ($id === $isPartiallyPaid->amortization_id) {
                    if ($id != $amortization->id) {

                        $amortization->short_principal = $isPartiallyPaid->short_principal;
                        $amortization->short_interest = $isPartiallyPaid->short_interest;
                    } else {
                        $amortization->total = $amortization->total - ($amortization->principal + $amortization->interest);
                        $amortization->principal = 0;
                        $amortization->penalty = 0;
                        $amortization->interest = 0;
                        $amortization->short_principal = $isPartiallyPaid->short_principal;
                        $amortization->short_interest = $isPartiallyPaid->short_interest;
                        $amortization->short_penalty = $isPartiallyPaid->short_penalty;
                        $amortization->over_payment = $isPartiallyPaid->over_payment;
                    }

                    $amortization->penalty = $this->getPenalty($amortization->delinquent['missed'], $totalAmort, $transactionDateNow);
                }

            } else {

                $amortization->short_interest -= $amortization->delinquent["short"];

                $amortization->penalty = $this->getPenalty($amortization->delinquent['missed'], $totalAmort, $transactionDateNow);
            }

            $amortization->day_late = $dayDiff;

            /*  $amortization->delinquent = $this->getDelinquent($this->loan_account_id, $amortization->id, $amortization->advance_principal, $transactionDateNow); */



            if ($dayDiff > 10 && $amortization->advance_principal < $amortization->schedule_principal) {
                array_merge(array_unique($amortization->delinquent['missed']), [$amortization->id]);
            }

            $amortization->total = ($amortization->principal + $amortization->interest) + ($amortization->short_principal + $amortization->short_interest);
            $amortization->totalPaid = $this->getPaymentTotal($this->loan_account_id);
            $amortization->outstandingBalance = $this->outstandingBalance($this->loan_account_id);
        }
        return $amortization;
    }

    public function getAmortizationDue()
    {
        $amortization = new Amortization();
        $firstAmortization = $amortization->getFirstAmortization($this->loan_account_id);
        $amortizationDue = $firstAmortization ? $firstAmortization["principal"] + $firstAmortization["interest"] : 0;
        return $amortizationDue;
    }
    public function getTotalPenalty($transactionDateNow)
    {

        $amortization = new Amortization();
        $lastPaidAmort = $amortization->getLastPaidAmortization($this->loan_account_id);
        /*         $this->setDelinquent($this->loan_account_id, $transactionDateNow, $this->payment_mode); */
        $current = $amortization->currentAmortization($this->loan_account_id, $this->payment_mode, $transactionDateNow, $this->loan_status);
        $totalAmort = $this->getAmortizationDue();
        $ids = [];

        if ($current) {
            $currentAmortId = $current->id;
            if ($lastPaidAmort) {
                $lastpaidAmortId = $lastPaidAmort->id;
                $delinquents = $this->getPrevAmortization($this->loan_account_id, $currentAmortId, ['delinquent'], $lastpaidAmortId, false, 'DESC');
            } else {
                $delinquents = $this->getPrevAmortization($this->loan_account_id, $currentAmortId, ['delinquent'], null, false, 'DESC');
            }
            foreach ($delinquents as $delinquent) {
                $ids[] = $delinquent->id;
            }
        }

        return $this->getPenalty($ids, $totalAmort, $transactionDateNow);
    }
    public function getTotalPdi($transactionDateNow)
    {
        $isPastDue = $this->checkPastDue($this->due_date, $transactionDateNow);

        $pdi = 0;
        if ($isPastDue) {
            $pdi = $this->getPDI($this->loan_amount, $this->interest_rate, $isPastDue);
        }
        return $pdi;
    }

    public function getCurrentAmortization()
    {


        if ($this->status == LoanAccount::STATUS_PENDING || !$this->isAccountHasSchedule() || $this->loan_status == LoanAccount::LOAN_PAID) {
            return false;
        }
        $currentAmortization = $this->getLoanAmortization();
        return $currentAmortization ?? null;
    }

    public function getPrevAmortization($loanAccountId, $amortizationId, $status = ['open'], $refId = null, $single = false, $order = 'ASC')
    {

        $cond = '<';
        $current = Amortization::with('payments')->find($amortizationId, ['status']);
        if ($current) {
            if ($current->status === 'delinquent') {
                $cond = '<=';
            }
        }

        $amortizations = Amortization::where('loan_account_id', $loanAccountId)
            ->with('payments', function ($query) {
                $query->paid();
            })
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

    public function getDelinquent($loanAccountId, $amortizationId, $advancePrincipal = 0, $prevAmortId)
    {


        $delinquents = null;
        $lastPaidAmort = $this->getPrevAmortization($loanAccountId, $amortizationId, ['paid'], null, true, 'DESC');
        if ($lastPaidAmort) {
            $delinquents = $this->getPrevAmortization($loanAccountId, $amortizationId, ['delinquent'], $lastPaidAmort->id, false, 'DESC');
        } else {
            $delinquents = $this->getPrevAmortization($loanAccountId, $amortizationId, ['delinquent'], null, false, 'DESC');
        }


        $balance = $advancePrincipal;
        $ids = [];
        $missed = [];
        $totalPrincipal = 0;
        $totalInterest = 0;
        $totalPdi = 0;
        $totalPenalty = 0;
        $totalShort = 0;
        // identify missed payments


        if ($delinquents) {
            $lastDelinquent = $delinquents->last();
            foreach ($delinquents as $delinquent) {
                $ids[] = $delinquent->id;
                /* $payments = $this->getDelinquentPayment($loanAccountId, $delinquent->id); */
                if (isset($delinquent->payments) && count($delinquent->payments) > 0) {
                    $isNotAdvancePayment = true;
                    $totalShort = $lastDelinquent->payments->last()->short_interest;

                    foreach ($delinquent->payments as $payment) {
                        $totalPrincipal += $payment->short_principal;
                        $totalInterest += $payment->short_interest;
                        $totalPdi += $payment->short_pdi;
                        $totalPenalty += $payment->short_penalty;
                        $isNotAdvancePayment = (bool) $payment->total_payable;
                        break;
                    }

                    if (!$isNotAdvancePayment) { // if advanced payment only add principal and interest
                        /* array_push($missed, $delinquent->id); */
                        $totalPrincipal += round($delinquent->principal);
                        $totalInterest += round($delinquent->interest);
                    }
                    break;

                } else {
                    array_push($missed, $delinquent->id);

                }


                $totalPrincipal += round($delinquent->principal);
                $totalInterest += round($delinquent->interest);
            }




        }



        if ($advancePrincipal) {
            if (count($missed) > 0) {

                $missedAmortizations = Amortization::whereIn('id', $missed)->orderBy('id', 'ASC')->get();

                foreach ($missedAmortizations as $key => $missedAmortization) {

                    if ($balance >= $missedAmortization->principal) {
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
            'short' => $totalShort,
            'missed' => array_values($missed)
        ];
    }

    public function setDelinquent($loanAccountId, $currentDay, $paymentMode)
    {
        /* $amortizations = $this->getPrevAmortization($loanAccountId, $amortizationId); */

        $amortizations = Amortization::select('id', 'amortization_date', 'status')
            ->where('amortization_date', '<=', $currentDay)
            /* ->when($paymentMode === 'Monthly', function ($query) use ($currentDay) {
                $query->where('amortization_date', '<=', $currentDay);
            }, function ($query) use ($currentDay) {
                $query->where('amortization_date', '<=', $currentDay);
            }) */
            ->where('status', 'open')
            ->where('loan_account_id', $loanAccountId)
            ->get();
        if (count($amortizations) > 0) {
            foreach ($amortizations as $amortization) {
                $schedDate = $paymentMode === 'Monthly' ? $amortization->amortization_date->endOfMonth() : $amortization->amortization_date->startOfDay();
                if ($schedDate < $currentDay) {
                    $amortization->status = 'delinquent';
                    $amortization->save();
                }
            }
        }
        return $amortizations;
    }



    public function setDelinquentAmortization($advancePrincipal = 0, $lastPaidAmort, $currentAmort)
    {
        $amortization = new Amortization();
        /* $delinquents = $this->getDelinquentAmortization($lastPaidAmort, $currentAmort); */
        $delinquents = $amortization->getDelinquentAmortization($this->loan_account_id, $lastPaidAmort, $currentAmort);
        $ids = [];
        $missed = [];
        $totalPrincipal = 0;
        $totalInterest = 0;
        $totalPdi = 0;
        $totalPenalty = 0;
        $balance = 0;
        if (count($delinquents) > 0) {
            foreach ($delinquents as $delinquent) {
                $ids[] = $delinquent->id;
                $payments = $this->getPaymentDelinquents($delinquent->id);
                $delinquent->payments = $payments;
                if (isset($delinquent->payments) && count($delinquent->payments) > 0) {
                    $isNotAdvancePayment = true;
                    foreach ($delinquent->payments as $payment) {
                        $paymentPartial = array_search($payment->amortization_id, $ids);
                        unset($ids[$paymentPartial]);
                        /* $totalPrincipal += $payment->short_principal; */

                        $totalInterest += $payment->short_interest;
                        $totalPdi += $payment->short_pdi;
                        $totalPenalty += $payment->short_penalty;
                        $isNotAdvancePayment = (bool) $payment->total_payable;
                        break;
                    }

                    if (!$isNotAdvancePayment) {

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

                    if ($balance >= $missedAmortization->principal) {
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
            'ids' => array_values($ids),
            'principal' => $totalPrincipal,
            'interest' => $totalInterest,
            'penalty' => $totalPenalty,
            'balance' => $balance,
            'pdi' => $totalPdi,
            'advance' => $advancePrincipal,
            'missed' => array_values($missed)
        ];
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

    /*  public function getDelinquentAmortization($lastPaidAmort, $currentAmort)
    {
        $amortizations = null;
        if ($lastPaidAmort) {
            $lastPaidAmortId = $lastPaidAmort->id;
            $account = $account->with('amortizations', function ($query) use ($lastPaidAmortId) {
                $query->where('id', '>', $lastPaidAmortId)->delinquent();
            })->without('branch')->accountId();
            $amortizations = $account->amortizations;
        } else {
            $currentAmortId = $currentAmort->id;
            $account = $account->with('amortizations', function ($query) use ($currentAmortId) {
                $query->where('id', '<=', $currentAmortId)->delinquent();
            })->without('branch')->accountId();
            $amortizations = $account->amortizations;
        }
        return $amortizations;
    } */

    public function getLastPaidAmortization()
    {
        $columns = ['loan_account_id', 'branch_code', 'product_id', 'payment_mode'];
        $without = ['documents', 'borrower', 'center', 'product', 'accountOfficer', 'payments'];


        $lastPaidAmort = $this->getAccount($columns, $without)
            ->with('amortizations', function ($query) {
                $query->where('status', 'paid')->orderBy('id', 'DESC')->first();
            })
            ->accountId();

        return $lastPaidAmort->amortizations->first();
    }

    public function getPaymentDelinquents($amortizationId = null)
    {
        $payments = Payment::query()->when($amortizationId, function ($query, $amortizationId) {
            $query->where('amortization_id', $amortizationId);
        })->select([
                    'loan_account_id',
                    'amortization_id',
                    'short_principal',
                    'short_pdi',
                    'short_penalty',
                    'total_payable'
                ])
            ->where('loan_account_id', $this->loan_account_id)
            ->orderBy('payment_id', 'DESC')
            ->paid()
            ->get();
        return $payments;
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
        return Payment::where(['loan_account_id' => $loanAccountId, 'status' => 'paid', 'amortization_id' => $amortizationId])->get();
    }

    public function getPaymentTotal($loanAccountId)
    {
        $totalPayment = 0;
        $payments = $this->getPayment($loanAccountId);
        foreach ($payments as $payment) {
            $totalPayment += $payment["amount_applied"];
        }
        return $totalPayment;
    }

    public function getPaymentTotalPrincipalInterest($loanAccountId, $payments = null)
    {


        $paymentTotal = 0;
        /* $payments = $this->getPayment($loanAccountId); */
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
        $dDate = $dueDate;

        if ($dDate <= $currentDay) {
            return $currentDay->diffInDays($dDate);
        }

        return 0;
    }

    public function getAdvancePrincipal($loanAccountId, $amortizationId)
    {
        $principal = 0;
        $paymentInfo = Payment::select('advance_principal')->where(['loan_account_id' => $loanAccountId, 'status' => 'paid'])
            ->orderBy('payment_id', 'DESC')
            ->first();
        return $paymentInfo ? $paymentInfo->advance_principal : 0;
    }

    public function getAdvanceInterest($loanAccountId, $amortizationId)
    {
        $principal = 0;
        $paymentInfo = Payment::select('advance_interest')->where(['loan_account_id' => $loanAccountId, 'status' => 'paid'])
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
            $currentDay = $dateNow->copy()->startOfDay();
            $amortizations = Amortization::find($missed)->pluck('amortization_date');
            $counter = 0;

            foreach ($amortizations as $date) {

                $dateSched = $date->startOfDay();
                $dayDiff = $dateSched->diffInDays($currentDay);
                if ($this->payment_mode === 'Monthly') {
                    $endMonth = $date->endOfMonth();
                    $dayDiff = $endMonth->diffInDays($currentDay, false);

                    if ($dayDiff >= 10) {
                        $counter++;
                    }
                } else {
                    if ($dayDiff > 10) {
                        $counter++;
                    }
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

        $account = LoanAccount::select('loan_account_id', 'interest_amount', 'loan_amount', 'type')->where(['loan_account_id' => $loanAccountId])->without('payments', 'documents')->first();
        $payment = $this->getPaymentTotalPrincipalInterest($loanAccountId, $account->payments);

        if ($account->type == 'Prepaid') {
            $bal = ($account->loan_amount) - $payment;
        } else {
            $bal = ($account->loan_amount + $account->interest_amount) - $payment;
        }
        return floatval(number_format($bal, 2, ".", ""));
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
        $transaction_date = $transactionDateNow;
        $due_date = $this->due_date != null ? $this->due_date : null;
        /* $days_late = $due_date != null ? $due_date->diffInDays($transaction_date, false) : 0; */
        $account = LoanAccount::query()
            ->select(['loan_account_id', 'branch_code', 'loan_amount', 'interest_amount', 'prepaid_interest', 'account_num', 'interest_amount'])
            ->without(['borrower', 'documents', 'accountOfficer', 'center', 'branch', 'product'])
            ->where(['loan_account_id' => $this->loan_account_id])
            ->first();
        $payments = $account->payments;
        /*         $account = LoanAccount::where(['loan_account_id' => $this->loan_account_id])->first();
        $payments = Payment::where(['loan_account_id' => $this->loan_account_id, 'status' => 'paid'])->orderBy('payment_id', 'DESC')->get(); */

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
        $accountSummary['penalty']['debit'] += /* 2;  */$this->getTotalPenalty($transactionDateNow);
        $accountSummary['pdi']['debit'] += /* 2;  */$this->getTotalPdi($transactionDateNow);



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
        $accountSummary['interest']['balance'] = $accountSummary['interest']['debit'] - $accountSummary['interest']['credit'];
        $accountSummary['penalty']['balance'] = $accountSummary['penalty']['debit'] - $accountSummary['penalty']['credit'];
        $accountSummary['pdi']['balance'] = $accountSummary['pdi']['debit'] - $accountSummary['pdi']['credit'];
        $accountSummary['rebates']['balance'] = $accountSummary['rebates']['debit'] - $accountSummary['rebates']['credit'];

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
            'account_num' => $accountNum
        ]);
        $loanAccount->save();
        if ($loanAccount) {
            Document::where('loan_account_id', $this->loan_account_id)->update([
                'promissory_number' => $accountNum
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
            ->with([
                'pendingPayments' => function ($query) use ($id) {
                    $query->where('status', Payment::STATUS_OPEN)
                        ->where('loan_account_id', $id)->first();
                }
            ])->find($id);
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
