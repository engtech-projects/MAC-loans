<?php

namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Branch;
use App\Http\Resources\Branch as BranchResource;

class BranchController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $branch = Branch::all();
        return $this->sendResponse(BranchResource::collection($branch), 'Branches fetched.');
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
        # add validator dri
        $branch = Branch::create($input);
        return $this->sendResponse(new BranchResource($branch), 'Branch Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch) {
        return $this->sendResponse(new BranchResource($branch), 'Branch fetched.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch) {
        // return view()
    }

     /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch) {
        $input = $request->all();
        # add validator na pd dri
        $branch->branch_code = $input['branch_code'];
        $branch->branch_name = $input['branch_name'];
        $branch->branch_address = $input['branch_address'];
        $branch->save(); 

        return $this->sendResponse(new BranchResource($branch), 'Branch Updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy() {}
}
