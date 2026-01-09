<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalEntryDetails extends Model
{
    use HasFactory;

    const SUBSIDIARY_MAIN_BRANCH = 1;
    const CREDIT_ACCOUNT_NO = 402;
    const DEBIT_ACCOUNT_NO = 306;
    const JOURNAL_DETAILS_ACCOUNT_NO_CREDIT = 2100;
    const JOURNAL_DETAILS_ACCOUNT_NO_DEBIT = 2;

    protected $table = 'journal_entry_details';
    protected $primaryKey = 'journal_details_id';
    protected $connection = 'mysql2';

    protected $fillable = [
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

    /** Casting model attributes */
    protected $casts = [
        "journal_details_credit" => 'double',
        "journal_details_credit" => 'double',
        "created_at" => 'date:Y-m-d',
        "updated_at" => 'date:Y-m-d'
    ];

    /** Journal Entry Model that belongs to Journal Entry Details */
    public function entry()
    {
        return $this->belongsTo(JournalEntry::class, 'journal_id', 'journal_id');
    }

    /** Get Journal Entry by Journal Id
     *
     * @params journal_id
     */
    public function getEntryById($id)
    {
        return $this->findOrFail($id)->select('journal_id');
    }


    /**
     * Set double entry for journal entry details for credit and debit in chart of accounts
     * @params journalEntry the created journal Entry
     */
    public function setDoubleEntry($entry)
    {

        $doubleEntry = [
            [
                'journal_id' => $entry->journal_id,
                'account_id' => self::CREDIT_ACCOUNT_NO,
                'subsidiary_id' => 1,
                'journal_details_account_no' => self::JOURNAL_DETAILS_ACCOUNT_NO_CREDIT,
                'journal_details_title' => 'Prepaid Interest Income',
                'journal_details_debit' => 0,
                'journal_details_credit' => $entry->amount,
                'journal_details_description' => 'Debit Description',
                'journal_details_ref_no' => '',
                'status' => 'unposted'
            ],
            [
                'journal_id' => $entry->journal_id,
                'account_id' => self::DEBIT_ACCOUNT_NO,
                'subsidiary_id' => 1,
                'journal_details_account_no' => self::JOURNAL_DETAILS_ACCOUNT_NO_DEBIT,
                'journal_details_title' => 'Un-earned Interest & Discounts (UID)',
                'journal_details_debit' => $entry->amount,
                'journal_details_credit' => 0,
                'journal_details_description' => 'Debit Description',
                'journal_details_ref_no' => '',
                'status' => 'unposted',

            ]

        ];
        return $doubleEntry;
    }
}
