<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Str;

class Reports extends Model
{
    use HasFactory;

    public function getLoanAccounts($filters = []) {

    	$loanAccount = new LoanAccount();

    	if( isset($filters['date_from']) && isset($filters['date_to']) ){
    		/*$loanAccount = LoanAccount::whereBetween(DB::raw('date(loan_accounts.date_release)'), [ $filters['date_from'], $filters['date_to'] ]);*/

            $loanAccount = LoanAccount::whereDate('loan_accounts.date_release', '>=', $filters['date_from']);
            $loanAccount = LoanAccount::whereDate('loan_accounts.date_release', '<=', $filters['date_to']);
    	}


    	$loanAccount->where([ 'loan_accounts.status' => 'released' ]);
    	
    	if( isset($filters['product_id']) ){
    		$loanAccount->where([ 'loan_accounts.product_id' => $filters['product_id'] ]);
    	}

    	if( isset($filters['cycle_no']) ){
    		$loanAccount->where([ 'loan_accounts.cycle_no' => $filters['cycle_no'] ]);
    	}

    	if( isset($filters['branch_code']) ){
    		$loanAccount->where([ 'loan_accounts.branch_code' => $filters['branch_code'] ]);
    	}

    	if( isset($filters['center']) ){
    		$loanAccount->where([ 'loan_accounts.center_id' => $filters['center'] ]);
    	}

    	if( isset($filters['product']) ){
    		$loanAccount->where([ 'loan_accounts.product_id' => $filters['product'] ]);
    	}

    	if( isset($filters['account_officer']) ){
    		$loanAccount->where([ 'loan_accounts.ao_id' => $filters['account_officer'] ]);
    	}


    	return $loanAccount->get([
							'loan_accounts.loan_account_id',
							'loan_accounts.account_num',
							'loan_accounts.date_release',
							'loan_accounts.terms',
							'loan_accounts.loan_amount', 
							'loan_accounts.interest_amount', 
							'loan_accounts.document_stamp', 
							'loan_accounts.filing_fee', 
							'loan_accounts.insurance', 
							'loan_accounts.notarial_fee', 
							'loan_accounts.prepaid_interest', 
							'loan_accounts.affidavit_fee', 
							'loan_accounts.total_deduction', 
							'loan_accounts.net_proceeds', 
							'loan_accounts.borrower_id',
							'loan_accounts.product_id',
							'loan_accounts.ao_id', 
							'loan_accounts.center_id', 
							'loan_accounts.branch_code',
                            'loan_accounts.release_type',
                            'loan_accounts.cycle_no'
						]);
    }


    /* start transaction reports */
    public function transactionReports($filters = []) {

    	$report = new Reports();

    	$report->by_product = $this->getReleaseByProduct($filters);
    	$report->by_client = $this->getReleaseByClient($filters);

    	return $report;
    }

