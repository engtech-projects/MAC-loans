<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    use HasFactory;

    protected $table = 'borrower_info';
    protected $primaryKey = 'borrower_id';

    protected $fillable = [
    	'borrower_id',
		'borrower_num',
		'firstname',
		'middlename',
		'lastname',
		'suffix',
		'address',
		'birthdate',
		'gender',
		'status',
		'contact_number',
		'id_type',
		'id_no',
		'id_date_issued',
		'spouse_firstname',
		'spouse_middlename',
		'spouse_lastname',
		'spouse_address',
		'spouse_birthdate',
		'spouse_contact_number',
		'spouse_id_type',
		'spouse_id_no',
		'spouse_id_date_issued',
    ];

    public function generateBorrowerNum() {}

    public function businessInfo() {
    	$this->hasMany(BusinessInfo::class, 'borrower_id');
    }
    public function employmentInfo() {
    	$this->hasMany(EmploymentInfo::class, 'borrower_id');
    }
    public function householdMembers() {
    	$this->hasMany(HouseholdMembers::class, 'borrower_id');
    }
    public function outstandingObligations() {
    	$this->hasMany(OutstandingObligations::class, 'borrower_id');
    }

    
}
