<?php

namespace App\Http\Controllers\API;

use App\Models\{
    JournalEntry,
    JournalEntryDetails,
};
use Illuminate\Http\Request;

class JournalEntryController extends BaseController
{
    protected $journalEntry;
    protected $journalDetails;

    public function __construct(JournalEntry $journalEntry, JournalEntryDetails $journalDetails)
    {
        $this->journalEntry = $journalEntry;
        $this->journalDetails = $journalDetails;
    }
    public function index()
    {
        $entries = $this->journalEntry->getJournalEntry();
        return $this->sendResponse($entries, "Journal Entries Fetched.");
    }

    public function store(Request $request)
    {

        $entry = $this->journalEntry->createJournalEntry($request->input());
        return $this->sendResponse($entry, 'Journal Entry Saved.');


        /* $journalEntry = $this->journalEntry->createJournalEntry($request);
        if ($journalEntry) {
            $this->journalDetails->journalDoubleEntry($journalEntry);
        }
        return $this->sendResponse($journalEntry, 'Journal Entry Saved.'); */
    }
}
