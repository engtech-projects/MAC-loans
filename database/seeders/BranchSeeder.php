<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $branches = [
            [
                'branch_code' => "001",
                'branch_name' => "Butuan City",
                'branch_manager' => "Janine L. Descallar",
                'branch_address' => "Butuan City",
                'status' => "active",
            ],
            [
                'branch_code' => "002",
                'branch_name' => "Nasipit",
                'branch_manager' => "Jomel T. Gallanero",
                'branch_address' => "Nasipit",
                'status' => "active",
            ],
            [
                'branch_code' => "003",
                'branch_name' => "Gingoog",
                'branch_manager' => "Mark",
                'branch_address' => "Gingoog City",
                'status' => "active",
            ]
        ];

        $data = collect($branches)->map(function ($item) {
            return [
                'branch_code' => $item['branch_code'],
                'branch_name' => $item['branch_name'],
                'branch_manager' => $item['branch_manager'],
                'branch_address' => $item['branch_address'],
                'status' => $item['status']
            ];
        })->toArray();
        Branch::upsert(
            $data,
            ['branch_code'],
            ['branch_code', 'branch_name', 'branch_address']
        );
    }
}
