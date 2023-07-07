<?php

namespace App\Http\Controllers\API;
use App\Models\{
    JournalBook,
    JournalEntry,
    EndTransaction
};
use Illuminate\Http\Request;

class JournalEntryController extends BaseController
{
    protected $journalEntry;
    public function __construct(JournalEntry $journalEntry)
    {
        $this->journalEntry = $journalEntry;

    }

    public function store(Request $request)
    {

        $journalEntry = $this->journalEntry->createJournalEntry($request);
        if($journalEntry) {

        }
        return $this->sendResponse($journalEntry, 'Journal Entry Saved.');

    }
}
