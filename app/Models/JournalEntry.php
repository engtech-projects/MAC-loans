<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use App\Models\JournalEntryDetails;
use App\Models\EndTransaction;
use Carbon\Carbon;

class JournalEntry extends Model
{
    use HasFactory;

    const SOURCE_RELASES = 'Releases';
    const STATUS_UNPOSTED = 'Unposted';

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
        'status',
        'remarks',
    ];

    protected $casts = [
        'amount' => 'double',
        'journal_date' => 'date:Y-m-d',
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d',
    ];

    /** Journal Book that belongs this Journal Entry */
    public function journalBook()
    {
        return $this->belongsTo(JournalBook::class, 'book_id');
    }

    /** Journal Entry Details that owns by Journal Entry */
    public function entryDetails()
    {
        return $this->hasMany(JournalEntryDetails::class, 'journal_id', 'journal_id');
    }

    /**
     * Handle for generating Journal Entry Code
     * Get the last transaction in the Journal Book and increment the id
     * for journal no series
     * @params Journal Boook Code
     */
    public function generateJournalEntryCode($bookCode)
    {

        $transaction = self::where('book_id', JournalBook::GENERAL_JOURNAL_BOOK)
            ->orderBy('journal_id', 'DESC')
            ->pluck('journal_no')
            ->first();
        if ($transaction) {
            $code = explode('-', $transaction);
            $num = (int)$code[1] + 1;
        } else {
            $num = 1;
        }
        return $bookCode . '-' . str_pad($num, 7, '0', STR_PAD_LEFT);
    }

    /**
     * Handle for creating Journal Entry
     *
     * @params Store Request
     */
    public function createJournalEntry($entry)
    {
        $endTransaction = new EndTransaction();
        $journalBook = new JournalBook();
        $entryDetails = new JournalEntryDetails();
        $journalDate = $endTransaction->getTransactionDate($entry["branch_id"])->date_end;
        $book = $journalBook->getJournalBookById($journalBook::GENERAL_JOURNAL_BOOK);
        $entry =  $this->create([
            'journal_no'            =>          $this->generateJournalEntryCode($book->book_code),
            'book_id'               =>          $book->book_id,
            'journal_date'          =>          $journalDate,
            'branch_id'             =>          $entry["branch_id"],
            'source'                =>          'UID',
            'amount'                =>          $entry["amount"],
            'status'                =>          self::STATUS_UNPOSTED,
            'remarks'               =>          'Remarks',
        ]);

        if ($entry) {
            $doubleEntry = $entryDetails->setDoubleEntry($entry);
            $entry->entryDetails()->createMany($doubleEntry);
        }

        return $entry;
    }
}
