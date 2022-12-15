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

   const STATUS_RELEASED = "released";
   const STATUS_PENDING = "pending";
   const PAYMENT_PAID = "Paid";
   const PAYMENT_CURRENT = "Current";
   const PAYMENT_DELINQUENT = "Delinquent";
   const LOAN_ONGOING = "Ongoing";
   const LOAN_PAID = "Paid";
   const LOAN_PASTDUE = "Past Due";
   const LOAN_WRITEOFF = "Write-Off";

   public static function generateAccountNum($branchCode, $productCode, $identifier = 1) {
      // compute for the document transaction
      $accounNum = NULL;

      $num = LoanAccount::where('account_num', 'LIKE', '%'.$branchCode . '-' .$productCode.'%')->get()->pluck('account_num')->last();

      if( $num ){
         $series = explode('-', $num);
         $identifier = (int)$series[2] + 1;
      }

      return $branchCode . '-' .$productCode . '-' . str_pad($identifier, 7, '0', STR_PAD_LEFT);
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
   //    return Borrower::with(['businessInfo','employmentInfo','householdMembers','outstandingObligations'])->find($this->borrower_id);
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
      return $this->hasMany(Payment::class, 'loan_account_id')->whereIn('status', ['paid', 'cancelled']);
   }


   public function overrideReleaseAccounts($filters = array()) {

      $branch = Branch::find($filters['branch_id']);
      $accounts = LoanAccount::where('status', '=', 'pending')->where(['branch_code' => $branch->branch_code]);

      if( isset($filters['transaction_date']) && $filters['transaction_date'] ){
         $accounts->whereDate('loan_accounts.transaction_date', '=', $filters['transaction_date'] );
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

   public function releasedAccounts($filters = array()) {

      $branch = Branch::find($filters['branch_id']);
      $accounts = LoanAccount::where('status', '=', 'released')->where(['branch_code' => $branch->branch_code]);

      if( isset($filters['date_release']) && $filters['date_release'] ){
         $accounts->whereDate('loan_accounts.date_release', '=', $filters['date_release'] );
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

   public function currentAmortization($loanAccountId, $dateNow) {

      // get current amortization
      $amortization = Amortization::whereDate('amortization_date', '<=', $dateNow)
                     ->where('loan_account_id', $loanAccountId)
                     ->whereIn('status', ['open', 'delinquent', 'paid'])
                     ->orderBy('amortization_date', 'DESC')
                     ->limit(1)
                     ->first();


      if( (isset($amortization->status) && $amortization->status == 'paid') || $amortization == null ){

         $amortization = Amortization::whereDate('amortization_date', '>', $dateNow)
                     ->where('loan_account_id', $loanAccountId)
                     ->whereIn('status', ['open', 'delinquent'])
                     ->orderBy('amortization_date', 'ASC')
                     ->limit(1)
                     ->first();
      }

      return $amortization;
   }

   public function getCurrentAmortization(){
      $tranDate = new EndTransaction();
      $transactionDateNow = $tranDate->getTransactionDate($this->branch->branch_id)->date_end;

      if( $this->status == LoanAccount::STATUS_PENDING ){
         return false;
      }

      $hasSchedule = Amortization::where('loan_account_id', $this->loan_account_id)->get();

      if( !count($hasSchedule) ){
         return false;
      }


      if( $this->loan_status == LoanAccount::LOAN_PAID){
         return;
      }

      $amortization = $this->currentAmortization($this->loan_account_id, $transactionDateNow);

      // check if past due
      $isPastDue = $this->checkPastDue($this->due_date, $transactionDateNow);
      if( $isPastDue && $amortization ){
         // update loan status.
         // set current amortization status to delinquent/
         // var_dump($this->loan_account_id);
         if($this->loan_status == LoanAccount::LOAN_WRITEOFF){
            LoanAccount::where(['loan_account_id' => $this->loan_account_id])->update(['loan_status' => LoanAccount::LOAN_PASTDUE]);
         }
         $amortization->status = 'delinquent';
         $amortization->save();

         $amortization->pdi = $this->getPDI($this->loan_amount, $this->interest_rate, $isPastDue);
      }
      $amortization->pdi = $amortization->pdi ? $amortization->pdi : 0;

      # compute for total payables
      # compute for total payments
      # get last payment
      if ( $amortization ) {
         // check and set previous schedule to delinquent if unpaid (missed)
         $this->setDelinquent($this->loan_account_id, $amortization->id, $transactionDateNow);
         // return $this->getMissedPayments($this->loan_account_id, $amortization->id);

         // get advance principal
         $amortization->advance_principal = $this->getAdvancePrincipal($this->loan_account_id, $amortization->id);
         $amortization->advance_interest = $this->getAdvanceInterest($this->loan_account_id, $amortization->id);
         // get delinquents
         $amortization->delinquent = $this->getDelinquent($this->loan_account_id, $amortization->id, $amortization->advance_principal);
         $amortization->short_principal = $amortization->delinquent['principal'] - (in_array($amortization->id, $amortization->delinquent['ids']) ? $amortization->principal : 0);
         $amortization->short_interest = $amortization->delinquent['interest'] - (in_array($amortization->id, $amortization->delinquent['ids']) ? $amortization->interest : 0);
         $amortization->schedule_principal = $amortization->principal;
         $amortization->schedule_interest = $amortization->interest;
         $amortization->short_pdi = 0;
         $amortization->short_penalty = $amortization->delinquent['penalty'];
         // check if current amortization is paid partially.
         $isPaid = $this->getPayment($this->loan_account_id, $amortization->id)->last();
         if( $isPaid && ($isPaid->short_principal || $isPaid->short_interest) ){

            $amortization->total = $amortization->total - ($amortization->principal + $amortization->interest);
            $amortization->principal = 0;
            $amortization->interest = 0;
            $amortization->short_principal = $isPaid->short_principal;
            $amortization->short_interest = $isPaid->short_interest;
            $amortization->short_penalty = $isPaid->short_penalty;
            $amortization->over_payment = $isPaid->over_payment;
         }
         $currentDay = Carbon::createFromFormat('Y-m-d', $transactionDateNow);
         $dateSched = Carbon::createFromFormat('Y-m-d', $amortization->amortization_date);
         $dateSchedPension = Carbon::createFromFormat('Y-m-d', $amortization->amortization_date)->startOfMonth();
         $dayDiff = $dateSched->diffInDays($currentDay, false);
         $dayDiffPension = $dateSchedPension->diffInDays($currentDay, false);
         $penaltyMissed = $amortization->delinquent['missed'];
         $amortization->day_late = $dayDiff;
         if($this->getPaymentTotal($this->loan_account_id)){ // condition that checks if not the first payment
            if($this->product->product_name != "Pension Loan"){
               if($dayDiff < 0){
                  $amortization->principal = 0;
                  $amortization->interest = 0;
               }
            }else{
               if($dayDiffPension < 0){
                  $amortization->principal = 0;
                  $amortization->interest = 0;
               }
            }
         }
         if($dayDiff > 0 && !$isPaid && $amortization->advance_principal < $amortization->schedule_principal){
            Amortization::find($amortization->id)->update(['status' => 'delinquent']);
            $amortization->delinquent = $this->getDelinquent($this->loan_account_id, $amortization->id, $amortization->advance_principal);
         }
         if($dayDiff > 10 && !$isPaid && $amortization->advance_principal < $amortization->schedule_principal){
            $penaltyMissed = array_merge($amortization->delinquent['missed'], [$amortization->id]);
         }
         $amortization->penalty = $this->getPenalty($penaltyMissed, ($amortization->schedule_principal + $amortization->schedule_interest), $transactionDateNow);

         // $amortization->penalty = $this->getPenalty($amortization->delinquent['missed'], ($amortization->principal + $amortization->interest));
         $amortization->total = ($amortization->principal + $amortization->interest) + ( $amortization->short_principal + $amortization->short_interest);
         $amortization->totalPaid = $this->getPaymentTotal($this->loan_account_id);
         $amortization->outstandingBalance = $this->outstandingBalance($this->loan_account_id);

      }

      return $amortization;
   }

   public function getPrevAmortization($loanAccountId, $amortizationId, $status = ['open'], $refId = null, $single = false, $order = 'ASC') {

      $cond = '<';
      $current = Amortization::find($amortizationId);
      if($current->status === 'delinquent'){
         $cond = '<=';
      }
      $amortizations = Amortization::where('loan_account_id', $loanAccountId)
                        ->whereIn('status', $status)
                        ->where('id', $cond, $amortizationId);

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

      } else {
         $delinquents = $this->getPrevAmortization($loanAccountId, $amortizationId, ['delinquent'], null, false, 'DESC');
      }

      $ids = [];
      $missed = [];
      $totalPrincipal = 0;
      $totalInterest = 0;
      $missed = [];
      $totalPdi = 0;
      $totalPenalty = 0;


      // identify missed payments
      if( $delinquents ){

         foreach ($delinquents as $delinquent) {

            $payments = $this->getPayment($loanAccountId, $delinquent->id);
            $delinquent->payments = $payments;

         }

         foreach ($delinquents as $delinquent) {

            $ids[] = $delinquent->id;

            if( isset($delinquent->payments) && count($delinquent->payments) > 0 ) {
               $isNotAdvancePayment = true;
               foreach ($delinquent->payments as $payment) {
                  $totalPrincipal += $payment->short_principal;
                  $totalInterest += $payment->short_interest;
                  $totalPdi += $payment->short_pdi;
                  $totalPenalty += $payment->short_penalty;
                  $isNotAdvancePayment = (boolean)$payment->total_payable;
                  break;
               }
               if(!$isNotAdvancePayment){ // if advanced payment only add principal and interest
                  $totalPrincipal += $delinquent->principal;
                  $totalInterest += $delinquent->interest;
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
      }

      if( count($ids) ){
         LoanAccount::find($loanAccountId)->update(['payment_status' => 'Delinquent']);
      }

      return [
         'ids' => $ids,
         'principal' => $totalPrincipal,
         'interest' => $totalInterest,
         'penalty' => $totalPenalty,
         'pdi' => $totalPdi,
         'advance' => $advancePrincipal,
         'missed' => $missed
      ];
   }

   public function setDelinquent($loanAccountId, $amortizationId, $currentDay){
      $currentDay = Carbon::createFromFormat('Y-m-d', $currentDay);
      $amortizations = $this->getPrevAmortization($loanAccountId, $amortizationId);

      if( count($amortizations) > 0 ) {

         foreach ($amortizations as $amortization) {

            $schedDate = Carbon::createFromFormat('Y-m-d', $amortization->amortization_date);

            if( $amortization->id > $amortizationId ){
               continue;
            }

            if( !$currentDay->lessThanOrEqualTo($schedDate) ){
               $amortization->status = 'delinquent';
               $amortization->save();
            }
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

   public function getPaymentTotalPrincipalInterest($loanAccountId){

      $paymentTotal = 0;
      $payments = $this->getPayment($loanAccountId);

      foreach ($payments as $payment) {
         $paymentTotal += $payment->principal;
         $paymentTotal += $payment->interest;
         $paymentTotal += $payment->rebates;
      }

      return $paymentTotal;
   }

   public function checkPastDue($dueDate,$dateNow) {

      $currentDay = Carbon::createFromFormat('Y-m-d', $dateNow);
      $dDate = Carbon::createFromFormat('Y-m-d', $dueDate);

      if ( $dDate->lt($currentDay) ){

         return $currentDay->diffInDays($dDate);
      }

      return 0;
   }

   public function getAdvancePrincipal($loanAccountId, $amortizationId) {
      $principal = 0;
      $paymentInfo = Payment::where([ 'loan_account_id' => $loanAccountId, 'status' => 'paid'])
                              ->orderBy('payment_id', 'DESC')
                              ->first();
      return $paymentInfo ? $paymentInfo->advance_principal : 0;
   }

   public function getAdvanceInterest($loanAccountId, $amortizationId) {
      $principal = 0;
      $paymentInfo = Payment::where([ 'loan_account_id' => $loanAccountId, 'status' => 'paid'])
                              ->orderBy('payment_id', 'DESC')
                              ->first();
      return $paymentInfo ? $paymentInfo->advance_interest : 0;
   }

   public function getPDI($amount, $rate, $days) {

      $perDay = ($amount * ( $rate/100 )) * 12 / 365;
      return round($perDay * $days);
   }

   public function getPenalty($missed = [], $totalAmortization, $dateNow, $percent = 2) {

      $penalty = 0;

      if( count($missed) ){

         $currentDay = Carbon::createFromFormat('Y-m-d', $dateNow);
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

   public function daysMissed($missed = [], $dateNow = '', $firstOnly = false) {
      $dateNow = $dateNow ? $dateNow : Carbon::now()->format('Y-m-d');
      $missedDays = 0;

      if( count($missed) ){

         $currentDay = Carbon::createFromFormat('Y-m-d', $dateNow);
         $amortizations = Amortization::whereIn('id', $missed)->orderBy('id', 'ASC')->get();

         foreach ($amortizations as $amortization) {

            $dateSched = Carbon::createFromFormat('Y-m-d', $amortization->amortization_date);
            $dayDiff = $currentDay->diffInDays($dateSched);

            if( $dayDiff > 10 ){
               $missedDays += $dayDiff;
               if($firstOnly){
                  return $dayDiff;
               }
            }
         }


      }

      return $missedDays;
   }

   public function outstandingBalance($loanAccountId) {

      $account = LoanAccount::where(['loan_account_id' => $loanAccountId])->first();
      $payment = $this->getPaymentTotalPrincipalInterest($loanAccountId);

      return ($account->loan_amount + $account->interest_amount) - $payment;
   }

   public function amortization(){
      $account = LoanAccount::where(['loan_account_id' => $this->loan_account_id])->first();
      return [
         "principal" => ceil($account->loan_amount/$account->no_of_installment),
         "interest" => ceil($account->interest_amount/$account->no_of_installment),
         "total" => ceil($account->interest_amount/$account->no_of_installment) + ceil($account->loan_amount/$account->no_of_installment),
      ];
   }

   public function remainingBalance() {

      $account = LoanAccount::where(['loan_account_id' => $this->loan_account_id])->first();
      $payments = Payment::where(['loan_account_id' => $this->loan_account_id, 'status' => 'paid'])->orderBy('payment_id', 'DESC')->get();

      $accountSummary = [
         'memo' => [
            'account' => '',
            'balance' => 0,
         ],
         'principal' => [
            'debit' => $account->loan_amount,
            'credit' => 0,
            'balance' => 0,
         ],
         'interest' => [
            'debit' => $account->interest_amount,
            'credit' => 0,
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

      $currentAmortization = $account->getCurrentAmortization();

      if( $currentAmortization ) {
         $accountSummary['penalty']['debit'] = $currentAmortization->penalty + $currentAmortization->short_penalty;
         $accountSummary['pdi']['debit'] = $currentAmortization->pdi;
      }

      if( count($payments) ) {

         foreach ($payments as $payment) {

            $accountSummary['principal']['credit'] += $payment->principal;
            $accountSummary['interest']['credit'] += $payment->interest;

            if( !$payment->penalty_approval_no ) {
                $accountSummary['penalty']['credit'] += $payment->penalty;
            }

            if( !$payment->pdi_approval_no ) {
                $accountSummary['pdi']['credit'] += $payment->pdi;
            }

            if( $payment->rebates_approval_no ) {
                $accountSummary['rebates']['credit'] += $payment->rebates;
            }
         }
      }

      $accountSummary['penalty']['debit'] += $accountSummary['penalty']['credit'];
      $accountSummary['pdi']['debit'] += $accountSummary['pdi']['debit'] ? 0 : $accountSummary['pdi']['credit'];
      // calculate balance
      $accountSummary['principal']['balance'] = $accountSummary['principal']['debit'] - $accountSummary['principal']['credit'];
      $accountSummary['interest']['balance'] =  $accountSummary['interest']['debit'] - $accountSummary['interest']['credit'];
      $accountSummary['penalty']['balance'] =  $accountSummary['penalty']['debit'] - $accountSummary['penalty']['credit'];
      $accountSummary['pdi']['balance'] =  $accountSummary['pdi']['debit'] - $accountSummary['pdi']['credit'];
      $accountSummary['rebates']['balance'] =  $accountSummary['rebates']['debit'] - $accountSummary['rebates']['credit'];

      $accountSummary['memo']['account'] = $account->account_num;
      $accountSummary['memo']['balance'] = $accountSummary['principal']['balance'] + $accountSummary['interest']['balance'] + $accountSummary['penalty']['balance'] + $accountSummary['pdi']['balance'] + $accountSummary['rebates']['balance'];

      return $accountSummary;

   }

   public function collectionRate(){
      return round( ( ($this->remainingBalance()['principal']['credit'] + $this->remainingBalance()['interest']['credit'] + $this->remainingBalance()['rebates']['credit']) / ($this->remainingBalance()['principal']['debit'] + $this->remainingBalance()['interest']['debit']) ) * 100);
   }

}


