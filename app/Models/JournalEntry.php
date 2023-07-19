<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use App\Models\JournalEntryDetails;

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
        'status',
        'remarks',
    ];

    public function generateJournalEntryCode()
    {
        $transaction = self::where('book_id', 5)
            ->orderBy('journal_id', 'DESC')
            ->pluck('journal_no')
            ->first();
        if ($transaction) {
            $code = explode('-', $transaction);
            $num = (int)$code[1] + 1;
        } else {
            $num = 1;
        }
        return $code[0] . '-' . str_pad($num, 7, '0', STR_PAD_LEFT);
    }

    public function createJournalEntry($request)
    {
        $transactionDateNow = new EndTransaction();
        $journalBook = new JournalBook();
        $transDate = $transactionDateNow->getTransactionDate($request["branch_id"])->date_end;
        $journalBook = $journalBook->getJounalBookById(5);
        //Create Journal Entry
        if ($journalBook) {
            $journalEntry = self::create([
                'journal_no'            =>          $this->generateJournalEntryCode(),
                'book_id'               =>          $journalBook->book_id,
                'journal_date'          =>          $transDate,
                'branch_id'             =>          $request->input("branch_id"),
                'source'                =>          'Releases',
                'amount'                =>          $request->input("amount"),
                'status'                =>          'unposted',
                'remarks'               =>          'Remarks',
            ]);
            return $journalEntry;
        }
        return "Fail to save journal Entry.";
    }
}
