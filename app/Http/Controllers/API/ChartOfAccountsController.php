<?php

namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\ChartOfAccounts;
use App\Http\Resources\ChartOfAccounts as ChartOfAccountsResource;

class ChartOfAccountsController extends BaseController
{
    
	/**
     * Display a listing of the resource.
     */
    public function index() {
        $coa = ChartOfAccounts::all();
        return $this->sendResponse(ChartOfAccountsResource::collection($coa), 'Chart of Accounts fetched.');
    }
    
}
