<?php

namespace Database\Seeders;

use App\Models\AccountOfficer;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AccountOfficerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $account_officer = [
            [
                'ao_id' => '1',
                'name' => 'Robert Dumaog',
                'branch_id' => '001',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'ao_id' => '2',
                'name' => 'Jimmy A. Castillo',
                'branch_id' => '001',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ao_id' => '3',
                'name' => 'Jomel T. Gallenero',
                'branch_id' => '001',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ao_id' => '4',
                'name' => 'Randy F. Navarro',
                'branch_id' => '001',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ao_id' => '5',
                'name' => 'Butuan Branch Office',
                'branch_id' => '001',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ao_id' => '21',
                'name' => 'John Rey Mark Jamen',
                'branch_id' => '002',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ao_id' => '22',
                'name' => 'John Mark Barcenas',
                'branch_id' => '002',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ao_id' => '23',
                'name' => 'Lemuel Roy S Salcedo',
                'branch_id' => '003',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ao_id' => '24',
                'name' => 'Nasipit Branch Ofs.',
                'branch_id' => '001',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ao_id' => '25',
                'name' => 'Janine L. Descallar',
                'branch_id' => '002',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ao_id' => '40',
                'name' => 'Jomel T. Gallanero',
                'branch_id' => '002',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ao_id' => '41',
                'name' => 'Unknown AO',
                'branch_id' => '001',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        $data = collect($account_officer)->map(function ($item) {
            return [
                'ao_id' => $item['ao_id'],
                'name' => $item['name'],
                'branch_id' => $item['branch_id'],
                'created_at' => $item['created_at'],
                'updated_at' => $item['updated_at'],
            ];
        })->toArray();
        AccountOfficer::upsert(
            $data,
            ['ao_id'],
            ['name', 'branch_id',]
        );
    }
}
