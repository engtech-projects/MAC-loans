<?php

namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Center;
use App\Http\Resources\Center as CenterResource;

class CenterController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $centers = Center::all();
        return $this->sendResponse(CenterResource::collection($centers), 'Centers fetched.');
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
        $center = Center::create($input);
        return $this->sendResponse(new CenterResource($center), 'Center Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Center $center) {
        return $this->sendResponse(new CenterResource($center), 'Center fetched.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Center $center) {
        // return view()
    }

     /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Center $center) {
        $input = $request->all();
        # add validator na pd dri
        $center->center = $input['center'];
        $center->day_sched = $input['day_sched'];
        $center->status = $input['status'];
        $center->save(); 

        return $this->sendResponse(new CenterResource($center), 'Center Updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy() {}

}
