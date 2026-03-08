<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChartOfAccounts extends Model
{
    use HasFactory;

    protected $table = 'chart_of_accounts';
    protected $primaryKey = 'account_id';
    protected $connection = 'mysql2';

}
