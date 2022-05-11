<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function transactionProduct(){
		return view('reports.transaction')->with([
			'nav' => ['reports', 'transaction',''],
			'title' => 'Reports - Transaction',
		]);
	}
	public function releaseProduct(){
		return view('reports.release.product')->with([
			'nav' => ['reports', 'release',''],
			'title' => 'Reports - Release',
		]);
	}

	public function releaseClient(){
		return view('reports.release.client')->with([
			'nav' => ['reports', 'release',''],
			'title' => 'Reports - Release',
		]);
	}

	public function releaseAo(){
		return view('reports.release.ao')->with([
			'nav' => ['reports', 'release',''],
			'title' => 'Reports - Release',
		]);
	}

	public function repaymentProduct(){
		return view('reports.repayment.product')->with([
			'nav' => ['reports', 'repayment',''],
			'title' => 'Reports - Repayment',
		]);
	}

	public function repaymentClient(){
		return view('reports.repayment.client')->with([
			'nav' => ['reports', 'repayment',''],
			'title' => 'Reports - Repayment',
		]);
	}

	public function collectionClient(){
		return view('reports.collection.client')->with([
			'nav' => ['reports', 'collection',''],
			'title' => 'Reports - Collection',
		]);
	}

	public function collectionProduct(){
		return view('reports.collection.product')->with([
			'nav' => ['reports', 'collection',''],
			'title' => 'Reports - Collection',
		]);
	}

	public function collectionAo(){
		return view('reports.collection.ao')->with([
			'nav' => ['reports', 'collection',''],
			'title' => 'Reports - Collection',
		]);
	}
}
