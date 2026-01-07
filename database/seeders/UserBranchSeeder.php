<?php

namespace Database\Seeders;

use App\Models\Branch;
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
        $user = User::where('username', 'mac_admin')->orWhere('id', 1)->first();
        $branches = Branch::all()->pluck('branch_id');

        try {
            DB::transaction(function () use ($user, $branches) {
                if ($user) {
                    $user->user_branch()->syncWithoutDetaching($branches);
                }
            });
        } catch (\Exception $e) {
            var_dump(['message' => 'Transaction Failed.', 'errorr' => $e->getMessage()]);
        }
    }
}
