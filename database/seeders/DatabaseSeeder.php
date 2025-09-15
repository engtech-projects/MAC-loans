<?php

namespace Database\Seeders;

use App\Models\UserAccessibility;
use App\Models\UserBranch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            AccessibilitySeeder::class,
            UserAccessibility::class,
            BranchSeeder::class,
            AccountOfficerSeeder::class,
            AccountOfficerBranchSeeder::class,
            CenterSeeder::class,
            ProductSeeder::class,
            UserBranch::class,
            GLSeeder::class,
            DeductionFeesSeeder::class,
        ]);
    }
}
