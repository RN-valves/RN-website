<?php

namespace App\Http\Controllers\Api\V1\Catalogue;

use App\Models\{
    Category,
    Product,
    Subcategory
};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Http\Resources\{
    ProductsResource,
    ProductDeailResources
};

use App\Http\Controllers\Api\V1\ApiBaseController as BaseController;

class ProductsController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $data = ProductsResource::collection(Product::get());
            $data = [
                $subcategories = $data,
            ];
            return $this->sendResponse($data, 'product list fetched!!');
        }catch(\Exception $e){
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product, Request $request)
    {
        try{
            $product = Product::where(['status'=>'Active','is_visible_website'=>1,'id'=>$product->id])->first();

            if(empty($product)){
                return $this->sendError("empty product is not valid");
            }

            $data = [
                'product' => new ProductDeailResources($product),
            ];
            
            return $this->sendResponse($data, 'data fetched');
        }catch(\Exception $e){
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Section $section)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        //
    }
}
