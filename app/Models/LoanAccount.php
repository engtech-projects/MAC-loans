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
   		$account = new LoanAccount();

   		return $account->whereDate('loan_accounts.created_at', '=', $filters['created_at'] )
   				->where('loan_accounts.status', '=', 'pending')
   				->get();
   	}

   	public function center() {
   		return Center::find($this->center_id)->first();
   	}

   	public function product(){
   		return Product::find($this->product_id)->first();
   	}

   	// public function generateAmortizationSched($installments, $dueDate) {}

}
