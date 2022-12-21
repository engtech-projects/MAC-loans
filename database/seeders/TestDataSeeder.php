<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Faker\Factory as Faker;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fake = Faker::create();

        DB::table('end_transaction')->insert([
            [
                'id' => "1",
                'branch_id' => "1",
                'date_end' => Carbon::now()->format("Y-m-d"),
                'status' => "open",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        DB::table('product')->insert([
            [
                'product_code' => '000',
                'product_name' => 'Unknown Product',
                'interest_rate' => '0',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_code' => '001',
                'product_name' => 'Micro Individual',
                'interest_rate' => '2',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_code' => '002',
                'product_name' => 'Micro Group',
                'interest_rate' => '4',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_code' => '003',
                'product_name' => 'Pension Loan',
                'interest_rate' => '4',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_code' => '004',
                'product_name' => 'Pnsion Emergency',
                'interest_rate' => '2',
                'status' => 'inactive',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_code' => '005',
                'product_name' => 'Salary Loan',
                'interest_rate' => '2',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_code' => '006',
                'product_name' => 'Salry Emergency',
                'interest_rate' => '2',
                'status' => 'inactive',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_code' => '007',
                'product_name' => 'SME Loan',
                'interest_rate' => '4',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_code' => '008',
                'product_name' => 'Allotment Loan',
                'interest_rate' => '4',
                'status' => 'active',
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
                'day_sched' => 'monday',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'center' => 'Pineapple',
                'day_sched' => 'tuesday',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        DB::table('borrower_info')->insert([
            [
                'borrower_num' => '0000001',
                'date_registered' => $fake->date(),
                'firstname' => $fake->firstName,
                'middlename' => $fake->randomLetter,
                'lastname' => $fake->lastName,
                'suffix' => '',
                'address' => $fake->city,
                'birthdate' => $fake->date(),
                'gender' => 'male',
                'status' => 'married',
                'contact_number' => '09'.$fake->randomNumber($nbDigits =9,$strict = true),
                'id_type' => 'SSS',
                'id_no' => '233-456-456',
                'id_date_issued' => $fake->date(),
                'spouse_firstname' => $fake->firstName,
                'spouse_middlename' => $fake->randomLetter,
                'spouse_lastname' => $fake->lastName,
                'spouse_address' => 'Libertad Butuan City',
                'spouse_birthdate' => $fake->date(),
                'spouse_contact_number' => '123456',
                'spouse_id_type' => 'SSS',
                'spouse_id_no' => '233-456-456',
                'spouse_id_date_issued' => $fake->date(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'username' => 'VincentPadilla',
                'password' => Hash::make("admin"),
            ]
        ]);
        DB::table('loan_accounts')->insert([
            [
                'account_num' => '001-001-0000001',
                'date_release' => Carbon::now()->format('Y-m-d'),
                'transaction_date' => Carbon::now()->format("Y-m-d"),
                'cycle_no' => '1',
                'ao_id' => '1',
                'product_id' => '1',
                'type' => 'Add-On',
                'payment_mode' => 'Monthly',
                'terms' => '180',
                'loan_amount' => '20000',
                'interest_rate' => '4',
                'interest_amount' => '4800',
                'no_of_installment' => '6',
                'due_date' => '2023-01-23',
                'day_schedule' => '1',
                'borrower_num' => '0000001',
                'borrower_id' => '1',
                'co_borrower_name' => $fake->name,
                'co_borrower_address' => $fake->city,
                'co_borrower_id_type' => 'SSS',
                'co_borrower_id_number' => '89-8712398',
                'co_borrower_id_date_issued' => '2020-10-02',
                'co_maker_name' => $fake->name,
                'co_maker_address' => $fake->city,
                'co_maker_id_type' => 'TIN',
                'co_maker_id_number' => '1234',
                'co_maker_id_date_issued' => '2020-05-01',
                'document_stamp' => '73.97',
                'filing_fee' => '200',
                'insurance' => '120',
                'notarial_fee' => '100',
                'prepaid_interest' => '0',
                'affidavit_fee' => '0',
                'memo' => '0',
                'total_deduction' => '493.97',
                'net_proceeds' => '19506.03',
                'release_type' => 'Cash',
                'status' => 'pending',
                'branch_code' => '001',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        DB::table('documents')->insert([
            [
                'loan_account_id' => '1',
                'date_release' => Carbon::now(),
                'description' => 'Land Title',
                'bank' => 'Metro Bank',
                'account_no' => 'ACC NUMBER',
                'card_no' => '182654',
                'promissory_number' => '001-001-0000001',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

    }
}
