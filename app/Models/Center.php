<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Center extends Model
{
    use HasFactory;
    protected $table = 'center';
    protected $primaryKey = 'center_id';

    protected $fillable = [
    	'center', 'day_sched', 'status', 'deleted', 'area'

    ];

    public static function fetchCenters() {
        //fetch all cenrters order by center name
        $centers = Center::orderBy('center')->get();

        //Capitalize first letter of each center
        foreach($centers as $center) {
            $center->center = Str::title($center->center);
        }

        return $centers;
    }
}
