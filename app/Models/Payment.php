<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payment';
    protected $primaryKey = 'payment_id';

    const STATUS_PAID = 'paid';
    const STATUS_OPEN = 'open';

    protected $fillable = [
        'loan_account_id',
        'branch_id',
        'payment_type',
        'or_no',
        'cheque_no',
        'bank_name',
        'reference_no',
        'memo_type',
        'amortization_id',  // references amortization (id) primary key,
        'principal',
        'interest',
        'short_principal',
        'advance_principal',
        'short_interest',
        'advance_interest',
        'pdi',
        'pdi_approval_no',
        'short_pdi',
        'penalty',
        'penalty_approval_no',
        'short_penalty',
        'rebates',
        'rebates_approval_no',
        'vat',
        'total_payable',
        'amount_applied',
        'status',
        'reference_id',
        'remarks',
        'transaction_number',
        'transaction_date',
        'cancelled_date',
        'cancelled_by',
        'gcash_no'
    ];

    public $pCodes = [
        'cash' => 'CSH',
        'Gcash' => 'GCS',
        'check' => 'CHK',
        'pos' => 'POS',
        'deduct' => 'MDB',
        'interbranch' => 'MBP',
        'offset' => 'MPF',
        'rebates' => 'MEM'
    ];

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function account()
    {
        return $this->belongsTo(LoanAccount::class, 'loan_account_id');
    }
    public function loanDetails()
    {
        return $this->belongsTo(LoanAccount::class, 'loan_account_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }


    public function getCollectionPaymentByBranch($date)
    {
        $date = $date ? Carbon::createFromFormat('Y-m-d', $date) : null;
        $months = getMonths();


        $paymentsYearly = Branch::query()->select('branch_id', 'branch_name')
            ->with('payments', function ($query) use ($date) {
                $query->when($date, function ($query, $date) {
                    $query->where('status', 'paid')
                        ->whereYear('transaction_date', $date->year)
                        ->whereMonth('transaction_date', $date->month);
                });
                $query->selectRaw(
                    'branch_id,
                    YEAR(transaction_date) as year,
                    MONTH(transaction_date) as month,
                    SUM(amount_applied) as total_collection,
                    count(distinct loan_account_id) as no_of_accounts',
                )
                    ->groupBy('year', 'month', 'branch_id')
                    ->orderBy('year', 'DESC')
                    ->orderBy('month', 'DESC');
            })->get();
        $groupPayments = [];
        /* dd($paymentsYearly->toArray()); */
        foreach ($paymentsYearly as $branch) {
            $branchName = $branch->branch_name;
            foreach ($branch->payments as $payment) {
                $year = $payment->year;

                $month = $payment->month;
                $monthName = $months[$month - 1];
                if (!isset($groupPayments[$branchName][$year])) {
                    $groupPayments[$branchName][$year] = array_fill_keys($months, [
                        'no_of_accounts' => 0,
                        'total_collection' => 0
                    ]);
                }
                $groupPayments[$branchName][$year][$monthName] = [
                    'no_of_accounts' => $payment->no_of_accounts,
                    'total_collection' => $payment->total_collection
                ];
            }
        }
        return $groupPayments;
    }

    public function addPayment(Request $request)
    {

        $account = LoanAccount::find($request->input('loan_account_id'));
        $payment = new Payment();

        $payment->loan_account_id = $request->input('loan_account_id');
        $payment->branch_id = $request->input('branch_id');
        $payment->payment_type = $request->input('payment_type');
        $payment->or_no = $request->input('or_no');
        $payment->cheque_no = $request->input('cheque_no');
        $payment->bank_name = $request->input('bank_name');
        $payment->reference_no = $request->input('reference_no');
        $payment->memo_type = $request->input('memo_type');
        $payment->amortization_id = $request->input('amortization_id');
        $payment->principal = $request->input('principal');
        $payment->interest = $request->input('interest');
        $payment->short_principal = $request->input('short_principal');
        $payment->advance_principal = $request->input('advance_principal');
        $payment->short_interest = $request->input('short_interest');
        $payment->advance_interest = $request->input('advance_interest');
        $payment->pdi = $request->input('pdi');
        $payment->pdi_approval_no = $request->input('pdi_approval_no');
        $payment->short_pdi = $request->input('short_pdi');
        $payment->penalty = $request->input('penalty');
        $payment->penalty_approval_no = $request->input('penalty_approval_no');
        $payment->short_penalty = $request->input('short_penalty');
        $payment->rebates = $request->input('rebates');
        $payment->rebates_approval_no = $request->input('rebates_approval_no');
        $payment->vat = $request->input('vat');
        $payment->over_payment = $request->input('over_payment');
        $payment->total_payable = $request->input('total_payable');
        $payment->amount_applied = $request->input('amount_applied');
        $payment->vat = 0.00;
        $payment->reference_id = $request->input('reference_id');
        $payment->remarks = $request->input('remarks');
        $endTransaction = new EndTransaction();
        $dateEnd = $endTransaction->getTransactionDate($request->input("branch_id"));
        $payment->transaction_date = $dateEnd->date_end;
        $payment->gcash_no = $request->input('gcash_no');

        if ($payment->interest > 0 || $payment->pdi > 0 || $payment->penalty > 0) {
            $pdi = 0;
            $penalty = 0;
            if ($payment->pdi > 0 && !$payment->pdi_approval_no) {
                $pdi = $payment->pdi;
            }

            if ($payment->penalty > 0 && !$payment->penalty_approval_no) {
                $penalty = $payment->penalty;
            }

            $vatint = round(($payment->interest) / 1.12 *0.12,2);
            $vatpdi = round(($pdi) / 1.12 *0.12,2);
            // $vat = ($payment->interest + $pdi + $penalty) / 1.12 * 0.12;
            $vat = $vatpdi + $vatint;

            $payment->vat = round($vat, 2);
        }

        // $payment->status = 'paid';
        $payment->save();

        if ($payment->payment_id) {
            $payment->transaction_number = $this->generateTransactionNumber($payment->payment_id, $payment->payment_type, $payment->memo_type);
            $payment->save();
        }


        // $amortization = Amortization::find( $payment->amortization_id );
        // $amortization->status = 'paid';

        // if( $payment->short_principal > 0 ){
        //     $amortization->status = 'delinquent';
        // }

        // $amortization->save();

        return $payment;
    }

    public function overridePaymentAccounts($filters = array())
    {

        $payments = Payment::join('loan_accounts', 'loan_accounts.loan_account_id', '=', 'payment.loan_account_id')
            ->join('borrower_info', 'borrower_info.borrower_id', '=', 'loan_accounts.borrower_id');

        if (isset($filters['transaction_date']) && $filters['transaction_date']) {
            $payments->whereDate('payment.transaction_date', '=', $filters['transaction_date']);
        }

        if (isset($filters['ao_id']) && $filters['ao_id'] != 'all' && $filters['ao_id']) {
            $payments->where('loan_accounts.ao_id', '=', $filters['ao_id']);
        }

        if (isset($filters['center_id']) && $filters['center_id'] != 'all' && $filters['center_id']) {
            $payments->where('loan_accounts.center_id', '=', $filters['center_id']);
        }

        if (isset($filters['product_id']) && $filters['product_id'] != 'all' && $filters['product_id']) {
            $payments->where('loan_accounts.product_id', '=', $filters['product_id']);
        }

        if (isset($filters['branch_id'])) {
            $payments->where('payment.branch_id', '=', $filters['branch_id']);
        }

        $payments->where('payment.status', '=', 'open');

        return $payments->get(['payment.*', 'loan_accounts.*', 'borrower_info.*']);
    }

    public function overriddenList($filters = array())
    {

        $payments = Payment::join('loan_accounts', 'loan_accounts.loan_account_id', '=', 'payment.loan_account_id')
            ->join('borrower_info', 'borrower_info.borrower_id', '=', 'loan_accounts.borrower_id');

        if (isset($filters['transaction_date']) && $filters['transaction_date']) {
            $payments->whereDate('payment.transaction_date', '=', $filters['transaction_date']);
        }

        if (isset($filters['branch_id'])) {
            $payments->where('payment.branch_id', '=', $filters['branch_id']);
        }

        $payments->where('payment.status', '=', 'paid');

        return $payments->get(['payment.*', 'loan_accounts.*', 'borrower_info.*']);
    }

    public function paymentList($transDate, $branchId)
    {

        return Payment::whereDate('payment.transaction_date', '=', $transDate)
            ->where(['branch_id' => $branchId])
            ->get();
    }

    public function generateTransactionNumber($paymentId, $paymentType, $memoType = null)
    {

        if ($paymentType) {

            if (Str::contains(Str::lower($paymentType), 'cash')) {
                if ($paymentType == 'Gcash') {
                    return $this->pCodes['Gcash'] . '-' . str_pad($paymentId, 7, '0', STR_PAD_LEFT);
                }
                return $this->pCodes['cash'] . '-' . str_pad($paymentId, 7, '0', STR_PAD_LEFT);
            }
            if (Str::contains(Str::lower($paymentType), 'check')) {
                return $this->pCodes['check'] . '-' . str_pad($paymentId, 7, '0', STR_PAD_LEFT);
            }
            if (Str::contains(Str::lower($paymentType), 'pos')) {
                return $this->pCodes['pos'] . '-' . str_pad($paymentId, 7, '0', STR_PAD_LEFT);
            }
            if (Str::contains(Str::lower($paymentType), 'memo')) {

                if (Str::contains(Str::lower($memoType), 'deduct')) {
                    return $this->pCodes['deduct'] . '-' . str_pad($paymentId, 7, '0', STR_PAD_LEFT);
                }
                if (Str::contains(Str::lower($memoType), 'interbranch')) {
                    return $this->pCodes['interbranch'] . '-' . str_pad($paymentId, 7, '0', STR_PAD_LEFT);
                }
                if (Str::contains(Str::lower($memoType), 'offset')) {

                    return $this->pCodes['offset'] . '-' . str_pad($paymentId, 7, '0', STR_PAD_LEFT);
                }
                if (Str::contains(Str::lower($memoType), 'rebates')) {
                    return $this->pCodes['rebates'] . '-' . str_pad($paymentId, 7, '0', STR_PAD_LEFT);
                }
            }
        }



        // Str::contains(Str::lower($payment->payment_type), 'check')
    }

    public function remarks()
    {
        $status = $this->status;
        $remarks = $this->remarks;

        if (Str::lower($status) == 'cancelled') {
            return ucwords($status) . ' - ' . $remarks;
        }

        return $remarks;
    }

    public function cancelPayment()
    {
    }

    public function getOngoingPayment($request = array())
    {
        return Payment::where([
            'loan_account_id' => $request['loan_account_id'],
            'status' => 'open'
        ])->get()->first();
    }
}
