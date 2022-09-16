<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
    use HasFactory;
    protected $table = 'deduction_rate';
    protected $primaryKey = 'id';

    protected $fillable = [
    	'id',
		'name',
		'rate',
		'product_id',
		'term_start',
		'term_end',
		'age_start',
		'age_end',
		'deleted',
		'status',
		'created_at',
		'updated_at'
    ];


}
