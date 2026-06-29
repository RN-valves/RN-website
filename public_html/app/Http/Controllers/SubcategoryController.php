<?php

namespace App\Http\Controllers;

use App\Models\{
    Category,
    Subcategory,
    Content
};
use Illuminate\Http\Request;
use App\Traits\DefaultTrait;
use File;
use DB;

class SubcategoryController extends Controller
{
    use DefaultTrait;
    private function deleteLocalFileIfExists(?string $path): void
    {
        if (empty($path) || str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return;
        }

        $absolutePath = public_path($path);
        if (File::exists($absolutePath)) {
            File::delete($absolutePath);
        }
    }

    function __construct()
    {
        $this->middleware(['permission:subcategory-list'], ['only' => ['index']]);
        $this->middleware(['permission:subcategory-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:subcategory-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:subcategory-delete'], ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $title = "Subcategory Index";
            $subcategories = Subcategory::get();
            return view('admin.subcategories.index', compact('title','subcategories'));
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
            $title = "Add New SubCategory";
            $categories = Category::where(['status'=>'Active'])->get();
            $contents = Content::where('status', 'Active')->get();
            return view('admin.subcategories.create', compact('title','contents','categories'));
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
            'name' => ['required','max:55','string','unique:subcategories,name'],
            'title' => ['required','max:100','string'],
            'keywords' => ['required','max:150','string'],
            'description' => ['required','max:150','string'],
            'image' => ['nullable','max:1024','mimes:jpg,jpeg,png,webp'],
            'banner' => ['nullable','max:1024','mimes:jpg,jpeg,png,webp'],
            'icon' => ['nullable','max:500','mimes:jpg,jpeg,png,webp'],
            'content_id' => ['nullable','exists:contents,id'],
            'status' => ['required','in:Active,InActive'],
            'is_visible_website' => ['required','in:0,1'],
            'category_id' => ['required','exists:categories,id'],
            'pdf_catalogue' => ['nullable'],
        ]);
        try{
            $data = $request->only('name','title','keywords','description','image','is_visible_website','content_id','status','banner','icon','category_id','pdf_catalogue');
            $data['image'] = $this->ImageResizer($request, 'image', 'uploads/catalogue/subcategories/',500,500)??null;
            $data['icon'] = $this->ImageResizer($request, 'icon', 'uploads/catalogue/subcategories/icons/',100,100)??null;
            $data['banner'] = $this->ImageResizer($request, 'banner', 'uploads/catalogue/subcategories/banners/',1900,400)??null;
            if($request->hasFile('pdf_catalogue')){
                $data['pdf_catalogue'] = $this->verifyAndUpload($request, 'pdf_catalogue', 'uploads/catalogue/')??null;
            }else{
                $data['pdf_catalogue'] = $request->pdf_catalogue;
            }
            $data['url_key'] = str($data['name'])->slug();
            $data['uuid'] = str()->uuid()->toString();
            $subcategory = Subcategory::updateOrCreate(
                [
                    'name' => $data['name'],
                ],
                $data
            );
            $this->productsStatusUpdateSubCategory($subcategory->id);
            return redirect()->route('subcategories.show', ['subcategory' => $subcategory])->with('success', 'Data added successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Subcategory $subcategory)
    {
        try{
            return view('admin.subcategories.show', compact('subcategory'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subcategory $subcategory)
    {
        try{
            $title = "Edit SubCategory";
            $categories = Category::where(['status'=>'Active'])->get();
            $contents = Content::where('status', 'Active')->get();
            return view('admin.subcategories.create', compact('title','contents','categories','subcategory'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        $request->validate([
            'name' => ['required','max:55','string','unique:subcategories,name,'.$subcategory->id],
            'title' => ['required','max:100','string'],
            'keywords' => ['required','max:150','string'],
            'description' => ['required','max:150','string'],
            'image' => ['nullable','max:1024','mimes:jpg,jpeg,png,webp'],
            'banner' => ['nullable','max:1024','mimes:jpg,jpeg,png,webp'],
            'icon' => ['nullable','max:500','mimes:jpg,jpeg,png,webp'],
            'content_id' => ['nullable','exists:contents,id'],
            'status' => ['required','in:Active,InActive'],
            'is_visible_website' => ['required','in:0,1'],
            'category_id' => ['required','exists:categories,id'],
            'pdf_catalogue' => ['nullable'],
        ]);
        try{
            $data = $request->only('name','title','keywords','description','image','is_visible_website','content_id','status','banner','icon','category_id');
            if($request->hasFile('image')){
                $oldFile = Subcategory::whereId($subcategory->id)->value('image');
                $this->deleteLocalFileIfExists($oldFile);
                $data['image'] = $this->ImageResizer($request, 'image', 'uploads/catalogue/subcategories/',500,500)??null;
            }else{
                $data['image'] = Subcategory::whereId($subcategory->id)->value('image');
            }
            
            if($request->hasFile('icon')){
                $iconFile = Subcategory::whereId($subcategory->id)->value('icon');
                $this->deleteLocalFileIfExists($iconFile);
                $data['icon'] = $this->ImageResizer($request, 'icon', 'uploads/catalogue/subcategories/icons/',100,100)??null;
            }else{
                $data['icon'] = Subcategory::whereId($subcategory->id)->value('icon');
            }
            
            if($request->hasFile('banner')){
                $bannerFile = Subcategory::whereId($subcategory->id)->value('banner');
                $this->deleteLocalFileIfExists($bannerFile);
                $data['banner'] = $this->ImageResizer($request, 'banner', 'uploads/catalogue/subcategories/banners/',1900,400)??null;
            }else{
                $data['banner'] = Subcategory::whereId($subcategory->id)->value('banner');
            }
            
            if($request->hasFile('pdf_catalogue')){
                $pdf_catalogueFile = Subcategory::whereId($subcategory->id)->value('pdf_catalogue');
                $this->deleteLocalFileIfExists($pdf_catalogueFile);
                $data['pdf_catalogue'] = $this->verifyAndUpload($request, 'pdf_catalogue', 'uploads/catalogue/')??null;
            }else{
                $data['pdf_catalogue'] = $request->pdf_catalogue ?? Subcategory::whereId($subcategory->id)->value('pdf_catalogue');
            }
            
            $data['url_key'] = str($data['name'])->slug();
            Subcategory::whereId($subcategory->id)->update($data);
            $this->productsStatusUpdateSubCategory($subcategory->id);
            return redirect()->route('subcategories.show', ['subcategory' => $subcategory])->with('success', 'Data updated successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subcategory $subcategory)
    {
        return back()->with('error', 'can not delete');
    }
}
