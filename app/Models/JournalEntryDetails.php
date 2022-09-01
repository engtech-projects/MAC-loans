<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalEntryDetails extends Model
{
    use HasFactory;

    protected $table = 'journal_entry_details';
	protected $primaryKey = 'journal_details_id';
	protected $connection = 'mysql2';
    public $timestamps = false;

    protected $fillable = [
		'journal_id',
		'account_id',
		'subsidiary_id',
		'journal_details_account_no',
		'journal_details_title',
		'journal_details_debit',
		'journal_details_credit',
		'journal_details_ref_no',
		'journal_details_description',
		'status'
    ];

    
}
