<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $table = 'branch';
    protected $primaryKey = 'branch_id';

    protected $fillable = [
    	'branch_code', 'branch_name', 'branch_manager', 'branch_address', 'status', 'deleted'
    ];

    public function endTransaction()
    {
        return $this->hasOne(EndTransaction::class, 'branch_id', 'branch_id')->latest();
    }

    public function performanceReports()
    {
        return $this->hasMany(PerformanceReport::class,'branch_id');
    }
}
