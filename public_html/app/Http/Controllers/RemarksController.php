<?php

namespace App\Http\Controllers;

use App\Models\Remark;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RemarksController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:remark-list'], ['only' => ['index']]);
        $this->middleware(['permission:remark-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:remark-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:remark-delete'], ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $remarks = Remark::all();
            return view('admin.remarks.index', compact('remarks'));
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
            $types = array('User','Enquiry');
            return view('admin.remarks.create', compact('types'));
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
            'type' => ['required',Rule::in(['User','Enquiry'])],
            'name' => ['required','string','max:155'],
            'description' => ['required','string','max:255'],
        ]);
        $data = $request->only('name','type','description');
        try{
            Remark::updateOrCreate(
                [
                    'name' => $data['name'],
                ],
                [
                    'type' => $data['type'],
                    'name' => $data['name'],
                    'description' => $data['description'],
                ],
            );
            return redirect(route('remarks.index'))->with('success', 'data added successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Remark $remark)
    {
        try{
            return view('admin.remarks.show', compact('remark'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Remark $remark)
    {
        try{
            $types = array('User','Enquiry');
            return view('admin.remarks.create', compact('remark','types'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Remark $remark)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Remark $remark)
    {
        try{
            if($remark->forceDelete()){
                return back()->with('success', 'data deleted successfully');
            }else{
                return back()->with('error', 'failled....');
            }
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }
}
