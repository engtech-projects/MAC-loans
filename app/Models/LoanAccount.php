<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Str;
use Storage;
use File;


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

   public function getDocs($borrowerId, $loanAccountId) {
      
      $main = 'borrowers/';
      $identifier = $borrowerId . '/';
      $folder = $loanAccountId.'/';

      $dir = $main . $identifier . $folder;
      $files = Storage::files('public/' . $dir);
      $docs = [];

      if( count($files) > 0 ){

            foreach ($files as $file) {
                $docs[] = url(Str::replace('public', 'storage', $file));
            }
            
            return $docs;
         }

      return false;
   }

   public function setDocs($borrowerId, $loanAccountId, $files) {

      $root = storage_path('app/public/');
      $main = 'borrowers/';
      $identifier = $borrowerId . '/';
      $folder = $loanAccountId.'/';

      $dir = $main . $identifier . $folder;

      // check if folder exists
      if( !File::isDirectory($root . $dir) ){
         // create folder
         File::makeDirectory($root . $dir, 0777, true, true);
      }

      
      foreach ($files as $file) {
         $name = $file->getClientOriginalName();
         $file->storeAs('public/' . $dir, $name);
      }
     
   }

   public function cashVoucher() {

      if( $this->status != 'released' ){
         return false;
      }

      $glAccounts = GeneralLedger::where(['type' => 'releasing'])->get();

      $cashVoucher = [];

      foreach ($glAccounts as $gl) {
         
         if( $gl->loans == 'Cash'  ){

            if( $this->release_type == 'Cash' || $this->release_type == 'Cash Release'){
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

         if( $gl->loans == 'Check'  ){
            
             if( $this->release_type == 'Check' || $this->release_type == 'Check Release'){
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

         if( $value['reference'] == 'Loan Receivable' ){
             $cashVoucher[$key]['debit'] = $this->loan_amount;
         }

         if( $value['reference'] == 'Check' ){
             $cashVoucher[$key]['credit'] = $this->net_proceeds;
         }

         if( $value['reference'] == 'Cash' ){
             $cashVoucher[$key]['credit'] = $this->net_proceeds;
         }

         if( $value['reference'] == 'Filing Fee' ){
             $cashVoucher[$key]['credit'] = $this->filing_fee;
         }

         if( $value['reference'] == 'Documentary Stamp' ){
             $cashVoucher[$key]['credit'] = $this->document_stamp;
         }

         if( $value['reference'] == 'Insurance' ){
             $cashVoucher[$key]['credit'] = $this->insurance;
         }

         if( $value['reference'] == 'Notarial' ){
             $cashVoucher[$key]['credit'] = $this->notarial_fee;
         }

         if( $value['reference'] == 'Prepaid' ){
             $cashVoucher[$key]['credit'] = $this->prepaid_interest;
         }

         if( $value['reference'] == 'Others' ){
             $cashVoucher[$key]['credit'] = $this->affidavit_fee;
         }

         if( $value['reference'] == 'Memo' ){
             $cashVoucher[$key]['credit'] = $this->memo;
         }

      }

      return $cashVoucher;
   }

   public function payments() {
      return $this->hasMany(Payment::class, 'loan_account_id')->where(['status' => 'paid']);
   }

   public function overrideReleaseAccounts($filters = array()) {        

      $accounts = LoanAccount::where('status', '=', 'pending');

      if( isset($filters['created_at']) && $filters['created_at'] ){
         $accounts->whereDate('loan_accounts.created_at', '=', $filters['created_at'] );
      }

      if( isset($filters['ao_id']) && $filters['ao_id'] != 'all' ){
         $accounts->where('loan_accounts.ao_id', '=', $filters['ao_id']);
      }

      if( isset($filters['center_id']) && $filters['center_id'] != 'all' ){
         $accounts->where('loan_accounts.center_id', '=', $filters['center_id']);
      }

      if( isset($filters['product_id']) && $filters['product_id'] != 'all' ){
         $accounts->where('loan_accounts.product_id', '=', $filters['product_id']);
      }

      return $accounts->get();
   }

   public function currentAmortization($loanAccountId) {

      // get current amortization
      $amortization = Amortization::whereDate('amortization_date', '<=', Carbon::now()->format('Y-m-d'))
                     ->where('loan_account_id', $loanAccountId)
                     ->whereIn('status', ['open', 'delinquent', 'paid'])
                     ->orderBy('amortization_date', 'DESC')
                     ->limit(1)
                     ->first();

    
      if( (isset($amortization->status) && $amortization->status == 'paid') || $amortization == null ){

          $amortization = Amortization::whereDate('amortization_date', '>', Carbon::now()->format('Y-m-d'))
                     ->where('loan_account_id', $loanAccountId)
                     ->whereIn('status', ['open', 'delinquent'])
                     ->orderBy('amortization_date', 'ASC')
                     ->limit(1)
                     ->first();
      }

      return $amortization;
   }

   public function getPrevAmortization($loanAccountId, $amortizationId, $status = ['open'], $refId = null, $single = false, $order = 'ASC') {

      $amortizations = Amortization::where('loan_account_id', $loanAccountId)
                        ->whereIn('status', $status)
                        ->where('id', '<=', $amortizationId);

      if( $refId ) {

         $amortizations->where('id', '>=', $refId);

      }

      $amortizations->orderBy('id', $order);

      if( $single ){

         return $amortizations->first();

      }

      return $amortizations->get();
   }

   public function getDelinquent($loanAccountId, $amortizationId, $advancePrincipal = 0) {

      $lastPaidAmort = $this->getPrevAmortization($loanAccountId, $amortizationId, ['paid'], null, true, 'DESC');
      $delinquents = null;

      if( $lastPaidAmort ){

         $delinquents = $this->getPrevAmortization($loanAccountId, $amortizationId, ['delinquent'], $lastPaidAmort->id, false, 'DESC');

         foreach ($delinquents as $delinquent) {
            
            $payments = $this->getPayment($loanAccountId, $delinquent->id);
            $delinquent->payments = $payments;

         }

      } else {
         $delinquents = $this->getPrevAmortization($loanAccountId, $amortizationId, ['delinquent']);
      }

      $ids = [];
      $missed = [];
      $totalPrincipal = 0;
      $totalInterest = 0;
      $missed = [];

      // identify missed payments
      if( $delinquents ){

         foreach ($delinquents as $delinquent) {
            
            $ids[] = $delinquent->id;

            if( isset($delinquent->payments) && count($delinquent->payments) > 0 ) {
               foreach ($delinquent->payments as $payment) {
                     
                     $totalPrincipal += $payment->short_principal;
                     $totalInterest += $payment->short_interest;

                 break;
               }
               break;
            }else{
               $missed[] = $delinquent->id;
            }

            $totalPrincipal += $delinquent->principal;
            $totalInterest += $delinquent->interest;
         }
      }

      if( $advancePrincipal ){

         if( count($missed) > 0 ){
            $balance = $advancePrincipal;
            // $balance = 0;
            $missedAmortizations = Amortization::whereIn('id', $missed)->orderBy('id', 'ASC')->get();

            foreach ($missedAmortizations as $key => $missedAmortization) {
               
               if( $balance >=  $missedAmortization->principal){
                  $balance -= $missedAmortization->principal;
                  $pos = array_search($missedAmortization->id, $missed);
                  unset($missed[$pos]);
               }else{
                  // LoanAccount::find($loanAccountId)->update(['payment_status' => 'Delinquent']);
                  break;
               }
            }
         }
      }else{

         if( count($ids) ){
            LoanAccount::find($loanAccountId)->update(['payment_status' => 'Delinquent']);
         }

      }
      
      return [ 
         'ids' => $ids, 
         'principal' => $totalPrincipal, 
         'interest' => $totalInterest,
         'advance' => $advancePrincipal,
         'missed' => $missed
      ];
   }

   public function setDelinquent($loanAccountId, $amortizationId){

      $amortizations = $this->getPrevAmortization($loanAccountId, $amortizationId);
      
      if( count($amortizations) > 0 ) {

         foreach ($amortizations as $amortization) {

            if( $amortization->id == $amortizationId ){
               continue;
            }

            $amortization->status = 'delinquent';
            $amortization->save();
         }
      }
      return $amortizations;
   }

   public function getPayment($loanAccountId, $amortizationId = null) {

      if( !$amortizationId ){
         return Payment::where(['loan_account_id' => $loanAccountId, 'status' => 'paid'])->get();
      }

      return Payment::where(['loan_account_id' => $loanAccountId, 'status' => 'paid', 'amortization_id' => $amortizationId ])->get();
   }

   public function getPaymentTotal($loanAccountId){

      $paymentTotal = 0;
      $payments = $this->getPayment($loanAccountId);

      foreach ($payments as $payment) {
         $paymentTotal += $payment->amount_applied;
      }

      return $paymentTotal;
   }

   public function getCurrentAmortization(){

      if( $this->status == 'pending' ){
         return false;
      }

      $hasSchedule = Amortization::where('loan_account_id', $this->loan_account_id)->get();

      if( !count($hasSchedule) ){
         return false;
      }


      if( $this->loan_status == 'paid' ){
         // go where?
         return;
      }

      $amortization = $this->currentAmortization($this->loan_account_id);
      return $amortization;
      // check if past due
      $isPastDue = $this->checkPastDue($this->due_date);

      if( $isPastDue ){
         // update loan status.
         // set current amortization status to delinquent/
         LoanAccount::where(['loan_account_id' => $this->loan_account_id])->update(['loan_status' => 'Past Due']);
         $amortization->status = 'delinquent';
         $amortization->save();

         $amortization->pdi = $this->getPDI($this->loan_amount, $this->interest_rate, $isPastDue);
      }


      // check and set previous schedule to delinquent if unpaid (missed)
      $this->setDelinquent($this->loan_account_id, $amortization->id);
      // return $this->getMissedPayments($this->loan_account_id, $amortization->id);

      # compute for total payables
      # compute for total payments
      # get last payment
   	if ( $amortization ) {
         // check if current amortization is paid partially.
         $isPaid = $this->getPayment($this->loan_account_id, $amortization->id);

         if( count($isPaid) > 0 ){

            $amortization->total = $amortization->total - ($amortization->principal + $amortization->interest);
            $amortization->principal = 0;
            $amortization->interest = 0;

         }
         // get advance principal
         $amortization->advance_principal = $this->getAdvancePrincipal($this->loan_account_id, $amortization->id);
         // get delinquents
         $amortization->delinquent = $this->getDelinquent($this->loan_account_id, $amortization->id, $amortization->advance_principal);
         $amortization->short_principal = $amortization->delinquent['principal'];
         $amortization->short_interest = $amortization->delinquent['interest'];
         $amortization->penalty = $this->getPenalty($amortization->delinquent['missed'], ($amortization->principal + $amortization->interest));
         $amortization->total = ($amortization->principal + $amortization->interest) + ( $amortization->short_principal + $amortization->short_interest);
         $amortization->totalPaid = $this->getPaymentTotal($this->loan_account_id);
         $amortization->outstandingBalance = $this->outstandingBalance($this->loan_account_id);
   	}

      return $amortization;
   }

   public function checkPastDue($dueDate) {

      $currentDay = Carbon::createFromFormat('Y-m-d', Carbon::now()->format('Y-m-d'));
      $dDate = Carbon::createFromFormat('Y-m-d', $dueDate);
      
      if ( $dDate->lt($currentDay) ){

         return $currentDay->diffInDays($dDate);
      }

      return 0;
   }

   public function getAdvancePrincipal($loanAccountId, $amortizationId) {
      // get last paid amortization
      $lastPaidAmort = $this->getPrevAmortization($loanAccountId, $amortizationId, ['paid'], null, true, 'DESC');
      $principal = 0;
      if ( $lastPaidAmort ){
         // get payment info
         $paymentInfo = Payment::where([ 'loan_account_id' => $loanAccountId, 'amortization_id' => $lastPaidAmort->id ])
                                 ->orderBy('payment_id', 'DESC')
                                 ->first();

         $principal = (isset($paymentInfo->advance_principal) ? $paymentInfo->advance_principal : 0);
      }

      return $principal;
   }

   public function getPDI($amount, $rate, $days) {

      $perDay = ($amount * ( $rate/100 )) * 12 / 365;
      return round($perDay * $days);

   } 

   public function getPenalty($missed = [], $totalAmortization, $percent = 2) {

      $penalty = 0;

      if( count($missed) ){

         $currentDay = Carbon::createFromFormat('Y-m-d', Carbon::now()->format('Y-m-d'));
         $amortizations = Amortization::whereIn('id', $missed)->orderBy('id', 'ASC')->get();
         $counter = 0;

         foreach ($amortizations as $amortization) {
         
            $dateSched = Carbon::createFromFormat('Y-m-d', $amortization->amortization_date);
            $dayDiff = $currentDay->diffInDays($dateSched);

            if( $dayDiff > 10 ){
               $counter++;
            }
         }

         $penalty = ($totalAmortization * ( $percent/100 )) * $counter ;
      }

      return $penalty;
   }

   public function outstandingBalance($loanAccountId) {

      $account = LoanAccount::where(['loan_account_id' => $loanAccountId])->first();
      $payment = $this->getPaymentTotal($loanAccountId);

      return ($account->loan_amount + $account->interest_amount) - $payment;

   }

}
