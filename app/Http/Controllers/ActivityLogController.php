<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
    public function index(Request $request)
    {
        $filter = $request->all();

        $activityLogs = Activity::when($request['log_name'], function ($query) use ($filter) {
            $logname = $filter['log_name'];
            $query->where('log_name', 'like', "%$logname%");
        })->when($request['event'], function ($query) use ($filter) {
            $query->where('event', $filter['event']);
        })->paginate(10);
        $data = $activityLogs->map(function ($item) {
            return [
                'id' => $item->id,
                'log_name' => $item->log_name,
                'description' => $item->description,
                'subject_type' => Str::headline(class_basename($item->subject_type)),
                'subject' => $item->subject?->id,
                'subject' => [
                    'id' => $item->subject_id,
                    'data' => $item->properties['model_snapshot'] ?? null
                ],
                'event' => $item->event,
                'causer_type' => Str::headline(class_basename($item->causer_type)),
                'causer' => $item->causer->firstname ? trim($item->causer->firstname.' '.$item->causer->lastname) : $item->causer->username,
                'user_role' => $item->causer->userRole,
                'properties' => $item->changes(),
                'transaction_date' => $item->transaction_date ? Carbon::parse($item->transaction_date)->format('Y-m-d') : "",
                'created_at' => $item->created_at->format('Y-m-d g:i A'),
                'updated_at' => $item->created_at->format('Y-m-d g:i A')
            ];
        });
        return new JsonResponse([
            'data' => $data,
            'current_page' => $activityLogs->currentPage(),
            'last_page' => $activityLogs->lastPage(),
            'per_page' => $activityLogs->perPage(),
            'total' => $activityLogs->total(),
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
                'data' => $activity->properties['model_snapshot'] ?? null
            ],
            'event' => $activity->event,
            'causer_type' => Str::headline(class_basename($activity->causer_type)),
            'causer' => $activity->causer->firstname ? trim($activity->causer->firstname.' '.$activity->causer->lastname) : $activity->causer->username,
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
