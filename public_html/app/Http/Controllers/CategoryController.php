<?php

namespace App\Http\Controllers;

use App\Models\{
    Category,
    Content
};
use Illuminate\Http\Request;
use App\Traits\DefaultTrait;
use File;
use Image;

class CategoryController extends Controller
{
    use DefaultTrait;
    function __construct()
    {
        $this->middleware(['permission:category-list'], ['only' => ['index']]);
        $this->middleware(['permission:category-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:category-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:category-delete'], ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $title = "Category Index";
            $categories = Category::get();
            return view('admin.categories.index', compact('title','categories'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try{
            $title = "Add New Category";
            $contents = Content::where('status', 'Active')->get();
            return view('admin.categories.create', compact('title','contents'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required','max:55','string','unique:categories,name'],
            'title' => ['required','max:100','string'],
            'keywords' => ['required','max:150','string'],
            'description' => ['required','max:150','string'],
            'image' => ['nullable','max:1024','mimes:jpg,jpeg,png,webp'],
            'banner' => ['nullable','max:1024','mimes:jpg,jpeg,png,webp'],
            'icon' => ['nullable','max:500','mimes:jpg,jpeg,png,webp'],
            'content_id' => ['nullable','exists:contents,id'],
            'status' => ['required','in:Active,InActive'],
            'is_visible_website' => ['required','in:0,1'],
            'discount' => ['required','numeric'],
            'tax' => ['required','numeric'],
            'pdf_catalogue' => ['nullable','string','max:255'],                                                                                                                                                                
        ]);
        try{
            $data = $request->only('name','title','keywords','description','image','is_visible_website','content_id','status','banner','icon','discount','tax','pdf_catalogue');
            $data['image'] = $this->ImageResizer($request, 'image', 'uploads/catalogue/categories/',651,500)??null;
            $data['icon'] = $this->ImageResizer($request, 'icon', 'uploads/catalogue/categories/icons/',100,100)??null;
            $data['banner'] = $this->ImageResizer($request, 'banner', 'uploads/catalogue/categories/banners/',1900,400)??null;
            $data['mobile_banner'] = $this->ImageResizer($request, 'mobile_banner', 'uploads/catalogue/categories/banners/',414,200)??null;
            $data['url_key'] = str($data['name'])->slug();
            $data['uuid'] = str()->uuid()->toString();
            Category::updateOrCreate(
                [
                    'name' => $data['name'],
                ],
                $data
            );
            return back()->with('success', 'data added successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        try{
            return view('admin.categories.show', compact('category'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        try{
            $title = "Edit Category";
            $contents = Content::where('status', 'Active')->get();
            return view('admin.categories.create', compact('title','contents','category'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => ['required','max:55','string','unique:categories,name,'.$category->id],
            'title' => ['required','max:100','string'],
            'keywords' => ['required','max:150','string'],
            'description' => ['required','max:150','string'],
            'image' => ['nullable','max:1024','mimes:jpg,jpeg,png,webp'],
            'banner' => ['nullable','max:1024','mimes:jpg,jpeg,png,webp'],
            'icon' => ['nullable','max:500','mimes:jpg,jpeg,png,webp'],
            'content_id' => ['nullable','exists:contents,id'],
            'status' => ['required','in:Active,InActive'],
            'is_visible_website' => ['required','in:0,1'],
            'discount' => ['required','numeric'],
            'tax' => ['required','numeric'],
            'pdf_catalogue' => ['nullable','string','max:255'],   
        ]);
            $data = $request->only('name','title','keywords','description','image','is_visible_website','content_id','status','banner','icon','discount','tax','pdf_catalogue');
            if($request->hasFile('image')){
                $oldFile = Category::whereId($category->id)->value('image');
                File::delete($oldFile);
                $data['image'] = $this->ImageResizer($request, 'image', 'uploads/catalogue/categories/',651,500)??null;
            }else{
                $data['image'] = Category::whereId($category->id)->value('image');
            }
            
            if($request->hasFile('icon')){
                $iconFile = Category::whereId($category->id)->value('icon');
                File::delete($iconFile);
                $data['icon'] = $this->ImageResizer($request, 'icon', 'uploads/catalogue/categories/icons/',100,100)??null;
            }else{
                $data['icon'] = Category::whereId($category->id)->value('icon');
            }
            
            if($request->hasFile('banner')){
                $bannerFile = Category::whereId($category->id)->value('banner');
                File::delete($bannerFile);
                $data['banner'] = $this->ImageResizer($request, 'banner', 'uploads/catalogue/categories/banners/',1900,400)??null;
            }else{
                $data['banner'] = Category::whereId($category->id)->value('banner');
            }
            if($request->hasFile('mobile_banner')){
                $mobilebannerFile = Category::whereId($category->id)->value('mobile_banner');
                File::delete($mobilebannerFile);
                $data['mobile_banner'] = $this->ImageResizer($request, 'mobile_banner', 'uploads/catalogue/categories/banners/',414,200)??null;
            }else{
                $data['mobile_banner'] = Category::whereId($category->id)->value('mobile_banner');
            }
            
            // $data['url_key'] = str($data['name'])->slug();
            Category::whereId($category->id)->update($data);
            return to_route('categories.index')->with('success', 'data updated successfully');
        try{
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        return back()->with('error', 'can not delete');
    }
}
