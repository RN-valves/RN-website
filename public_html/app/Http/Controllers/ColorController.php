<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Color
};
use App\Traits\DefaultTrait;

class ColorController extends Controller
{
    use DefaultTrait;
    function __construct()
    {
        $this->middleware(['permission:color-list'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:color-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:color-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:color-delete'], ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $colors = Color::all();
            return view('admin.colors.index', compact('colors'));
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
            return view('admin.colors.create');
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
            'name' => ['required','unique:colors,name'],
            'icon' => ['required','max:500','mimes:jpg,jpeg,png,webp'],
        ]);
        $data = $request->only('name','icon');
        try{
            $data['icon'] = $this->ImageResizer($request, 'icon', 'uploads/catalogue/colors/',100,100)??null;
            Color::create($data);
            return to_route('sizes.index')->with('success', 'Data added successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Color $color)
    {
        try{
            return view('admin.colors.show', compact('color'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Color $color)
    {
        try{
            return view('admin.colors.create', compact('color'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Color $color)
    {
        $request->validate([
            'name' => ['required','unique:colors,name,'.$color->id],
            'icon' => ['required','max:500','mimes:jpg,jpeg,png,webp'],
        ]);
        $data = $request->only('name','icon');
        try{
            if($request->hasFile('icon')){
                $oldFile = Color::whereId($color->id)->value('icon');
                File::delete($oldFile);
                $data['icon'] = $this->ImageResizer($request, 'icon', 'uploads/catalogue/colors/',100,100)??null;
            }else{
                $data['icon'] = Color::whereId($color->id)->value('icon');
            }
            Color::whereId($color->id)->update($data);
            return to_route('sizes.index')->with('success', 'Data added successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Color $color)
    {
        //
    }
}
