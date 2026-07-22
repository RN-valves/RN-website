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
use Illuminate\Support\Facades\File;

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
            $updateTemplatePath = storage_path('app/exports/product_images_update_template.xlsx');
            $updateTemplatePending = is_file($updateTemplatePath.'.pending');
            $updateTemplateReady = is_file($updateTemplatePath) && !$updateTemplatePending;

            return view('admin.product_images.index', compact('updateTemplateReady', 'updateTemplatePending'));
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
                $output = storage_path('app/exports/product_images_update_template.xlsx');
                $pending = $output.'.pending';
                File::ensureDirectoryExists(dirname($output), 0775, true);

                if ($request->download == '1') {
                    if (is_file($output) && !is_file($pending)) {
                        return response()->download($output, now().'_images.xlsx');
                    }

                    return back()->with('error', 'Update Template is not ready yet. Wait a bit and try Download Ready again.');
                }

                if (is_file($pending)) {
                    return back()->with('success', 'Update Template is still being prepared. Wait 2-3 minutes, refresh this page, then click Download Ready.');
                }

                if (is_file($output) && filemtime($output) > (time() - 900) && !$request->boolean('rebuild')) {
                    return response()->download($output, now().'_images.xlsx');
                }

                $this->spawnArtisanBackground('product-images:export-update-template', [$output]);

                return back()->with('success', 'Preparing Update Template in the background (~16k rows). Refresh in 2-3 minutes and click Download Ready.');
            }
            
            $imports = ImportedFileLog::where(['model_name'=>'productImage'])->get();
            $updateTemplatePath = storage_path('app/exports/product_images_update_template.xlsx');
            $updateTemplatePending = is_file($updateTemplatePath.'.pending');
            $updateTemplateReady = is_file($updateTemplatePath) && !$updateTemplatePending;
            return view('admin.product_images.import', compact('imports', 'updateTemplateReady', 'updateTemplatePending'));
        }catch(\Throwable $e){
            Log::error('Product images import failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => optional(auth()->user())->id,
            ]);
            return back()->with('error', $e->getMessage());
        }
    }

    protected function spawnArtisanBackground(string $command, array $arguments = []): void
    {
        $php = (defined('PHP_BINARY') && PHP_BINARY) ? PHP_BINARY : 'php';
        $artisan = base_path('artisan');
        $args = collect($arguments)->map(fn ($arg) => escapeshellarg($arg))->implode(' ');
        $log = storage_path('logs/artisan-bg.log');

        Log::info('Spawning background artisan', [
            'command' => $command,
            'arguments' => $arguments,
        ]);

        $disabled = array_map('trim', explode(',', (string) ini_get('disable_functions')));
        $canExec = function_exists('exec') && !in_array('exec', $disabled, true)
            && function_exists('popen') && !in_array('popen', $disabled, true);

        if ($canExec) {
            if (strncasecmp(PHP_OS, 'WIN', 3) === 0) {
                $cmd = "start /B \"\" {$php} \"{$artisan}\" {$command} {$args} >> \"{$log}\" 2>&1";
                pclose(popen($cmd, 'r'));
                return;
            }

            $cmd = sprintf(
                'nohup %s %s %s %s >> %s 2>&1 < /dev/null &',
                escapeshellarg($php),
                escapeshellarg($artisan),
                $command,
                $args,
                escapeshellarg($log)
            );
            exec($cmd);
            return;
        }

        throw new \RuntimeException('Unable to start background process for product image export.');
    }
}
