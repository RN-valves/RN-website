<?php

namespace App\Http\Controllers;

use App\Models\{
    Category,
    Blog,
    BlogLog
};
use Illuminate\Http\Request;
use App\Traits\DefaultTrait;
use File;
use Image;

class BlogController extends Controller
{
    use DefaultTrait;
    function __construct()
    {
        $this->middleware(['permission:blog-list'], ['only' => ['index']]);
        $this->middleware(['permission:blog-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:blog-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:blog-delete'], ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $blogs = Blog::all();
            return view('admin.blogs.index', compact('blogs'));
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
            $categories = Category::orderByDesc('id')->get();
            return view('admin.blogs.create', compact('categories'));
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
            'name' => ['required','max:155','string','unique:blogs,name'],
            'title' => ['required','max:155','string','unique:blogs,title'],
            'keywords' => ['required','max:150','string'],
            'description' => ['required','max:150','string'],
            'short_description' => ['required','max:255','string'],
            'image' => ['required','max:1024','mimes:jpg,jpeg,png,webp'],
            'status' => ['required','in:Active,InActive'],
            'content' => ['required','min:10'],                                                                                                                                                         
            'published_at' => ['required','date'],                                                                                                                                                   
            'category_id' => ['required','exists:categories,id'],                                                                                                                                                   
        ]);
        try{
            $data = $request->only('name','title','keywords','description','image','short_description','content','status','published_at','category_id');
            $data['image'] = $this->ImageResizer($request, 'image', 'uploads/blogs/',363,436)??null;     
            $data['url_key'] = str($data['name'])->slug();
            $data['created_by'] = auth()->user()->name;
            $data['auth_id'] = auth()->user()->id;
            $blog = Blog::updateOrCreate(
                [
                    'name' => $data['name'],
                ],
                $data
            );
            if(!empty($blog)){
                BlogLog::create(
                    [
                        'blog_id' => $blog->id,
                        'auth_id' => $data['auth_id'],
                        'created_by' => $data['created_by'],
                    ]
                );
            }
            return redirect(route('blogs.show', $blog))->with('success', 'data added successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        try{
            return view('admin.blogs.show', compact('blog'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        try{
            $categories = Category::orderByDesc('id')->get();
            return view('admin.blogs.create', compact('categories','blog'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'name' => ['required','max:155','string','unique:blogs,name,'.$blog->id],
            'title' => ['required','max:155','string','unique:blogs,title,'.$blog->id],
            'keywords' => ['required','max:150','string'],
            'description' => ['required','max:150','string'],
            'short_description' => ['required','max:255','string'],
            'image' => ['nullable','max:1024','mimes:jpg,jpeg,png,webp'],
            'status' => ['required','in:Active,InActive'],
            'content' => ['required','min:10'],                                                                                                                                                       
            'published_at' => ['required','date'],                                                                                                                                        
            'category_id' => ['required','exists:categories,id'],                                                                                                                                                   
        ]);
        try{
            $data = $request->only('name','title','keywords','description','image','short_description','content','status','published_at','category_id');

            if($request->hasFile('image')){
                $imageFile = Blog::whereId($blog->id)->value('image');
                File::delete($imageFile);
                $data['image'] = $this->ImageResizer($request, 'image', 'uploads/blogs/',363,436)??null;
   
            }else{
                $data['image'] = Blog::whereId($blog->id)->value('image');
            }

            $data['url_key'] = str($data['name'])->slug();
            $blog = Blog::updateOrCreate(
                [
                    'name' => $data['name'],
                ],
                $data
            );

            $data['created_by'] = auth()->user()->name;
            $data['auth_id'] = auth()->user()->id;
            if(!empty($blog)){
                BlogLog::create(
                    [
                        'blog_id' => $blog->id,
                        'auth_id' => $data['auth_id'],
                        'created_by' => $data['created_by'],
                    ]
                );
            }
            return redirect(route('blogs.show', $blog))->with('success', 'data updated successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        //
    }
}
