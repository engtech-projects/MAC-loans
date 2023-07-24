<?php

namespace App\Http\Controllers\API;

use App\Models\JournalEntry;
use Illuminate\Http\Request;

class JournalEntryDetailsController extends BaseController
{
    //

    protected $entry;
    public function __construct(JournalEntry $entry)
    {
        $this->entry = $entry;
    }

    public function store(Request $request)
    {
        $details = $this->entry->createEntries($request);
    }
}
