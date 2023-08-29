<?php

namespace App\Http\Controllers\API;

use App\Models\PerformanceReport;
use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use App\Http\Resources\PerformaceReport as PerformanceReportResource;
use Exception;
use Throwable;

class PerformanceReportController extends BaseController
{

    protected $performanceReport;
    public function __construct(PerformanceReport $performanceReport)
    {
        $this->performanceReport = $performanceReport;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {
        $reports = $this->performanceReport->getAOPerformanceReport($request);
        return $this->sendResponse($reports,"AO Performance Reports fetch");
        /*  return $this->sendResponse(PerformanceReportResource::collection($reports),"Performance Reports Fetch."); */
    }


    public function fetchReportsDate(Request $request)
    {

        $branchId = $request->query("branchId");
        if(isset($branchId)) {
            $response = $this->performanceReport->getDateReports($branchId);
            return $this->sendResponse($response,"Fetch report dates");
        }else {
            return $this->sendError("No branch found",null,404);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->performanceReport->getPerformanceReport($request);
        return $this->sendResponse("Reports", "Successfully saved", 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PerformanceReport  $performanceReport
     * @return \Illuminate\Http\Response
     */
    public function show(PerformanceReport $performanceReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PerformanceReport  $performanceReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PerformanceReport $performanceReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PerformanceReport  $performanceReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(PerformanceReport $performanceReport)
    {
        //
    }
}
