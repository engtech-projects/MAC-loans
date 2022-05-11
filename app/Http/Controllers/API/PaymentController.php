<?php

namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\LoanAccount;
use App\Models\Amortization;
use App\Http\Resources\Payment as PaymentResource;


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
        // [ 'created_at' => '2022-05-05']
        // return $this->sendResponse(PaymentResource::collection($payment->overridePaymentAccounts()), 'Payments');
         return $this->sendResponse($payment->overridePaymentAccounts($filters), 'Payments');
         // return $filters;
    }


    public function overridePayment() {



    }

    public function deletePayment() {


    }

}