<?php

namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Center;
use App\Http\Resources\Center as CenterResource;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity;

class CenterController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $centers = Center::fetchCenters();
        return $this->sendResponse(CenterResource::collection($centers), 'Centers fetched.');
    }
    public function activeCenter()
    {
        $centers = Center::where(["status" => "active"])->orderBy('center')->get();
        return $this->sendResponse(CenterResource::collection($centers), 'Centers fetched.');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'center' => 'required|unique:center,center',
        ]);

        $input = $request->all();
        $center = Center::create($input);

        activity("Center - AO Setup")->event("created")->performedOn($center)
            ->withProperties(['model_snapshot' => $center->toArray()])
            ->tap(function (Activity $activity) {
                $activity->transaction_date = null;
            })
            ->log("Center - Create");
        return $this->sendResponse(new CenterResource($center), 'Center Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Center $center)
    {
        return $this->sendResponse(new CenterResource($center), 'Center fetched.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Center $center)
    {
        // return view()
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Center $center)
    {
        $request->validate([
            'center' => 'required|unique:center,center,' . $center->center_id . ',center_id',
        ]);
        
        $replicate = $center->replicate();
        $input = $request->all();
        $center->center = $input['center'];
        $center->day_sched = $input['day_sched'];
        $center->status = $input['status'];
        $center->area = $input['area'];
        $center->save();

        $changes = $this->getChanges($center, $replicate);
        unset($changes['attributes']['updated_at'], $changes['old']['updated_at']);
        if (!empty($changes['attributes'])) {
            activity("Center - AO Setup")->event("updated")->performedOn($center)
                ->withProperties([
                    'model_snapshot' => $center->toArray(),
                    'attributes' => $changes['attributes'], 
                    'old' => $changes['old']
                ])
                ->tap(function (Activity $activity) {
                    $activity->transaction_date = null;
                })
                ->log("Center - Update");
        }
        return $this->sendResponse(new CenterResource($center), 'Center Updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy() {}
}
