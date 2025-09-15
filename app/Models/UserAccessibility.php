<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccessibility extends Model
{
    use HasFactory;

    protected $table = 'user_accessibility';
    protected $fillable = ['id', 'access_id'];
}
