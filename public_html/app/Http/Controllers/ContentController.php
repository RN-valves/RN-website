<?php

namespace App\Http\Controllers;
use App\Models\Content;

use Illuminate\Http\Request;

class ContentController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:content-list'], ['only' => ['index']]);
        $this->middleware(['permission:content-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:content-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:content-delete'], ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $title = "Content Index";
            $contents = Content::get();
            return view('admin.contents.index', compact('title','contents'));
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
            $title = "Add New Content";
            return view('admin.contents.create', compact('title'));
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
            'title' => ['required','string','max:255','unique:contents'],
            'content' => ['required','string','min:10'],
            'is_visible_website' => ['required','digits_between:0,1'],
            'status' => ['required','in:Active,InActive'],
        ]);
        try{
            $data = $request->only('title','content','is_visible_website','status');
            $data['uuid'] = str()->uuid()->toString();
            Content::create($data);
            return back()->with('success', 'data added successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Content $content)
    {
        try{
            return view('admin.contents.show', compact('content'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Content $content)
    {
        try{
            $title = "Edit Content";
            return view('admin.contents.create', compact('title','content'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Content $content)
    {
        $request->validate([
            'title' => ['required','string','max:255','unique:contents,title,'.$content->id],
            'content' => ['required','string','min:10'],
            'is_visible_website' => ['required','digits_between:0,1'],
            'status' => ['required','in:Active,InActive'],
        ]);
        try{
            $data = $request->only('title','content','is_visible_website','status');
            Content::whereId($content->id)->update($data);
            return to_route('contents.index')->with('success', 'data updated successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Content $content)
    {
        //
    }
}
