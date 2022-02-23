<?php

namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Borrower;
use App\Http\Resources\Borrower as BorrowerResource;

class BorrowerController extends BaseController
{
    public function index() {

    	$borrowers = Borrower::all();
    	return $this->sendResponse(BorrowerResource::collection($borrowers), 'Borrowers');

    }

    public function store() {}

    public function show($id) {}

    public function update(Request $request, Borrower $borrower) {}

    public function destroy(Borrower $borrower) {}
}
