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

    public function store(Request $request)
    {
        $journalEntry = $this->journalEntry->createJournalEntry($request);
        if ($journalEntry) {
            $this->journalDetails->journalDoubleEntry($journalEntry);
        }
        return $this->sendResponse($journalEntry, 'Journal Entry Saved.');
    }
}
