<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;
class Reports extends Model
{
    use HasFactory;

    public function transactionReports($dateFrom, $dateTo) {

    	$report = new Reports();
    	
    	$dateFrom = Carbon::createFromFormat('Y-m-d', $dateFrom);
        $dateTo = Carbon::createFromFormat('Y-m-d', $dateTo);

        // $paymentType = config('enums.payment_type');
        // $paymentSummary = array();

        // $byProduct = array();
        // $byClient = array();

    	// foreach ($product as $key => $value) {
    		
    	// 	$accounts = null; 
    	// 	$accounts = LoanAccount::join('borrower_info', 'borrower_info.borrower_id', '=', 'loan_accounts.borrower_id')
    	// 				->whereBetween(DB::raw('date(loan_accounts.date_release)'), [ $dateFrom, $dateTo ])
    	// 				->where(['loan_accounts.status' => 'released', 'loan_accounts.product_id' => $value->product_id])
    	// 				->get([
    	// 						'loan_accounts.loan_account_id','loan_accounts.loan_amount', 
    	// 						'loan_accounts.interest_amount', 'loan_accounts.document_stamp', 
    	// 						'loan_accounts.filing_fee', 'loan_accounts.insurance', 
    	// 						'loan_accounts.notarial_fee', 'loan_accounts.prepaid_interest', 
    	// 						'loan_accounts.affidavit_fee', 'loan_accounts.total_deduction', 
    	// 						'loan_accounts.net_proceeds', 
    	// 						'borrower_info.firstname', 'borrower_info.middlename', 
    	// 						'borrower_info.lastname', 'borrower_info.suffix'
    	// 					]);

    		
    	// 	if( count($accounts) > 0 ){
    	// 		$value->accounts = $accounts;
    	// 		// $byProduct[$value->product_name] = array();

    	// // 		$value->accounts = $accounts;
 				// // $value->reference = $value->product_code . ' - ' . $value->product_name;

    	// // 		foreach ($value->accounts as $account) {
    			
		   // //  		$value->principal += $account->interest_amount;
		   // //  		$value->interest += $account->interest_amount;
		   // //  		$value->document_stamp += $account->document_stamp;
					// // $value->filing_fee += $account->filing_fee;
					// // $value->insurance += $account->insurance;
					// // $value->notarial_fee += $account->notarial_fee;
					// // $value->prepaid_interest += $account->prepaid_interest;
					// // $value->affidavit_fee += $account->affidavit_fee;
					// // $value->total_deduction += $account->total_deduction;
					// // $value->net_proceeds += $account->net_proceeds;


					// // // if (  count($account->payments) > 0 ) {

					// // // 	foreach ($paymentType as $type) {
							
					// // // 		$principal = 0;
					// // // 		$interest = 0;

					// // // 		foreach ($account->payments as $payment) {
								
					// // // 			if( $payment->payment_type == $type ){
					// // // 				$principal += $payment->principal;
					// // // 				$interest += $payment->interest;
					// // // 			}
					// // // 		}

					// // // 		if( $principal && $interest ) {
					// // // 			$paymentSummary[$value->product_name][$type]['principal'] = $principal;
					// // // 			$paymentSummary[$value->product_name][$type]['interest'] = $interest;
					// // // 		}

					// // // 	}
					// // // }

    	// // 		}
    	// 	}
    	// }
    	
    	$products = Product::where([ 'status' => 'active' ])->get(['product_id', 'product_code', 'product_name']);
        $accounts = $this->getLoanAccounts($dateFrom, $dateTo);

    	// $report->by_product = [ 'releases' => $this->releaseByProduct($accounts, $products), 'payments' => $this->paymentByProduct($accounts, $products) ];
    	// $report->by_product = $this->releaseByProduct($accounts, $products);
    	$report->by_product = $accounts;
    	$report->by_client = null;

    	return $report;
    }

    public function getLoanAccounts($dateFrom, $dateTo) {

    	return LoanAccount::whereBetween(DB::raw('date(loan_accounts.date_release)'), [ $dateFrom, $dateTo ])
					->where(['loan_accounts.status' => 'released'])
					// ->where(['loan_accounts.branch_code' => ''])
					->get([
							'loan_accounts.loan_account_id',
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
							'loan_accounts.branch_code'
						]);
    }

   //  public function releaseByProduct($accounts, $products) {

   //  	$paymentType = config('enums.payment_type');
   //  	$releases = array();
   //  	// $payments = array();

   //  	foreach ($products as $product) {

   //  		$reference = $product->product_code . ' - ' . $product->product_name;
	  //   	$principal = 0; 
   //  		$interest = 0;
   //  		$document_stamp = 0; 
			// $filing_fee = 0; 
			// $insurance = 0; 
			// $notarial_fee = 0; 
			// $prepaid_interest = 0; 
			// $affidavit_fee = 0;
			// $total_deduction = 0; 
			// $net_proceeds = 0;

   //  		foreach ($accounts as $account) {
    			
   //  			if( $product->product_id == $account->product_id ){

   //  				$principal += $account->loan_amount;  
		 //    		$interest += $account->interest_amount; 
		 //    		$document_stamp += $account->document_stamp;  
			// 		$filing_fee += $account->filing_fee;  
			// 		$insurance += $account->insurance;  
			// 		$notarial_fee += $account->notarial_fee;  
			// 		$prepaid_interest += $account->prepaid_interest;  
			// 		$affidavit_fee += $account->affidavit_fee; 
			// 		$total_deduction += $account->total_deduction;
			// 		$net_proceeds += $account->net_proceeds; 
			// 		// $payments[] = $account->payments;
			// 		// if (  count($account->payments) > 0 ) {
			// 		// 	$payments = $product->product_id;
			// 		// }
					

			// 		// if (  count($account->payments) > 0 ) {

	  //   // 				foreach ($paymentType as $type) {

	  //   // 					$paidPrincipal = 0;
	  //   // 					$paidInterest = 0;

			// 		// 		foreach ($account->payments as $payment) {
								
			// 		// 			if( $payment->payment_type == $type ){
			// 		// 				$paidPrincipal += $payment->principal;
			// 		// 				$paidInterest += $payment->interest;
			// 		// 			}
			// 		// 		}

			// 		// 		$payments[$type]['principal'] = $paidPrincipal;
			// 		// 		$payments[$type]['interest'] = $paidInterest;
			// 		// 		// if( $a && $b ) {
			// 		// 		// }
			// 		// 	}

	  //   			// }
   //  			}



   //  		}

   //  		$releases[] = [
	  //   		'product' => $product->product_name,
	  //   		'reference' => $reference,
	  //   		'principal' => $principal,
			// 	'interest' => $interest,
			// 	'document_stamp' => $document_stamp,
			// 	'filing_fee' => $filing_fee,
			// 	'insurance' => $insurance,
			// 	'notarial_fee' => $notarial_fee,
			// 	'prepaid_interest' => $prepaid_interest,
			// 	'affidavit_fee' => $affidavit_fee,
			// 	'total_deduction' => $total_deduction,
			// 	'net_proceeds' => $net_proceeds,
			// 	'payment_id' => $payments,
	  //   	];
   //  	}
   //  	return [ 'releases' => $releases ];
   //  }
}