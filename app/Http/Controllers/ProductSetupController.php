<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductSetupController extends Controller
{
    public function index(){
		return view('maintenance.product_setup')->with([
			'nav' => ['maintenance', 'product setup'],
			'title' => 'Product Setup',
		]);
	}
}
