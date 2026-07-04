<?php

namespace App\Http\Controllers;

use App\Models\{
    OrderTransport,
    Order,
    OrderLog,
    Payment
};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use File;
use App\Traits\DefaultTrait;
use Mail;
use App\Mail\OrderStatusMail;

class OrderTransportController extends Controller
{
    use DefaultTrait;
    function __construct()
    {
        $this->middleware(['permission:orderTransport-list'], ['only' => ['index']]);
        $this->middleware(['permission:orderTransport-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:orderTransport-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:orderTransport-delete'], ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $order_transports = OrderTransport::all();
            return view('admin.order_transports.index', compact('order_transports'));
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
        $request->validate([
            'status' => ['required', Rule::in(['Pending','In-Progress','In-Transit','Delivered','Completed','Cancelled'])],
            'order_id' => ['required','exists:orders,id'],
            'transport_name' => ['nullable','max:155'],
            'transport_contact' => ['nullable','max:15'],
            'transport_url' => ['nullable','max:255'],
            'order_tracking_id' => ['nullable','max:55'],
            'attachment' => ['nullable','max:2048'],
            'invoice' => ['nullable','max:2048'],
        ]);
        try{
            $data = $request->all();
            $getSingleOrder = Order::getSingleOrder($data['order_id']);
            if(empty($getSingleOrder)){
                return back()->with('error', 'Order not found.');
            }

            if ($getSingleOrder->requiresTransportForStatus($data['status'])) {
                $checkOdTransport = OrderTransport::where('order_id', $data['order_id'])->first();
                if (empty($checkOdTransport)) {
                    return back()->with('error', 'First need to update transport details for this order');
                }
            }

            if(!empty($getSingleOrder)){

                $checkOdTransport = OrderTransport::where('order_id', $data['order_id'])->first();
                if(!empty($checkOdTransport)){
                    if($request->hasFile('attachment')){
                        $oldFile = OrderTransport::whereId($checkOdTransport->id)->value('attachment');
                        File::delete($oldFile);
                        $attachment = $this->verifyAndUpload($request, 'attachment', 'uploads/bilties/')??'';
                    }else{
                        $attachment = OrderTransport::whereId($checkOdTransport->id)->value('attachment');
                    }
                    if($request->hasFile('invoice')){
                        $oldFileInvoice = Order::whereId($getSingleOrder->id)->value('invoice');
                        File::delete($oldFileInvoice);
                        $invoice = $this->verifyAndUpload($request, 'invoice', 'uploads/invoices/')??'';
                    }else{
                        $invoice = Order::whereId($getSingleOrder->id)->value('invoice');
                    }
                }else{
                    $attachment = $this->verifyAndUpload($request, 'attachment', 'uploads/bilties/')??'';
                    $invoice = $this->verifyAndUpload($request, 'invoice', 'uploads/invoices/')??'';
                }

                $getSingleOrder->status = $data['status'];
                $getSingleOrder->invoice = $invoice;
                $getSingleOrder->save();

                OrderLog::create(
                    [
                        'order_id' => $getSingleOrder->id,
                        'user_id' => auth()->user()->id,
                        'user_name' => auth()->user()->name,
                        'change_value' => $data['status'],
                        'change_type' => "status",
                    ],
                );

                OrderTransport::updateOrCreate(
                    [
                        'order_id' => $getSingleOrder->id,
                    ],
                    [
                        'order_id' => $getSingleOrder->id,
                        'user_id' => auth()->user()->id,
                        'transport_name' => $data['transport_name']??'',
                        'transport_contact' => $data['transport_contact']??'',
                        'transport_url' => $data['transport_url']??'',
                        'order_tracking_id' => $data['order_tracking_id']??'',
                        'attachment' => $attachment,
                    ],
                );
                if(!empty($getSingleOrder->pay_link_id && $getSingleOrder->status=="Cancelled")){
                    $result = razorpay_link_cancel($getSingleOrder->pay_link_id);
                    $result = json_decode($result->getBody());

                    $payment = Payment::getPaymentUrl($getSingleOrder->pay_link_id);
                    $payment->status = $result->status;
                    $payment->save();
                }
                //Mail::to($getSingleOrder->email)->send(new OrderStatusMail($getSingleOrder));

            }
            //Order::ship_rocket_detail($getSingleOrder->id);
            return back()->with('success', 'Order status has been updated successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderTransport $orderTransport)
    {
        try{
            return view('admin.order_transports.show', compact('orderTransport'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderTransport $orderTransport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderTransport $orderTransport)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderTransport $orderTransport)
    {
        //
    }
}
