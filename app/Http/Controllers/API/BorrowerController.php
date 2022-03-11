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

	/**
     * Display a listing of the resource.
     */
    public function index() {

    	$borrowers = Borrower::all();
    	return $this->sendResponse(BorrowerResource::collection($borrowers), 'Borrowers');

    }
     /**
     * Show the form for creating a new resource.
     */
    public function create() {
        // return view();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {

        $input = $request->all();
        return json_encode( [ 
            'data' => $input ] 
        );
        # add validator dri
        // $borrower = Borrower::create($input);
        // return $this->sendResponse(new BorrowerResource($borrower), 'Borrower Created');
    }
}
