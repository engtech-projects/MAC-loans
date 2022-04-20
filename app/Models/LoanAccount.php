<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanAccount extends Model
{
    use HasFactory;
    protected $table = 'loan_accounts';
   	protected $primaryKey = 'loan_account_id';


   	protected $fillable = [
		'account_num',
		'date_release',
		'cycle_no',
		'ao_id',
		'product_id',
		'center_id',
		'type',
		'payment_mode',
		'terms',
		'loan_amount',
		'interest_rate',
		'interest_amount',
		'no_of_installment',
		'due_date',
		'day_schedule',
		'borrower_num',
		'borrower_id',
		'co_borrower_name',
		'co_borrower_address',
		'co_borrower_id_type',
		'co_borrower_id_number',
		'co_borrower_id_date_issued',
		'co_maker_name',
		'co_maker_address',
		'co_maker_id_type',
		'co_maker_id_number',
		'co_maker_id_date_issued',
		'document_stamp',
		'filing_fee',
		'insurance',
		'notarial_fee',
		'prepaid_interest',
		'affidavit_fee',
		'memo',
		'total_deduction',
		'net_proceeds',
		'release_type',
		'status',
		'branch_code',
		'transaction_date',
    ];


   	public static function generateAccountNum(Branch $branch, Product $product) {
   		return '1001-1001-001';

   	}

   	public function getCycleNo() {
   		return 1;
   	}

   	public function overrideReleaseAccounts($filters = array()) {
   		$accounts = new LoanAccount();

   		$accounts = LoanAccount::where('status', '=', 'pending');

   		if( isset($filters['created_at']) && $filters['created_at'] ){
   			$accounts->whereDate('loan_accounts.created_at', '=', $filters['created_at'] );
   		}

   		if( isset($filters['ao_id']) && $filters['ao_id'] ){
   			$accounts->where('loan_accounts.ao_id', '=', $filters['ao_id']);
   		}

   		if( isset($filters['center_id']) && $filters['center_id'] ){
   			$accounts->where('loan_accounts.center_id', '=', $filters['center_id']);
   		}

		if( isset($filters['product_id']) && $filters['product_id'] ){
   			$accounts->where('loan_accounts.product_id', '=', $filters['product_id']);
   		}

   		return $accounts->get();
   	}

   	public function center() {
   		return Center::find($this->center_id);
   	}

   	public function product(){
   		return Product::find($this->product_id);
   	}

   	public function borrower() {
   		return Borrower::find($this->borrower_id);
   	}

   	// public function generateAmortizationSched($installments, $dueDate) {}

}
