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

    const BRANCH_AO_PERFORMANCE = "performance_report";
    const BRANCH_AO_WRITEOFF = "write_off";
    const BRANCH_AO_DELINQUENT = "delinquent";

    public function getLoanAccounts($filters = []) {

        $branch = Branch::find($filters['branch_id']);
        

        $loanAccount = Loanaccount::where([ 'loan_accounts.status' => 'released', 'branch_code' => $branch->branch_code ]);

        if( isset($filters['date_from']) && isset($filters['date_to']) ){
            /*$loanAccount = LoanAccount::whereBetween(DB::raw('date(loan_accounts.date_release)'), [ $filters['date_from'], $filters['date_to'] ]);*/

            $loanAccount->whereDate('loan_accounts.date_release', '>=', $filters['date_from']);
            $loanAccount->whereDate('loan_accounts.date_release', '<=', $filters['date_to']);
        }

        if( isset($filters['due_from']) && isset($filters['due_to']) ){
            $loanAccount->whereDate('loan_accounts.due_date', '>=', $filters['due_from']);
            $loanAccount->whereDate('loan_accounts.due_date', '<=', $filters['due_to']);
        }

    	
    	if( isset($filters['product_id']) && $filters['product_id'] ){
    		$loanAccount->where([ 'loan_accounts.product_id' => $filters['product_id'] ]);
    	}

    	if( isset($filters['cycle_no']) && $filters['cycle_no'] ){
    		$loanAccount->where([ 'loan_accounts.cycle_no' => $filters['cycle_no'] ]);
    	}

    	if( isset($filters['center']) && $filters['center'] ){
    		$loanAccount->where([ 'loan_accounts.center_id' => $filters['center'] ]);
    	}

    	if( isset($filters['product']) && $filters['product'] ){
    		$loanAccount->where([ 'loan_accounts.product_id' => $filters['product'] ]);
    	}

    	if( isset($filters['account_officer']) && $filters['account_officer'] ){
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
            'loan_accounts.cycle_no',
            'loan_accounts.memo',
            'loan_accounts.due_date',
        ]);
    }

    public function getPayments($filters = []) {


        $branch = Branch::find($filters['branch_id']);

        $payments = Payment::where([ 'payment.status' => 'paid', 'branch_id' => $branch->branch_id ]);

        if( isset($filters['product_id']) ){
            $payments = Payment::join('loan_accounts', 'loan_accounts.loan_account_id', '=', 'payment.loan_account_id');
            $payments->where([ 'loan_accounts.product_id' => $filters['product_id'] ]);
        }

        if( isset($filters['date_from']) && isset($filters['date_to']) ){
            $payments->whereDate('payment.transaction_date', '>=', $filters['date_from']);
            $payments->whereDate('payment.transaction_date', '<=', $filters['date_to']);
        }

        return $payments->get();
    }

    /* start transaction reports */
    public function transactionReports($filters = []) {

    	$report = new Reports();

    	$report->product = $this->getReleaseByProduct($filters);
    	$report->client = $this->getReleaseByClient($filters);

    	return $report;
    }

    public function getReleaseByProduct($filters) {
        // if( isset($filters['product']) && $filters['product'] ){
        //     $products = Product::where([ 'status' => 'active', 'product_id' => $filters['product'] ])->get(['product_id', 'product_code', 'product_name', 'interest_rate']);
        // }else{
            $products = Product::where([ 'status' => 'active' ])->get(['product_id', 'product_code', 'product_name', 'interest_rate']);
        // }
        
        $paymentTypes = config('enums.payment_type');

        $data = [];
     

        foreach ($products as $key => $product) {

            $data[$key]['reference'] = $product->reference = $product->product_code . ' - ' . $product->product_name;
            $data[$key]['release'] = [
                'principal' => 0,
                'interest' => 0,
                'document_stamp' => 0,
                'filing_fee' => 0,
                'insurance' => 0,
                'notarial_fee' => 0,
                'prepaid_interest' => 0,
                'affidavit_fee' => 0,
                'total_deduction' => 0,
                'net_proceeds' => 0,
                'memo' => 0,
                'cash' => 0,
                'check' => 0,
            ];

            $data[$key]['payment'] = [];

            $accounts = null;
            $payments = null;

            $filters['product_id'] = $product->product_id;

            $accounts = $this->getLoanAccounts($filters);
            $payments = $this->getPayments($filters);
           
            if( count($accounts) ){

                foreach ($accounts as $account) {

                    $data[$key]['release']['principal'] += $account->loan_amount;
                    $data[$key]['release']['interest'] += $account->interest_amount;
                    $data[$key]['release']['document_stamp'] += $account->document_stamp;
                    $data[$key]['release']['filing_fee'] += $account->filing_fee;
                    $data[$key]['release']['insurance'] += $account->insurance;
                    $data[$key]['release']['notarial_fee'] += $account->notarial_fee;
                    $data[$key]['release']['prepaid_interest'] += $account->prepaid_interest;
                    $data[$key]['release']['affidavit_fee'] += $account->affidavit_fee;
                    $data[$key]['release']['total_deduction'] += $account->total_deduction;
                    $data[$key]['release']['net_proceeds'] += $account->net_proceeds;
                    $data[$key]['release']['memo'] += $account->memo;

                    if( str_contains(strtolower($account->release_type), 'cash')  ){
                         $data[$key]['release']['cash'] += $account->net_proceeds;
                    }

                    if( str_contains(strtolower($account->release_type), 'check') ){
                         $data[$key]['release']['check'] += $account->net_proceeds;
                    }
                }
            }

        
            if( count($payments) ) {

                foreach ($payments as $k => $payment) {
                    
                    foreach ($paymentTypes as $type) {

                        if( $payment->payment_type == $type ){

                            if( !isset($data[$key]['payment'][$type]) ){
                                $data[$key]['payment'][$type] = [
                                   
                                    'principal' => 0,
                                    'interest' => 0,
                                    'pdi' => 0,
                                    'over' => 0,
                                    'discount' => 0,
                                    'total_payment' => 0,
                                    'net_int' => 0,
                                    'vat' => 0
                                ];
                            }

                            $data[$key]['payment'][$type]['principal'] += $payment->principal;
                            $data[$key]['payment'][$type]['interest'] += $payment->interest;
                            $data[$key]['payment'][$type]['pdi'] += $payment->pdi;
                            $data[$key]['payment'][$type]['over'] += $payment->over_payment;
                            $data[$key]['payment'][$type]['discount'] += null;
                            $data[$key]['payment'][$type]['total_payment'] += $payment->amount_applied;
                            $data[$key]['payment'][$type]['net_int'] += null;
                            $data[$key]['payment'][$type]['vat'] += $payment->vat;
                        }

                    }

                }

            }
        }
        return $data;
    }

    public function getReleaseByClient($filters, $collection = true) {

        $data = [];
        $accounts = $this->getLoanAccounts($filters);
        $payments = $this->getPayments($filters);

        foreach ($accounts as $account) {
            
            $data['release'][] = [ 
                'cycle_no' => $account->cycle_no,
                'product_id' => $account->product_id,
                'account_num' => $account->account_num,
                'borrower' => $account->borrower->fullname() ,
                'date_loan' => $account->date_release,
                'date_release' => $account->date_release,
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
                'memo' => $account->memo,
                'type' => $account->release_type,
            ];
        }

        if( !$collection ) {

            return $data;

        }

        foreach ($payments as $payment) {
            
            $borrower = LoanAccount::find($payment->loan_account_id);

            $data['collection'][] = [
                'borrower' => Borrower::find($borrower->borrower_id)->fullname(),
                'date_paid' => Carbon::createFromFormat('Y-m-d H:i:s', $payment->created_at)->format('m/d/Y'),
                'or' => $payment->or_no,
                'principal' => $payment->principal,
                'interest' => $payment->interest,
                'pdi' => $payment->pdi,
                'over' => $payment->over_payment,
                'discount' => null,
                'total_payment' => $payment->amount_applied,
                'net_int' => null,
                'vat' => $payment->vat
            ];

        }

        // foreach ($accounts as $account) {
            
        //     $client['summary'][] = [ 
        //                 'account_num' => $account->account_num,
        //                 'borrower' => $account->borrower->fullname() ,
        //                 'date_loan' => $account->date_release,
        //                 'date_release' => $account->date_release,
        //                 'term' => $account->terms,
        //                 'amount_loan' => $account->loan_amount,
        //                 'filing_fee' => $account->filing_fee,
        //                 'document_stamp' => $account->document_stamp,
        //                 'insurance' => $account->insurance,
        //                 'notarial_fee' => $account->notarial_fee,
        //                 'affidavit_fee' => $account->affidavit_fee,
        //                 'deduction' => $account->total_deduction,
        //                 'prepaid_interest' => $account->prepaid_interest,
        //                 'net_proceeds' => $account->net_proceeds,
        //                 'memo' => $account->memo,
        //                 'type' => $account->release_type,
        //             ];

        //     if( !$collection ) continue;

        //     if( count($account->payments) ) {

        //         foreach ($account->payments as $payment) {

        //             $client['collection'][] = [
        //                     'borrower' => $account->borrower->fullname(),
        //                     // 'date_paid' => Carbon::createFromFormat('Y-m-d', $payment->created_at)->format('Y-m-d'),
        //                     'date_paid' => Carbon::createFromFormat('Y-m-d H:i:s', $payment->created_at)->format('m/d/Y'),
        //                     'or' => $payment->or_no,
        //                     'principal' => $payment->principal,
        //                     'interest' => $payment->interest,
        //                     'pdi' => $payment->pdi,
        //                     'over' => $payment->over_payment,
        //                     'discount' => null,
        //                     'total_payment' => $payment->amount_applied,
        //                     'net_int' => null,
        //                     'vat' => $payment->vat
        //             ];
        //         }
        //     }
        // }

        return $data;
    }
    /* start transaction reports */

    /* start release reports */
    public function releaseReports($filters = [], $category) {

    	switch ($category) {
    		case 'product':

    			return $this->getReleaseByProduct($filters);
    			break;

    		case 'client':

    			$type = $filters['type'];
    			if( $type == 'new' ){
    				$filters['cycle_no'] = 1;
    			}

                if( $type == 'center' || $type == 'product' || $type == 'account_officer' ) {
                    $filters[$type] = $filters['spec'];
                }

                
    			return $this->getReleaseByClient($filters, false);
    			break;

    		case 'account_officer':
       //          $type = $filters['type'];
    			// if( $type == 'new' ){
       //              $filters['cycle_no'] = 1;
       //          }
                return $this->getReleaseByAccountOfficer($filters);
    			break;

            case 'dst':
                $type = $filters['type'];
                if( $type == 'new' ){
                    $filters['cycle_no'] = 1;
                }
                return $this->getReleaseByDST($filters);
                break;

            case 'insurance':
            return $this->releaseInsurance($filters);
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

        if( $filters['account_officer'] == 'all' ){
            $officers = AccountOfficer::where(['status' => 'active'])->get();
        }else{
            $officers = AccountOfficer::where(['status' => 'active', 'ao_id' => $filters['account_officer'] ])->get();
        }
        
        // if( $filters['type'] != 'all' ){
        //     $aoId = $filters['type'];
        //     $officers = AccountOfficer::where(['status' => 'active', 'ao_id' => $aoId ])->get()->toArray();    
        // }

        $products = Product::where([ 'status' => 'active' ])->get(['product_id', 'product_code', 'product_name', 'interest_rate']);

        $data = [];
        foreach ($officers as $key => $value) {
            $data[$key]['account_officer'] = $value['name'];

            foreach ($products as $k => $v) {

                $data[$key]['products'][$k] = [
                    'reference' => null,
                    'new_account' => null,
                    'new_account_amount_released' => null,
                    'repeat_account' => null,
                    'repeat_account_amount_released' => null,
                    'total_released' => null,
                ];

                $accounts = null;
                $filters['product_id'] = $v['product_id'];
                $filters['account_officer'] = $value['ao_id'];
                $accounts = $this->getLoanAccounts($filters);

                if( count($accounts) > 0 ) {

                    $data[$key]['products'][$k] = [
                        'reference' => $v['product_code'] . ' - ' . $v['product_name'],
                        'new_account' => null,
                        'new_account_amount_released' => null,
                        'repeat_account' => null,
                        'repeat_account_amount_released' => null,
                        'total_released' => null,
                    ];

            //         $v['reference'] = $v['product_code'] . ' - ' . $v['product_name'];
            //         // $v['repeat_account'] = 0;
            //         // $v['repeat_account_amount'] = 0;
            //         // $v['new_account'] = 0;
            //         // $v['new_account_amount'] = 0;
                    foreach ($accounts as $account) {

                        if( $account->cycle_no > 1 ){
                            $data[$key]['products'][$k]['repeat_account'] += 1;
                            $data[$key]['products'][$k]['repeat_account_amount_released'] += $account->loan_amount;
            //         //         $v['repeat_account'] += 1;
            //         //         $v['repeat_account_amount'] += $account->loan_amount;
                        }else{
                            $data[$key]['products'][$k]['new_account'] += 1;
                            $data[$key]['products'][$k]['new_account_amount_released'] += $account->loan_amount;
            //         //          $v['new_account'] += 1;
            //         //          $v['new_account_amount'] += $account->loan_amount;
                        }

                        $data[$key]['products'][$k]['total_released'] = $data[$key]['products'][$k]['new_account_amount_released'] + $data[$key]['products'][$k]['repeat_account_amount_released'];
                    }
                }

            //     // $officers[$key] = $v;
            }
        }
        return $data;
        // return $filters;
    }

    public function releaseInsurance($filters = []){
        $accounts = $this->getLoanAccounts($filters);
        $insurance = [];
        foreach ($accounts as $key => $value) {
            $insurance[$key]["account_num"] = $value->account_num;
            $insurance[$key]["name"] = $value->borrower->fullname();
            $insurance[$key]["birthdate"] = $value->borrower->birthdate;
            $insurance[$key]["gender"] = $value->borrower->gender;
            $insurance[$key]["marital_status"] = $value->borrower->status;
            $insurance[$key]["amount_loan"] = $value->loan_amount;
            $insurance[$key]["insurance"] = $value->insurance;
            $insurance[$key]["date_loan"] = $value->date_release;
            $insurance[$key]["due_date"] = $value->due_date;
            $insurance[$key]["term"] = $value->terms;
        }
        return $insurance;
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

        $branch = Branch::find($filters['branch_id']);

        $accounts = LoanAccount::join('center', 'center.center_id', '=', 'loan_accounts.center_id');
        
        if( isset($filters['account_officer']) && $filters['account_officer'] ){
            $accounts->where([ 'loan_accounts.ao_id' => $filters['account_officer'] ]);
        }

        if( isset($filters['center']) && $filters['center'] ){
            $accounts->where([ 'loan_accounts.center_id' => $filters['center'] ]);
        }

        $accounts->where(['loan_accounts.branch_code' => $branch->branch_code]);
        $accounts->whereIn('loan_accounts.loan_status', ['Ongoing', 'Past Due']);

        $accounts = $accounts->get();

        $data = [];

        if( count($accounts) > 0 ) {

            foreach ($accounts as $key => $value) {
                
                $loanAccount = LoanAccount::find($value['loan_account_id']);
                $currentAmortization = $loanAccount->getCurrentAmortization();
                
                $borrower = Borrower::find($value['borrower_id']);
                $data[$key]['center'] = $value->center_id;
                $data[$key]['account_officer'] = $value->ao_id; 
                $data[$key]['client'] = $borrower->fullname();
                $data[$key]['date_loan'] = $value['date_release'];
                $data[$key]['maturity_date'] = $value['due_date'];
                $data[$key]['amount_loan'] = $value['loan_amount'];
                $data[$key]['outstanding_balance'] = $currentAmortization->outstandingBalance;
                $data[$key]['principal_balance'] = $currentAmortization->principal_balance;
                $data[$key]['delinquent'] = $currentAmortization->total;
                $data[$key]['weekly_amortization'] = $value['total'];
                $data[$key]['contact'] = $borrower->contact_number;
                $data[$key]['address'] = $borrower->address;

            }

        }

        return $d = [

                    'name' =>  '',
                    'data' => $data,

                ];
    }

    public function branchMaturityReport($filters = []) {
        $matureLoans = [];
        $loanAccounts = $this->getLoanAccounts($filters);
        foreach ($loanAccounts as $key => $value) {
            $matureLoans[$key]["loan_account_id"] = $value->loan_account_id;
            $matureLoans[$key]["loan_account_num"] = $value->account_num;
            $matureLoans[$key]["client"] = $value->borrower->fullname();
            $matureLoans[$key]["date_released"] = $value->date_release;
            $matureLoans[$key]["due_date"] = $value->due_date;
            // $matureLoans[$key]["balance"] = $value->remainingBalance();
            $matureLoans[$key]["principal_balance"] = $value->remainingBalance()["principal"]["balance"];
            $matureLoans[$key]["interest_balance"] = $value->remainingBalance()["interest"]["balance"];
            $matureLoans[$key]["center"] = $value->center->center;
        }
        return $matureLoans;

    }

    public function branchAOReport($filters = []) {
        $data = [];
        if($filters["group"] == Reports::BRANCH_AO_PERFORMANCE){
            $accOfficers =  AccountOfficer::where(["status" => AccountOfficer::STATUS_ACTIVE, "branch_id" => $filters["branch_id"]])
                ->get()->toArray();
            $products = Product::where(["status" => Product::STATUS_ACTIVE])
                ->get()->toArray();
            foreach ($accOfficers as $aoKey => $aoValue) {
                foreach ($products as $prodKey => $prodValue) {
                    $tempProd = $prodValue;
                    $allAOProd = LoanAccount::where([
                        "status"=>LoanAccount::STATUS_RELEASED,
                        "ao_id"=>$aoValue["ao_id"], 
                        "product_id"=>$prodValue["product_id"]
                    ])
                    ->whereNotIn("loan_status",[LoanAccount::LOAN_PAID])
                    ->get();
                    $tempProd["all"] = ["count" => 0, "amount" => 0];
                    $tempProd["delinquent"] = ["count" => 0, "amount" => 0, "rate" => 0];
                    $tempProd["pastdue"] = ["count" => 0, "amount" => 0, "rate" => 0];
                    foreach ($allAOProd as $key => $value) {
                        $tempProd["all"]["count"] += 1;
                        $tempProd["all"]["amount"] += $value->remainingBalance()["principal"]["balance"];
                        if($value->loan_status == LoanAccount::LOAN_ONGOING){
                            if($value->payment_status == LoanAccount::PAYMENT_DELINQUENT){
                                $tempProd["delinquent"]["count"] += 1;
                                $tempProd["delinquent"]["amount"] += $value->remainingBalance()["principal"]["balance"];
                                $tempProd["delinquent"]["rate"] = ($tempProd["delinquent"]["amount"] / $tempProd["all"]["amount"])*100;
                            }
                        }
                        if($value->loan_status == LoanAccount::LOAN_PASTDUE){
                            $tempProd["pastdue"]["count"] += 1;
                            $tempProd["pastdue"]["amount"] += $value->remainingBalance()["principal"]["balance"];
                            $tempProd["pastdue"]["rate"] = ($tempProd["pastdue"]["amount"] / $tempProd["all"]["amount"])*100;
                        }
                    }
                    $accOfficers[$aoKey]["products"][] = $tempProd;
                }
            }
            $data = $accOfficers;
        }else if($filters["group"] == Reports::BRANCH_AO_WRITEOFF){
            // WRITE OFF REPORTS
        }else if($filters["group"] == Reports::BRANCH_AO_DELINQUENT){
            // DELINQUENT REPORTS
        }
        return $data;
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

    public function microGroup($filters = [], $weeksAndDays, $monthStart, $monthEnd){
        $data = ["monday"=>[],"tuesday"=>[],"wednesday"=>[],"thursday"=>[],"friday"=>[]];
        foreach ($data as $weekDay => $weekDayData) {
            //get centers where center.day_sched
            $centers = Center::where(["center.day_sched"=>$weekDay,"status"=>"active"]) // center daysched  or use center sched in loan account?
                ->get();
            foreach ($centers as $centerId => $centerVal) {
                $data[$weekDay][$centerVal->center]["account_officer"]  = "test_data_api_result";
                $no_of_clients = LoanAccount::join("product", 'loan_accounts.product_id', '=', 'product.product_id')
                    ->where(["loan_accounts.center_id"=>$centerVal->center_id, "product.product_name"=>'micro group'])
                    ->groupBy("loan_accounts.center_id")
                    ->select([DB::raw("ifnull(count(loan_accounts.loan_account_id),0) as no_of_clients")])
                    ->first();
                $data[$weekDay][$centerVal->center]["all"]['no_of_clients'] = $no_of_clients->no_of_clients ? $no_of_clients->no_of_clients : 0;
                $data[$weekDay][$centerVal->center]["all"]["start"] = $monthStart;
                $data[$weekDay][$centerVal->center]["all"]["end"] = $monthEnd;
                $monthPayments = Payment::join("loan_accounts", 'payment.loan_account_id', '=', 'loan_accounts.loan_account_id')
                    ->join("product", 'loan_accounts.product_id', '=', 'product.product_id')
                    ->where(["loan_accounts.center_id"=>$centerVal->center_id, "product.product_name"=>'micro group'])
                    ->whereDate('payment.transaction_date', '>=', $monthStart)
                    ->whereDate('payment.transaction_date', '<=', $monthEnd)
                    ->groupBy("loan_accounts.loan_account_id")
                    ->select(["loan_accounts.loan_account_id","payment.amount_applied as total_paid"])
                    ->get();
                $data[$weekDay][$centerVal->center]["all"]["num_of_payments"] = 0;
                $data[$weekDay][$centerVal->center]["all"]["total_paid"] = 0;
                foreach ($monthPayments as $key => $value) {
                    $data[$weekDay][$centerVal->center]["all"]["num_of_payments"] += 1;
                    $data[$weekDay][$centerVal->center]["all"]["total_paid"] += $value->total_paid;
                }
                foreach($weeksAndDays as $week => $weekData){
                    $data[$weekDay][$centerVal->center]["weeklyData"][$week] = ["num_of_payments"=>0, "total_paid"=>0];
                    $data[$weekDay][$centerVal->center]["weeklyData"][$week]["start"] = $weekData['start'];
                    $data[$weekDay][$centerVal->center]["weeklyData"][$week]["end"] = $weekData['end'];
                    $loanAccounts = Payment::join("loan_accounts", 'payment.loan_account_id', '=', 'loan_accounts.loan_account_id')
                        ->join("product", 'loan_accounts.product_id', '=', 'product.product_id')
                        ->where(["loan_accounts.center_id"=>$centerVal->center_id, "product.product_name"=>'micro group'])
                        ->whereDate('payment.transaction_date', '>=', $weekData['start'])
                        ->whereDate('payment.transaction_date', '<=', $weekData['end'])
                        ->groupBy("loan_accounts.loan_account_id")
                        ->select([DB::raw("count(payment.payment_id) as num_of_payments"),DB::raw("sum(payment.amount_applied) as total_paid")])
                        ->get();
                    foreach ($loanAccounts as $key => $value) {
                        $data[$weekDay][$centerVal->center]["weeklyData"][$week]["num_of_payments"] += 1;
                        $data[$weekDay][$centerVal->center]["weeklyData"][$week]["total_paid"] += $value->total_paid;
                    }
                }
            }
        }
        return $data;
    }

    public function microIndividual($filters = [], $weeksAndDays, $monthStart, $monthEnd){
        $centers = Center::where(["status"=>"active"])->get();
        $data = Payment::join("loan_accounts", 'payment.loan_account_id', '=', 'loan_accounts.loan_account_id')
            ->join("center", "loan_accounts.center_id", "=", "center.center_id")
            ->join("product", 'loan_accounts.product_id', '=', 'product.product_id')
            ->where(["product.product_name"=>'micro individual'])
            ->whereDate('payment.transaction_date', '>=', $monthStart)
            ->whereDate('payment.transaction_date', '<=', $monthEnd)
            ->groupBy("loan_accounts.borrower_id", "loan_accounts.center_id", "center.center", "center.day_sched", "loan_accounts.day_schedule")
            ->select([DB::raw("count(payment.payment_id) as num_of_payments"), DB::raw("sum(payment.amount_applied) as total_paid"), "loan_accounts.borrower_id", "loan_accounts.center_id", "center.center", "loan_accounts.day_schedule as loanSched", "center.day_sched as centerSched"])
            ->get()->toArray();
        foreach($data as $key => $paymentData) {
            $data[$key]["borrower"] = Borrower::find($paymentData['borrower_id'])->fullname();
            foreach($weeksAndDays as $week => $weekData){
                $loanAccounts = Payment::join("loan_accounts", 'payment.loan_account_id', '=', 'loan_accounts.loan_account_id')
                    ->join("product", 'loan_accounts.product_id', '=', 'product.product_id')
                    ->where(["loan_accounts.center_id"=>$paymentData['center_id'], "loan_accounts.borrower_id"=>$paymentData['borrower_id'], "product.product_name"=>'micro individual'])
                    ->whereDate('payment.transaction_date', '>=', $weekData['start'])
                    ->whereDate('payment.transaction_date', '<=', $weekData['end'])
                    ->groupBy("loan_accounts.borrower_id", "loan_accounts.center_id")
                    ->select([DB::raw("count(payment.payment_id) as num_of_payments"),DB::raw("sum(payment.amount_applied) as total_paid")])
                    ->first();
                $data[$key]["weeklyData"][$week] = $loanAccounts ? $loanAccounts : ["num_of_payments"=>0, "total_paid"=>0];
                $data[$key]["weeklyData"][$week]["start"] = $weekData['start'];
                $data[$key]["weeklyData"][$week]["end"] = $weekData['end'];
            }
        }
        return $data;
    }


}