<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Country,
    State,
    City,
    ImportedFileLog
};
use App\Imports\CityImport;
use Excel;
use Rap2hpoutre\FastExcel\FastExcel;

class CityController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:city-list'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:city-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:city-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:city-excel-upload'], ['only' => ['import_cities']]);
    }

    public function index(){
        try{
            $cities = City::get();
            return view('admin.cities.index', compact('cities'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function create(){
        try{
            $title = "Add New City";
            $countries = Country::select('id','name')->get();
            return view('admin.cities.create', compact('title','countries'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function store(Request $request){
        $request->validate([
            'country_id' => ['required','exists:countries,id'],
            'state_id' => ['required','exists:states,id'],
            'name' => ['required','max:55','unique:cities,name'],
            'code' => ['required','max:10','unique:cities,code'],
        ]);
        $data = $request->only('name','code','country_id','state_id');
        try{
            City::updateOrCreate(
                [
                    'state_id' => $data['state_id'],
                    'name' => $data['name'],
                ],
                $data,
            );
            return back()->with('success', 'City created successfully.');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(){

    }

    public function edit(City $city){
        try{
            $countries = Country::select('id','name')->get();
            $title = "Edit New City ". $city->name;
            return view('admin.cities.create', compact('title','countries','city'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, City $city){
        $request->validate([
            'country_id' => ['required','exists:countries,id'],
            'state_id' => ['required','exists:states,id'],
            'name' => ['required','max:55','unique:cities,name,'.$city->id],
            'code' => ['required','max:10','unique:cities,code,'.$city->id],
        ]);
        $data = $request->only('name','code','country_id','state_id');
        try{
            City::whereId($city->id)->update($data);
            return redirect()->route('cities.index')->with('success', 'City updated successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }
    

    public function import_cities(Request $request){
        try{
            if($request->isMethod('post')){
                $request->validate([
                    'import_file' => ['required','mimes:xlsx'],
                ]);

                if($request->hasFile('import_file')){
                    try{
                        $import = new CityImport;
                        $import->import($request->file('import_file'));
                    }catch(\Maatwebsite\Excel\Validators\ValidationException $e){
                        $failures = $e->failures();
                        return back()->with('failures', $failures);
                    }
                }

                //upload history for public path
                common_import_store($request, 'import_file', 'city');
                return back()->with('success', 'file uploaded successfully');
            }
            
            if($request->export=="export"){
                $cities = City::select('country_id','state_id','name','code')->limit(1)->get();
                return export_fast_excel($cities, now().'_cities.xlsx');
            }
            
            $imports = ImportedFileLog::where(['model_name'=>'city'])->get();
            return view('admin.cities.import',compact('imports'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }
}
