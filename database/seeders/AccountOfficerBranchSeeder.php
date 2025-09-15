<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AccountOfficer;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use App\Models\AccountOfficerBranch;
use Illuminate\Support\Facades\DB;

class AccountOfficerBranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $account_officer_branch = [
            [
                'ao_id' => '1',
                'branch_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'ao_id' => '2',
                'branch_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ao_id' => '3',
                'branch_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ao_id' => '4',
                'branch_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ao_id' => '5',
                'branch_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ao_id' => '25',
                'branch_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ao_id' => '3',
                'branch_id' => '2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ao_id' => '21',
                'branch_id' => '2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ao_id' => '22',
                'branch_id' => '2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ao_id' => '23',
                'branch_id' => '2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ao_id' => '24',
                'branch_id' => '2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ao_id' => '25',
                'branch_id' => '2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ao_id' => '40',
                'branch_id' => '3',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ao_id' => '40',
                'branch_id' => '2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];
        try {
            DB::transaction(function () use ($account_officer_branch) {
                $grouped = collect($account_officer_branch)->groupBy('ao_id');
                foreach ($grouped as $aoId => $records) {
                    $branchIds = $records->pluck('branch_id')->toArray();
                    $ao = AccountOfficer::find($aoId);
                    if ($ao) {
                        $ao->branch_registered()->sync($branchIds);
                    }
                }
            });
        } catch (\Exception $e) {
            var_dump(['message' => 'Transaction Failed.', 'errorr' => $e->getMessage()]);
        }
    }
}
