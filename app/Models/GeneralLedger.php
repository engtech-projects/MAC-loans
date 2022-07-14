<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralLedger extends Model
{
    use HasFactory;

    protected $table = 'general_ledger';
    protected $primaryKey = 'gl_id';

    protected $fillable = [
    	'loans',
		'code',
		'accounting',
		'type',
    ];
}
