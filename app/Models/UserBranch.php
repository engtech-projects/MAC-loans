<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBranch extends Model
{
    use HasFactory;

    protected $table = 'user_branch';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [ 'id', 'branch_id' ];

}
