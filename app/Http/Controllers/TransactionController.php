<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
	public function releaseEntry(){
		return view('transaction.release_entry')->with([
			'nav' => ['transaction', 'release entry'],
			'title' => 'Release Entry',
		]);
	}
	public function overrideRelease(){
		return view('transaction.override_release')->with([
			'nav' => ['transaction', 'override release'],
			'title' => 'Override Release',
		]);
	}
}
