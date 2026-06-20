<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catalogue;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Traits\DefaultTrait;
class CatalogueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use DefaultTrait;
    public function index()
    {
        return view('admin.catalogue.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try{
            $title = "Add New Catalogue";
            return view('admin.catalogue.create', compact('title'));
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
            'name' => ['required','string','max:255','unique:catalogues'],
            // 'pdf_file' => ['required'],
            'status' => ['required','digits_between:0,1'],
        ]);
        try{
          
            
            $qrCodePath = public_path('uploads/catalogue/qrcodes');
            if (!file_exists($qrCodePath)) {
                mkdir($qrCodePath, 0777, true);
            }
            $pdfPath = $request->pdf_file;
            if($request->hasFile('pdf_file')){
                $pdfPath = $this->handleUpload($request, 'pdf_file', 'uploads/catalogue/pdfs');
            }
            $qrCodePath = $this->generateQrCode($pdfPath, 'uploads/catalogue/qrcodes');
            Catalogue::create([
                'name' => $request->name,
                'qr_code' => $qrCodePath,
                'pdf' => $pdfPath,
            ]);
            return back()->with('success', 'Data added successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Catalogue $catalogue)
    {
        try{
            $content = $catalogue;
            return view('admin.catalogue.view', compact('content'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $title = 'Edit Catalogue';
        $content = Catalogue::find($id);
       
        return view('admin.catalogue.create',compact('title','content'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'pdf_file' => ['required', 'file', 'mimes:pdf'],
            'status' => ['required', 'digits_between:0,1'],
        ]);
    
        try {
            $data = Catalogue::find($id);
            
            if (!$data) {
                return back()->with('error', 'Catalogue not found.');
            }
    
            if ($request->hasFile('pdf_file')) {
                $existingPdfPath = public_path($data->pdf);
    
                // Ensure the previous PDF file exists
                if ($data->pdf && file_exists($existingPdfPath)) {
                    // Replace the existing file with the new one while keeping the same name
                    $request->file('pdf_file')->move(dirname($existingPdfPath), basename($existingPdfPath));
                } else {
                    $pdfPath = $this->handleUpload($request, 'pdf_file', 'uploads/catalogue/pdfs');    
                }
    
                $data->save();
            }
    
            return back()->with('success', 'Data updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function downloadQrCode($id)
    {
        $catalogue = Catalogue::findOrFail($id);
    
        if (!$catalogue->qr_code) {
            abort(404, 'QR Code not found.');
        }
    
        $filePath = public_path($catalogue->qr_code);
    
        if (!file_exists($filePath)) {
            abort(404, 'QR Code file not found.');
        }
        $fileName = $catalogue->name . 'QR-Code.png';
        return response()->download($filePath, $fileName);
    }

    public function vcard(Request $request)
{
    $name = 'Rajeev Jain';
    $org = 'RN Valves & Faucets';
    $mobile = '+91 9540499900';
    $email = 'md@rnvalves.com';
    $title = 'Managing Director';
    $lastName = 'Jain';
    $firstName = 'Rajeev';

    $vcard = "BEGIN:VCARD\r\n";
    $vcard .= "VERSION:3.0\r\n";
    $vcard .= "N:$lastName;$firstName;;;\r\n";
    $vcard .= "FN:$name\r\n";
    $vcard .= "ORG:$org\r\n";
    $vcard .= "TITLE:$title\r\n";
    $vcard .= "TEL;TYPE=WORK,VOICE:$mobile\r\n";
    $vcard .= "EMAIL;TYPE=INTERNET,PREF:$email\r\n";
    $vcard .= "ADR;TYPE=WORK:;;B-68, Site-IV, Sahibabad Industrial Area;Ghaziabad;Uttar Pradesh;201010;India\r\n";
    $vcard .= "URL:https://www.rnvalves.com\r\n";
    $vcard .= "END:VCARD\r\n";

    $qrCodeDirectory = 'uploads/vcard/qrcodes';
    
    $qrCodeFileName = uniqid() . '.png';
    $qrCodeFullPath = $qrCodeDirectory . '/' . $qrCodeFileName;
    
    QrCode::format('png')
            ->size(200)
            ->generate($vcard, public_path($qrCodeFullPath));

    Catalogue::create([
        'name' => $name,
        'qr_code' => $qrCodeFullPath,
        'pdf' => '',
    ]);
    return dd($qrCodeFullPath);
}

}
