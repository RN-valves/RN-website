<?php

namespace App\Http\Controllers;

use App\Models\{
    Enquiry,
    Pincode,
    User,
    ImportedFileLog,
    Remark
};
use Illuminate\Http\Request;
use App\Repositories\Interfaces\EnquiryInterface;
use Illuminate\Validation\Rule;
use App\Imports\EnquiryImport;
use Excel;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Jobs\SendEmailNotification;
use App\Jobs\ProcessUploadEnquiry;

class EnquiryController extends Controller
{
    private $enquiryRep;

    function __construct(EnquiryInterface $enquiryRep)
    {
        $this->middleware(['permission:enquiry-list'], ['only' => ['index']]);
        $this->middleware(['permission:enquiry-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:enquiry-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:enquiry-delete'], ['only' => ['destroy']]);
        $this->middleware(['permission:enquiry-excel-upload'], ['only' => ['import_enquiries']]);
        $this->enquiryRep = $enquiryRep;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            return view('admin.enquiries.index');
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
            $users = User::getEmployeeList();
            $types = array('Distributor','Retailer','Dealer', 'Architect', 'Interier Designer', 'Consultant', 'Contractor', 'Plumber', 'Consumer', 'Other');
            $scources = array('Facebook','Website','Call','Walk','SMS','Toll-Free','JustDial','Whatsapp','IndiaMart','Reference','Other');
            return view('admin.enquiries.create', compact('scources','types','users'));
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
            'salesmen_id' => ['required','exists:users,id'],
            'name' => ['required','max:55','string'],
            'company_name' => ['required','max:55','string'],
            'mobile' => ['required','digits:10'],
            'zipcode' => ['required','exists:pincodes,code'],
            'email' => ['nullable','max:100','string','email'],
            'enquiry_type' => ['required',Rule::in(['Distributor','Retailer','Dealer', 'Architect', 'Interier Designer', 'Consultant', 'Contractor', 'Plumber', 'Consumer', 'Other'])],
            'scource_type' => ['required',Rule::in(['Facebook','Website','Call','Walk','SMS','Toll-Free','JustDial','Whatsapp','IndiaMart','Reference','Other'])],
            'address' => ['nullable','string','max:255'],
            'purpose' => ['required','string','max:255'],
            'page_url' => ['nullable','string'],
            'published_at' => ['nullable','date'],
        ]);
        $data = $request->only('salesmen_id','name','company_name','mobile','zipcode','email','enquiry_type','scource_type','address','purpose','page_url','published_at');
        $pincode = Pincode::where('code', $data['zipcode'])->first();
        if(empty($pincode)){
            return back()->with('error','please enter valid pincode');
        }
        try{
            $data['ip_address'] = $request->ip();
            $data['created_by'] = auth()->user()->name??'Guest';
            $enquiry = $this->enquiryRep->store($data);
            return redirect(route('enquiries.show', $enquiry))->with('success', 'data has been added successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Enquiry $enquiry)
    {
        try{
            $remarks = Remark::where(['type'=>'Enquiry'])->get();
            return view('admin.enquiries.show', compact('enquiry','remarks'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enquiry $enquiry)
    {
        try{
            $users = User::getEmployeeList();
            $types = array('Distributor','Retailer','Dealer', 'Architect', 'Interier Designer', 'Consultant', 'Contractor', 'Plumber', 'Consumer', 'Other');
            $scources = array('Facebook','Website','Call','Walk','SMS','Toll-Free','JustDial','Whatsapp','IndiaMart','Reference','Other');
            return view('admin.enquiries.create', compact('scources','types','enquiry','users'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Enquiry $enquiry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enquiry $enquiry)
    {
        //
    }

    public function import_enquiries(Request $request){
        try{
            if($request->isMethod('post')){
                $request->validate([
                    'import_file' => ['required','mimes:xlsx'],
                ]);

                $file = $request->file('import_file')->store('temp'); 
                $path = storage_path('app'). '/' .$file; 
                $email = auth()->user()->email??'web@rnvalves.com'; 

                //upload history for public path
                common_import_store($request, 'import_file', 'pincode');

                
                Bus::chain([
                new ProcessUploadEnquiry($path),
                new SendEmailNotification($email)
                ])->dispatch();

                if($request->hasFile('import_file')){
                    try{
                        $import = new EnquiryImport;
                        $import->import($request->file('import_file'));
                    }catch(\Maatwebsite\Excel\Validators\ValidationException $e){
                        $failures = $e->failures();
                        return back()->with('failures', $failures);
                    }
                }

                //upload history for public path
                common_import_store($request, 'import_file', 'enquiry');
                return back()->with('success', 'file uploaded successfully');
            }
            
            if($request->export=="export"){
                $enquiries = Enquiry::select('salesmen_id','name','email','company_name','mobile','enquiry_type','scource_type','zipcode','address','purpose','published_at')->limit(1)->get();
                return export_fast_excel($enquiries, now().'_enquiries.xlsx');
            }
            
            $imports = ImportedFileLog::where(['model_name'=>'enquiry'])->get();
            return view('admin.enquiries.import',compact('imports'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }
}
