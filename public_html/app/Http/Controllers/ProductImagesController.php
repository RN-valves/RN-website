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
use Illuminate\Support\Facades\DB;

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

            // Do not add the main product image again into the gallery.
            if (rtrim(strtolower(trim((string) $data['image'])), '/')
                === rtrim(strtolower(trim((string) ($product->image ?? ''))), '/')) {
                return back()->with('error', 'This image is already the main product image. Add a different gallery image.');
            }

            $exists = ProductImage::where('sku_code', $data['sku_code'])
                ->get()
                ->contains(function ($row) use ($data) {
                    return rtrim(strtolower(trim((string) $row->image)), '/')
                        === rtrim(strtolower(trim((string) $data['image'])), '/');
                });
            if ($exists) {
                return back()->with('success', 'Product image already exists — skipped duplicate.');
            }

            ProductImage::create($data);
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
                // Template export — 1 sample row only
                $enquiries = ProductImage::select('sku_code','image')->limit(1)->get();
                return export_fast_excel($enquiries, now().'_images.xlsx');
            }
            
            if($request->update=="update"){
                // Stream 16k+ rows using a generator/cursor — never loads all rows into memory
                @ini_set('memory_limit', '1024M');
                @set_time_limit(600);

                $generator = function () {
                    DB::table('product_images')
                        ->join('products', 'products.id', '=', 'product_images.product_id')
                        ->select('products.article', 'product_images.sku_code', 'product_images.image')
                        ->orderBy('product_images.id')
                        ->chunk(500, function ($rows) use (&$generator) {
                            foreach ($rows as $row) {
                                yield [
                                    'article'  => $row->article,
                                    'sku_code' => $row->sku_code,
                                    'image'    => $row->image,
                                ];
                            }
                        });
                };

                // FastExcel accepts a Generator — streams to xlsx without holding all rows in RAM
                return (new FastExcel($generator()))->download(now().'_images.xlsx');
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
