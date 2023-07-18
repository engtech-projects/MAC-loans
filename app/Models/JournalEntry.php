<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalEntry extends Model
{
    use HasFactory;

    protected $table = 'journal_entry';
	protected $primaryKey = 'journal_id';
	protected $connection = 'mysql2';
    public $timestamps = true;

    protected $fillable = [
		'journal_no',
		'journal_date',
		'branch_id',
		'book_id',
		'source',
		'cheque_no',
		'cheque_date',
		'amount',
		'payee',
		'remarks',
    ];
}
