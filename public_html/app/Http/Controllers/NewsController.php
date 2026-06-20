<?php

namespace App\Http\Controllers;

use App\Models\{
    News,
};
use Illuminate\Http\Request;
use App\Traits\DefaultTrait;
use File;
use Image;

class NewsController extends Controller
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
            $news = News::all();
            return view('admin.news.index', compact('news'));
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
            return view('admin.news.create');
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
            'name' => ['required','max:155','string','unique:news,name'],
            'title' => ['required','max:155','string','unique:news,title'],
            'keywords' => ['required','max:150','string'],
            'description' => ['required','max:150','string'],
            'short_description' => ['required','max:255','string'],
            'image' => ['required','max:1024','mimes:jpg,jpeg,png,webp'],
            'status' => ['required','in:Active,InActive'],
            'content' => ['required','min:10'],                                                                                                                                                         
            'published_at' => ['required','date'],                                                                                                                                                                                                                                                                                                   
        ]);
        // try{
            $data = $request->only('name','title','keywords','description','image','short_description','content','status','published_at');
            $data['image'] = $this->ImageResizer($request, 'image', 'uploads/news/',566,679)??null;     
            $data['url_key'] = str($data['name'])->slug();
            $data['created_by'] = auth()->user()->name;
            $data['auth_id'] = auth()->user()->id;
            $news = News::updateOrCreate(
                [
                    'name' => $data['name'],
                ],
                $data
            );
            return redirect(route('news.show', $news))->with('success', 'Data added successfully');
        // }catch(\Exception $e){
        //     return back()->with('error', $e->getMessage());
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        try{
            return view('admin.news.show', compact('news'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        try{
            return view('admin.news.create', compact('news'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        $request->validate([
            'name' => ['required','max:155','string','unique:news,name,'.$news->id],
            'title' => ['required','max:155','string','unique:news,title,'.$news->id],
            'keywords' => ['required','max:150','string'],
            'description' => ['required','max:150','string'],
            'short_description' => ['required','max:255','string'],
            'image' => ['nullable','max:1024','mimes:jpg,jpeg,png,webp'],
            'status' => ['required','in:Active,InActive'],
            'content' => ['required','min:10'],                                                                                                                                                       
            'published_at' => ['required','date'],                                                                                                                                                                                                                                                                                         
        ]);
        try{
            $data = $request->only('name','title','keywords','description','image','short_description','content','status','published_at');

            if($request->hasFile('image')){
                $imageFile = News::whereId($news->id)->value('image');
                File::delete($imageFile);
                $data['image'] = $this->ImageResizer($request, 'image', 'uploads/news/',363,436)??null;
   
            }else{
                $data['image'] = News::whereId($news->id)->value('image');
            }

            $data['url_key'] = str($data['name'])->slug();
            $news = News::updateOrCreate(
                [
                    'id' => $news->id,
                ],
                $data
            );

            $data['created_by'] = auth()->user()->name;
            $data['auth_id'] = auth()->user()->id;
            return redirect(route('news.show', $news))->with('success', 'data updated successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        //
    }
}
