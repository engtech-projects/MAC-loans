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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $performanceReport = new PerformanceReport();

/*         try { */
        //$data = $performanceReport->storePerformanceReport($request);
        $aoPerformanceReport = $performanceReport->getPerformanceReport($request);
        return $aoPerformanceReport;
/*         return $this->sendResponse(new PerformanceReportResource($data),'Performance Reports.'); */
/*         } catch (Exception $e) {
            return response($e->getMessage());
        } */

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
