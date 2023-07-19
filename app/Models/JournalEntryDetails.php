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


    public function journalDoubleEntry($journalEntry)
    {
        if ($journalEntry) {
            $this->createJournalCreditEntry($journalEntry);
            $this->createJournalDebitEntry($journalEntry);
            return "Journal Details saved.";
        } else {
            return "Failed to save journal entry.";
        }
    }

    public function createJournalDebitEntry($journalEntry)
    {

        if ($journalEntry) {
            $debitEntry = JournalEntryDetails::create([
                'journal_id' => $journalEntry->journal_id,
                'account_id' => 306,
                'subsidiary_id' => 1,
                'journal_details_account_no' => 2100,
                'journal_details_title' => 'Un-earned Interest & Discounts (UID)',
                'journal_details_debit' => $journalEntry->amount,
                'journal_details_credit' => 0,
                'journal_details_description' => 'Debit Description',
                'journal_details_ref_no' => '',
                'status' => 'unposted',

            ]);
            return $debitEntry;
        }
        return "Fail to save journal details.";
    }
    public function createJournalCreditEntry($journalEntry)
    {

        if ($journalEntry) {
            $creditentry = JournalEntryDetails::create([
                'journal_id' => $journalEntry->journal_id,
                'account_id' => 402,
                'subsidiary_id' => 1,
                'journal_details_account_no' => 4011,
                'journal_details_title' => 'Prepaid Interest Income',
                'journal_details_debit' => 0,
                'journal_details_credit' => $journalEntry->amount,
                'journal_details_description' => 'Credit Description',
                'journal_details_ref_no' => '',
                'status' => 'unposted',

            ]);

            return $creditentry;
        }
        return "Fail to save journal entry details";
    }
}
