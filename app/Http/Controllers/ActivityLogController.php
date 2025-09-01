<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $activityLogs = Activity::all();
        $data = $activityLogs->map(function ($item) {
            return [
                'id' => $item->id,
                'log_name' => $item->log_name,
                'description' => $item->description,
                'subject_type' => Str::headline(class_basename($item->subject_type)),
                'subject' => $item->subject?->id,
                'subject' => [
                    'id' => $item->subject_id,
                    'data' => $item->subject
                ],
                'event' => $item->event,
                'causer_type' => Str::headline(class_basename($item->causer_type)),
                'causer' => $item->causer->username,
                'causer' => $item->causer->username,
                'user_role' => $item->causer->userRole,
                'properties' => $item->changes(),
                'created_at' => $item->created_at->format('H:i d, M Y')
            ];
        });
        return new JsonResponse([
            'data' => $data,
            'message' => 'Successfully Fetched.',
        ], JsonResponse::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $activity = Activity::find($id);
        $activityLog = [
            'id' => $activity->id,
            'log_name' => $activity->log_name,
            'description' => $activity->description,
            'subject_type' => Str::headline(class_basename($activity->subject_type)),
            'subject' => $activity->subject?->id,
            'subject' => [
                'id' => $activity->subject_id,
                'data' => $activity->subject
            ],
            'event' => $activity->event,
            'causer_type' => Str::headline(class_basename($activity->causer_type)),
            'causer' => $activity->causer->username,
            'causer' => $activity->causer->username,
            'user_role' => $activity->causer->userRole,
            'properties' => $activity->changes(),
            'created_at' => $activity->created_at->format('H:i d, M Y')
        ];
        return new JsonResponse([
            'data' => $activityLog,
            'message' => 'Activity log fetched.',
            'success' => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
