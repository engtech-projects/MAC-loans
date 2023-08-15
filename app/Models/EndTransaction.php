<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class EndTransaction extends Model
{
    use HasFactory;
    protected $table = 'end_transaction';
    protected $primaryKey = 'id';
    protected $fillable = [
        'branch_id',
        'date_end',
        'status'
    ];

    protected $casts = [
        'date_end' => 'date:Y-m-d'
    ];

    /*
		fetch transaction date by branch that has an open status
		open status means an End of day transaction has not been performed yet
	*/
    // public function getTransactionDate($branchId) {

    // # get current date
    // $currentDate = Carbon::now()->format('Y-m-d');
    // $transactionDate = EndTransaction::where([ 'branch_id' => $branchId, 'status' => 'open' ])->get()->last();

    // if( !$transactionDate ){

    // 	$hasCurrentDate = EndTransaction::where([ 'branch_id' => $branchId, 'status' => 'closed' ])->get()->last();


    // 	if( $hasCurrentDate && ($hasCurrentDate->date_end == $currentDate)) {
    // 		return $hasCurrentDate;
    // 	}

    // 	# create transaction date based on current date.
    // 	return EndTransaction::create(array(
    // 		'branch_id' => $branchId,
    // 		'date_end' => Carbon::now()->format('Y-m-d'),
    // 		'status' => 'open',
    // 	));

    // }

    // return $transactionDate;
    // }

    public static function getTransactionDate($branchId)
    {

        $eod = EndTransaction::where(['branch_id' => $branchId, 'status' => 'open'])->get()->last();

        if (!$eod) {
            $eod = EndTransaction::where(['branch_id' => $branchId])->orderBy("date_end", 'DESC')->first();
        }

        if (!$eod) {
            // if there is no transaction date. create a fake closed transaction date yesterday.
            $eod = new EndTransaction();
            $eod->branch_id = $branchId;
            $eod->date_end = Carbon::now()->addDay(-1)->format('Y-m-d');
            $eod->status = 'closed';
        }

        return $eod;
    }

    public function verify($branchId)
    {

        $transactionDate = EndTransaction::where(['branch_id' => $branchId, 'status' => 'open'])->get()->last();

        if ($transactionDate) {
            return true;
        }
        return false;
    }

    public function exists($dateEnd, $branchId)
    {

        $transactionDate = EndTransaction::where(['date_end' => $dateEnd, 'branch_id' => $branchId])->first();

        if ($transactionDate) {
            return true;
        }
        return false;
    }

    public function existOld($dateEnd, $branchId)
    {

        $transactionDate = EndTransaction::where(['branch_id' => $branchId])->whereDate('date_end', ">=", $dateEnd)->get()->last();
        if ($transactionDate) {
            return true;
        }
        return false;
    }

    public function validate($dateEnd, $branchId)
    {

        if ($this->verify($branchId)) {
            return true;
        }
        return false;
    }

    public function releasing($dateEnd, $branchId, $status = 'unposted')
    {

        $releaseLedger = new GeneralLedger();

        $branch = Branch::find($branchId);
        $loanAccounts = loanAccount::where(['status' => 'released', 'branch_code' => $branch->branch_code, 'date_release' => $dateEnd])->get();


        if (count($loanAccounts) > 0) {

            $ledger = $releaseLedger->ledger('releasing');

            $netProceeds = 0;
            foreach ($loanAccounts as $account) {

                $netProceeds += $account->net_proceeds;
                foreach ($ledger as $key => $value) {

                    switch ($value['reference']) {
                        case 'Loan Receivable':
                            $ledger[$key]['debit'] += $account->loan_amount;
                            break;
                        case 'Check':

                            if ($account->release_type == 'Check' || $account->release_type == 'Check Release') {
                                $ledger[$key]['credit'] += $account->net_proceeds;
                            }

                            break;
                        case 'Cash':

                            if ($account->release_type == 'Cash' || $account->release_type == 'Cash Release') {
                                $ledger[$key]['credit'] += $account->net_proceeds;
                            }

                            break;
                        case 'Filing Fee':
                            $ledger[$key]['credit'] += $account->filing_fee;
                            break;
                        case 'Documentary Stamp':
                            $ledger[$key]['credit'] += $account->document_stamp;
                            break;
                        case 'Insurance':
                            $ledger[$key]['credit'] += $account->insurance;
                            break;
                        case 'Notarial':
                            $ledger[$key]['credit'] += $account->notarial_fee;
                            break;
                        case 'Prepaid':
                            $ledger[$key]['credit'] += $account->prepaid_interest;
                            break;
                        case 'Others':
                            $ledger[$key]['credit'] += $account->affidavit_fee;
                            break;
                        case 'Memo':
                            $ledger[$key]['credit'] += $account->memo;
                            break;
                    }
                }
            }


            $journalEntry = new JournalEntry();
            $loanReleasesBook = 8;

            $journalEntry->journal_no = $this->getJournalNo($loanReleasesBook);
            $journalEntry->journal_date = $dateEnd;
            $journalEntry->branch_id = $branch->branch_id;
            $journalEntry->book_id = $loanReleasesBook;
            $journalEntry->source = 'Releases';
            $journalEntry->cheque_no;
            $journalEntry->cheque_date;
            $journalEntry->amount = $netProceeds;
            $journalEntry->payee = '';
            $journalEntry->status = $status;
            $journalEntry->remarks = 'Loan Releases for the day ' . Carbon::createFromFormat('Y-m-d', $dateEnd)->format('m/d/Y');
            $journalEntry->save();

            $entryData = [];
            foreach ($ledger as $key => $value) {

                if ($value['debit'] > 0 || $value['credit'] > 0) {

                    $entryData[] = [
                        'journal_id' => $journalEntry->journal_id,
                        'account_id' => $value['id'],
                        'subsidiary_id' => $branch->branch_code,
                        'journal_details_account_no' => $value['acct'],
                        'journal_details_title' => $value['title'],
                        'journal_details_debit' => $value['debit'],
                        'journal_details_credit' => $value['credit'],
                        'journal_details_ref_no' => '',
                        'journal_details_description' => '',
                    ];
                }
            }

            return JournalEntryDetails::insert($entryData);
            // return $ledger;
        }

        return false;
    }

    public function repayment($dateEnd, $branchId, $status = 'unposted')
    {

        $repaymentLedger = new GeneralLedger();
        $branch = Branch::find($branchId);
        $payments = Payment::where(['status' => 'paid', 'branch_id' => $branchId])->whereDate('transaction_date', $dateEnd)->get();

        if (count($payments) > 0) {

            $ledger = $repaymentLedger->ledger('repayment');

            $amountApplied = 0;
            foreach ($payments as $payment) {

                $amountApplied += $payment->amount_applied;
                foreach ($ledger as $key => $value) {

                    switch ($value['reference']) {
                        case 'Loan Receivable':
                            $ledger[$key]['credit'] += $payment->principal;
                            break;
                        case 'Check':

                            if (Str::contains(Str::lower($payment->payment_type), 'check')) {
                                $ledger[$key]['debit'] += $payment->amount_applied;
                            }

                            break;
                        case 'Cash':

                            if (Str::contains(Str::lower($payment->payment_type), 'cash')) {
                                $ledger[$key]['debit'] += $payment->amount_applied;
                            }

                            break;
                        case 'Rebates':

                            if ($payment->rebates > 0 && $payment->rebates_approval_no) {
                                $ledger[$key]['debit'] += $payment->rebates;
                            }

                            break;
                        case 'Interest Income':
                            // rebates
                            $r = 0;
                            if ($payment->rebates > 0 && $payment->rebates_approval_no) {
                                $r = $payment->rebates;
                            }

                            $ledger[$key]['credit'] += ($payment->interest + $r);
                            break;
                        case 'Penalty Income':

                            if ($payment->penalty > 0 && !$payment->penalty_approval_no) {
                                $ledger[$key]['credit'] += $payment->penalty;
                            }

                            break;
                        case 'Others':
                            $ledger[$key]['credit'] += $payment->over_payment;
                            break;
                        case 'Pastdue Interest':

                            if ($payment->pdi > 0 && !$payment->pdi_approval_no) {
                                $ledger[$key]['credit'] += $payment->pdi;
                            }

                            break;
                            // case 'Prepaid Interest':
                            // 	// $ledger[$key]['credit'] = $payment->;
                            // 	break;
                        case 'Memo':

                            if (Str::contains(Str::lower($payment->payment_type), 'memo')) {
                                $ledger[$key]['debit'] += $payment->amount_applied;
                            }

                            break;

                        case 'POS':

                            if (Str::contains(Str::lower($payment->payment_type), 'pos')) {
                                $ledger[$key]['debit'] += $payment->amount_applied;
                            }

                            break;

                        case 'VAT Payable':
                            $ledger[$key]['credit'] += $payment->vat;
                            break;
                    }
                }
            }

            foreach ($ledger as $k => $v) {

                switch ($v['reference']) {
                    case 'VAT':
                        $rebates = $repaymentLedger->getDataFromLedger($ledger, 'Rebates');
                        $interestIncome = $repaymentLedger->getDataFromLedger($ledger, 'Interest Income', 'credit');

                        $ledger[$k]['debit'] = round(($interestIncome - $rebates) / 1.12 * 0.12, 2);
                        break;

                    case 'Penalty':
                        $penalty = $repaymentLedger->getDataFromLedger($ledger, 'Penalty Income', 'credit');

                        $ledger[$k]['debit'] = round($penalty / 1.12 * 0.12, 2);
                        break;

                    case 'PDI':
                        $pdi = $repaymentLedger->getDataFromLedger($ledger, 'Pastdue Interest', 'credit');
                        $ledger[$k]['debit'] = round($pdi / 1.12 * 0.12, 2);
                        break;
                }
            }

            $journalEntry = new JournalEntry();
            $loanPaymentsBook = 9;

            $journalEntry->journal_no = $this->getJournalNo($loanPaymentsBook);
            $journalEntry->journal_date = $dateEnd;
            $journalEntry->branch_id = $branch->branch_id;
            $journalEntry->book_id = $loanPaymentsBook;
            $journalEntry->source = 'Repayments';
            $journalEntry->cheque_no;
            $journalEntry->cheque_date;
            $journalEntry->amount = $amountApplied;
            $journalEntry->payee = '';
            $journalEntry->status = $status;
            $journalEntry->remarks = 'Loan Repayments for the day ' . Carbon::createFromFormat('Y-m-d', $dateEnd)->format('m/d/Y');
            $journalEntry->save();


            $entryData = [];
            foreach ($ledger as $key => $value) {

                if ($value['debit'] > 0 || $value['credit'] > 0) {

                    $entryData[] = [
                        'journal_id' => $journalEntry->journal_id,
                        'account_id' => $value['id'],
                        'subsidiary_id' => $branch->branch_code,
                        'journal_details_account_no' => $value['acct'],
                        'journal_details_title' => $value['title'],
                        'journal_details_debit' => $value['debit'],
                        'journal_details_credit' => $value['credit'],
                        'journal_details_ref_no' => '',
                        'journal_details_description' => '',
                    ];
                }
            }

            return JournalEntryDetails::insert($entryData);
            // return $ledger;
        }

        return false;
    }

    public function getJournalNo($id)
    {

        $book = DB::connection('mysql2')->table("journal_book")
            ->leftJoin("journal_entry", function ($join) {
                $join->on("journal_book.book_id", "=", "journal_entry.book_id");
            })
            ->selectRaw("journal_book.*, COUNT(journal_entry.journal_id) as ccount")
            ->where(['journal_book.book_id' => $id])
            ->groupBy("journal_book.book_id")
            ->first();

        return $book->book_code . '-' . str_pad($book->ccount + 1, 7, '0', STR_PAD_LEFT);
    }

    public function close($branchId)
    {

        $transactionDate = EndTransaction::where(['branch_id' => $branchId, 'status' => 'open'])->get()->last();
        $transactionDate->status = 'closed';
        return $transactionDate->save();
    }
}
