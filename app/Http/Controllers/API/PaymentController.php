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

    	$payments = Payment::all();
    	return $this->sendResponse(PaymentResource::collection($borrowers), 'Borrowers');

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

    

}