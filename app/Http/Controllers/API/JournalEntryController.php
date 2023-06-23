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

    public function index()
    {
        $journals = new JournalEntry();
        return $journals::all();
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $journalEntry = new JournalEntry();
        $eod = new EndTransaction();
        $transactionDateNow = $eod->getTransactionDate(1)->date_end;
        $journalBook = $this->journalBook->getJounalBookById(5);
        $created = $journalEntry::create([
            'journal_no'            =>          $journalBook->book_code,
            'book_id'               =>          $journalBook->book_id,
            'journal_date'          =>          $transactionDateNow,
            'branch_id'             =>          1,
            'source'                =>          'Releases',
            'amount'                =>          23555,
            'status'                =>          'unposted',
            'remarks'               =>          'Remarks',
        ]);

        return $this->sendResponse($created, 'Saved to Journal Entry');

    }


    public function show($id)
    {

    }


    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
