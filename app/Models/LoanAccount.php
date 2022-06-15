<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;


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
   ];


	public static function generateAccountNum($branchCode, $productCode, $identifier) {
		// compute for the document transaction
		$accountNum = $branchCode . '-' .$productCode . '-' . str_pad($identifier, 7, '0', STR_PAD_LEFT);
		return $accountNum;
	}

	public static function getCycleNo($id) {
      $cycleNo = LoanAccount::where(['borrower_id' => $id, 'status' => 'released'])->count();

      return $cycleNo + 1;
	}

	public function center() {
      return $this->hasOne(Center::class, 'center_id', 'center_id');
		// return Center::find($this->center_id);
	}

	public function product(){
      return $this->hasOne(Product::class, 'product_id', 'product_id');
		// return Product::find($this->product_id);
	}

   public function branch() {
      return $this->hasOne(Branch::class, 'branch_code', 'branch_code');
   }

   public function accountOfficer() {
      return $this->hasOne(AccountOfficer::class, 'ao_id', 'ao_id');  
   }

	// public function borrower() {
	// 	return Borrower::with(['businessInfo','employmentInfo','householdMembers','outstandingObligations'])->find($this->borrower_id);
	// }

   public function borrowerPhoto() {

      $borrower = Borrower::find($this->borrower_id);
      return $borrower->getPhoto();
   }

   public function borrower(){
      return $this->hasOne(Borrower::class, 'borrower_id', 'borrower_id');
   }

   public function documents(){
     return $this->hasOne(Document::class, 'loan_account_id');
   }

   public function payments() {
      return $this->hasMany(Payment::class, 'loan_account_id')->where(['status' => 'paid']);
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

   public function getPenalty($delinquent) {

      $amortization = $this->currentAmortization();
      $missedPayments = $delinquent;
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

         if( $amortizationId ) {
            $amortization = Amortization::where([ 'id' => $amortizationId ])->first();   
         }
      }

      return $amortization;
   }

    public function getCurrentAmortization(){

      $amortization = $this->currentAmortization();
      
      # compute for total payables
      # compute for total payments
      # get last payment
	  if($amortization){
      $amortization->shortpayment = $this->shortpayment($amortization->loan_account_id, $amortization->id);
      // $amortization->prev_record = $this->getPrevRecord($amortization->loan_account_id, $amortization->id);
      $amortization->delinquent = $this->getDelinquent($amortization->amortization_id);
      $amortization->PrevPayment = $this->lastPayment($amortization->loan_account_id, true);
      $amortization->lastPayment = $this->lastPayment($amortization->loan_account_id);

      foreach ($amortization->delinquent as $key => $value) {

         if( $value->id < $amortization->id && $value->id > $amortization->PrevPayment->amortization_id){
            continue;
         }

         $amortization->delinquent->forget($key);
      }

      $amortization->short_principal = 0;
      $amortization->advance_principal = 0;
      $amortization->short_interest = 0;
      $amortization->advance_interest = 0;
      $amortization->penalty = $this->getPenalty(count($amortization->delinquent));
      $amortization->pdi = $this->getPDI($amortization->loan_account_id);
      $amortization->outstandingBalance = $this->outstandingBalance($amortization->loan_account_id);
      $amortization->missedPayments = count($amortization->delinquent);

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
	}
      return $amortization;
   }

   public function shortPayment($loanAccountId, $amortizationId) {

      $totalPayable = $this->getTotalPayable($loanAccountId, $amortizationId);
      $totalPaid = $this->getTotalPayments($loanAccountId);

      $principal =  $totalPayable['principal'] - $totalPaid['principal'];
      $interest =  $totalPayable['interest'] - $totalPaid['interest'];

      return [ 
         'principal' => $principal, 
         'interest' => $interest, 
      ];
   }

   public function getTotalPayable($loanAccountId, $amortizationId) {

      $amortization = Amortization::where([ 'loan_account_id' => $loanAccountId ])
                                    ->where('id', '<', $amortizationId)
                                    ->get();
      
      $principal = 0;
      $interest = 0;
      foreach ($amortization as $key => $value) {
         
         $principal += $value->principal;
         $interest += $value->interest;
        
      }

      return [ 'principal' => $principal, 'interest' => $interest ];
   }

   public function getTotalPayments($loanAccountId) {

      $payments = Payment::where(['loan_account_id' => $loanAccountId, 'status' => 'paid' ])
                           ->orderBy('payment_id', 'asc')
                           ->get();

      $principal = 0;
      $interest = 0;

      foreach ($payments as $key => $value) {

         $principal += $value->principal;
         $interest += $value->interest;

      }

      return [ 'principal' => $principal, 'interest' => $interest ];
   }

   public function getDelinquent($amortizationId) {

      return Amortization::where(['loan_account_id' => $this->loan_account_id,'status' => 'delinquent'])
                           ->orderBy('id', 'ASC')
                           ->get();
   }

   public function outstandingBalance($loanAccountId) {

      $account = LoanAccount::where(['loan_account_id' => $loanAccountId])->first();
      $payments = Payment::where(['loan_account_id' => $loanAccountId, 'status' => 'paid' ])
                           ->orderBy('payment_id', 'asc')
                           ->get();

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

   public function lastPayment($loanAccountId, $isComplete = false) {

      $payment = null;
      $payment = $this->getPrevPayment($loanAccountId);


      if( !$isComplete ) return $payment;
       
      if( !$payment ) return false;
     
      if( !$payment ) return false;

      if( $payment->total_payable == $payment->amount_applied ){
          return $payment;
      }
             
      $isDelinquent = true;

      while( $isDelinquent ) {

         $payment = $this->getPrevPayment($loanAccountId, $payment->payment_id);

         if( $payment->total_payable == $payment->amount_applied ){
           $isDelinquent = false;
         }
      }
      
      return $payment;
   }

   public function getPrevPayment($loanAccountId, $paymentId = null){

      if( !$paymentId ){
        $paymentId = Payment::where('loan_account_id', $loanAccountId)->max('payment_id');
      }else{
         $paymentId = Payment::where('loan_account_id', $loanAccountId)
                     ->where('payment_id', '<', $paymentId)
                     ->max('payment_id');   
      }

      return Payment::find($paymentId);         
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
               'amortization_date', '=', $currentDay
            )
            ->where([ 'loan_account_id' => $value->loan_account_id, 'status' => 'open' ])
            ->update(['status' => 'delinquent']);

         if ($delinquents) $counter++;
      }
   }

   public function checkAmortizationStatus($loanAccountId) {

      $amortization = Amortization::whereIn('status', ['open', 'delinquent'])->where(['loan_account_id' => $loanAccountId])->get();

      return $amortization;
   }	

}
