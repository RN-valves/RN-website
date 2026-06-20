<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;
use App\Traits\DefaultTrait;

class CertificateController extends Controller
{
    use DefaultTrait;
    function __construct()
    {
        $this->middleware(['permission:frontPage-edit'], ['only' => ['store', 'update','destroy']]);
    }
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
            'image' => ['required'],
        ]);
        try{
            $data['image'] = $this->verifyAndUpload($request, 'image', 'uploads/certificates/')??null;
            Certificate::create($data);
            return back()->with('success', 'Uploaded successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'image' => ['required'],
        ]);
        try{
            $certificate = Certificate::findOrFail($id);
            if ($certificate->image && file_exists(public_path($certificate->image))) {
                unlink(public_path($certificate->image));
            }
            $image = $this->verifyAndUpload($request, 'image', 'uploads/certificates/')??null;
            $certificate->image = $image;
            $certificate->save();
            return back()->with('success', 'Updated successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
          
          $certificate = Certificate::findOrFail($id);
          if ($certificate->image && file_exists(public_path($certificate->image))) {
              unlink(public_path($certificate->image));
          }
          $certificate->delete();
            return back()->with('success', 'Deleted successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }  
    }
}
