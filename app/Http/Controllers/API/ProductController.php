<?php

namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Product;
use App\Models\User;
use App\Http\Resources\Product as ProductResource;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return $this->sendResponse(ProductResource::collection($products), 'Products fetched.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        // return view('product')
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {

        $input = $request->all();
        # add validator dri
        $product = Product::create($input);
        return $this->sendResponse(new ProductResource($product), 'Product Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product) {
        return $this->sendResponse(new ProductResource($product), 'Product fetched.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product) {}

     /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy() {}

}
