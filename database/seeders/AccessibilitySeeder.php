<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AccessibilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
        	[ 
        		'label' => 'Personal Information',
        		'group' => 'Client Information',
        		'permission' => 'view borrower',
        		'description' => 'description',
        		'created_at' => Carbon::now(),
            	'updated_at' => Carbon::now(), 
        	],
        	[ 
        		'label' => 'Update Personal Info',
        		'group' => 'Client Information',
        		'permission' => 'edit borrower',
        		'description' => 'description',
        		'created_at' => Carbon::now(),
            	'updated_at' => Carbon::now(), 
        	],
            [ 
                'label' => 'Statement of Accounts',
                'group' => 'Client Information',
                'permission' => 'view statement of accounts',
                'description' => 'description',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(), 
            ],
        	// [ 
        	// 	'label' => 'Balance Inquiry',
        	// 	'group' => 'Client Information',
        	// 	'permission' => 'balance_inquiry',
        	// 	'description' => 'description',
        	// 	'created_at' => Carbon::now(),
         //    	'updated_at' => Carbon::now(), 
        	// ],
        	// [ 
        	// 	'label' => 'Release Entry',
        	// 	'group' => 'Transaction',
        	// 	'permission' => 'release_entry',
        	// 	'description' => 'description',
        	// 	'created_at' => Carbon::now(),
         //    	'updated_at' => Carbon::now(), 
        	// ],
        	// [ 
        	// 	'label' => 'Override Release',
        	// 	'group' => 'Transaction',
        	// 	'permission' => 'override_release',
        	// 	'description' => 'description',
        	// 	'created_at' => Carbon::now(),
         //    	'updated_at' => Carbon::now(), 
        	// ],
        	// [ 
        	// 	'label' => 'Rejected Release',
        	// 	'group' => 'Transaction',
        	// 	'permission' => 'rejected_release',
        	// 	'description' => 'description',
        	// 	'created_at' => Carbon::now(),
         //    	'updated_at' => Carbon::now(), 
        	// ],
        	// [ 
        	// 	'label' => 'Repayment Entry',
        	// 	'group' => 'Transaction',
        	// 	'permission' => 'repayment_entry',
        	// 	'description' => 'description',
        	// 	'created_at' => Carbon::now(),
         //    	'updated_at' => Carbon::now(), 
        	// ],
        	// [ 
        	// 	'label' => 'Override Payment',
        	// 	'group' => 'Transaction',
        	// 	'permission' => 'override_payment',
        	// 	'description' => 'description',
        	// 	'created_at' => Carbon::now(),
         //    	'updated_at' => Carbon::now(), 
        	// ],
        ];

        DB::table('accessibility')->insert($permissions);
    }
}
