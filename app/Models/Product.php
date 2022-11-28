<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';
    protected $primaryKey = 'product_id';
    const STATUS_ACTIVE = "active";
    const STATUS_INACTIVE = "inactive";

    protected $fillable = [
    	'product_code', 'product_name', 'interest_rate', 'status', 'deleted'
    ];
    
}
