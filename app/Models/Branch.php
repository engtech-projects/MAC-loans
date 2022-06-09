<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $table = 'branch';
    protected $primaryKey = 'branch_id';

    protected $fillable = [
    	'branch_code', 'branch_name', 'branch_manager', 'branch_address', 'status', 'deleted'
    ];
}
