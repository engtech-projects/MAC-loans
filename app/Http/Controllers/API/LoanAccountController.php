<?php

namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Requests\UpdateCoMakerRequest;
use Illuminate\Http\Request;
use App\Models\Borrower;
use App\Models\LoanAccount;
use App\Models\Document;
use App\Models\Product;
use App\Models\Amortization;
use App\Models\Branch;
use App\Models\ChartOfAccounts;
use App\Models\Payment;
use Carbon\Carbon;
use App\Http\Resources\Borrower as BorrowerResource;
use App\Http\Resources\LoanAccount as LoanAccountResource;
use App\Http\Resources\Amortization as AmortizationResource;
use App\Jobs\FixShortAdvMigration;
use App\Models\LoanAccountMigrationFix;

class LoanAccountController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function showLoanAccount(LoanAccount $account) {
        return $this->sendResponse(new LoanAccountResource($account), 'Account fetched.');
    }

    public function showLoanDetails(LoanAccount $account) {

        $loan_details = $account->getLoanDetails();


        //return $this->sendResponse(new LoanAccountResource($account),'Loan details fetched');
        return $this->sendResponse($loan_details,'Loan details fetched');
        //return $account->showLoanDetails();

    }

    public function getRemainingBalance(LoanAccount $account) {
        return $this->sendResponse($account->remainingBalance(), 'Remaining Balance fetched');
    }


    public function showCurrentAmortization(LoanAccount $account) {
        $data = $account->getAmortization();

        return $this->sendResponse($data,'Amortization details fetched');
    }


    public function accountRetagging(Request $request,$branchId) {
        return $branchId;
    }


	/**
     * Store a newly created resource in storage.
     */
    public function createLoanAccount(Request $request, Borrower $borrower) {
        // $branchCode = Branch::find(session()->get('branch_id'))->branch_code;
        # to be replaced when branch is fetched through session.
        $branch = Branch::find($request->input('branch_id'));
        $product = Product::find($request->input('product_id'));

        $request->merge([
            'cycle_no' => LoanAccount::getCycleNo($borrower->borrower_id),
            'status' => 'pending',
            'account_num' => '',
            'borrower_num' =>  $borrower->borrower_num,
            'borrower_id' =>  $borrower->borrower_id,
            'branch_code' => $branch->branch_code,
        ]);

        $account = LoanAccount::create($request->input());
        $account->account_num = LoanAccount::generateAccountNum($branch->branch_code, $product->product_code);
        $account->save();

        if( $account->loan_account_id ) {
            Document::create(
                array_merge(
                    $request->input('documents'),
                    ['loan_account_id' => $account->loan_account_id ],
                )
            );


            if( $request->hasFile('loanfiles') ) {
                $account->setDocs($account->borrower_id, $account->loan_account_id, $request->file('loanfiles'));
            }
        }

    	return $this->sendResponse($account, 'Account fetched.');

    }

	public function updateLoanAccount(Request $request, LoanAccount $account) {
		if($request->input('data')){
			$request->request->add(objToArray(json_decode($request->input('data'))));
		}
        $account->fill($request->input());
        $account->save();
        if($request->input('data')) {

            $document = Document::find($request->input('documents')['id']);

            if( $document ) {
                $document->description = ($request->input('documents')['description']);
                $document->bank = ($request->input('documents')['bank']);
                $document->account_no = ($request->input('documents')['account_no']);
                $document->card_no = ($request->input('documents')['card_no']);
                $document->promissory_number = ($request->input('documents')['promissory_number']);
                $document->save();
            }else if($request->input('documents')) {
                Document::create(
                    array_merge(
                        $request->input('documents'),
                        ['loan_account_id' => $account->loan_account_id ],
                    )
                );
            }

            if( $request->hasFile('loanfiles') ) {
                $files[] = $request->file('loanfiles');
                $account->setDocs($account->borrower_id, $account->loan_account_id, $files);
            }
        }
        return $this->sendResponse(new LoanAccountResource($account), 'Account Updated.');
    }

    // yyyy-mm-dd format
    // get override release accounts
    public function overrideAccountList(Request $request) {
        $filters = [
            'transaction_date' => ($request->has('transaction_date')) ? $request->input('transaction_date') : 'all',
            'ao_id' => ($request->has('ao_id')) ? $request->input('ao_id') : 'all',
            'center_id' => ($request->has('center_id')) ? $request->input('center_id') : 'all',
            'product_id' => ($request->has('product_id')) ? $request->input('product_id') : 'all',
            'branch_id' => ($request->has('branch_id')) ? $request->input('branch_id') : 'all',
        ];

        $accounts = new LoanAccount();
        $accounts = $accounts->overrideReleaseAccounts($filters);
        return $this->sendResponse($accounts, 'List.');
    }

    // yyyy-mm-dd format
    // get released accounts
    public function releasedAccountList(Request $request) {
        $filters = [
            'date_release' => ($request->has('date_release')) ? $request->input('date_release') : 'all',
            'ao_id' => ($request->has('ao_id')) ? $request->input('ao_id') : 'all',
            'center_id' => ($request->has('center_id')) ? $request->input('center_id') : 'all',
            'product_id' => ($request->has('product_id')) ? $request->input('product_id') : 'all',
            'branch_id' => ($request->has('branch_id')) ? $request->input('branch_id') : 'all',
        ];

        $accounts = new LoanAccount();
        $accounts = $accounts->releasedAccounts($filters);
        return $this->sendResponse($accounts, 'List.');
    }

    // yyyy-mm-dd format
    // get rejected release accounts
    public function rejectedAccountList($branchId) {

        $branch = Branch::find($branchId);

        $rejectedAccounts = LoanAccount::where(['status' => 'rejected', 'branch_code' => $branch->branch_code])->get();
        return $this->sendResponse(LoanAccountResource::collection($rejectedAccounts), 'List.');
    }

    public function override(Request $request) {

        foreach ($request->input() as $key => $value) {

            $account = LoanAccount::find($value['loan_account_id']);

            $account->transaction_date = $value['transaction_date'];
            $account->date_release = $value['date_release'];
            $account->due_date = $value['due_date'];
            $account->status = 'released';
            $account->loan_status = 'Ongoing';
            $account->update();

            $this->createAmortizationSched($account);
        }
        return $this->sendResponse(['status' => 'released'], 'Released');
    }

    public function updateAccountAmortization(LoanAccount $account) {

        $account = LoanAccount::find($account->loan_account_id);

        $account->transaction_date = $account->transaction_date;
        $account->date_release = $account->date_release;
        $account->due_date = $account->due_date;
        $account->update();

        $this->createAmortizationSched($account);

        return $this->sendResponse(['status' => 'released'], 'Released');
    }

    public function reject(Request $request, LoanAccount $account) {

        if( $account->memo > 0 ){
            Payment::where(['reference_id' => $account->loan_account_id])->delete();
        }

        $account->status = 'rejected';
        $account->save();

        return $this->sendResponse(['status' => 'rejected'], 'Rejected');
    }

    public function destroy($id) {

        // if( $user->hasAccess('delete releases') ) {
        //     return 'has acccess';
        // }else{
        //     return 'no access';
        // }

        $loanAccount = LoanAccount::find($id);
        //get document
        $document = new Document();


        if( $loanAccount->memo > 0 ){
            Payment::where(['reference_id' => $loanAccount->loan_account_id])->delete();
        }

        //delete document
        $document->deleteDocument($loanAccount->loan_account_id);
        $loanAccount->delete();
        return $this->sendResponse(['status' => 'Account deleted'], 'Deleted');
    }

    public function generateAmortizationSched(Request $request) {
        $amortization = new Amortization();
        $dateRelease = ($request->input('date_release')? $request->input('date_release') : date('Y-m-d'));
        $account = LoanAccount::find($request->input('loan_account_id'));
        return $this->sendResponse(($amortization->createAmortizationSched($account, $dateRelease)), 'Amortization Schedule Drafted');
    }

    public function generateSMESched(Request $request) {
        $amortization = new Amortization();
        $dateRelease = ($request->input('date_release')? $request->input('date_release') : date('Y-m-d'));
        $account = LoanAccount::find($request->input('loan_account_id'));
        return $this->sendResponse(($amortization->specialSchedule($account, $dateRelease)), 'Amortization Schedule Drafted');
    }

    public function createAmortizationSched(LoanAccount $account) {

        $amortization = new Amortization();
        $amortization->storeAmortizationSched($account);
    }

    public function getPromissoryNo(Request $request) {

        $branch = Branch::find($request->input('branch_id'));
        $product = Product::find($request->input('product_id'));

        $document = new Document();

        return $document->getPromissoryNo($branch->branch_code, $product->product_code);
    }

    public function cashVoucher(LoanAccount $account) {

        $account->cash_voucher = $account->cashVoucher();

        return $this->sendResponse($account, 'Account fetched.');
    }

    public function statement(Borrower $borrower) {
        $accounts = $borrower->loanAccounts();

        $accountDetails = [];
        if($accounts) {

            foreach ($accounts as $account) {

                $accountDetails[] = [
                    "account_id" => $account->loan_account_id,
                    'account_num' => $account->account_num,
                    'loan_amount' =>  $account->loan_amount,
                    'date_granted' => $account->date_release,
                    'term' => $account->terms,
                    'collection_rate' => $account->collectionRate($account->remainingBalance), //$account->collectionRateSOA($account->remainingBalance),
                    'payment_history' => $account->payment_status,
                    'loan_status' => $account->loan_status,
                    'amortization' => $account->amortization(),
                ];

            }
        }
        return $accountDetails;
    }

    public function updateCoMaker(UpdateCoMakerRequest $request,LoanAccount $account) {
        $validated = $request->validated($request);
        $account->fill($validated);
        $account->save();
        return $this->sendResponse(new LoanAccountResource($account),'Co-maker successfully updated');

    }

    public function fixShortAdv(){
        // $type = 'realtime'; // realtime or background
        $type = 'background'; // realtime or background
        $limit = 10;
        $start = 0;
        $totalPages = 1500;
        $workers = 15; // for simultaneous queue instance
        for ($i=$start; $i <= $totalPages; $i++) {
            if($type == 'background'){
                // For Using Queue in Background
                FixShortAdvMigration::dispatch($i, $limit)->onQueue($i % $workers);
            }else if($type == 'realtime'){
                // For Using just waiting in front end / Realtime
                LoanAccountController::fixLoanAccountShortAndAdvances($i, $limit);
                break;
            }else{
                break;
            }
        }
        if($type == 'background'){
            return response()->json(["data"=>"success", "message"=>"Being processed in background"], 202); // Queue in Background
        }else if($type == 'realtime'){
            return response()->json(["data"=>"success"],200); // Realtime
        }
        return response()->json(["data"=>"failed", 'message'=>'wrong type'],200); // Realtime
    }

    public static function fixLoanAccountShortAndAdvances($i, $limit){
        $accountsArray = LoanAccountMigrationFix::offset($i * $limit)->limit($limit)->get()->pluck('loan_account_id');
        // $accountsArray = LoanAccountMigrationFix::where('account_num', "002-002-0009141")->offset($i * $limit)->limit($limit)->get();
        // dd($accountsArray[0]);
        foreach($accountsArray as $acc_id){
            LoanAccountController::fixMigration($acc_id);
        }
    }

    public static function fixMigration($acc_id){
        $acc = LoanAccountMigrationFix::where('loan_account_id', $acc_id)->with(['product','lastAmortization', 'lastPayment', 'branch.endTransaction', 'amortizations', 'amortizations.payments'])->first();
        $amortP = 0;
        $amortI = 0;
        $advP = 0;
        $advI = 0;
        $shortP = 0;
        $shortI = 0;
        $principal = $acc->loan_amount;
        $interest = $acc->interest_amount;
        $pastLast = null;
        $pastLastDone = false;
        foreach($acc->amortizations as $amort){
            $amortP += round($amort->principal);
            $amortI += round($amort->interest);
            $principal -= round($amort->principal);
            $interest -= round($amort->interest);
            $currentAmortP = $principal < 0 ? round($amort->principal) - abs($principal): round($amort->principal);
            $principal = $principal < 0 ? 0: $principal;
            $currentAmortI = $interest < 0 ? round($amort->interest) - abs($interest) : round($amort->interest);
            $interest = $interest < 0 ? 0: $interest;
            $currentAmortP += $principal > 0 && $amort->id == $acc->lastAmortization->id ? $principal : 0;
            $currentAmortI += $interest > 0 && $amort->id == $acc->lastAmortization->id ? $interest : 0;
            $amortP += $principal > 0 && $amort->id == $acc->lastAmortization->id ? $principal : 0;
            $amortI += $interest > 0 && $amort->id == $acc->lastAmortization->id ? $interest : 0;
            $principal -= $principal > 0 && $amort->id == $acc->lastAmortization->id ? $principal: 0;
            $interest -= $interest > 0 && $amort->id == $acc->lastAmortization->id ? $interest : 0;
            foreach($amort->payments as $payment){
                $payment->principal += $advP;
                $payment->interest += $advI;
                $shortP = $amortP < $payment->principal ? 0 : $amortP - $payment->principal;
                $advP = $amortP < $payment->principal ? $payment->principal - $amortP : 0;
                $shortI = $amortI < $payment->interest ? 0 : $amortI - $payment->interest;
                $advI = $amortI < $payment-> interest ? $payment->interest - $amortI : 0;
                $totalPayable = $payment->amount_applied + $shortI + $shortP;

                if($acc->lastPayment && $acc->lastPayment->payment_id == $payment->payment_id ){
                    $pastLast = $amort->id;
                    if($shortP > 0){
                        if($acc->branch->endTransaction->date_end <= $amort->amortization_date){
                            Amortization::find($amort->id)->fill([
                                'status' => 'open'
                            ])->save();
                        }else{
                            Amortization::find($amort->id)->fill([
                                'status' => 'delinquent'
                            ])->save();

                            LoanAccountMigrationFix::find($acc->loan_account_id)->fill([
                                'payment_status' => 'Delinquent'
                            ])->save();
                        }
                    }
                }
                Payment::find($payment->payment_id)->fill([
                    "total_payable" => $totalPayable,
                    "short_interest"=> $shortI,
                    "short_principal"=> $shortP,
                    "advance_interest"=> $advI,
                    "advance_principal"=> $advP,
                ])->save();
                $amortP -= $payment->principal > $amortP ? $amortP : $payment->principal;
                $amortI -= $payment->interest > $amortI ? $amortI : $payment->interest;
                if($shortI + $shortP <= 0){
                    Amortization::find($amort->id)->fill([
                        'status' => 'paid'
                    ])->save();
                }
            }
            $amort->refresh();
            if($advI + $advP >= 0 && $pastLast != null && $pastLast < $amort->id && !$pastLastDone && $acc->product->product_code == '003'){
                $pastLastDone = true;
                $advI -= $currentAmortI;
                $advP -= $currentAmortP;
                Payment::find($acc->lastPayment->payment_id)->fill([
                    "advance_interest"=> $advI,
                    "advance_principal"=> $advP,
                ])->save();
                Amortization::find($amort->id)->fill([
                    'status' => 'paid'
                ])->save();
            }else if($amort->status != 'paid' && $acc->branch->endTransaction->date_end > $amort->amortization_date){
                Amortization::find($amort->id)->fill([
                    'status' => 'delinquent'
                ])->save();
                
                LoanAccountMigrationFix::find($acc->loan_account_id)->fill([
                    'payment_status' => 'Delinquent'
                ])->save();

            }
            Amortization::find($amort->id)->fill([
                'principal_balance' => $principal,
                'interest_balance' => $interest,
                'principal' => $currentAmortP,
                'interest' => $currentAmortI,
                'total' => $currentAmortP + $currentAmortI,
            ])->save();
        }
    }

}
