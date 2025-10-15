<?php

namespace Database\Seeders;

use App\Models\Accessibility;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserAccessibilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::where('username', 'mac_admin')->orWhere('id', 1)->first();
        $accesbilityIds = Accessibility::all()->pluck('access_id');
        try {
            DB::transaction(function () use ($accesbilityIds, $user) {
                if ($user) {
                    $user->accessibility()->syncWithoutDetaching($accesbilityIds);
                }
            });
        } catch (\Exception $e) {
            var_dump(['message' => 'Transaction Failed.', 'errorr' => $e->getMessage()]);
        }
    }
}
