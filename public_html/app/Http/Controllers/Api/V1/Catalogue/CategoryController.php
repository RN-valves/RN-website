<?php

namespace App\Http\Controllers\Api\V1\Catalogue;

use App\Http\Controllers\Controller;
use App\Models\{
    Category,
    Product
};
use Illuminate\Http\Request;
use DB;
use App\Http\Resources\{
    CategoryDetailResource,
    CategoryResource
};

use App\Http\Controllers\Api\V1\ApiBaseController as BaseController;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $categories = CategoryResource::collection(Category::get());
            $data = [
                'categories' => $categories,
            ];
            return $this->sendResponse($data, 'category list fetched!!');
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
    public function show(Category $category, Request $request)
    {
        try{
            $category = Category::getSingleCategory($category->url_key);

            if(empty($category)){
                return $this->sendError("empty category is not valid");
            }

            $data = [
                'category' => new CategoryDetailResource($category),
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
