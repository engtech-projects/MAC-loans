<?php

use App\Models\Accessibility;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Activitylog\Contracts\Activity;

class UpdateActivityLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $accessibility = Accessibility::create([
            'label' => 'Activity Logs',
            'group' => 'Maintenance',
            'permission' => 'view activity logs',
            'description' => 'description',

        ]);

        $user = User::where('username', 'mac_admin')->first();
        /*         dd($user->accessibility->toArray()); */

        $user->accessibility()->sync([$accessibility->id]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            //
        });
    }
}
