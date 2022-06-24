<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accessibility extends Model
{
    use HasFactory;

    protected $table = 'accessibility';
    protected $primaryKey = 'access_id';

    protected $fillable = [
    	'label', 'group', 'permission', 'description'
    ];

}
