<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmploymentInfo extends Model
{
    use HasFactory;

    protected $table = 'employment_info';
    protected $primaryKey = 'id';

    protected $fillable = [
    	'borrower_id',
		'company_name',
		'company_address',
		'contact_no',
		'years_employed',
		'position',
		'salary',
    ];
}
