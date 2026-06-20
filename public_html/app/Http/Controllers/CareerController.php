<?php

namespace App\Http\Controllers;

use App\Models\{
    Pincode,
    Career
};
use Illuminate\Http\Request;
use App\Traits\DefaultTrait;
use File;

class CareerController extends Controller
{
    use DefaultTrait;
    function __construct()
    {
        $this->middleware(['permission:career-list'], ['only' => ['index']]);
        $this->middleware(['permission:career-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:career-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:career-delete'], ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $careers = Career::get();
            return view('admin.careers.index', compact('careers'));
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
            return view('admin.careers.create');
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
            'title' => ['required','string','max:255'],
            'designation' => ['required','string','max:255'],
            'zipcode' => ['required','exists:pincodes,code'],
            'content' => ['required','string'],
            'status' => ['required', 'in:Active,InActive'],
            'published_at' => ['required','date'],
            'attachment' => ['nullable','mimes:docx,pdf'],
        ]);
        try{
            $data = $request->only('title','designation','zipcode','content','status','published_at','attachment');
            $pincode = Pincode::where('code',$data['zipcode'])->first();
            if(!empty($pincode)){
                $data['attachment'] = $this->verifyAndUpload($request, 'attachment', 'uploads/careers/')??null;
                Career::updateOrCreate(
                    [
                        'title' => $data['title'],
                    ],
                    [
                        'uuid' => str()->uuid()->toString(),
                        'edit_by' => auth()->user()->name,
                        'title' => $data['title'],
                        'created_by' => auth()->user()->name,
                        'created_id' => auth()->user()->id,
                        'designation' => $data['designation'],
                        'zipcode' => $data['zipcode'],
                        'content' => $data['content'],
                        'status' => $data['status'],
                        'state' => $pincode->state->name,
                        'city' => $pincode->city->name,
                        'country' => $pincode->country->name,
                        'published_at' => $data['published_at'],
                        'attachment' => $data['attachment'],
                    ],
                );
            }
            return back()->with('success', 'data has been updated successfully!!');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Career $career)
    {
        try{
            return view('admin.careers.show', compact('career'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Career $career)
    {
        try{
            return view('admin.careers.create', compact('career'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Career $career)
    {
        $request->validate([
            'title' => ['required','string','max:255'],
            'designation' => ['required','string','max:255'],
            'zipcode' => ['required','exists:pincodes,code'],
            'content' => ['required','string'],
            'status' => ['required', 'in:Active,InActive'],
            'published_at' => ['required','date'],
            'attachment' => ['nullable','mimes:docx,pdf'],
        ]);
        try{
            $data = $request->only('title','designation','zipcode','content','status','published_at','attachment');
            $pincode = Pincode::where('code',$data['zipcode'])->first();
            if(!empty($pincode)){

                if($request->hasFile('attachment')){
                    $oldFile = Career::whereId($career->id)->value('attachment');
                    File::delete($oldFile);
                    $data['attachment'] = $this->verifyAndUpload($request, 'attachment', 'uploads/careers/')??null;
                }else{
                    $data['attachment'] = Career::whereId($career->id)->value('attachment');
                }
                
                Career::updateOrCreate(
                    [
                        'title' => $data['title'],
                    ],
                    [
                        'edit_by' => auth()->user()->name,
                        'title' => $data['title'],
                        'designation' => $data['designation'],
                        'zipcode' => $data['zipcode'],
                        'content' => $data['content'],
                        'status' => $data['status'],
                        'state' => $pincode->state->name,
                        'city' => $pincode->city->name,
                        'country' => $pincode->country->name,
                        'published_at' => $data['published_at'],
                        'attachment' => $data['attachment'],
                    ],
                );
            }
            return redirect(route('careers.index'))->with('success', 'data has been updated successfully!!');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Career $career)
    {
        //
    }
}
