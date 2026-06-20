<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Discount
};
use App\Traits\DefaultTrait;
use Illuminate\Validation\Rule;

class DiscountController extends Controller
{
    use DefaultTrait;
    function __construct()
    {
        $this->middleware(['permission:discount-list'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:discount-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:discount-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:discount-delete'], ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $discounts = Discount::all();
            return view('admin.discounts.index', compact('discounts'));
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
            return view('admin.discounts.create');
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
            'name' => ['required','unique:discounts,name'],
            'type' => ['required', Rule::in(['Amount','Percent'])],
            'status' => ['required', Rule::in(['Active','InActive'])],
            'value' => ['required'],
            'expired_at' => ['required'],
            'start_value' => ['required','lte:end_value','numeric'],
            'end_value' => ['required','gte:start_value','numeric'],
        ]);
        $data = $request->only('name','type','value','expired_at','status','start_value','end_value');
        try{
            Discount::create($data);
            return to_route('discounts.index')->with('success', 'Data added successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Discount $discount)
    {
        try{
            return view('admin.discounts.show', compact('discount'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discount $discount)
    {
        try{
            return view('admin.discounts.create', compact('discount'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Discount $discount)
    {
        $request->validate([
            'name' => ['required','unique:discounts,name,'.$discount->id],
            'type' => ['required', Rule::in(['Amount','Percent'])],
            'status' => ['required', Rule::in(['Active','InActive'])],
            'value' => ['required'],
            'expired_at' => ['required'],
            'start_value' => ['required','lte:end_value','numeric'],
            'end_value' => ['required','gte:start_value','numeric'],
        ]);
        $data = $request->only('name','type','value','expired_at','status','start_value','end_value');
        try{
            $data['expired_at'] = \Carbon\Carbon::parse($data['expired_at']);
            Discount::whereId($discount->id)->update($data);
            return to_route('discounts.index')->with('success', 'Data added successfully');
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
