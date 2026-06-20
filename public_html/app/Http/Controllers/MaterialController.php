<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:material-list'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:material-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:material-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:material-delete'], ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $materials = Material::all();
            return view('admin.materials.index', compact('materials'));
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
            return view('admin.materials.create');
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
            'name' => ['required','unique:materials,name'],
        ]);
        $data = $request->only('name');
        try{
            Material::create($data);
            return to_route('materials.index')->with('success', 'Data added successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Material $material)
    {
        try{
            return view('admin.materials.show', compact('material'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Material $material)
    {
        try{
            return view('admin.materials.create', compact('material'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Material $material)
    {
        $request->validate([
            'name' => ['required','unique:materials,name,'.$material->id],
        ]);
        $data = $request->only('name');
        try{
            Material::whereId($material->id)->update($data);
            return to_route('materials.index')->with('success', 'Data added successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        //
    }
}
