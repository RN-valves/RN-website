<?php

namespace App\Http\Controllers;

use App\Models\{
    Category,
    BPoint,
    Subcategory,
    Product
};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BulletPointsController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:bullet-point-list'], ['only' => ['index']]);
        $this->middleware(['permission:bullet-point-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:bullet-point-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:bullet-point-delete'], ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.bullet_points.index');
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
        $request->validate([
            'model_type' => ['required',Rule::in(['Category','Subcategory','Product'])],
            'model_id' => ['required'],
            'name' => ['required','string','max:255'],
        ]);
        $data = $request->only('model_type','model_id','name');
        try{
            BPoint::create([
                'model_type' => $data['model_type'],
                'model_id' => $data['model_id'],
                'name' => $data['name'],
            ]);

            return back()->with('success', 'data added successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BPoint $bPoint)
    {
        try{
            return view('admin.bullet_points.show', compact('bPoint'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BPoint $bPoint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BPoint $bPoint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BPoint $bPoint)
    {
        if($bPoint->forceDelete()){
            return back()->with('success', 'data deleted successfully');
        }else{
            return back()->with('error', 'failled...');
        }
    }
}