    public function getReleaseByProduct($filters) {

        $products = Product::where([ 'status' => 'active' ])->get(['product_id', 'product_code', 'product_name', 'interest_rate']);
        $paymentTypes = config('enums.payment_type');

        foreach ($products as $key => $product) {

            $accounts = null;
            $payments = null;
            $filters['product_id'] = $product->product_id;
            $accounts = $this->getLoanAccounts($filters);
            $product->cash = 0;
            $product->check = 0;

            if( count($accounts) > 0 ){

                $product->reference = $product->product_code . ' - ' . $product->product_name;

                foreach ($accounts as $account) {
                    
                    $product->principal += $account->loan_amount;
                    $product->interest += $account->interest_amount;
                    $product->document_stamp += $account->document_stamp;
                    $product->filing_fee += $account->filing_fee;
                    $product->insurance += $account->insurance;
                    $product->notarial_fee += $account->notarial_fee;
                    $product->prepaid_interest += $account->prepaid_interest;
                    $product->affidavit_fee += $account->affidavit_fee;
                    $product->total_deduction += $account->total_deduction;
                    $product->net_proceeds += $account->net_proceeds;

                    if( str_contains(strtolower($account->release_type), 'cash')  ){
                         $product->cash += $account->net_proceeds;
                    }

                    if( str_contains(strtolower($account->release_type), 'check') ){
                         $product->check += $account->net_proceeds;
                    }

                    if( count($account->payments) ){

                        foreach ($account->payments as $payment) {

                            foreach ($paymentTypes as $type) {
                                
                                if( $payment->payment_type == $type ){

                                    if( !isset($payments[$type]) ){
                                        $payments[$type]['principal'] = 0;
                                        $payments[$type]['interest'] = 0;
                                        $payments[$type]['pdi'] = 0;
                                        $payments[$type]['over'] = 0;
                                        $payments[$type]['discount'] = 0;
                                        $payments[$type]['total_payment'] = 0;
                                        $payments[$type]['net_int'] = 0;
                                        $payments[$type]['vat'] = 0;
                                    }

                                    $payments[$type]['principal'] += $payment->principal;
                                    $payments[$type]['interest'] += $payment->interest;
                                    $payments[$type]['pdi'] += $payment->pdi;
                                    $payments[$type]['over'] += null;
                                    $payments[$type]['discount'] += null;
                                    $payments[$type]['total_payment'] += $payment->amount_applied;
                                    $payments[$type]['net_int'] += null;
                                    $payments[$type]['vat'] += $payment->vat;
                                }
                            }
                        }
                    }
                }

                $product->payments = $payments;
            }else{
                unset($products[$key]);
            }       
        }

        return $products;
    }

    public function getReleaseByClient($filters, $collection = true) {

        $client = [];
        $accounts = $this->getLoanAccounts($filters);

        foreach ($accounts as $account) {
            
            $client['summary'][] = [ 
                        'account_num' => $account->account_num,
                        'borrower' => $account->borrower->fullname() ,
                        'date_loan' => $account->date_release,
                        'term' => $account->terms,
                        'amount_loan' => $account->loan_amount,
                        'filing_fee' => $account->filing_fee,
                        'document_stamp' => $account->document_stamp,
                        'insurance' => $account->insurance,
                        'notarial_fee' => $account->notarial_fee,
                        'affidavit_fee' => $account->affidavit_fee,
                        'deduction' => $account->total_deduction,
                        'prepaid_interest' => $account->prepaid_interest,
                        'net_proceeds' => $account->net_proceeds,
                        'type' => '',
                    ];

            if( !$collection ) continue;

            if( count($account->payments) ){

                foreach ($account->payments as $payment) {

                    $client['collection'][] = [
                            'borrower' => $account->borrower->fullname(),
                            // 'date_paid' => Carbon::createFromFormat('Y-m-d', $payment->created_at)->format('Y-m-d'),
                            'date_paid' => Carbon::createFromFormat('Y-m-d H:i:s', $payment->created_at)->format('m/d/Y'),
                            'or' => $payment->or_no,
                            'principal' => $payment->principal,
                            'interest' => $payment->interest,
                            'pdi' => $payment->pdi,
                            'over' => null,
                            'discount' => null,
                            'total_payment' => $payment->amount_applied,
                            'net_int' => null,
                            'vat' => null
                    ];
                }
            }
        }

        return $client;
    }
    /* start transaction reports */

    /* start release reports */
    public function releaseReports($filters = [], $category) {

    	switch ($category) {
    		case 'product':
                $type = $filters['type'];
                if( $type == 'new' ){
                    $filters['cycle_no'] = 1;
                }else{
                    $filters[$type] = $filters['spec'];
                }

    			return $this->getReleaseByProduct($filters);
    			break;

    		case 'client':
    			$type = $filters['type'];
    			if( $type == 'new' ){
    				$filters['cycle_no'] = 1;
    			}else{
    				$filters[$type] = $filters['spec'];
    			}
    			return $this->getReleaseByClient($filters, false);
    			break;

    		case 'account_officer':
                $type = $filters['type'];
    			if( $type == 'new' ){
                    $filters['cycle_no'] = 1;
                }

                return $this->getReleaseByAccountOfficer($filters);
    			break;

            case 'dst':
                $type = $filters['type'];
                if( $type == 'new' ){
                    $filters['cycle_no'] = 1;
                }
                return $this->getReleaseByDST($filters);
                break;
    		
    		default:
    			# code...
    			break;
    	}
    }

