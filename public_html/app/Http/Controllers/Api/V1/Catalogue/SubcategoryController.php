<?php

namespace App\Http\Controllers\Api\V1\Catalogue;

use App\Http\Controllers\Controller;
use App\Models\{
    Category,
    Product,
    Subcategory
};
use Illuminate\Http\Request;
use DB;
use App\Http\Resources\{
    SubcategoryResource,
    SubcategoryDetailResource
};

use App\Http\Controllers\Api\V1\ApiBaseController as BaseController;

class SubcategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $data = SubcategoryResource::collection(Subcategory::get());
            $data = [
                $subcategories = $data,
            ];
            return $this->sendResponse($data, 'subcategory list fetched!!');
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
    public function show(Subcategory $subcategory, Request $request)
    {
        try{
            $subcategory = Subcategory::getSingleSubCategory($subcategory->url_key);

            if(empty($subcategory)){
                return $this->sendError("empty subcategory is not valid");
            }

            $data = [
                'subcategory' => new SubcategoryDetailResource($subcategory),
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
