<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountOfficer extends Model
{
    use HasFactory;

    protected $table = 'account_officer';
    protected $primaryKey = 'ao_id';
    protected $with = ['branch','branch_registered'];
    public $timestamps = false;

    protected $fillable = [
    	'name', 'status', 'deleted', 'branch_id'
    ];

    const STATUS_ACTIVE = "active";
    const STATUS_INACTIVE = "inactive";

    public function branch() {
    	return $this->hasOne(Branch::class, 'branch_id', 'branch_id');
    }

    public function branch_registered() {
        return $this->hasManyThrough(
            Branch::class,
            AccountOfficerBranch::class, 'ao_id', 'branch_id', 'ao_id', 'branch_id'
        );
    }
}