    public function getReleaseByDST($filters) {
        $accounts = $this->getLoanAccounts($filters);

        $releaseSummary = [];
        foreach ($accounts as $key => $value) {
            
            $releaseSummary[$key]['cycle_no'] = $value->cycle_no;
            $releaseSummary[$key]['term'] = $value->terms;
            $releaseSummary[$key]['loan_amount'] = $value->loan_amount;

        }

        return $releaseSummary;
    }   
    
    public function getReleaseByAccountOfficer($filters) {

        $officers = AccountOfficer::where(['status' => 'active'])->get()->toArray();

        if( $filters['type'] != 'all' ){
            $aoId = $filters['type'];
            $officers = AccountOfficer::where(['status' => 'active', 'ao_id' => $aoId ])->get()->toArray();    
        }

        $products = Product::where([ 'status' => 'active' ])->get(['product_id', 'product_code', 'product_name', 'interest_rate'])->toArray();

        foreach ($officers as $key => $value) {
            
            foreach ($products as $k => $v) {

                $accounts = null;
                $filters['product_id'] = $v['product_id'];
                $filters['account_officer'] = $value['ao_id'];
                
                $accounts = $this->getLoanAccounts($filters);

                if( count($accounts) > 0 ) {

                    $v['reference'] = $v['product_code'] . ' - ' . $v['product_name'];
                    $v['repeat_account'] = 0;
                    $v['repeat_account_amount'] = 0;
                    $v['new_account'] = 0;
                    $v['new_account_amount'] = 0;
                    foreach ($accounts as $account) {

                        if( $account->cycle_no > 1 ){
                            $v['repeat_account'] += 1;
                            $v['repeat_account_amount'] += $account->loan_amount;
                        }else{
                             $v['new_account'] += 1;
                             $v['new_account_amount'] += $account->loan_amount;
                        }
                    }
                }

                $officers[$key]['products'][] = $v;
            }
        }
        return $officers;
    }
    /* end release reports */

    /* start repayment report */
    public function repaymentByProduct($filters = []) {

        $products = Product::where([ 'status' => 'active' ])->get(['product_id', 'product_code', 'product_name', 'interest_rate']);

        $data = [];

        foreach ($products as $key => $value) {
            
            $data[$key]['reference'] = $value['product_code'] . '-' . $value['product_name'];

            $payments = Payment::join('loan_accounts', 'payment.loan_account_id', '=', 'loan_accounts.loan_account_id')
                    ->where(['loan_accounts.product_id' => $value['product_id'], 'payment.branch_id' => $filters['branch_id']])
                    ->whereDate('payment.updated_at', '>=', $filters['date_from'])
                    ->whereDate('payment.updated_at', '<=', $filters['date_to'])
                    ->get([
                        'payment.*',
                    ]);

            if( count($payments) > 0 ) {

                foreach ($payments as $payment) {
                        
                    $type = null;

                    if( Str::contains(Str::lower($payment->payment_type), 'cash') ){ $type = 'cash'; }
                    if( Str::contains(Str::lower($payment->payment_type), 'cheque') ){ $type = 'cheque'; }
                    if( Str::contains(Str::lower($payment->payment_type), 'pos') ){ $type = 'pos'; }
                    if( Str::contains(Str::lower($payment->payment_type), 'memo') ){ $type = 'memo'; }

                    if( !isset($data[$key][$type]) ){
                        $data[$key][$type] = [
                            'principal' => 0,
                            'interest' => 0,
                            'pdi' => 0,
                            'overpayment' => 0,
                            'rebates' => 0,
                            'total' => 0,
                            'net_interest' => 0,
                            'vat' => 0
                        ];
                    }


                    if( !$type ) continue;

                    $data[$key][$type]['principal'] += $payment->principal;
                    $data[$key][$type]['interest'] += $payment->interest;
                    $data[$key][$type]['pdi'] = 0;
                    $data[$key][$type]['overpayment'] = 0;
                    $data[$key][$type]['rebates'] += $payment->rebates;
                    $data[$key][$type]['total'] = 0;
                    $data[$key][$type]['net_interest'] = 0;
                    $data[$key][$type]['vat'] = 0;

                }

            }

        }

        return $data;
    }

