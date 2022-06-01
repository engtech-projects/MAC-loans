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
    	$request->merge(['branch_id' => 2]);

        return $payment->addPayment($request);
    	// return $this->sendResponse(new PaymentResource($payment->addPayment($request)), 'Payment');
    }




    // Override Payment
    public function overridePaymentList(Request $request) {

        $filters = [
            'created_at' => ($request->has('created_at')) ? $request->input('created_at') : false,
            'ao_id' => ($request->has('ao_id')) ? $request->input('ao_id') : false,
            'center_id' => ($request->has('center_id')) ? $request->input('center_id') : false,
            'product_id' => ($request->has('product_id')) ? $request->input('product_id') : false,
            'branch_id' => 1
        ];
        $payment = new Payment();
     
        return $this->sendResponse( 
            PaymentLoanAccountResource::collection($payment->overridePaymentAccounts($filters)), 
            'Payments'
        );

    }


    public function overridePayment(Request $request) {


        $payment = null;

        foreach ($request->input() as $key => $value) {
            $payment = Payment::find($value['payment_id']);
            $payment->status = 'paid';
            $payment->save();

            # update amortization
            if( $payment->total_payable > $payment->amount_applied ){
                $amortization = Amortization::find($payment->amortization_id)->update([ 'status' => 'delinquent' ]);
            }else{
                $amortization = Amortization::find($payment->amortization_id)->update([ 'status' => 'completed' ]);
            }
        }

        return $this->sendResponse('Override', 'Override');

    }

    public function destroy($id) {

        $payment = Payment::find($id);
        $payment->status = 'deleted';
        $payment->save();

        return $this->sendResponse($payment, 'Deleted');
    }

}