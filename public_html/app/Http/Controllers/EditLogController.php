<?php

namespace App\Http\Controllers;

use App\Models\{
    EditLog,
    User,
    ReportUser
};
use Illuminate\Http\Request;
use App\Traits\DefaultTrait;

class EditLogController extends Controller
{
    use DefaultTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'customer_id' => ['required','exists:users,id'],
            'remark' => ['required','string','max:155'],
            'reporting_ids' => ['required'],
        ]);

        try{
            $data = $request->only('customer_id','remark');

            $customer = User::where(['id'=>$data['customer_id']])->first();
            if(empty($customer)){
                return back()->with('error', 'Whoops! Something went wrong');
            }

            $lastEditTime = EditLog::where(['customer_id'=>$data['customer_id']])->latest()->first();
            if(!empty($lastEditTime)){
                $differenceTime = $lastEditTime->created_at->diffInMinutes(now());
                if($differenceTime < 2){
                    return back()->with('error', 'Whoops! Something went wrong, try again after a minute');
                }
            }

            $data['user_id'] = auth()->user()->id;
            $data['user_name'] = auth()->user()->name;
            $data['customer_name'] = $customer->name;
            EditLog::create($data);
            $this->assigningReportUsers($request['reporting_ids'], $customer->id, $customer->user_type);
            return back()->with('success', 'data updated successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(EditLog $editLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EditLog $editLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EditLog $editLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EditLog $editLog)
    {
        //
    }
}
