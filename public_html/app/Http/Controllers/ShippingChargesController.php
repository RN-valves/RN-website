<?php

namespace App\Http\Controllers;

use App\Models\ShippingCharge;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ShippingChargesController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:shipping_charge-list'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:shipping_charge-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:shipping_charge-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:shipping_charge-delete'], ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $shippingCharges = ShippingCharge::get();
            return view('admin.shipping_charges.index', compact('shippingCharges'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ShippingCharge $shippingCharge)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShippingCharge $shippingCharge)
    {
        try{
            return view('admin.shipping_charges.create', compact('shippingCharge'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShippingCharge $shippingCharge)
    {
        $request->validate([
            'w_0_100gm' => ['required','numeric'],
            'w_101_200gm' => ['required','numeric'],
            'w_201_400gm' => ['required','numeric'],
            'w_401_600gm' => ['required','numeric'],
            'w_601_1000gm' => ['required','numeric'],
            'w_1001_1500gm' => ['required','numeric'],
            'w_1501_2000gm' => ['required','numeric'],
            'w_2001_2500gm' => ['required','numeric'],
            'w_2501_3000gm' => ['required','numeric'],
            'w_3001_4000gm' => ['required','numeric'],
            'w_4001_5000gm' => ['required','numeric'],
            'w_5001_10000gm' => ['required','numeric'],
            'w_10001_20000gm' => ['required','numeric'],
            'w_20001_40000gm' => ['required','numeric'],
            'status' => ['required', Rule::in(['Active','InActive'])],
        ]);

        try{
            $data = $request->only('w_0_100gm','w_101_200gm','w_201_400gm','w_401_600gm','w_601_1000gm','w_1001_1500gm','w_1501_2000gm','w_2001_2500gm','w_2501_3000gm','w_3001_4000gm','w_4001_5000gm','w_5001_10000gm','w_10001_20000gm','w_20001_40000gm','status');
            ShippingCharge::whereId($shippingCharge->id)->update($data);
            return redirect()->route('shippingCharges.index')->with('success', 'data updated successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShippingCharge $shippingCharge)
    {
        //
    }
}
