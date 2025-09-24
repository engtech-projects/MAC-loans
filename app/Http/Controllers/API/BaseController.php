<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\EndTransaction;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller as Controller;
use Spatie\Activitylog\Models\Activity;

class BaseController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message, $code = 200)
    {

        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];
        return response()->json($response, $code);
    }


    public function transactionDate()
    {
        $branch_id = Session::get('branch.branch_id');
        $eod = EndTransaction::getTransactionDate($branch_id);
        $transactionDate = $eod->date_end;

        return $transactionDate;
    }
    public function getChanges($model, $replicate)
    {

        $attributes = $model->getChanges();
        $old = [];
        foreach ($attributes as $key => $value) {
            $old[$key] = $replicate[$key];
        }
        return [
            'attributes' => $attributes,
            'old' => $old
        ];
    }
    public function activityLogWithProperties($model, $attributes, $replicate)
    {
        $attributes = $model->getChanges();
        $old = [];
        foreach ($attributes as $key => $value) {
            $old[$key] = $replicate[$key];
        }
        activity($attributes['log_name'])->event($attributes['event'])->performedOn($model)
            ->withProperties(['attributes' => $attributes, 'old' => $old])
            ->tap(function (Activity $activity) {
                $activity->transaction_date = $this->transactionDate();
            })
            ->log($attributes['log']);
    }
    public function activityLog($model, $attributes)
    {
        activity($attributes['log_name'])->event($attributes['event'])->performedOn($model)
            ->tap(function (Activity $activity) {
                $activity->transaction_date = $this->transactionDate();
            })
            ->log($attributes['log']);
    }
    public function sendError($error, $errorMessages = [], $code = 401)
    {

        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }
}