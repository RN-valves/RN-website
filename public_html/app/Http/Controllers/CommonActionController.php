<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    ImportedFileLog
};

class CommonActionController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:delete-uploaded-excel-file'], ['only' => ['delete_imported_excels']]);
    }

    public function delete_imported_excels(ImportedFileLog $importedFileLog){
        try{
            if(\File::exists(public_path($importedFileLog->file_path))){
                \File::delete(public_path($importedFileLog->file_path));
            }
            $importedFileLog->delete();
            return back()->with('success', 'record has beed deleted successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }
}
