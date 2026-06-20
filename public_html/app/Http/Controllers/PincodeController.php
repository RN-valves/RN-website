<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Country,
    State,
    City,
    Pincode,
    ImportedFileLog
};

use App\Jobs\SendEmailNotification;
use App\Jobs\ProcessUploadPincode;
use Illuminate\Support\Facades\Bus;
use App\Imports\PincodeImport;
use Excel;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Traits\DefaultTrait;

class PincodeController extends Controller
{
    use DefaultTrait;
    function __construct()
    {
        $this->middleware(['permission:pincode-list'], ['only' => ['index']]);
        $this->middleware(['permission:pincode-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:pincode-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:pincode-delete'], ['only' => ['destroy']]);
        $this->middleware(['permission:pincode-excel-upload'], ['only' => ['import_pincodes']]);
    }

    public function index(){
        try{
            $pincodes = Pincode::get();
            return view('admin.pincodes.index', compact('pincodes'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function create(){
        try{
            $title = "Add New Pincode";
            $countries = Country::select('id','name')->get();
            return view('admin.pincodes.create', compact('title','countries'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function store(Request $request){
        $request->validate([
            'country_id' => ['required','exists:countries,id'],
            'state_id' => ['required','exists:states,id'],
            'city_id' => ['required','exists:cities,id'],
            'name' => ['required','max:55','unique:pincodes,name'],
            'code' => ['required','max:10','unique:pincodes,code'],
        ]);
        $data = $request->only('name','code','country_id','state_id','city_id');
        try{
            Pincode::updateOrCreate(
                [
                    'state_id' => $data['state_id'],
                    'city_id' => $data['city_id'],
                    'code' => $data['code'],
                ],
                $data,
            );
            return back()->with('success', 'Pincode created successfully.');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Pincode $pincode){
        try{
            $title = "Pincode ". $pincode->name;
            return view('admin.pincodes.show', compact('title','pincode'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit(Pincode $pincode){
        try{
            $countries = Country::select('id','name')->get();
            $title = "Edit New pincode ". $pincode->name;
            return view('admin.pincodes.create', compact('title','countries','pincode'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, Pincode $pincode){
        $request->validate([
            'country_id' => ['required','exists:countries,id'],
            'state_id' => ['required','exists:states,id'],
            'city_id' => ['required','exists:cities,id'],
            'name' => ['required','max:55','unique:pincodes,name,'.$pincode->id],
            'code' => ['required','max:10','unique:pincodes,code,'.$pincode->id],
        ]);
        $data = $request->only('name','code','country_id','state_id','city_id');
        try{
            Pincode::whereId($pincode->id)->update($data);
            return redirect()->route('pincodes.index')->with('success', 'Pincode updated successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function get_pincode_city_state(Request $request){
        if($request->ajax()){
            $data = $request->only('pincode');
            $pincode = Pincode::where('code',$request->pincode)->first();
            if(!empty($pincode)){
                $data['city'] = $pincode->city;
                $data['state'] = $pincode->state;
                $data['country'] = $pincode->country;
                return response()->json($data);
            }
        }
    }

    public function import_pincodes(Request $request){
        try{
            if($request->isMethod('post')){
                $request->validate([
                    'import_file' => ['required','mimes:xlsx'],
                ]);

                if($request->hasFile('import_file')){
                    try{
                        $import = new PincodeImport;
                        $import->import($request->file('import_file'));
                    }catch(\Maatwebsite\Excel\Validators\ValidationException $e){
                        $failures = $e->failures();
                        return back()->with('failures', $failures);
                    }
                }


                /*$file = $request->file('import_file')->store('temp'); 
                $path = storage_path('app'). '/' .$file; 
                $email = auth()->user()->email??'sajidmirja19@gmail.com'; */

                //upload history for public path
                common_import_store($request, 'import_file', 'pincode');

                
                /*Bus::chain([
                new ProcessUploadPincode($path),
                new SendEmailNotification($email)
                ])->dispatch();*/
                //Excel::import(new PincodeImport, $request->import_file);
                return back()->with('success', 'Your file is being uploaded. We will email you once it is completed');
            }

            if(request('download')=="download"){
                $pincodes = Pincode::select('pincodes.name','pincodes.code','states.name as state_name', 'cities.name as city_name','pincodes.city_id','pincodes.state_id')
                    ->join('states', 'states.id', '=', 'pincodes.state_id')
                    ->join('cities','cities.id','=','pincodes.city_id')
                    ->get();
                return export_fast_excel($pincodes, now().'_pincodes.xlsx');
            }
            
            if($request->export=="export"){
                $pincodes = Pincode::select('country_id','state_id','city_id','name','code')->limit(1)->get();
                return export_fast_excel($pincodes, now().'_pincodes.xlsx');
            }
            
            $imports = ImportedFileLog::where(['model_name'=>'pincode'])->get();
            return view('admin.pincodes.import',compact('imports'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }
}
