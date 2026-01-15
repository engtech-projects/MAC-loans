<?php

namespace Database\Seeders;


use App\Models\User;
use App\Models\UserAccessibility;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users = [
            [
                'username' => 'mac_admin',
                'password' => Hash::make('@engtech'),
                'firstname' => 'Admin',
                'middlename' => 'admin',
                'lastname' => 'admin',
                'status' => 'active',
                'updated_at' => now(),
            ],
            [
                'username' => 'admin',
                'password' => Hash::make('admin'),
                'firstname' => 'Jeremae',
                'middlename' => 'G',
                'lastname' => 'Payot',
                'status' => 'active',
                'updated_at' => now(),
            ],
            [
                'username' => 'adminn',
                'password' => Hash::make('admin'),
                'firstname' => 'Janine',
                'middlename' => 'L',
                'lastname' => 'Descalar',
                'status' => 'active',
                'updated_at' => now(),
            ],
            [
                'username' => 'adminnn',
                'password' => Hash::make('admin'),
                'firstname' => 'Mark',
                'middlename' => '',
                'lastname' => '',
                'status' => 'active',
                'updated_at' => now(),
            ]
        ];

        User::upsert(
            $users,
            ['username'],
            ['username', 'firstname', 'password', 'middlename', 'lastname', 'status']
        );
    }
}
