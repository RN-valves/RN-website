<?php

namespace App\Http\Controllers;

use App\Models\{
    RemarkLog,
    User,
    Enquiry
};
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use Carbon\Carbon;

class RemarkLogsController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:remark-log-list'], ['only' => ['index','show']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            if(!empty(request('user_id')) && !empty(request('from_date')) && !empty(request('end_date')) ){

                $from_date = \Carbon\Carbon::parse(request('from_date'))->format('Y-m-d H:i:s');
                $end_date = \Carbon\Carbon::parse(request('end_date'))->format('Y-m-d H:i:s');

                $remarkLogs = RemarkLog::select('created_at','customer_name','customer_mobile','user_name','remark','message as content','logable_type')
                    ->where(['user_id'=>request('user_id')])
                    ->whereBetween('created_at', [$from_date, $end_date])->get();
                /*$remarkLogs = RemarkLog::select([
                        'remark_logs.created_at as created_date',
                        'remark_logs.customer_name as customer_name', 
                        'remark_logs.customer_mobile as customer_mobile', 
                        'users.name as caller_name',
                        'remark_logs.remark as selected_remark', 
                        'remark_logs.message as remark', 
                        'remark_logs.logable_type as logable_type', 
                    ])->join('users','users.id','=','remark_logs.user_id')
                    ->where(['remark_logs.user_id'=>request('user_id')])
                    ->whereBetween('remark_logs.created_at', [$from_date, $end_date])
                    ->get();*/

                return export_fast_excel($remarkLogs, now().'_remark_logs.xlsx');
            }
            $remark_logs = RemarkLog::orderByDesc('id')->get();
            $employees = User::where(['user_type'=>'Employee'])->get();
            return view('admin.reports.remark_log', compact('remark_logs','employees'));
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
            'remark' => ['required','exists:remarks,name'],
            'message' => ['required','string','max:255'],
            'logable_id' => ['required'],
        ]);
        $data = $request->only('remark','message');

        $lastEditTime = RemarkLog::where(['logable_id'=>$request['logable_id']])->latest()->first();
        if(!empty($lastEditTime)){
            $differenceTime = $lastEditTime->created_at->diffInMinutes(now());
            if($differenceTime < 2){
                 return back()->with('error', 'Whoops! Something went wrong, try again after a minute');
            }
        }

        if($request['en_type']=="Enquiry"){
            $logable = Enquiry::whereId($request->logable_id)->first();
            Enquiry::whereId($request->logable_id)->update(['status'=>$data['remark']]);
        }elseif($request['en_type']=="User"){
            $logable = User::whereId($request->logable_id)->first();
        }else{
            return back()->with('error', 'Whoops!, Something went wrong');
        }

        try{
            $data['user_id'] = auth()->user()->id;
            $data['customer_mobile'] = $logable->mobile;
            $data['customer_name'] = $logable->name;
            $data['user_name'] = auth()->user()->name;
            $user = User::whereId($data['user_id'])->first();
            $logable->logables()->create($data);
            return back()->with('success', 'data added successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(RemarkLog $remarkLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RemarkLog $remarkLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RemarkLog $remarkLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RemarkLog $remarkLog)
    {
        //
    }
}
