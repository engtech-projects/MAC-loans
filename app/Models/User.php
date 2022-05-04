<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'salt',
        'status',
        'firstname',
        'middlename',
        'lastname',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'salt',
        'remember_token',

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getBranches() {
      
        $branches = User::rightJoin('user_branch', 'user_branch.user_id', '=', 'users.id')
                        ->rightJoin('branch', 'branch.branch_id', '=', 'user_branch.branch_id')
                        ->where('users.id', $this->id)
                        ->get(['branch.*']);

        return $branches;
    }



// $users = User::join('posts', 'posts.user_id', '=', 'users.id')
//               ->join('comments', 'comments.post_id', '=', 'posts.id')
//               ->get(['users.*', 'posts.descrption']);

    // public static function checkBranch(User $user) {
    //     return $user;
    // }
}
