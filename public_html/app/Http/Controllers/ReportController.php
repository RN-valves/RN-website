<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    RemarkLog,
    User,
    Enquiry,
    OrderCancelLog,
    Order,
    Category,
    Subcategory
};
use Carbon\Carbon;
use App\Exports\OrderReportExport;
use App\Exports\ProductExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:order-cancel-log-list'], ['only' => ['order_cancel_log_list','orderReports','orderReportsExport']]);
    }

    public function order_cancel_log_list(){
        try{
            $order_cancel_logs = OrderCancelLog::get();
            return view('admin.reports.order_cancel_logs', compact('order_cancel_logs'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function orderReports(Request $request){
        try{
            $orders = '';
            $reqStatus = '';
            if($request->from_date && $request->to_date || $request->status){
                $fromDate = $request->from_date ?? '';
                $toDate = $request->to_date ?? '';
                $reqStatus = $request->status;
                $fromDate = Carbon::createFromFormat('d/m/Y', $fromDate)->format('Y-m-d');
                $toDate = Carbon::createFromFormat('d/m/Y', $toDate)->format('Y-m-d');
                $orders = Order::query()
                ->when(isset($fromDate) && isset($toDate), function ($query) use ($fromDate, $toDate) {
                    $query->whereBetween('created_at', [
                        Carbon::parse($fromDate)->startOfDay(),
                        Carbon::parse($toDate)->endOfDay()
                    ]);
                })
                ->when(isset($reqStatus), function ($query) use ($reqStatus) {
                    $query->whereIn('status',$reqStatus);
                })
                ->get();
            }
            $status = Order::query()->pluck('status')->unique()->values();
            return view('admin.reports.order_report',compact('orders','status','reqStatus'));
        }catch(\Exception $e){
           return back()->with('error',$e->getMessage());
        }
    }

    public function orderReportsExport(Request $request)
    {
    
        $fromDate = $request->from_date;
        $toDate = $request->to_date;
        $reqStatus = $request->status;
        $fromDate = Carbon::createFromFormat('d/m/Y', @$fromDate)->format('Y-m-d');
        $toDate = Carbon::createFromFormat('d/m/Y', @$toDate)->format('Y-m-d');
        $orders = Order::query()
        ->when(isset($fromDate) && isset($toDate), function ($query) use ($fromDate, $toDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($fromDate)->startOfDay(),
                Carbon::parse($toDate)->endOfDay()
            ]);
        })
        ->when(isset($reqStatus), function ($query) use ($reqStatus) {
            $query->whereIn('status',$reqStatus);
        })
        ->with('orderTransort')
        ->get();
    return Excel::download(new OrderReportExport($orders), now().'order-report.xlsx');
    }

    public function productReport(){
        $categories = Category::where('status','Active')->get();
        return view('admin.reports.product_report',compact('categories'));
    }

    public function ajaxSubcategory(Request $request)
    {
        $categoryIds = $request->category_ids;

        if ($categoryIds && in_array('all', $categoryIds)) {
            $subcategories = Subcategory::where('is_visible_website',1)->where('status','Active')->get();
        } else {
            $subcategories = Subcategory::where('is_visible_website',1)->where('status','Active')->whereIn('category_id', $categoryIds)->get();
        }
       return response()->json($subcategories);
    }

    public function productExportReports(Request $request)
    {

        $categoryInput = $request->input('category_ids', []);
        $subcategoryIds = $request->input('subcategory_ids', []);
    
        $isAllCategory = in_array('all', $categoryInput);
    
        // Only filter categories if not "all"
        $categoryIds = $isAllCategory ? [] : $categoryInput;
    
        return Excel::download(new ProductExport($categoryIds, $subcategoryIds, $isAllCategory), now().'products.xlsx');
       
    }
}
