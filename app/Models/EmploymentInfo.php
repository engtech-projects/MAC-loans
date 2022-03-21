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

	protected $casts = [
		'created_at' => "datetime:Y-m-d H:i:s",
		'updated_at' => "datetime:Y-m-d H:i:s"
	];
}
