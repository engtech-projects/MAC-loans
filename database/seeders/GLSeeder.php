<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GLSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$gl = [
    		[
    			'loans' => 'Loan Receivable',
    			'code' => '1205',
    			'accounting' => 'Loans Receivable - Current',
    			'type' => 'releasing',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
    		],
    		[
    			'loans' => 'Check',
    			'code' => '1045',
    			'accounting' => 'Cash in Bank (MYB)',
    			'type' => 'releasing',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
    		],
    		[
    			'loans' => 'Cash',
    			'code' => '1010',
    			'accounting' => 'Cash on Hand',
    			'type' => 'releasing',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
    		],
    		[
    			'loans' => 'Filing Fee',
    			'code' => '4020',
    			'accounting' => 'Filing Fees',
    			'type' => 'releasing',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
    		],
    		[
    			'loans' => 'Documentary Stamp',
    			'code' => '2030',
    			'accounting' => 'Documentary Stamp Tax Payable',
    			'type' => 'releasing',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
    		],
    		[
    			'loans' => 'Insurance',
    			'code' => '2040',
    			'accounting' => 'Loan Insurance Payable',
    			'type' => 'releasing',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
    		],
    		[
    			'loans' => 'Notarial',
    			'code' => '2015',
    			'accounting' => 'Notarial Payable',
    			'type' => 'releasing',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
    		],
    		[
    			'loans' => 'Prepaid',
    			'code' => '2100',
    			'accounting' => 'Un-earned Interest & Discounts (UID)',
    			'type' => 'releasing',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
    		],
    		[
    			'loans' => 'Others',
    			'code' => '2020',
    			'accounting' => 'Affidavit - Payable',
    			'type' => 'releasing',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
    		],
    		[
    			'loans' => 'Memo',
    			'code' => '1010',
    			'accounting' => 'Cash on Hand',
    			'type' => 'releasing',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
    		],
    		[
				'loans' => 'Check',
    			'code' => '2085',
    			'accounting' => 'Accounts Payable Check for Clearing',
    			'type' => 'repayment',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
    		],
    		[
				'loans' => 'Cash',
    			'code' => '1010',
    			'accounting' => 'Cash on Hand',
    			'type' => 'repayment',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
    		],
    		[
				'loans' => 'Rebates',
    			'code' => '4010',
    			'accounting' => 'Interest Income',
    			'type' => 'repayment',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
    		],
			[
				'loans' => 'Loan Receivable',
				'code' => '1205',
				'accounting' => 'Loans Receivable - Current',
				'type' => 'repayment',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			],
    		[
    			'loans' => 'Interest Income',
    			'code' => '4010',
    			'accounting' => 'Interest Income',
    			'type' => 'repayment',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
    		],
    		[
    			'loans' => 'Penalty Income',
    			'code' => '4025',
    			'accounting' => 'Fines, Penalties, Surcharges',
    			'type' => 'repayment',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
    		],
    		[
    			'loans' => 'Others',
    			'code' => '2045',
    			'accounting' => 'Over payment',
    			'type' => 'repayment',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
    		],
    		[
    			'loans' => 'Pastdue Interest',
    			'code' => '4026',
    			'accounting' => 'Past Due Interest Income',
    			'type' => 'repayment',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
    		],
    		[
    			'loans' => 'Prepaid Interest',
    			'code' => '2100',
    			'accounting' => 'Un-earned Interest & Discounts (UID)',
    			'type' => 'repayment',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
    		],
    		[
    			'loans' => 'Memo',
    			'code' => '1010',
    			'accounting' => 'Cash on Hand',
    			'type' => 'repayment',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
    		],
    		[
    			'loans' => 'VAT Payable',
    			'code' => '2065',
    			'accounting' => 'VAT Payable',
    			'type' => 'repayment',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
    		],
    		[
    			'loans' => 'VAT',
    			'code' => '4010',
    			'accounting' => 'Interest Income',
    			'type' => 'repayment',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
    		],
    		[
    			'loans' => 'Rebates',
    			'code' => '4010',
    			'accounting' => 'Interest Income',
    			'type' => 'repayment',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
    		],
    		[
    			'loans' => 'PDI',
    			'code' => '4026',
    			'accounting' => 'Past Due Interest Income',
    			'type' => 'repayment',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
    		],
    		[
    			'loans' => 'Penalty',
    			'code' => '4025',
    			'accounting' => 'Fines, Penalties, Surcharges',
    			'type' => 'repayment',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
    		],
    		[
    			'loans' => 'POS',
    			'code' => '1060',
    			'accounting' => 'Cash in Bank - BDO',
    			'type' => 'repayment',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
    		],
    	];

    	DB::table('general_ledger')->insert($gl);

    }
}
