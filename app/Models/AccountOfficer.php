<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountOfficer extends Model
{
    use HasFactory;

    protected $table = 'account_officer';
    protected $primaryKey = 'ao_id';

    protected $fillable = [
    	'name', 'status', 'deleted'
    ];
}
