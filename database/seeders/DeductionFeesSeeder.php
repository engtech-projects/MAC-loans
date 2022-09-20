<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DeductionFeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $docStamp = [
            [
                "name" => "Documentary Stamp",
                "rate" => 300,
                "term_start" => 0,
                "term_end" => 365,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
            ],
            [
                "name" => "Documentary Stamp",
                "rate" => 300,
                "term_start" => 366,
                "term_end" => 9999,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
            ],
        ];
        $filingFee = [
            [
                "name" => "Filing Fee",
                "rate" => 200,
                "product_id" => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
            ],
            [
                "name" => "Filing Fee",
                "rate" => 200,
                "product_id" => 2,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
            ],
            [
                "name" => "Filing Fee",
                "rate" => 100,
                "product_id" => 5,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
            ],
            [
                "name" => "Filing Fee",
                "rate" => 100,
                "product_id" => 7,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
            ],
            [
                "name" => "Filing Fee",
                "rate" => 100,
                "product_id" => 8,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
            ],
        ];
        $filingFeeSalary = [
            [
                "name" => "Filing Fee",
                "rate" => "1%",
                "product_id" => 3,
                "term_start" => 0,
                "term_end" => 365,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
            ],
            [
                "name" => "Filing Fee",
                "rate" => "2%",
                "product_id" => 3,
                "term_start" => 366,
                "term_end" => 9999,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
            ],
        ];
        $insurance = [
            [
                "name" => "Insurance",
                "rate" => 1,
                "term_start" => 0,
                "term_end" => 365,
                "age_start" => 18,
                "age_end" => 65,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
            ],
            [
                "name" => "Insurance",
                "rate" => 2.8,
                "term_start" => 0,
                "term_end" => 365,
                "age_start" => 66,
                "age_end" => 75,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
            ],
            [
                "name" => "Insurance",
                "rate" => 1,
                "term_start" => 366,
                "term_end" => 9999,
                "age_start" => 18,
                "age_end" => 65,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
            ],
            [
                "name" => "Insurance",
                "rate" => 2.8,
                "term_start" => 366,
                "term_end" => 9999,
                "age_start" => 66,
                "age_end" => 75,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
            ],
        ];
        $notarialFee = [
            [
                "name" => "Notarial Fee",
                "rate" => 100,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
            ]
        ];
        DB::table('deduction_rate')->insert($docStamp);
        DB::table('deduction_rate')->insert($filingFee);
        DB::table('deduction_rate')->insert($filingFeeSalary);
        DB::table('deduction_rate')->insert($insurance);
        DB::table('deduction_rate')->insert($notarialFee);
    }
}
