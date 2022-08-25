<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('branch')->insert([
            [
                'branch_code' => "001",
                'branch_name' => "Butuan City",
                'branch_manager' => "Janine L. Descallar",
                'branch_address' => "Butuan City",
                'status' => "active",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(), 
            ],[
                'branch_code' => "002",
                'branch_name' => "Nasipit",
                'branch_manager' => "Jomel T. Gallanero",
                'branch_address' => "Nasipit",
                'status' => "active",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(), 
            ]
        ]);

        DB::table('user_branch')->insert([
            [
                'id' => "1",
                'branch_id' => "1",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(), 
            ],[
                'id' => "2",
                'branch_id' => "2",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(), 
            ]
        ]);

        DB::table('product')->insert([
            [
                'product_code' => '001',
                'product_name' => 'Salary Loan',
                'interest_rate' => '2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(), 
            ],
            [
                'product_code' => '002',
                'product_name' => 'Micro Group',
                'interest_rate' => '4',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(), 
            ]
        ]);
        
        DB::table('account_officer')->insert([
            [
                'name' => 'Jomel T. Gallanero',
                'branch_id' => '001',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(), 
                
            ],
            [
                'name' => 'Janine L. Descallar',
                'branch_id' => '002',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(), 
            ]
        ]);
        
        DB::table('center')->insert([
            [
                'center' => 'Acasia',
                'day_sched' => 'Monday',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(), 
                
            ],
            [
                'center' => 'Pineapple',
                'day_sched' => 'Tuesday',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(), 
            ]
        ]);
        
        DB::table('borrower_info')->insert([
            [
                'borrower_num' => '0000001',
                'date_registered' => '2015-04-11',
                'firstname' => 'Vincent',
                'middlename' => 'L',
                'lastname' => 'Padilla',
                'suffix' => '',
                'address' => 'Libertad Butuan City',
                'birthdate' => '1995-02-12',
                'gender' => 'male',
                'status' => 'single',
                'contact_number' => '9639427945',
                'id_type' => 'SSS',
                'id_no' => '233-456-456',
                'id_date_issued' => '2015-04-11',
                'spouse_firstname' => 'May Ann',
                'spouse_middlename' => 'J',
                'spouse_lastname' => 'Padilla',
                'spouse_address' => 'Libertad Butuan City',
                'spouse_birthdate' => '1997-05-11',
                'spouse_contact_number' => '',
                'spouse_id_type' => 'SSS',
                'spouse_id_no' => '233-456-456',
                'spouse_id_date_issued' => '2015-04-11',  
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(), 
                'username' => 'VincentPadilla',
                'password' => Hash::make("admin"),
            ]
        ]);




    }
}
