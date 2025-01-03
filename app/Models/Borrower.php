<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\isEmpty;

class Borrower extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'borrower_info';
    protected $primaryKey = 'borrower_id';
    public static $snakeAttributes = false;
    protected $appends = ['age'];

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
        'username',
        'password',
    ];

    public function generateDefaultUsername()
    {
        return $this->firstname . $this->lastname;
    }
    public function getAgeAttribute()
    {
        return Carbon::parse($this->attributes['birthdate'])->age;
    }

    public function generateDefaultPassword()
    {
        return Hash::make($this->lastname . $this->firstname);
    }

    public function generateBorrowerNum()
    {
        return str_pad($this->borrower_id, 7, '0', STR_PAD_LEFT);
    }

    public function fullname()
    {
        return ucfirst($this->lastname) . ', ' . ucfirst($this->firstname) . ', ' . ucfirst($this->middlename) . ' ' . ucfirst($this->suffix);
    }

    public function directories()
    {

        $root = storage_path('app/public/');
        $main = 'borrowers/';
        $identifier = $this->borrower_id . '/';
        $photo = 'photo/';
        $docs = 'docs/';
        // if borrowers folder does not exist. create folder
        if (!File::isDirectory(($root . $main))) {
            // create folder
            File::makeDirectory(($root . $main), 0777, true, true);
        }

        if (!File::isDirectory(($root . $main . $identifier))) {
            File::makeDirectory(($root . $main . $identifier), 0777, true, true);
            File::makeDirectory(($root . $main . $identifier . $photo), 0777, true, true);
            File::makeDirectory(($root . $main . $identifier . $docs), 0777, true, true);
        }

        return [
            'identifier' => $main . $identifier,
            'photo' => $main . $identifier . $photo,
            'docs' => $main . $identifier . $docs,
        ];
    }

    public function getPhoto()
    {

        $dirs = $this->directories();
        $files = Storage::files('public/' . $dirs['photo']);

        if (count($files) > 0) {
            return url(Str::replace('public', 'storage', $files[0]));
        }

        return false;
    }

    public function setBorrowerPhoto($img, $capture = true)
    {

        $dirs = $this->directories();

        if ($capture) {

            $imgParts = explode(";base64", $img);
            // $imageTypeAux = explode("image/", $imgParts[0]);
            // $imageType = $imageTypeAux[1];
            $content = base64_decode($imgParts[1]);
            $fileName = $dirs['photo'] . $this->borrower_id . '.png';
        } else {
            $content = $img;
            $fileName = $dirs['photo'] . $this->borrower_id . '.' . $content->getClientOriginalExtension();
        }

        Storage::disk("public")->put($fileName, $content);
    }

    public function getDocs()
    {

        $dirs = $this->directories();

        $files = Storage::files('public/' . $dirs['docs']);
        $docs = [];
        if (count($files) > 0) {

            foreach ($files as $file) {
                $docs[] = url(Str::replace('public', 'storage', $file));
            }

            return $docs;
        }

        return false;
    }

    public function setDocs($files)
    {

        $dirs = $this->directories();

        foreach ($files as $file) {

            $name = $file->getClientOriginalName();

            $file->storeAs('public/' . $dirs['docs'], $name);
        }
    }

    public function businessInfo()
    {
        return $this->hasMany(BusinessInfo::class, 'borrower_id');
    }

    public function employmentInfo()
    {
        return $this->hasMany(EmploymentInfo::class, 'borrower_id');
    }

    public function householdMembers()
    {
        return $this->hasMany(HouseholdMembers::class, 'borrower_id');
    }

    public function outstandingObligations()
    {
        return $this->hasMany(OutstandingObligations::class, 'borrower_id');
    }

    public function accounts()
    {
        return $this->hasMany(LoanAccount::class, 'loan_account_id');
    }

    public function loanAccounts($attributes = [])
    {
        $with = [];
        $without = [];
        if (!empty($attributes)) {
            $with = $attributes["with"];
            $without = $attributes["without"];
        }

        $id = $this->borrower_id;
        /*         $activeAccounts = Borrower::query()->with('accounts', function ($query) use ($id) {
                    $query->where('borrower_id', $id)->release();
                })->where('borrower_id', $id)
                    ->get(); */
        $activeAccounts = LoanAccount::query()
            ->without($without)
            ->with($with)
            ->where(['borrower_id' => $this->borrower_id, 'status' => 'released'])
            ->orderBy('date_release', 'DESC')
            ->get();

        if (count($activeAccounts) > 0) {

            foreach ($activeAccounts as $account) {

                $account->remainingBalance = $account->remainingBalance();
                //         $account->current_amortization = $account->getCurrentAmortization();
                //         $account->amortization = $account->amortization();
                //         $account->loan_status_view = $account->getStatusView();
                //         $account->collection_rate = $account->collectionRate();
            }
            return $activeAccounts;
        }

        // if( !count($activeAccounts) ) {
        return false;
        // }
        // return $activeAccounts;
    }
}