    public function repaymentByClient($filters = []) {

        $payments = Payment::join('loan_accounts', 'payment.loan_account_id', '=', 'loan_accounts.loan_account_id')
                        ->where(['payment.branch_id' => $filters['branch_id'], 'payment.status' => 'paid'])
                        ->whereDate('payment.updated_at', '>=', $filters['date_from'])
                        ->whereDate('payment.updated_at', '<=', $filters['date_to'])
                        ->orderBy('payment.updated_at', 'ASC')
                        ->get([
                            'payment.*', 'loan_accounts.borrower_id',
                        ]);

        $data = [];

        foreach ($payments as $payment) {

            $data[] = [
                'borrower' => Borrower::find($payment->borrower_id)->fullname(),
                'payment_date' => $payment->updated_at,
                'or' => $payment->or_no,
                'principal' => $payment->principal,
                'interest' => $payment->interest,
                'pdi' => ($payment->pdi_approval_no) ? $payment->pdi : 0,
                'overpayment' => 0,
                'rebates' => $payment->rebates,
                'total' => $payment->amount_applied,
                'net_interest' => 0,
                'vat' => 0,
                'payment_type' => $payment->payment_type
            ];

        }

        return $data;
    }
    /* end repayment report */


    public function repaymentByAccountOfficer($filters = []) {
    }

    public function branchCollectionReport($filters = []) {



    }

    public function cancelledRepaymentByClient($filters = []) {

        $payments = Payment::join('loan_accounts', 'payment.loan_account_id', '=', 'loan_accounts.loan_account_id')
                        ->where(['payment.branch_id' => $filters['branch_id'], 'payment.status' => 'cancelled'])
                        ->whereDate('payment.updated_at', '>=', $filters['date_from'])
                        ->whereDate('payment.updated_at', '<=', $filters['date_to'])
                        ->orderBy('payment.updated_at', 'ASC')
                        ->get([
                            'payment.*', 'loan_accounts.borrower_id', 'loan_accounts.account_num',
                        ]);

        $data = [];

        foreach ($payments as $payment) {

            $data[] = [
                'date_cancelled' => Carbon::createFromFormat('Y-m-d H:i:s', $payment->updated_at)->format('m/d/Y'),
                'cancelled_by' => '[backend_get_cancelled_by]',
                'account_num' => $payment->account_num,
                'borrower' => Borrower::find($payment->borrower_id)->fullname(),
                'payment_date' => Carbon::createFromFormat('Y-m-d H:i:s', $payment->updated_at)->format('m/d/Y'),
                'or' => $payment->or_no,
                'transaction_number' => $payment->transaction_number,
                'principal' => $payment->principal,
                'interest' => $payment->interest,
                'pdi' => ($payment->pdi_approval_no) ? $payment->pdi : 0,
                'pdi_waive' => ($payment->pdi_approval_no) ? 0 : $payment->pdi,
                'penalty' => ($payment->penalty_approval_no) ? $payment->penalty : 0,
                'penalty_waive' => ($payment->penalty_approval_no) ? 0 : $payment->penalty,
                'rebates' => $payment->rebates,
                'overpayment' => $payment->over_payment,
                'total' => $payment->amount_applied,
                'remarks' => $payment->remarks,
                'payment_type' => $payment->payment_type
            ];

        }

        return $data;
    }

}