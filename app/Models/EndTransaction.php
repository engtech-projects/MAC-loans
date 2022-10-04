<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class EndTransaction extends Model
{
    use HasFactory;
    protected $table = 'end_transaction';
    protected $primaryKey = 'id';

    public function getTransactionDate($branchId) {

    	$transactionDate = EndTransaction::where([ 'branch_id' => $branchId ])->get()->last();

    	if( !$transactionDate ){
    		return Carbon::now()->format('Y-m-d');
    	}

    	$endDay = Carbon::createFromFormat('Y-m-d', $transactionDate->date_end);

    	return $endDay->addDay()->format('Y-m-d');
    }

	public function releasing($dateEnd, $branchId) {

		$releaseLedger = new GeneralLedger();

		$branch = Branch::find($branchId);
		$loanAccounts = loanAccount::where(['status' => 'released', 'branch_code' => $branch->branch_code, 'date_release' => $dateEnd ])->get();
		

		$ledger = $releaseLedger->ledger('releasing');


		foreach ($loanAccounts as $account) {
			
			foreach ($ledger as $key => $value) {
				
				switch ($value['reference']) {
					case 'Loan Receivable':
						$ledger[$key]['debit'] += $account->loan_amount;
						break;
					case 'Check':

						if( $account->release_type == 'Check' || $account->release_type == 'Check Release' ){
							$ledger[$key]['credit'] += $account->net_proceeds;
						}

						break;
					case 'Cash':
						
						if( $account->release_type == 'Cash' || $account->release_type == 'Cash Release' ){
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

		

		// $journalEntry = new JournalEntry();
		// $loanReleasesBook = 8;

		// $journalEntry->journal_no = $this->getJournalNo($loanReleasesBook);
		// $journalEntry->journal_date = $dateEnd;
		// $journalEntry->branch_id = $branch->branch_id;
		// $journalEntry->book_id = $loanReleasesBook;
		// $journalEntry->source = 'Releases';
		// $journalEntry->cheque_no;
		// $journalEntry->cheque_date;
		// $journalEntry->amount;
		// $journalEntry->payee = $branch->branch_name;
		// $journalEntry->status = 'unposted';
		// $journalEntry->remarks = 'Loan Releases for the day ' . Carbon::createFromFormat('Y-m-d', $dateEnd)->format('m/d/Y');
		// $journalEntry->save();

		// $entryData = [];
		// foreach ($ledger as $key => $value) {
			
		// 	if( $value['debit'] > 0 || $value['credit'] > 0 ){

		// 		$entryData[] = [
		// 			'journal_id' => $journalEntry->journal_id,
		// 			'account_id' => $value['id'],
		// 			'subsidiary_id' => $branch->branch_code,
		// 			'journal_details_account_no' => $value['acct'],
		// 			'journal_details_title' => $value['title'],
		// 			'journal_details_debit' => $value['debit'],
		// 			'journal_details_credit' => $value['credit'],
		// 			'journal_details_ref_no' => '',
		// 			'journal_details_description' => '',
		// 		];

		// 	}
		// }

		// JournalEntryDetails::insert($entryData);
		return $ledger;
	}

	public function repayment($dateEnd, $branchId) {

		$repaymentLedger = new GeneralLedger();
		$branch = Branch::find($branchId);
		$payments = Payment::where(['status' => 'paid', 'branch_id' => $branchId ])->whereDate('created_at', $dateEnd)->get();

		$ledger = $repaymentLedger->ledger('repayment');


		foreach ($payments as $payment) {
			
			foreach ($ledger as $key => $value) {
				
				switch ($value['reference']) {
					case 'Loan Receivable':
						$ledger[$key]['credit'] += $payment->principal;
						break;
					case 'Check':

						if( $payment->payment_type == 'Check' || $payment->payment_type == 'Check Payment' ){
							$ledger[$key]['debit'] += $payment->amount_applied;
						}

						break;
					case 'Cash':
						
						if( $payment->payment_type == 'Cash' || $payment->payment_type == 'Cash Payment' ){
							$ledger[$key]['debit'] += $payment->amount_applied;
						}

						break;
					case 'Rebates':
						 $ledger[$key]['debit'] += $payment->rebates;
						break;
					case 'Interest Income':
						 $ledger[$key]['credit'] += $payment->interest;
						break;
					case 'Penalty Income':
						$ledger[$key]['credit'] += $payment->penalty;
						break;
					case 'Others':
						// $ledger[$key]['credit'] += $payment->;
						break;
					case 'Pastdue Interest':
						 $ledger[$key]['credit'] = $payment->pdi;
						break;
					case 'Prepaid Interest':
						// $ledger[$key]['credit'] = $payment->;
						break;
					case 'Memo':
			
						if( Str::contains($payment->payment_type, 'memo') ){
							$ledger[$key]['debit'] += $payment->amount_applied;
						}

						break;
					case 'VAT Payable':
						$ledger[$key]['credit'] += $payment->vat;
						break;
				}
			}


		}

		// $journalEntry = new JournalEntry();
		// $loanPaymentsBook = 9;

		// $journalEntry->journal_no = $this->getJournalNo($loanPaymentsBook);
		// $journalEntry->journal_date = $dateEnd;
		// $journalEntry->branch_id = $branch->branch_id;
		// $journalEntry->book_id = $loanPaymentsBook;
		// $journalEntry->source = 'Repayments';
		// $journalEntry->cheque_no;
		// $journalEntry->cheque_date;
		// $journalEntry->amount;
		// $journalEntry->payee = $branch->branch_name;
		// $journalEntry->status = 'unposted';
		// $journalEntry->remarks = 'Loan Repayments for the day ' . Carbon::createFromFormat('Y-m-d', $dateEnd)->format('m/d/Y');
		// $journalEntry->save();


		// $entryData = [];
		// foreach ($ledger as $key => $value) {
			
		// 	if( $value['debit'] > 0 || $value['credit'] > 0 ){

		// 		$entryData[] = [
		// 			'journal_id' => $journalEntry->journal_id,
		// 			'account_id' => $value['id'],
		// 			'subsidiary_id' => $branch->branch_code,
		// 			'journal_details_account_no' => $value['acct'],
		// 			'journal_details_title' => $value['title'],
		// 			'journal_details_debit' => $value['debit'],
		// 			'journal_details_credit' => $value['credit'],
		// 			'journal_details_ref_no' => '',
		// 			'journal_details_description' => '',
		// 		];

		// 	}
		// }

		// JournalEntryDetails::insert($entryData);
		return $ledger;
	}

	public function getJournalNo($id) {

        $book = DB::connection('mysql2')->table("journal_book")
            ->leftJoin("journal_entry", function($join){
                $join->on("journal_book.book_id", "=", "journal_entry.book_id");
            })
            ->selectRaw("journal_book.*, COUNT(journal_entry.journal_id) as ccount")
            ->where(['journal_book.book_id' => $id])
            ->groupBy("journal_book.book_id")
            ->first();

        return $book->book_code . '-' . str_pad($book->ccount+1, 7, '0', STR_PAD_LEFT);
    }

}
