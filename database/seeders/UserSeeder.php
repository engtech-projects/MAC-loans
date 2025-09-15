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

                // 'branch_id' => 1,
            ],
            [
                'username' => 'admin',
                'password' => Hash::make('admin'),
                'firstname' => 'Jeremae',
                'middlename' => 'G',
                'lastname' => 'Payot',
                'status' => 'active',
                'updated_at' => now(),
                // 'branch_id' => 1,
            ],
            [
                'username' => 'adminn',
                'password' => Hash::make('admin'),
                'firstname' => 'Janine',
                'middlename' => 'L',
                'lastname' => 'Descalar',
                'status' => 'active',
                'updated_at' => now(),
                // 'branch_id' => 1,
            ],
            [
                'username' => 'adminnn',
                'password' => Hash::make('admin'),
                'firstname' => 'Mark',
                'middlename' => '',
                'lastname' => '',
                'status' => 'active',
                'updated_at' => now(),
                // 'branch_id' => 1,
            ]
        ];

        User::upsert(
            $users,
            ['username'],
            ['username', 'firstname', 'password', 'middlename', 'lastname', 'status']
        );


        /* $users = User::where('id', [1, 2, 3])->get();
        $userAccess = UserAccessibility::where('id', [1, 2, 3])->get();
        $accessibilities = Accessibility::all()->pluck('access_id');
        $toDelete = array_diff($userAccess->toArray(), $accessibilities->toArray());
        $toInsert = array_diff($accessibilities->toArray(), $userAccess);

        collect($users)->each(function ($item) use ($toDelete) {
            Accessibility::where('access_id', $toDelete)->where('user_id', $item->id)->delete();
        });

        $insertData = array_map(function ($sml_id) use ($users) {
            return [
                'id' => $admin->id,
                'sml_id'  => $sml_id,
            ];
        }, $toInsert);
 */

        /*  DB::table('user_accessibility')->insert([
            [
                'id' => '1',
                'access_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '3',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '4',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '5',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '6',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '7',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '8',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '9',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '10',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '11',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '12',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '13',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '14',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '15',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '16',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '17',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '18',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '19',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '20',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '21',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '22',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '23',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '24',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '25',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '26',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '27',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '28',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '29',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '30',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '31',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '32',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '33',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '34',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '35',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '36',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '37',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '38',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '39',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '40',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '41',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '42',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '43',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '44',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '45',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '46',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '47',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '48',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '49',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '50',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '51',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '52',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '1',
                'access_id' => '53',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
 */
    }
}
