<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    use HasFactory;
    protected $table = 'center';
    protected $primaryKey = 'center_id';

    protected $fillable = [
    	'center', 'day_sched', 'status', 'deleted'

    ];
}
