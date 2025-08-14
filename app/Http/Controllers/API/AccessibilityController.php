<?php

namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Accessibility;

class AccessibilityController extends BaseController
{
      /**
     * Display a listing of the resource.
     */
    public function index() {
        $accessibility = new Accessibility();
        return $this->sendResponse($accessibility->permissions(), 'Accessibility');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(Accessibility $accessibility) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Accessibility $accessibility) {}

     /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Accessibility $accessibility) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy() {}
}

