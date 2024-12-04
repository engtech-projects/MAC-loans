<?php

namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\GeneralLedger;
use App\Http\Resources\GL as GLResource;

class GLController extends BaseController {
    

	/**
     * Display a listing of the resource.
     */
    public function index() {
    	$gl = GeneralLedger::all();
        return $this->sendResponse(GLResource::collection($gl), 'GL Accounts fetched.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {

    	$input = $request->all();
    	$gl = GeneralLedger::create($input);
    	return $this->sendResponse(new GLResource($gl), 'GL Created');

    }

    /**
     * Display the specified resource.
     */
    public function show(GeneralLedger $gl) {
    	return $this->sendResponse(new GLResource($gl), 'GL fetched.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GeneralLedger $gl) {

    	$gl->fill($request->input());
    	$gl->save();

    	return $this->sendResponse(new GLResource($gl), 'GL Updated.');
    }    
    	

}
