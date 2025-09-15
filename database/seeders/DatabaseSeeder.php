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
            UserAccessibilitySeeder::class,
            BranchSeeder::class,
            ProductSeeder::class,
            UserBranchSeeder::class,
            GLSeeder::class,
            DeductionFeesSeeder::class,
        ]);
    }
}
