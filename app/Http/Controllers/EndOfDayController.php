<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Auth;

class EndOfDayController extends Controller
{
    public function index(){
		$this->checkAccess('set beginning/end of day');
		return view('endofday.index')->with([
			'nav' => ['end of day',''],
			'title' => 'MAC | End of Day',
		]);
	}
	public function eodCheck(Request $request){
		return \App\Models\EndTransaction::where('date_end', date('Y-m-d'))->first()? 1:0;
	}
}
