<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\JournalEntryRequest;
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
    public function store(JournalEntryRequest $request)
    {
        $data = $request->validated($request);
        $entry = $this->journalEntry->createJournalEntry($data);
        return $this->sendResponse($entry, 'Journal Entry Saved.');
    }
}
