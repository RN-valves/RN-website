<?php

namespace App\Http\Controllers;

use App\Models\{
    Product,
    ImportedFileLog,
    ProductBullet
};
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\SheetCollection;
use Illuminate\Validation\Rule;
use App\Imports\ProductBulletImport;
use App\Exports\ProductBulletExport;
use Excel;

class ProductBulletsController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:product-bullet-point-list'], ['only' => ['index']]);
        $this->middleware(['permission:product-bullet-point-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:product-bullet-point-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:product-bullet-point-delete'], ['only' => ['destroy']]);
        $this->middleware(['permission:product-bullet-point-excel'], ['only' => ['import_pro_bullet']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.product_bullets.index');
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
            'name' => ['required','max:255'],
        ]);

        try{
            $data = $request->only('name');
            ProductBullet::updateOrCreate(
                [
                    'name' => $data['name'],
                ],
                [
                    'name' => $data['name'],
                ]
            );
            return back()->with('success', 'data added successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductBullet $productBullet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductBullet $productBullet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductBullet $productBullet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */

    public function delete(ProductBullet $productBullet)
    {
        if($productBullet->forceDelete()){
            return back()->with('success', 'data deleted successfully');
        }else{
            return back()->with('error', 'failled....');
        }
    }


    public function destroy(ProductBullet $productBullet)
    {
        if($productBullet->forceDelete()){
            return back()->with('success', 'data deleted successfully');
        }else{
            return back()->with('error', 'failled....');
        }
    }

    public function import_pro_bullet(Request $request){
        try{
            if($request->isMethod('post')){
                $request->validate([
                    'import_file' => ['required','mimes:xlsx'],
                ]);
                if($request->hasFile('import_file')){
                    try{
                        $import = new ProductBulletImport;
                        $import->import($request->file('import_file'));
                    }catch(\Maatwebsite\Excel\Validators\ValidationException $e){
                        $failures = $e->failures();
                        return back()->with('failures', $failures);
                    }
                }
                //upload history for public path
                common_import_store($request, 'import_file', 'product_bullet');
                return back()->with('success', 'file uploaded successfully');
            }
            
            if($request->export=="export"){
                $product_bullets = ProductBullet::select('id','name')->get();

                $sheets = new SheetCollection([
                    'product_bullets' => $product_bullets,
                ]);
                return export_fast_excel($sheets, now().'_products_bullets.xlsx');
            }
            
            if($request->update=="update"){
                return Excel::download(new ProductBulletExport, 'download_points.xlsx');
               /*$products_bullets = \DB::table('product_bullet_product')
                    ->join('products', 'products.id','=','product_bullet_product.product_id')
                    ->join('product_bullets', 'product_bullets.id','=','product_bullet_product.product_bullet_id')
                    ->select(['product_bullet_product.product_bullet_id', 'products.sku_code','products.name as product_name', 'product_bullets.name as bullet_name'])
                    ->get();
                return export_fast_excel($products_bullets, now().'_products_bullets.xlsx');*/
            }
            
            $imports = ImportedFileLog::where(['model_name'=>'product_bullet'])->get();
            return view('admin.product_bullets.import',compact('imports'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }
}
