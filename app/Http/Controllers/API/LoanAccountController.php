<?php

namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Borrower;
use App\Models\LoanAccount;
use App\Models\Document;
use App\Models\Product;
use App\Models\Amortization;
use App\Models\Branch;
use Session;
use Carbon\Carbon;
use App\Http\Resources\Borrower as BorrowerResource;
use App\Http\Resources\LoanAccount as LoanAccountResource;
use App\Http\Resources\Amortization as AmortizationResource;

class LoanAccountController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function showLoanAccount(LoanAccount $account) {
        return $this->sendResponse(new LoanAccountResource($account), 'Account fetched.');
    }

	/**
     * Store a newly created resource in storage.
     */
    public function createLoanAccount(Request $request, Borrower $borrower) {
        // $branchCode = Branch::find(session()->get('branch_id'))->branch_code;
        # to be replaced when branch is fetched through session.
        $branch = Branch::find(1);
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
        $account->account_num = LoanAccount::generateAccountNum($branch->branch_code, $product->product_code, $account->loan_account_id);
        $account->save();

        if( $account->loan_account_id ) {
            Document::create(
                array_merge(
                    $request->input('documents'), 
                    ['loan_account_id' => $account->loan_account_id ],
                )
            );
        }

    	return $this->sendResponse(new LoanAccountResource($account), 'Account fetched.');
        
    }

    public function updateLoanAccount(Request $request, LoanAccount $account) {
        $account->fill($request->input());
        $account->save();
		$document = Document::find($request->input('documents')['id']);
		$document->description = ($request->input('documents')['description']);
		$document->bank = ($request->input('documents')['bank']);
		$document->account_no = ($request->input('documents')['account_no']);
		$document->card_no = ($request->input('documents')['card_no']);
		$document->promissory_number = ($request->input('documents')['promissory_number']);
		$document->save();

        return $this->sendResponse(new LoanAccountResource($account), 'Account Updated.');
    }

    // yyyy-mm-dd format
    // get override release accounts
    public function overrideAccountList(Request $request) {
    
        $filters = [
            'created_at' => ($request->has('date')) ? $request->input('date') : false,
            'ao_id' => ($request->has('ao_id')) ? $request->input('ao_id') : false,
            'center_id' => ($request->has('center_id')) ? $request->input('center_id') : false,
            'product_id' => ($request->has('product_id')) ? $request->input('product_id') : false,
        ];

        $accounts = new LoanAccount();
        $accounts = $accounts->overrideReleaseAccounts($filters);
        return $this->sendResponse(LoanAccountResource::collection($accounts), 'List.');
    }

    // yyyy-mm-dd format
    // get rejected release accounts
    public function rejectedAccountList() {
        
        $rejectedAccounts = LoanAccount::where('status', 'rejected')->get();
        return $this->sendResponse(LoanAccountResource::collection($rejectedAccounts), 'List.');
    }

    public function override(Request $request) {

        foreach ($request->input() as $key => $value) {
            
            LoanAccount::where('loan_account_id', $value['loan_account_id'])
                ->update([
                    'transaction_date' => $value['transaction_date'],
                    'date_release' => $value['date_release'],
                    'due_date' => $value['due_date'],
                    'status' => 'released',
                ]);
        }

        return $this->sendResponse(['status' => 'released'], 'Released');
    }

    public function reject(Request $request, LoanAccount $account) {

        LoanAccount::where('loan_account_id', $account->loan_account_id)
            ->update([
                'status' => 'rejected',
            ]);

        return $this->sendResponse(['status' => 'rejected'], 'Rejected');
    }

    public function destroy($id) {

        $loanAccount = LoanAccount::find($id);
        $loanAccount->delete();
        return $this->sendResponse(['status' => 'Account deleted'], 'Deleted');
    }

    public function generateAmortizationSched(Request $request) {
        $amortization = new Amortization();
        $dateRelease = ($request->input('date_release')? $request->input('date_release') : date('Y-m-d'));
        $account = LoanAccount::find($request->input('loan_account_id'));
        return $this->sendResponse(($amortization->createAmortizationSched($account, $dateRelease)), 'Amortization Schedule Drafted');
    }

    public function createAmortizationSched(LoanAccount $account) {

        $amortization = new Amortization();
        return $this->sendResponse(($amortization->storeAmortizationSched($account)), 'Amortization Schedule Created');
    }

    public function getPromissoryNo(Request $request) {

        $branch = Branch::find(1);
        $product = Product::find($request->input('product_id'));

        $document = new Document();

        return $document->getPromissoryNo($branch->branch_code, $product->product_code);

    }

    // // end of day transaction
    // public function setDelinquent(){

    //     $loanAccount = new LoanAccount();
    //     $loanAccount->setDelinquent();

    // }

}
