<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessInfo extends Model
{
    use HasFactory;
    protected $table = 'business_info';
   	protected $primaryKey = 'id';

   	protected $fillable = [
    	'borrower_id',
		'business_name',
		'business_type',
		'business_address',
		'contact_no',
		'years_in_business',
		'income',
    ];
}
