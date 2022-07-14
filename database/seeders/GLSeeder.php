<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
    			'loans' => 'Check',
    			'code' => '1045',
    			'accounting' => 'Cash in Bank (MYB)',
    			'type' => 'releasing'
    		],
    		[
    			'loans' => 'Cash',
    			'code' => '1010',
    			'accounting' => 'Cash on Hand',
    			'type' => 'releasing'
    		],
    		[
    			'loans' => 'Filing Fee',
    			'code' => '4020',
    			'accounting' => 'Filing Fees',
    			'type' => 'releasing'
    		],
    		[
    			'loans' => 'Documentary Stamp',
    			'code' => '2030',
    			'accounting' => 'Documentary Stamp Tax Payable',
    			'type' => 'releasing'
    		],
    		[
    			'loans' => 'Insurance',
    			'code' => '2040',
    			'accounting' => 'Loan Insurance Payable',
    			'type' => 'releasing'
    		],
    		[
    			'loans' => 'Notarial',
    			'code' => '2015',
    			'accounting' => 'Notarial Payable',
    			'type' => 'releasing'
    		],
    		[
    			'loans' => 'Prepaid',
    			'code' => '2100',
    			'accounting' => 'Un-earned Interest & Discounts (UID)',
    			'type' => 'releasing'
    		],
    		[
    			'loans' => 'Others',
    			'code' => '2020',
    			'accounting' => 'Affidavit - Payable',
    			'type' => 'releasing'
    		],
    		[
    			'loans' => 'Memo',
    			'code' => '1010',
    			'accounting' => 'Cash on Hand',
    			'type' => 'releasing'
    		],
    	];

    	DB::table('general_ledger')->insert($gl);

    }
}
