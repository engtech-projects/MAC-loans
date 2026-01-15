<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class HouseholdMembers extends Model
{
    use HasFactory;
    protected $table = 'household_members_info';
    protected $primaryKey = 'id';

    protected $fillable = [
    	'borrower_id',
		'dependent',
		'age',
		'relationship',
		'occupation',
		'contact_no',
		'sbe_address',
    ];

	protected $casts = [
		'created_at' => "datetime:Y-m-d H:i:s",
		'updated_at' => "datetime:Y-m-d H:i:s"
	];
}
