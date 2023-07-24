<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use App\Models\JournalEntryDetails;
use App\Models\EndTransaction;

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


    public function book()
    {
        return $this->belongsTo(JournalBook::class, 'book_id');
    }
    public function entryDetails()
    {
        return $this->hasMany(JournalEntryDetails::class, 'journal_id');
    }

    public function getJournalEntry()
    {
        return self::with(['journalBook:book_id,book_code', 'entryDetails'])->get();
    }

    public function generateJournalEntryCode($bookCode)
    {
        $transaction = self::where('book_id', $this->journalBook::GENERAL_JOURNAL_BOOK)
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

    public function createJournalEntry($entry)
    {
        $endTransaction = new EndTransaction();
        $journalBook = new JournalBook();
        $journalDate = $endTransaction->getTransactionDate($entry["branch_id"])->date_end;
        $book = $journalBook->getJounalBookById($journalBook::GENERAL_JOURNAL_BOOK);

        $entry =  self::create([
            'journal_no'            =>          $this->generateJournalEntryCode($book->book_code),
            'book_id'               =>          $book->book_id,
            'journal_date'          =>          $journalDate,
            'branch_id'             =>          $entry["branch_id"],
            'source'                =>          'Releases',
            'amount'                =>          $entry["amount"],
            'status'                =>          self::STATUS_UNPOSTED,
            'remarks'               =>          'Remarks',
        ]);

        return $journalBook;

        /* $journalBook = new JournalBook();
        $transactionDate = $this->transactionDate->getTransactionDate($request["branch_id"])->date_end;
        $journalBook = $journalBook->getJounalBookById(5);
        //Create Journal Entry
        if ($journalBook) {
            $journalEntry = self::create([
                'journal_no'            =>          $this->generateJournalEntryCode($journalBook->book_code),
                'book_id'               =>          $journalBook->book_id,
                'journal_date'          =>          $transactionDate,
                'branch_id'             =>          $request->input("branch_id"),
                'source'                =>          'Releases',
                'amount'                =>          $request->input("amount"),
                'status'                =>          'unposted',
                'remarks'               =>          'Remarks',
            ]);
            return $journalEntry;
        }
        return "Fail to save journal Entry."; */
    }
    public function createJounalEntryDetails()
    {
    }
}
