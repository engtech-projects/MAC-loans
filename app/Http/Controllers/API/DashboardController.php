<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends BaseController
{
    //
    public function index() {
		return view('dashboard.dashboard');  	
    }
}
