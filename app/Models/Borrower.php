<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Storage;
use File;

class Borrower extends Model
{
    use HasFactory;

    protected $table = 'borrower_info';
    protected $primaryKey = 'borrower_id';
	public static $snakeAttributes = false;
	
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

    public function getPhoto() {

        $dir = 'public/borrowers/' . $this->borrower_id . '/photo/';
        $files = Storage::files($dir);
        // $path = 'storage/borrowers/' . $this->borrower_id . '/' . $this->borrower_id . '.png';
        // return url($path);

        if( count($files) > 0 ){
            return url(Str::replace('public', 'storage', $files[0]));
        }

        return false;
    }

    public function setBorrowerPhoto($img, $capture = true) {

        $dir = storage_path('app/public/borrowers/');
        $bDir = $dir . $this->borrower_id;
        $path = 'borrowers/' . $this->borrower_id . '/photo/';

        // if borrowers folder does not exist. create folder
        if( !File::isDirectory($dir) ){
            // create folder
            File::makeDirectory($dir, 0777, true, true);
        }

        if( !File::isDirectory($bDir) ) {
            File::makeDirectory($bDir, 0777, true, true);
            File::makeDirectory($bDir . '/photo/', 0777, true, true);
            File::makeDirectory($bDir . '/docs/', 0777, true, true);
        }

        if( $capture ){

            $imgParts = explode(";base64", $img);
            // $imageTypeAux = explode("image/", $imgParts[0]);
            // $imageType = $imageTypeAux[1];
            $content = base64_decode($imgParts[1]);
            $fileName = $path . $this->borrower_id . '.png';

        }else{
            $content = $img;
            $fileName = $path . $this->borrower_id . '.' . $content->getClientOriginalExtension();
        }

        Storage::disk("public")->put($fileName, $content);
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

    public function getLoanAccounts() {

        $loanAccount = new LoanAccount();
        $activeAccounts = LoanAccount::where(['borrower_id' => $this->borrower_id])->get();
        foreach ($activeAccounts as $key => $value) {
            $value->outstandingBalance = $loanAccount->outstandingBalance($value->loan_account_id);
			$value->current_amortization = $value->getCurrentAmortization();
        }
        return $activeAccounts;
    }
}
