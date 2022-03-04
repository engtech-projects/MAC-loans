<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    use HasFactory;

	protected $table = 'centers';
    protected $primaryKey = 'center_id';
	protected $fillable = [
    	'center_id', 'center', 'day_sched', 'status', 'deleted'
    ];
}
