<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;
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

    public function transactionReports($filters = []) {

    	$report = new Reports();

    	$report->by_product = $this->getReleaseByProduct($filters);
    	$report->by_client = $this->getReleaseByClient($filters);

    	return $report;
    }

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
    		
    		default:
    			# code...
    			break;
    	}
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
									$payments[$type]['vat'] += null;
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

}