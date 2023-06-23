<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JounalEntry extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $primaryKey = 'journal_id';

    protected $fillable = [
        'journal_no',
        'journal_date',
        'branch_id',
        'book_id',
        'source',
        'status',
        'payee',
        'remarks',
    ];

}
