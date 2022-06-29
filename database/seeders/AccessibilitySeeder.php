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
            // client information
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
        		'group' => 'Personal Information',
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
            [ 
                'label' => 'Edit Co-Maker',
                'group' => 'Statement of Accounts',
                'permission' => 'edit co-maker',
                'description' => 'description',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(), 
            ],
        	[ 
        		'label' => 'Balance Inquiry',
        		'group' => 'Client Information',
        		'permission' => 'view balance inquiry',
        		'description' => 'description',
        		'created_at' => Carbon::now(),
            	'updated_at' => Carbon::now(), 
        	],
            // transaction
        	[ 
        		'label' => 'Release Entry',
        		'group' => 'Transaction',
        		'permission' => 'view release entry',
        		'description' => 'description',
        		'created_at' => Carbon::now(),
            	'updated_at' => Carbon::now(), 
        	],
        	[ 
        		'label' => 'Override Release',
        		'group' => 'Transaction',
        		'permission' => 'view override release',
        		'description' => 'description',
        		'created_at' => Carbon::now(),
            	'updated_at' => Carbon::now(), 
        	],
            [ 
                'label' => 'Delete Releases',
                'group' => 'Override Release',
                'permission' => 'delete releases',
                'description' => 'description',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(), 
            ],
            [ 
                'label' => 'Reject Releases',
                'group' => 'Override Release',
                'permission' => 'reject releases',
                'description' => 'description',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(), 
            ],
        	[ 
        		'label' => 'Rejected Release',
        		'group' => 'Transaction',
        		'permission' => 'view rejected release',
        		'description' => 'description',
        		'created_at' => Carbon::now(),
            	'updated_at' => Carbon::now(), 
        	],
        	[ 
        		'label' => 'Repayment Entry',
        		'group' => 'Transaction',
        		'permission' => 'view repayment entry',
        		'description' => 'description',
        		'created_at' => Carbon::now(),
            	'updated_at' => Carbon::now(), 
        	],
        	[ 
        		'label' => 'Override Payment',
        		'group' => 'Transaction',
        		'permission' => 'view override payment',
        		'description' => 'description',
        		'created_at' => Carbon::now(),
            	'updated_at' => Carbon::now(), 
        	],
            [ 
                'label' => 'Delete Payment',
                'group' => 'Override Payment',
                'permission' => 'view override payment',
                'description' => 'description',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(), 
            ],
            // maintenance
            [ 
                'label' => 'Cancel Payment',
                'group' => 'Maintenance',
                'permission' => 'view cancelled payments',
                'description' => 'description',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(), 
            ],
            [ 
                'label' => 'Product Setup',
                'group' => 'Maintenance',
                'permission' => 'view product setup',
                'description' => 'description',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(), 
            ],
            [ 
                'label' => 'Center - AO Setup',
                'group' => 'Maintenance',
                'permission' => 'view center',
                'description' => 'description',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(), 
            ],
            [ 
                'label' => 'GL Setup',
                'group' => 'Maintenance',
                'permission' => 'view gl setup',
                'description' => 'description',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(), 
            ],
            [ 
                'label' => 'User Setting',
                'group' => 'Maintenance',
                'permission' => 'view users',
                'description' => 'description',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(), 
            ],
            [ 
                'label' => 'Account Retagging',
                'group' => 'Maintenance',
                'permission' => 'view account retagging',
                'description' => 'description',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(), 
            ],
            // reports
            [ 
                'label' => 'Transaction',
                'group' => 'Reports',
                'permission' => 'view transaction report',
                'description' => 'description',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(), 
            ],
            [ 
                'label' => 'Release',
                'group' => 'Reports',
                'permission' => 'view release report',
                'description' => 'description',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(), 
            ],
            [ 
                'label' => 'Repayment',
                'group' => 'Reports',
                'permission' => 'view repayment report',
                'description' => 'description',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(), 
            ],
            [ 
                'label' => 'Collection',
                'group' => 'Reports',
                'permission' => 'view collection report',
                'description' => 'description',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(), 
            ],
        ];

        DB::table('accessibility')->insert($permissions);
    }
}
