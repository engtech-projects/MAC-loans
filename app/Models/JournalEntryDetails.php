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


    public function createJournalEntryDetails($journalEntry)
    {
        if ($journalEntry) {
            self::create([
                'journal_id' => $journalEntry->journal_id,
                'account_id' => 249,
                'subsidiary_id' => 1,
                'journal_details_account_no' => 1205,
                'journal_details_title' => 'Title',
                'journal_details_debit' => $journalEntry->amount,
                'journal_details_credit' => '',
                'journal_details_description' => 'Description',
                'journal_details_ref_no' => '',
                'status' => '',

            ]);
        }
        return "Failed to save journal entry details.";
    }
}
