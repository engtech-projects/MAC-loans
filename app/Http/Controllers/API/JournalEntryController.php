<?php

namespace App\Http\Controllers\API;

use App\Models\JournalEntry;
use App\Models\LoanAccount;
use Illuminate\Http\Request;
use App\Http\Resources\JournalEntry as JournalEntryResource;
use App\Models\EndTransaction;
use App\Models\JournalBook;

class JournalEntryController extends BaseController
{
    protected $journalBook;
    public function __construct(JournalBook $journalBook)
    {
        $this->journalBook = $journalBook;
    }

    public function store(Request $request)
    {
        $journalEntry = new JournalEntry();
        $eod = new EndTransaction();
        $transactionDateNow = $eod->getTransactionDate($request->input()["branch_id"])->date_end;
        $journalBook = $this->journalBook->getJounalBookById($request->input()["journal_id"]);
        $created = $journalEntry::create([
            'journal_no'            =>          $journalBook->book_code,
            'book_id'               =>          $journalBook->book_id,
            'journal_date'          =>          $transactionDateNow,
            'branch_id'             =>          $request->branch_id,
            'source'                =>          'Releases',
            'amount'                =>          $request->amount,
            'status'                =>          'unposted',
            'remarks'               =>          'Remarks',
        ]);

        return $this->sendResponse($created, 'Reports saved.');

    }
}
