<?php

namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Http\Resources\Deduction as DeductionResource;
use App\Models\Deduction;

class DeductionController extends BaseController {
   
	/**
     * Display a listing of the resource.
     */
    public function index() {
        $deduction = Deduction::all();
        return $this->sendResponse(DeductionResource::collection($deduction), 'Deductions fetched.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {

        $input = $request->all();
        // // # add validator dri
        $deduction = Deduction::create($input);
        return $this->sendResponse(new DeductionResource($deduction), 'Deduction Created');
        // return 'test';
    }

    /**
     * Display the specified resource.
     */
    public function show(Deduction $deduction) {
        return $this->sendResponse(new DeductionResource($deduction), 'Deduction fetched.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Deduction $deduction) {
        $input = $request->all();

  		$deduction->name = isset($input['name']) ? $input['name'] : $dedcution->name;
		$deduction->rate = isset($input['rate']) ? $input['rate'] : $dedcution->rate;
		$deduction->product_id = isset($input['product_id']) ? $input['product_id'] : $dedcution->product_id;
		$deduction->term_start = isset($input['term_start']) ? $input['term_start'] : $dedcution->term_start;
		$deduction->term_end = isset($input['term_end']) ? $input['term_end'] : $dedcution->term_end;
		$deduction->age_start = isset($input['age_start']) ? $input['age_start'] : $dedcution->age_start;
		$deduction->age_end = isset($input['age_end']) ? $input['age_end'] : $dedcution->age_end;
		$deduction->deleted = isset($input['deleted']) ? $input['deleted'] : $dedcution->deleted;
		$deduction->status = isset($input['status']) ? $input['status'] : $dedcution->status;

        return $this->sendResponse(new DeductionResource($deduction), 'Deduction Updated.');
    }

}