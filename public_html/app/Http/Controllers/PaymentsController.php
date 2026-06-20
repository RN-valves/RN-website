<?php

namespace App\Http\Controllers;

use App\Models\{
    OrderTransport,
    Order,
    Payment
};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentsController extends Controller
{
    /*function __construct()
    {
        $this->middleware(['permission:payment-list'], ['only' => ['index']]);
        $this->middleware(['permission:payment-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:payment-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:payment-delete'], ['only' => ['destroy']]);
    }*/
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            return view('admin.payments.index');
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
    public function show(Payment $payment)
    {
        try{
            return view('admin.payments.show', compact('payment'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        if(!empty($payment->pay_link_id)){
            if($request->status=="Cancel"){
                $result = razorpay_link_cancel($payment->pay_link_id);
                $result = json_decode($result->getBody());
                $payment->status = $result->status;
                $payment->save();
                return back()->with('success', 'payment has been cancelled successfully!!');
            }elseif($request->status=="Resend_TXT"){
                $result = razorypay_resend_text_payment_link($payment->pay_link_id);
                $result = json_decode($result->getBody());
                return back()->with('success', 'Payment Text re-send successfully!!');
            }else{
                return back()->with('error', 'failled...');
            }
        }else{
            return back()->with('error', 'empty payment link id');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        //
    }
}
