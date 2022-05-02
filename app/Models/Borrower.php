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
		'date_registered',
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

    public function generateBorrowerNum() {
    	return '123456';
    }

    public function fullname() {
    	return ucfirst($this->lastname) . ', ' . ucfirst($this->firstname) . ' '. ucfirst($this->middlename) . ' '. ucfirst($this->suffix);
    }

    public function businessInfo() {
    	return $this->hasMany(BusinessInfo::class, 'borrower_id');
    }
    public function employmentInfo() {
    	return $this->hasMany(EmploymentInfo::class, 'borrower_id');
    }
    public function householdMembers() {
    	return $this->hasMany(HouseholdMembers::class, 'borrower_id');
    }
    public function outstandingObligations() {
    	return $this->hasMany(OutstandingObligations::class, 'borrower_id');
    }

    public function loanAccounts() {
        return $this->hasMany(LoanAccount::class, 'borrower_id');
    }
}
