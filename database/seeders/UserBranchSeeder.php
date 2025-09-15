<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserBranch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserBranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_branch = [
            [
                'id' => "1",
                'branch_id' => "1",
            ],
            [
                'id' => "2",
                'branch_id' => "2",
            ],
            [
                'id' => "3",
                'branch_id' => "3",
            ],
            [
                'id' => "8",
                'branch_id' => "2",
            ],

        ];

        try {
            DB::transaction(function () use ($user_branch) {
                $grouped = collect($user_branch)->groupBy('id');
                foreach ($grouped as $id => $records) {
                    $branchIds = $records->pluck('branch_id')->toArray();
                    $user = User::find($id);
                    if ($user) {
                        $user->user_branch()->syncWithoutDetaching($branchIds);
                    }
                }
            });
        } catch (\Exception $e) {
            var_dump(['message' => 'Transaction Failed.', 'errorr' => $e->getMessage()]);
        }
    }
}
