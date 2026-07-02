<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    ProductImage,
    Product,
    ImportedFileLog
};

use App\Imports\ProductImagesImport;
use Excel;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Traits\DefaultTrait;
use Illuminate\Support\Facades\Log;

class ProductImagesController extends Controller
{
    use DefaultTrait;
    function __construct()
    {
        $this->middleware(['permission:productImage-list'], ['only' => ['index']]);
        $this->middleware(['permission:productImage-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:productImage-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:productImage-delete'], ['only' => ['destroy']]);
        $this->middleware(['permission:productImage-excel-upload'], ['only' => ['import_productImages']]);
    }

    public function index(){
        try{
            $productImages = ProductImage::get();
            return view('admin.product_images.index', compact('productImages'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function create(){
        try{
            $title = "Add New Product Images";
            return view('admin.product_images.create', compact('title'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function store(Request $request){
        $request->validate([
            'sku_code' => ['required','exists:products,sku_code'],
            'image' => ['required','string','max:255'],
        ]);
        $data = $request->only('sku_code','image','created_by');
        try{
            $product = Product::where('sku_code', $data['sku_code'])->first();
            if(empty($product)){
                return back()->with('error', 'data not found!!');
            }
            $data['created_by'] = auth()->user()->name;
            $data['product_id'] = $product->id;
            ProductImage::updateOrCreate(
                [
                    'sku_code' => $data['sku_code'],
                    'image' => $data['image'],
                ],
                $data,
            );
            return back()->with('success', 'Product Images created successfully.');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(ProductImage $productImage){
        try{
            $product = Product::whereId($productImage->product_id)->first();
            return view('admin.product_images.show', compact('productImage','product'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit(ProductImage $productImage){
        try{
            return view('admin.product_images.create', compact('productImage'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, ProductImage $productImage){
        $request->validate([
            'sku_code' => ['required','exists:products,sku_code'],
            'image' => ['required','string','max:255'],
        ]);
        $data = $request->only('sku_code','image','created_by');
        try{
            $product = Product::where('sku_code', $data['sku_code'])->first();
            if(empty($product)){
                return back()->with('error', 'data not found!!');
            }
            $data['product_id'] = $product->id;
            ProductImage::whereId($productImage->id)->update($data);
            return redirect(route('productImages.index'))->with('success', 'Product Images updated successfully.');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(ProductImage $productImage){
        if(!empty($productImage)){
            if($productImage->forceDelete()){
                return redirect(route('productImages.index'))->with('success', 'deleted successfully');
            }else{
                return back()->with('error', 'failled');
            }
        }
    }

    public function import_productImages(Request $request){
        try{
            if($request->isMethod('post')){
                $request->validate([
                    'import_file' => ['required','mimes:xlsx'],
                ]);

                if($request->hasFile('import_file')){
                    try{
                        $import = new ProductImagesImport;
                        $import->import($request->file('import_file'));
                    }catch(\Maatwebsite\Excel\Validators\ValidationException $e){
                        $failures = $e->failures();
                        return back()->with('failures', $failures);
                    }
                }

                //upload history for public path
                common_import_store($request, 'import_file', 'productImage');
                return back()->with('success', 'file uploaded successfully');
            }
            
            if($request->export=="export"){
                $enquiries = ProductImage::select('sku_code','image')->limit(1)->get();
                return export_fast_excel($enquiries, now().'_images.xlsx');
            }
            
            if($request->update=="update"){
                $enquiries = ProductImage::join('products','products.id','=', 'product_images.product_id')->select('products.article','product_images.sku_code','product_images.image')->get();
                return export_fast_excel($enquiries, now().'_images.xlsx');
            }
            
            $imports = ImportedFileLog::where(['model_name'=>'productImage'])->get();
            return view('admin.product_images.import',compact('imports'));
        }catch(\Throwable $e){
            Log::error('Product images import failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => optional(auth()->user())->id,
            ]);
            return back()->with('error', $e->getMessage());
        }
    }
}
