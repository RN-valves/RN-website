<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Size
};

class SizeController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:size-list'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:size-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:size-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:size-delete'], ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $sizes = Size::all();
            return view('admin.sizes.index', compact('sizes'));
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
            return view('admin.sizes.create');
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
            'name' => ['required','unique:sizes,name'],
        ]);
        $data = $request->only('name');
        try{
            Size::create($data);
            return to_route('sizes.index')->with('success', 'Data added successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Size $size)
    {
        try{
            return view('admin.sizes.show', compact('size'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Size $size)
    {
        try{
            return view('admin.sizes.create', compact('size'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Size $size)
    {
        $request->validate([
            'name' => ['required','unique:sizes,name,'.$size->id],
        ]);
        $data = $request->only('name');
        try{
            Size::whereId($size->id)->update($data);
            return to_route('sizes.index')->with('success', 'Data added successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Size $size)
    {
        //
    }
}
