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

    public function activeProduct(){
        $products = Product::where(["status" => "active"])->get();
        return $this->sendResponse(ProductResource::collection($products), 'Active Products fetched.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        // return view();
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
    public function edit(Product $product) {
        // return view()
    }

     /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product) {
        $input = $request->all();
        # add validator na pd dri
        $product->product_code = $input['product_code'];
        $product->product_name = $input['product_name'];
        $product->interest_rate = $input['interest_rate'];
        $product->status = $input['status'];
        $product->deleted = $input['deleted'];
        $product->save();

        return $this->sendResponse(new ProductResource($product), 'Product Updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy() {}

}
