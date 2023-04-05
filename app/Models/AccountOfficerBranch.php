<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountOfficerBranch extends Model
{
    use HasFactory;
    protected $table = 'account_officer_branch';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [ 'ao_id', 'branch_id' ];
}
