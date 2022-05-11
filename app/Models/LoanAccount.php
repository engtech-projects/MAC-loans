<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class LoanAccount extends Model
{
    use HasFactory;
    protected $table = 'loan_accounts';
   	protected $primaryKey = 'loan_account_id';
	protected $with = ['documents'];


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
    ];


   	public static function generateAccountNum($branchCode, $productCode) {
   		// compute for the document transaction
   		$accountNum = $branchCode . '-' .$productCode . '-' . '001';
   		return $accountNum;
   	}

   	public static function getCycleNo() {
   		// retrieve 
   		return 1;
   	}

   	public function overrideReleaseAccounts($filters = array()) {   		

   		$accounts = LoanAccount::where('status', '=', 'pending');

   		if( isset($filters['created_at']) && $filters['created_at'] ){
   			$accounts->whereDate('loan_accounts.created_at', '=', $filters['created_at'] );
   		}

   		if( isset($filters['ao_id']) && $filters['ao_id'] ){
   			$accounts->where('loan_accounts.ao_id', '=', $filters['ao_id']);
   		}

   		if( isset($filters['center_id']) && $filters['center_id'] ){
   			$accounts->where('loan_accounts.center_id', '=', $filters['center_id']);
   		}

		if( isset($filters['product_id']) && $filters['product_id'] ){
   			$accounts->where('loan_accounts.product_id', '=', $filters['product_id']);
   		}

   		return $accounts->get();
   	}

   	public function center() {
   		return Center::find($this->center_id);
   	}

   	public function product(){
   		return Product::find($this->product_id);
   	}

   	public function borrower() {
   		return Borrower::find($this->borrower_id);
   	}

   	public function getPDI($loanAccountId) {


         $account = LoanAccount::where([ 'loan_account_id' => $loanAccountId ])->first();
         // 3 - 4
         $currentDay = Carbon::createFromFormat('Y-m-d', Carbon::now()->format('Y-m-d'));
         $dueDate = Carbon::createFromFormat('Y-m-d', $account->due_date);

         if( $dueDate->lt($currentDay) ){
            
            $product = Product::find($account->product_id);
            $rate = $product->interest_rate;
            $amountPerDay = round((($account->loan_amount * ($rate/100)) * 12 / 365), 2);
            $dayDiff = $currentDay->diffInDays($dueDate);

            return round($amountPerDay * (int)$dayDiff, 2);

         }
     
         return 0;
   	} 

      public function getPenalty() {

         $amortization = $this->currentAmortization();
         $missedPayments = count($this->getDelinquent());
         return $amortization->total * (2/100) * (int)$missedPayments;
   	}

      public function currentAmortization() {

         // get current amortization
         $amortization = Amortization::whereDate(
                        'amortization_date', '>=', Carbon::now()->format('Y-m-d')
                        )
                        ->where([
                              'loan_account_id' => $this->loan_account_id,
                              'status' => 'open'
                        ])
                        ->orderBy('amortization_date', 'ASC')
                        ->limit(1)
                        ->get()
                        ->first();


         if( $amortization == null ) {

            $amortizationId = Amortization::where([ 'loan_account_id' => $this->loan_account_id ])->max('id');
            $amortization = Amortization::where([ 'id' => $amortizationId ])->first();

         }

         return $amortization;
      }

      public function getCurrentAmortization(){

         $amortization = $this->currentAmortization();
         
         $amortization->delinquent = $this->getDelinquent();
         $amortization->short_principal = 0;
         $amortization->advance_principal = 0;
         $amortization->short_interest = 0;
         $amortization->advance_interest = 0;
         $amortization->penalty = $this->getPenalty();
         $amortization->pdi = $this->getPDI($amortization->loan_account_id);
         $amortization->outstandingBalance = $this->outstandingBalance($amortization->loan_account_id);;
         $amortization->missedPayments = count($amortization->delinquent);
         $amortization->lastPayment = $this->lastPayment($amortization->loan_account_id);

         if( count($amortization->delinquent) ){

            foreach ($amortization->delinquent as $key => $value) {
               $value->payment = Payment::where([ 'loan_account_id' =>$value->loan_account_id, 'amortization_id' => $value->id ])->first();

               if( $value->payment ){
                  $amortization->short_principal += $value->payment->short_principal;
                  $amortization->short_interest += $value->payment->short_interest;
               }else{
                  $amortization->short_principal += $value->principal;
                  $amortization->short_interest += $value->interest;
               }

            }

         }
         
         return $amortization;
      }

   	public function getDelinquent() {
         return Amortization::where(
            [
               'loan_account_id' => $this->loan_account_id, 
               'status' => 'delinquent'
            ])
            ->orderBy('id', 'ASC')
            ->get();
   	}

      public function outstandingBalance($loanAccountId) {

         $account = LoanAccount::where(['loan_account_id' => $loanAccountId])->first();
         $payments = Payment::where(['loan_account_id' => $loanAccountId ])->orderBy('payment_id', 'asc')->get();

         $principalBalance = $account->loan_amount;
         $interestBalance = $account->interest_amount;
         $surcharge = 0;
         $totalPaidPrincipal = 0;
         $totalPaidInterest = 0;
    
         if( count($payments) ){

            foreach ($payments as $key => $value) {
               
               $totalPaidPrincipal += $value->principal;
               $totalPaidInterest += $value->interest;
               $surcharge += ($value->pdi + $value->penalty);
            }

            return [ 
               'principal_balance' => $principalBalance - $totalPaidPrincipal, 
               'interest_balance' => $interestBalance - $totalPaidInterest,
               'surcharge' => $surcharge,
            ];
         }

         return [ 
            'principal_balance' => $principalBalance, 
            'interest_balance' => $interestBalance,
            'surcharge' => $surcharge,
         ];
      }

      public function lastPayment($loanAccountId) {

         $paymentId = Payment::where('loan_account_id', $loanAccountId)->max('payment_id');
         $payment = Payment::find($paymentId);

         return $payment;
      }

      public function setDelinquent($branchCode) {

         # get branch code of current branch
         // $branchCode = Branch::where('branch_code', $this->branch_code)->get()->first()->branch_code;
         # get released accounts with current branch code
         $accounts = LoanAccount::where( ['status' => 'released', 'branch_code' => $branchCode] )->get();

         # get current end of day date.
         $currentDay = Carbon::now()->format('Y-m-d');

         $delinquents = 0;
         $counter = 0;
         foreach ($accounts as $key => $value) {
            
            # update amortization  
            $delinquents = Amortization::whereDate(
                  'amortization_date', '<', $currentDay
               )
               ->where([ 'loan_account_id' => $value->loan_account_id, 'status' => 'open' ])
               ->update(['status' => 'delinquent']);

            $counter += $delinquents;
         }

         return $count;
      }

      public function checkAmortizationStatus($loanAccountId) {

         $amortization = Amortization::whereIn('status', ['open', 'delinquent'])->where(['loan_account_id' => $loanAccountId])->get();

         return $amortization;
      }

	  public function documents(){
		  return $this->hasOne(Document::class, 'loan_account_id');
	  }





}
