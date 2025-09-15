<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'product_code' => '001',
                'product_name' => 'Micro Individual',
                'interest_rate' => '2',
                'status' => 'active',
            ],
            [
                'product_code' => '002',
                'product_name' => 'Micro Group',
                'interest_rate' => '4',
                'status' => 'active',
            ],
            [
                'product_code' => '003',
                'product_name' => 'Pension Loan',
                'interest_rate' => '4',
                'status' => 'active',
            ],
            [
                'product_code' => '004',
                'product_name' => 'Pnsion Emergency',
                'interest_rate' => '2',
                'status' => 'inactive',
            ],
            [
                'product_code' => '005',
                'product_name' => 'Salary Loan',
                'interest_rate' => '2',
                'status' => 'active',
            ],
            [
                'product_code' => '006',
                'product_name' => 'Salry Emergency',
                'interest_rate' => '2',
                'status' => 'inactive',
            ],
            [
                'product_code' => '007',
                'product_name' => 'SME Loan',
                'interest_rate' => '4',
                'status' => 'active',
            ],
            [
                'product_code' => '008',
                'product_name' => 'Allotment Loan',
                'interest_rate' => '4',
                'status' => 'active',
            ],
            [
                'product_code' => '000',
                'product_name' => 'Unknown Product',
                'interest_rate' => '0',
                'status' => 'active',
            ]
        ];

        $data = collect($products)->map(function ($item) {
            return [
                'product_code' => $item['product_code'],
                'product_name' => $item['product_name'],
                'interest_rate' => $item['interest_rate'],
                'status' => $item['status']
            ];
        })->toArray();
        Product::upsert(
            $data,
            ['product_code'],
            ['product_code', 'product_name', 'interest_rate', 'status']
        );
    }
}
