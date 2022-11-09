<?php

namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\LoanAccount;
use App\Models\Amortization;
use App\Http\Resources\Payment as PaymentResource;
use App\Http\Resources\PaymentLoanAccount as PaymentLoanAccountResource;
use Carbon\Carbon;
use App\Models\EndTransaction;
use Illuminate\Support\Str;


class PaymentController extends BaseController
{
    
	/**
     * Display a listing of the resource.
     */
    public function index() {

    	// $payments = Payment::all();
    	// return $this->sendResponse(PaymentResource::collection($payments), 'Payments');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {

        # create payment instance.
        $payment = new Payment();
    	# get branch id and add to request data
    	// $request->merge(['branch_id' => 2]);

        // $payment->addPayment($request);
    	return $this->sendResponse(new PaymentResource($payment->addPayment($request)), 'Payment');
        // return $request->input();
    }

    // Override Payment
    public function overridePaymentList(Request $request) {

        $filters = [
            'created_at' => ($request->has('created_at')) ? $request->input('created_at') : false,
            'ao_id' => ($request->has('ao_id')) ? $request->input('ao_id') : false,
            'center_id' => ($request->has('center_id')) ? $request->input('center_id') : false,
            'product_id' => ($request->has('product_id')) ? $request->input('product_id') : false,
            'branch_id' => $request->input('branch_id')
        ];

        $payment = new Payment();

        return $this->sendResponse( 
            PaymentLoanAccountResource::collection($payment->overridePaymentAccounts($filters)), 
            'Payments'
        );
    }

    public function overridePayment(Request $request) {

        $payment = null;


        $succeed = 0;
        $failed = 0;
        foreach ($request->input() as $key => $value) {

            $payment = Payment::find($value['payment_id']);
            $amortization = Amortization::find($payment->amortization_id);
            $loanAccount = LoanAccount::find($payment->loan_account_id);

            if( $payment->reference_id ){
                $acc = LoanAccount::find($payment->reference_id);

                if( $acc->status == 'pending' ){
                    $failed++;
                    continue;
                }
            }

            $succeed++;
            $payment->status = 'paid';
            $payment->save();

            # update amortization
            if( $payment->total_payable > $payment->amount_applied ){

                $currentDay = Carbon::createFromFormat('Y-m-d', Carbon::now()->format('Y-m-d'));
                $schedDate = Carbon::createFromFormat('Y-m-d', $amortization->amortization_date);

                if( $currentDay->lt($schedDate) ){
                    $amortization->status = 'open';
                }else{
                    $amortization->status = 'delinquent';    
                }
                // $loanAccount->payment_status = 'delinquent';
                // Amortization::find($payment->amortization_id)->update([ 'status' => 'delinquent' ]);
                // LoanAccount::find($payment->loan_account_id)->update(['payment_status' => 'Delinquent']);
            }else{
                $amortization->status = 'paid';
                $loanAccount->payment_status = 'Current';
                // Amortization::find($payment->amortization_id)->update([ 'status' => 'paid' ]);
                // LoanAccount::find($payment->loan_account_id)->update(['payment_status' => 'Current']);
            }

            $balance = $loanAccount->outstandingBalance($loanAccount->loan_account_id);

            if( $balance <= 0 ){
                $loanAccount->payment_status = 'Paid';
                $loanAccount->loan_status = 'Paid';
            }

            $amortization->save();
            $loanAccount->save();
        }

        $sf = $succeed + $failed;
        return $this->sendResponse("{$succeed} of {$sf} Successfully Overriden", 'Override');
    }

    public function overrideList(Request $request) {

        $branchId = $request->input('branch_id');

        $endTransaction = new EndTransaction();
        $eod = $endTransaction->getTransactionDate($branchId);

        $payment = new Payment();
        $list =  $payment->overriddenList(array('branch_id' => $branchId, 'transaction_date' => $eod->date_end));

        if( count($list) > 0 ){
            return $this->sendResponse(PaymentLoanAccountResource::collection($list), 'Payments');
        }
        
        return false;
    }

    public function destroy($id) {

        $payment = Payment::find($id);
        $payment->delete();

        return $this->sendResponse(['status' => 'Payment deleted'], 'Deleted');
    }

    public function update(Request $request, Payment $payment) {
        
        $payment->fill($request->input());
        $payment->save();

        if( $payment->status == 'cancelled' ){
            return $this->sendResponse(new PaymentResource($payment), 'Payment Cancelled.');
        }
        
        return $this->sendResponse(new PaymentResource($payment), 'Payment Updated.');
    }

    public function show($branchId) {
    }

    public function paymentSummary($branchId) {

        $endTransaction = new EndTransaction();
        $dateEnd = $endTransaction->getTransactionDate($branchId);

        $payment = new Payment();
        $paymentList = $payment->paymentList($dateEnd, $branchId);

        $summary = [
            'cash' => 0,
            'check' => 0,
            'memo' => 0,
            'total' => 0,
        ];
        if( count($paymentList) > 0 ){

            foreach ($paymentList as $payment) {

                if( Str::contains(Str::lower($payment->payment_type), 'cash') ){

                    $summary['cash'] += $payment->amount_applied;
                    continue;
                }

                if( Str::contains(Str::lower($payment->payment_type), 'check') ){

                    $summary['check'] += $payment->amount_applied;
                    continue;
                }

                 if( Str::contains($payment->payment_type, 'memo') ){

                    $summary['memo'] += $payment->amount_applied;
                    continue;
                }

            }
            $summary['total'] = $summary['cash'] + $summary['check'] + $summary['memo'];
        }

        return $summary;
    }

}