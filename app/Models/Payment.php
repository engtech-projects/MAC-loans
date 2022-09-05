<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payment';
    protected $primaryKey = 'payment_id';

    protected $fillable = [
    	'loan_account_id', 
    	'branch_id',
    	'payment_type', 
    	'or_no',
        'cheque_no',
        'bank_name',
        'reference_no',
        'memo_type',
    	'amortization_id',  // references amortization (id) primary key,
        'principal',
        'interest',
        'short_principal',
        'advance_principal',
        'short_interest',
        'advance_interest',
    	'pdi',
        'pdi_approval_no',
		'penalty',
        'penalty_approval_no',
		'rebates',
        'rebates_approval_no',
		'total_payable',
		'amount_applied',
        'status'
    ];

	public function loanDetails(){
		return $this->belongsTo(LoanAccount::class, 'loan_account_id');
	}


    public function getTotalPayment() {
        
    }

    public function addPayment(Request $request){

        $account = LoanAccount::find($request->input('loan_account_id'));
        $payment = new Payment();

        $payment->loan_account_id = $request->input('loan_account_id');
        $payment->branch_id = $request->input('branch_id');
        $payment->payment_type = $request->input('payment_type');
        $payment->or_no = $request->input('or_no');
        $payment->cheque_no = $request->input('cheque_no');
        $payment->bank_name = $request->input('bank_name');
        $payment->reference_no = $request->input('reference_no');
        $payment->memo_type = $request->input('memo_type');
        $payment->amortization_id = $request->input('amortization_id');
        $payment->principal = $request->input('principal');
        $payment->interest = $request->input('interest');
        $payment->short_principal = $request->input('short_principal');
        $payment->advance_principal = $request->input('advance_principal');
        $payment->short_interest = $request->input('short_interest');
        $payment->advance_interest = $request->input('advance_interest');
        $payment->pdi = $request->input('pdi');
        $payment->penalty = $request->input('penalty');
        $payment->rebates = $request->input('rebates');
        $payment->total_payable = $request->input('total_payable');
        $payment->amount_applied = $request->input('amount_applied');
        // $payment->status = 'paid';
        $payment->save();

        // $amortization = Amortization::find( $payment->amortization_id );
        // $amortization->status = 'paid';
        
        // if( $payment->short_principal > 0 ){
        //     $amortization->status = 'delinquent';
        // }

        // $amortization->save();

        return $payment;
    }

    public function overridePaymentAccounts($filters = array()) {

        $payments = Payment::join('loan_accounts', 'loan_accounts.loan_account_id', '=', 'payment.loan_account_id')
                            ->join('borrower_info', 'borrower_info.borrower_id', '=', 'loan_accounts.borrower_id');

        if( isset($filters['created_at']) && $filters['created_at'] ){
            $payments->whereDate('payment.created_at', '=', $filters['created_at']);
        }

        if( isset($filters['ao_id']) && $filters['ao_id'] != 'all' ){
            $payments->where('loan_accounts.ao_id', '=', $filters['ao_id']);
        }

        if( isset($filters['center_id']) && $filters['center_id'] != 'all' ){
            $payments->where('loan_accounts.center_id', '=', $filters['center_id']);
        }

        if( isset($filters['product_id']) && $filters['product_id'] != 'all' ){
            $payments->where('loan_accounts.product_id', '=', $filters['product_id']);          
        }

        if( isset($filters['branch_id']) ){
            $payments->where('payment.branch_id', '=', $filters['branch_id']);
        }

        $payments->where('payment.status', '=', 'open');
                
        return $payments->get(['payment.*', 'loan_accounts.*', 'borrower_info.*']);
    
    }

    public function delete() {}

    public function paymentList($transDate, $branchId) {

        return Payment::whereDate('payment.updated_at', '=', $transDate)
                        ->where([ 'branch_id' => $branchId ])
                        ->get();

    }
    
    public function cancelPayment() {}

}
