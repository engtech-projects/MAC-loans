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
        'branch_code',
        'branch_name',
        'branch_manager',
        'branch_address',
        'status',
        'deleted'
    ];

    public function endTransaction()
    {
        return $this->hasOne(EndTransaction::class, 'branch_id', 'branch_id')->latest();
    }
    public function branchTransactionDates()
    {
        return $this->hasMany(EndTransaction::class, 'branch_id', 'branch_id');
    }

    public function performanceReports()
    {
        return $this->hasMany(PerformanceReport::class, 'branch_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'branch_id', 'branch_id');
    }

    public function registered_branch()
    {
        return $this->belongsToMany(
            AccountOfficer::class,
            'account_officer_branch',
            'branch_id',
            'ao_id'
        )->withTimestamps();
    }

    public function user_branch()
    {
        return $this->belongsToMany(
            User::class,
            'user_branch',
            'branch_id',
            'id'
        )->withTimestamps();
    }
}
