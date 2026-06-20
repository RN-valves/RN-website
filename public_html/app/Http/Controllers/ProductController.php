<?php

namespace App\Http\Controllers;

use App\Models\{
    Material,
    Color,
    Size,
    Product,
    Category,
    Subcategory,
    Content,
    Brand,
    ProductAttribute,
    Country,
    ImportedFileLog,
    ProductBullet
};
use Illuminate\Http\Request;
use App\Traits\DefaultTrait;
use File;
use App\Http\Requests\{
    ProductStoreRequest,
    ProductUpdateRequest
};
use App\Imports\ProductImport;
use App\Imports\ProductQuantityImport;
use App\Exports\ProductExport;
use Rap2hpoutre\FastExcel\SheetCollection;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    use DefaultTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware(['permission:product-list'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:product-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:product-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:product-delete'], ['only' => ['destroy']]);
        $this->middleware(['permission:create-new-product-color'], ['only' => ['addNewColor']]);
        $this->middleware(['permission:create-new-product-size'], ['only' => ['addNewSize']]);
        $this->middleware(['permission:change-product-status'], ['only' => ['statusProduct']]);
        $this->middleware(['permission:product-excel-upload'], ['only' => ['import_products']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $products = Product::orderByDesc('id')->get();
            return view('admin.products.index', compact('products'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            $subcategories = Subcategory::select('id','name','category_id')->get();
            $sizes = Size::select('id','name')->get();
            $colors = Color::select('id','name')->get();
            $materials = Material::select('id','name')->get();
            $contents = Content::select('id','title')->get();
            $brands = Brand::select('id','name')->get();
            $countries = Country::select('id','name')->get();
            return view('admin.products.create', compact('subcategories','sizes','colors','materials','contents','brands','countries'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        try{
            $data = $request->safe()->all();
            $color = Color::where(['name'=>$data['color_name']])->first();
            if(empty($color)){
                return back()->with('error', 'Whoops!! Selected colors is not valid');
            }
            $size = Size::where(['name'=>$data['size']])->first();
            if(empty($size)){
                return back()->with('error', 'Whoops!! Selected size is not valid');
            }
            $subcategory = Subcategory::where(['id'=>$data['subcategory_id']])->first();
            if(empty($subcategory)){
                return back()->with('error', 'Whoops!! Selected subcategory is not valid');
            }
            $color_group_id = str()->uuid()->toString();
            $packaging_group_id = str()->uuid()->toString();
            $product_combo_id = str()->uuid()->toString();
            $product_size_id = str()->uuid()->toString();
            $uuid = str()->uuid()->toString();
            $url_key = str($data['name'])->slug();
            $data['image'] = $this->ImageResizer($request, 'image', 'uploads/catalogue/products/',900,900)??null;
            
            $product = Product::updateOrCreate(
                [
                    'sku_code' => $data['sku_code'],
                ],
                [
                    'sku_code' => $data['sku_code'],
                    'in_mrp' => $data['in_mrp'],
                    'in_selling' => $data['in_selling'],
                    'in_v1_mrp' => $data['in_v1_mrp'],
                    'oth_mrp' => $data['oth_mrp'],
                    'oth_selling' => $data['oth_selling'],
                    'oth_v1_mrp' => $data['oth_v1_mrp'],
                    'color_group_id' => $color_group_id,
                    'packaging_group_id' => $packaging_group_id,
                    'product_combo_id' => $product_combo_id,
                    'product_size_id' => $product_size_id,
                    'uuid' => $uuid,
                    'url_key' => $url_key,
                    'category_id' => $subcategory->category_id,
                    'subcategory_id' => $data['subcategory_id'],
                    'brand' => $data['brand'],
                    'content_id' => $data['content_id'],
                    'material' => $data['material'],
                    'color_name' => $color->name,
                    'color_icon' => $color->icon,
                    'name' => $data['name'],
                    'article' => $data['article'],
                    'size' => $data['size'],
                    'hsn' => $data['hsn'],
                    'image' => $data['image'],
                    'title' => $data['title'],
                    'keywords' => $data['keywords'],
                    'description' => $data['description'],
                    'search_keywords' => $data['search_keywords'],
                    'is_visible_website' => $data['is_visible_website'],
                    'is_visible_api' => $data['is_visible_api'],
                    'new_arrival' => $data['new_arrival'],
                    'is_featured' => $data['is_featured'],
                    'is_full_turn' => $request->is_full_turn??0,
                    'full_turn_code' => $request->full_turn_code??null,
                    'sale_type' => $data['sale_type'],
                ],
            );
            $this->updateProductUrl($product->id);
            $product = Product::whereId($product->id)->first();
            ProductAttribute::updateOrCreate(
                [
                    'product_id' => $product->id,
                ],
                [
                    'product_id' => $product->id,
                    'sku_code' => $data['sku_code'],
                    'ctn_pcs' => $data['ctn_pcs'],
                    'mid_ctn_pcs' => $data['mid_ctn_pcs'],
                    'inner_pcs' => $data['inner_pcs'],
                    'stock_pcs' => $data['stock_pcs'],
                    'only_product_wt_gm' => $data['only_product_wt_gm'],
                    'product_length' => $data['product_length'],
                    'product_breadth' => $data['product_breadth'],
                    'product_height' => $data['product_height'],
                    'product_lbh_weight_gm' => $data['product_lbh_weight_gm'],
                    'mid_ctn_lbh_weight_kg' => $data['mid_ctn_lbh_weight_kg'],
                    'master_ctn_lbh_weight_kg' => $data['master_ctn_lbh_weight_kg'],
                    'residential_warranty' => $data['residential_warranty'],
                    'commercial_warranty' => $data['commercial_warranty'],
                    'amazon_link' => $data['amazon_link']??null,
                    'flipkart_link' => $data['flipkart_link']??null,
                    'short_description' => $data['short_description']??null,
                    'video_url' => $data['video_url']??null,
                    'created_by' => auth()->user()->name,
                ],
            );
            return redirect()->route('products.show', $product)
                ->with('success', 'Product created successfully.');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        try{
            $statuses = array('Active','InActive','Out-of-Stock','Discontinued');
            return view('admin.products.show', compact('product','statuses'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        try{
            $subcategories = Subcategory::select('id','name','category_id')->get();
            $sizes = Size::select('id','name')->get();
            $colors = Color::select('id','name')->get();
            $materials = Material::select('id','name')->get();
            $contents = Content::select('id','title')->get();
            $brands = Brand::select('id','name')->get();
            $countries = Country::select('id','name')->get();
            return view('admin.products.edit', compact('subcategories','sizes','colors','materials','contents','brands','countries','product'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        try{
            $data = $request->safe()->all();
            $color = Color::where(['name'=>$data['color_name']])->first();
            if(empty($color)){
                return back()->with('error', 'Whoops!! Selected colors is not valid');
            }
            $size = Size::where(['name'=>$data['size']])->first();
            if(empty($size)){
                return back()->with('error', 'Whoops!! Selected size is not valid');
            }
            $subcategory = Subcategory::where(['id'=>$data['subcategory_id']])->first();
            if(empty($subcategory)){
                return back()->with('error', 'Whoops!! Selected subcategory is not valid');
            }
            // if($request->hasFile('image')){
            //     $imageFile = Product::whereId($product->id)->value('image');
            //     File::delete($imageFile);
            //     $data['image'] = $this->ImageResizer($request, 'image', 'uploads/catalogue/products/',900,900)??null;
            // }else{
            //     $data['image'] = Product::whereId($product->id)->value('image');
            // }

            $data['image'] = $request->image;
            
            $product = Product::updateOrCreate(
                [
                    'sku_code' => $data['sku_code'],
                ],
                [
                    'sku_code' => $data['sku_code'],
                    'in_mrp' => $data['in_mrp'],
                    'in_selling' => $data['in_selling'],
                    'in_v1_mrp' => $data['in_v1_mrp'],
                    'oth_mrp' => $data['oth_mrp'],
                    'oth_selling' => $data['oth_selling'],
                    'oth_v1_mrp' => $data['oth_v1_mrp'],
                    'color_group_id' => $data['color_group_id'],
                    'product_combo_id' => $data['product_combo_id'],
                    'product_size_id' => $data['product_size_id'],
                    'category_id' => $subcategory->category_id,
                    'subcategory_id' => $data['subcategory_id'],
                    'brand' => $data['brand'],
                    'content_id' => $data['content_id'],
                    'material' => $data['material'],
                    'color_name' => $color->name,
                    'color_icon' => $color->icon,
                    'name' => $data['name'],
                    'article' => $data['article'],
                    'size' => $data['size'],
                    'hsn' => $data['hsn'],
                    'image' => $data['image'],
                    'title' => $data['title'],
                    'keywords' => $data['keywords'],
                    'description' => $data['description'],
                    'search_keywords' => $data['search_keywords'],
                    'is_visible_website' => $data['is_visible_website'],
                    'is_visible_api' => $data['is_visible_api'],
                    'new_arrival' => $data['new_arrival'],
                    'is_featured' => $data['is_featured'],
                    'is_full_turn' => $request->is_full_turn??0,
                    'full_turn_code' => $request->full_turn_code??null,
                    'sale_type' => $data['sale_type'],
                ],
            );
            $this->updateProductUrl($product->id);
        
            ProductAttribute::updateOrCreate(
                [
                    'product_id' => $product->id,
                ],
                [
                    'product_id' => $product->id,
                    'sku_code' => $data['sku_code'],
                    'ctn_pcs' => $data['ctn_pcs'],
                    'mid_ctn_pcs' => $data['mid_ctn_pcs'],
                    'inner_pcs' => $data['inner_pcs'],
                    'stock_pcs' => $data['stock_pcs'],
                    'only_product_wt_gm' => $data['only_product_wt_gm'],
                    'product_length' => $data['product_length'],
                    'product_breadth' => $data['product_breadth'],
                    'product_height' => $data['product_height'],
                    'product_lbh_weight_gm' => $data['product_lbh_weight_gm'],
                    'mid_ctn_lbh_weight_kg' => $data['mid_ctn_lbh_weight_kg'],
                    'master_ctn_lbh_weight_kg' => $data['master_ctn_lbh_weight_kg'],
                    'residential_warranty' => $data['residential_warranty'],
                    'commercial_warranty' => $data['commercial_warranty'],
                    'amazon_link' => $data['amazon_link']??null,
                    'flipkart_link' => $data['flipkart_link']??null,
                    'short_description' => $data['short_description']??null,
                    'video_url' => $data['video_url']??null,
                ],
            );
            //$this->productStockStatus($product->id);
            $product = Product::whereId($product->id)->first();
            return redirect()->route('products.show', $product)
                ->with('success', 'Product updated successfully.');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully');
    }

    public function addNewColor(Request $request, Product $product){
        if($request->isMethod("post")){
            //dd($request->all());
            $request->validate([
                'article' => ['required','string','max:15'],
                'sku_code' => ['required','string','max:15','unique:products,sku_code'],
                'color_name' => ['required','exists:colors,name'],
                'in_mrp' => ['required','numeric'],
                'in_selling' => ['required','numeric'],
                'in_v1_mrp' => ['required','numeric'],
                'oth_mrp' => ['required'],
                'oth_selling' => ['required'],
                'oth_v1_mrp' => ['required','numeric'],
                // 'image' => ['required','max:1024','mimes:jpg,jpeg,png,webp'],
                'stock_pcs' => ['required','numeric'],
            ]);
            $data = $request->only('article','sku_code','color_name','in_mrp','in_selling','in_v1_mrp','oth_mrp','oth_selling','oth_v1_mrp','image','stock_pcs');
            $product = Product::whereId($product->id)->first();
            if(empty($product)){
                return back()->with('error', 'Whoops! Selected product is not valid');
            }
            $checkColorGroup = Product::where(['color_group_id'=>$product->color_group_id, 'color_name'=>$data['color_name']])->first();
            if(!empty($checkColorGroup)){
                return back()->with('error', 'Whoops! Selected color already exists with this product Group');
            }
            $color = Color::where(['name'=>$data['color_name']])->first();
            if(empty($color)){
                return back()->with('error', 'Whoops!! Selected colors is not valid');
            }
            try{
                $uuid = str()->uuid()->toString();
                $product_combo_id = str()->uuid()->toString();
                $product_size_id = str()->uuid()->toString();
                $url_key = str($product['name'])->append(str()->random(25))->slug();
                $data['image'] = $this->ImageResizer($request, 'image', 'uploads/catalogue/products/',900,900)??null;
                $newColorProduct = Product::updateOrCreate(
                    [
                        'sku_code' => $data['sku_code'],
                    ],
                    [
                        'sku_code' => $data['sku_code'],
                        'article' => $data['article'],
                        'image' => $data['image'],
                        'in_mrp' => $data['in_mrp'],
                        'in_selling' => $data['in_selling'],
                        'in_v1_mrp' => $data['in_v1_mrp'],
                        'oth_mrp' => $data['oth_mrp'],
                        'oth_selling' => $data['oth_selling'],
                        'oth_v1_mrp' => $data['oth_v1_mrp'],
                        'color_name' => $color->name,
                        'color_icon' => $color->icon,
                        'color_group_id' => $product->color_group_id,
                        'product_combo_id' => $product_combo_id,
                        'product_size_id' => $product_size_id,
                        'uuid' => $uuid,
                        'url_key' => $url_key,
                        'category_id' => $product->category_id,
                        'subcategory_id' => $product['subcategory_id'],
                        'brand' => $product['brand'],
                        'content_id' => $product['content_id'],
                        'material' => $product['material'],
                        'name' => $product['name'],
                        'size' => $product['size'],
                        'hsn' => $product['hsn'],
                        'title' => $product['title'],
                        'keywords' => $product['keywords'],
                        'description' => $product['description'],
                        'search_keywords' => $product['search_keywords'],
                        'is_visible_website' => $product['is_visible_website'],
                        'is_visible_api' => $product['is_visible_api'],
                        'new_arrival' => $product['new_arrival'],
                        'is_featured' => $product['is_featured'],
                        'sale_type' => $product['sale_type'],
                    ],
                );
                $this->updateProductUrl($product->id);
                ProductAttribute::updateOrCreate(
                    [
                        'product_id' => $newColorProduct->id,
                    ],
                    [
                        'product_id' => $newColorProduct->id,
                        'sku_code' => $data['sku_code'],
                        'ctn_pcs' => $product['productAttribute']['ctn_pcs'],
                        'mid_ctn_pcs' => $product['productAttribute']['mid_ctn_pcs'],
                        'inner_pcs' => $product['productAttribute']['inner_pcs'],
                        'stock_pcs' => $data['stock_pcs']??0,
                        'only_product_wt_gm' => $product['productAttribute']['only_product_wt_gm'],
                        'product_length' => $product['productAttribute']['product_length'],
                        'product_breadth' => $product['productAttribute']['product_breadth'],
                        'product_height' => $product['productAttribute']['product_height'],
                        'product_lbh_weight_gm' => $product['productAttribute']['product_lbh_weight_gm'],
                        'mid_ctn_lbh_weight_kg' => $product['productAttribute']['mid_ctn_lbh_weight_kg'],
                        'master_ctn_lbh_weight_kg' => $product['productAttribute']['master_ctn_lbh_weight_kg'],
                        'residential_warranty' => $product['productAttribute']['residential_warranty'],
                        'commercial_warranty' => $product['productAttribute']['commercial_warranty'],
                        'short_description' => $product['productAttribute']['short_description']??null,
                    ],
                );
                //$this->productStockStatus($newColorProduct->id);
                return back()->with('success', 'data added successfully');
            }catch(\Exception $e){
                return back()->with('error', $e->getMessage());
            }
        }
        $colors = Color::select('id','name')->whereNot('name',$product->color_name)->get();
        return view('admin.products.colors.index', compact('colors','product'));
    }

    public function addNewSize(Request $request, Product $product){
        if($request->isMethod("post")){
            $request->validate([
                'size' => ['required','exists:sizes,name'],
                'sku_code' => ['required','string','max:15','unique:products,sku_code'],
                'in_mrp' => ['required','not_in:0','gte:in_selling'],
                'in_selling' => ['required','not_in:0','lte:in_mrp'],
                'in_v1_mrp' => ['required','numeric'],
                'oth_mrp' => ['required','not_in:0','gte:oth_selling'],
                'oth_selling' => ['required','not_in:0','lte:oth_mrp'],
                'oth_v1_mrp' => ['required','numeric'],
                'stock_pcs' => ['required','numeric'],
            ]);
            $data = $request->only('sku_code','in_mrp','in_selling','in_v1_mrp','oth_mrp','oth_selling','oth_v1_mrp','size','stock_pcs');
            $product = Product::whereId($product->id)->first();
            if(empty($product)){
                return back()->with('error', 'Whoops! Selected product is not valid');
            }
            $size = Size::where(['name'=>$data['size']])->first();
            if(empty($size)){
                return back()->with('error', 'Whoops!! Selected size is not valid');
            }
            /*$checkSizeGroup = Product::where(['product_size_id'=>$product['product_size_id'], 'size'=>$data['size']])->first();
            if(!empty($checkSizeGroup)){
                return back()->with('error', 'Whoops!! Selected size is not valid');
            }*/
            try{
                $uuid = str()->uuid()->toString();
                $product_combo_id = str()->uuid()->toString();
                $color_group_id = str()->uuid()->toString();
                $url_key = str($product['name'])->append(str()->random(25))->slug();
                $newColorProduct = Product::updateOrCreate(
                    [
                        'sku_code' => $data['sku_code'],
                    ],
                    [
                        'sku_code' => $data['sku_code'],
                        'size' => $data['size'],
                        'in_mrp' => $data['in_mrp'],
                        'in_selling' => $data['in_selling'],
                        'in_v1_mrp' => $data['in_v1_mrp'],
                        'oth_mrp' => $data['oth_mrp'],
                        'oth_selling' => $data['oth_selling'],
                        'oth_v1_mrp' => $data['oth_v1_mrp'],
                        'color_name' => $product->color_name,
                        'color_icon' => $product->color_icon,
                        'color_group_id' => $color_group_id,
                        'product_combo_id' => $product_combo_id,
                        'product_size_id' => $product->product_size_id,
                        'article' => $product['article'],
                        'image' => $product['image'],
                        'uuid' => $uuid,
                        'url_key' => $url_key,
                        'category_id' => $product->category_id,
                        'subcategory_id' => $product['subcategory_id'],
                        'brand' => $product['brand'],
                        'content_id' => $product['content_id'],
                        'material' => $product['material'],
                        'name' => $product['name'],
                        'hsn' => $product['hsn'],
                        'title' => $product['title'],
                        'keywords' => $product['keywords'],
                        'description' => $product['description'],
                        'search_keywords' => $product['search_keywords'],
                        'is_visible_website' => $product['is_visible_website'],
                        'is_visible_api' => $product['is_visible_api'],
                        'new_arrival' => $product['new_arrival'],
                        'is_featured' => $product['is_featured'],
                        'sale_type' => $product['sale_type'],
                    ],
                );
                $this->updateProductUrl($product->id);
                ProductAttribute::updateOrCreate(
                    [
                        'product_id' => $newColorProduct->id,
                    ],
                    [
                        'product_id' => $newColorProduct->id,
                        'sku_code' => $data['sku_code'],
                        'ctn_pcs' => $product['productAttribute']['ctn_pcs'],
                        'mid_ctn_pcs' => $product['productAttribute']['mid_ctn_pcs'],
                        'inner_pcs' => $product['productAttribute']['inner_pcs'],
                        'stock_pcs' => $data['stock_pcs'],
                        'only_product_wt_gm' => $product['productAttribute']['only_product_wt_gm'],
                        'product_length' => $product['productAttribute']['product_length'],
                        'product_breadth' => $product['productAttribute']['product_breadth'],
                        'product_height' => $product['productAttribute']['product_height'],
                        'product_lbh_weight_gm' => $product['productAttribute']['product_lbh_weight_gm'],
                        'mid_ctn_lbh_weight_kg' => $product['productAttribute']['mid_ctn_lbh_weight_kg'],
                        'master_ctn_lbh_weight_kg' => $product['productAttribute']['master_ctn_lbh_weight_kg'],
                        'residential_warranty' => $product['productAttribute']['residential_warranty'],
                        'commercial_warranty' => $product['productAttribute']['commercial_warranty'],
                        'short_description' => $product['productAttribute']['short_description']??null,
                    ],
                );
                //$this->productStockStatus($newColorProduct->id);
                return back()->with('success', 'data added successfully');
            }catch(\Exception $e){
                return back()->with('error', $e->getMessage());
            }
        }
        $sizes = Size::select('id','name')->whereNot('name',$product->size)->get();
        return view('admin.products.sizes.index', compact('sizes','product'));
    }

    public function import_products(Request $request){
        // try{
            if($request->isMethod('post')){
                $request->validate([
                    'import_file' => ['required','mimes:xlsx'],
                ]);
                if($request->hasFile('import_file')){
                    // dd($request->all());
                    // try{
                        //dd('kl');
                        $import = new ProductImport;
                        $import->import($request->file('import_file'));
                    // }catch(\Maatwebsite\Excel\Validators\ValidationException $e){
                    //     $failures = $e->failures();
                    //     return back()->with('failures', $failures);
                    // }
                }
                //upload history for public path
                common_import_store($request, 'import_file', 'product');
                return back()->with('success', 'file uploaded successfully');
            }
            
            if($request->export=="export"){
                $brands = Brand::select('id','name')->get();
                $categories = Subcategory::join('categories','categories.id','=','subcategories.category_id')
                    ->select('subcategories.id as subcategory_id','categories.name as category', 'subcategories.name as subcategory')->get();
                $sizes = Size::select('id','name')->get();
                $colors = Color::select('id','name')->get();
                $products = Product::join('product_attributes','product_attributes.product_id','=','products.id')
                    ->join('subcategories','subcategories.id','=','products.subcategory_id')
                    ->select(['subcategories.name as subcategory','products.name','products.content_id','products.brand','products.material','products.color_name','products.name','products.color_group_id','products.packaging_group_id','products.product_combo_id','products.product_size_id','products.article','products.sku_code','products.size','products.hsn','products.image','products.in_mrp','products.in_selling','products.in_v1_mrp','products.oth_mrp','products.oth_selling','products.oth_v1_mrp','products.title','products.keywords','products.description','products.search_keywords','products.status','products.is_visible_website','products.new_arrival','products.is_visible_api','products.is_featured','products.is_full_turn','products.full_turn_code','products.sale_type','product_attributes.ctn_pcs','product_attributes.mid_ctn_pcs','product_attributes.inner_pcs','product_attributes.stock_pcs','product_attributes.only_product_wt_gm','product_attributes.product_length','product_attributes.product_breadth','product_attributes.product_height','product_attributes.product_lbh_weight_gm','product_attributes.mid_ctn_lbh_weight_kg','product_attributes.master_ctn_lbh_weight_kg','product_attributes.residential_warranty','product_attributes.commercial_warranty','product_attributes.amazon_link','product_attributes.flipkart_link','product_attributes.short_description','product_attributes.video_url'])
                    ->limit(1)->get();

                $sheets = new SheetCollection([
                    'products' => $products,
                    'categories' => $categories,
                    'brands' => $brands,
                    'sizes' => $sizes,
                    'colors' => $colors,
                ]);
                return export_fast_excel($sheets, now().'_products.xlsx');
            }
            
            if($request->update=="update"){
               $products = Product::join('product_attributes','product_attributes.product_id','=','products.id')
                    ->join('subcategories','subcategories.id','=','products.subcategory_id')
                    ->join('categories','categories.id','=','products.category_id')
                    ->select(['categories.name as category','subcategories.name as subcategory','products.name','products.content_id','products.brand','products.material','products.color_name','products.name','products.color_group_id','products.packaging_group_id','products.product_combo_id','products.product_size_id','products.article','products.sku_code','products.size','products.hsn','products.image','products.in_mrp','products.in_selling','products.in_v1_mrp','products.oth_mrp','products.oth_selling','products.oth_v1_mrp','products.title','products.keywords','products.description','products.search_keywords','products.status','products.is_visible_website','products.new_arrival','products.is_visible_api','products.is_featured','products.is_full_turn','products.full_turn_code','products.sale_type','product_attributes.ctn_pcs','product_attributes.mid_ctn_pcs','product_attributes.inner_pcs','product_attributes.stock_pcs','product_attributes.only_product_wt_gm','product_attributes.product_length','product_attributes.product_breadth','product_attributes.product_height','product_attributes.product_lbh_weight_gm','product_attributes.mid_ctn_lbh_weight_kg','product_attributes.master_ctn_lbh_weight_kg','product_attributes.residential_warranty','product_attributes.commercial_warranty','product_attributes.amazon_link','product_attributes.flipkart_link','product_attributes.short_description','product_attributes.video_url'])
                    ->get();
                return export_fast_excel($products, now().'_products.xlsx');
                //return (new ProductExport)->download(now().'_products.xlsx', \Maatwebsite\Excel\Excel::XLSX);
            }
            
            $imports = ImportedFileLog::where(['model_name'=>'product'])->get();
            return view('admin.products.import',compact('imports'));
        // }catch(\Exception $e){
        //     return back()->with('error', $e->getMessage());
        // }
    }
    public function import_products_qty(Request $request){
        try{
            if($request->export=="export"){
                $products = Product::join('product_attributes','product_attributes.product_id','=','products.id')
                ->select(['products.sku_code','product_attributes.stock_pcs'])
                ->limit(1)->get();
                return export_fast_excel($products, now().'_stock_qty.xlsx');
            }
            if($request->isMethod('post')){
                $request->validate([
                    'import_file' => ['required','mimes:xlsx'],
                ]);
                if($request->hasFile('import_file')){
                    // try{
                        $import = new ProductQuantityImport;
                        $import->import($request->file('import_file'));
                    // }catch(\Maatwebsite\Excel\Validators\ValidationException $e){
                    //     $failures = $e->failures();
                    //     return back()->with('failures', $failures);
                    // }
                }
                //upload history for public path
               // common_import_store($request, 'import_file', 'productStocksQty');
                return back()->with('success', 'file uploaded successfully');
            }
            
            $imports = ImportedFileLog::where(['model_name'=>'productStocksQty'])->get();
            return view('admin.products.stock_qty_import',compact('imports'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function statusProduct(Product $product, Request $request){
        if($request->isMethod("post")){
            try{
                $request->validate([
                    'status' => ['required',Rule::in(['Active','InActive','Out-of-Stock','Discontinued'])],
                ]);

                $data = $request->only('status');
                Product::whereId($product->id)->update(['status'=>$data['status']]);
                return back()->with('success', 'data updated successfully');
            }catch(\Exception $e){
                return back()->with('error', $e->getMessage());
            }
        }else{
            return back()->with('error', 'Whoops!! Something went wrong');
        }
    }

    public function product_bullet_product(Request $request, Product $product){
        if($request->isMethod("post")){
            $request->validate([
                'product_bullet_id' => ['required','exists:product_bullets,id'],
            ]);
            $data = $request->only('product_bullet_id');
            try{
                $product = Product::whereId($product->id)->first();
                //$product->bullets()->detach();
                $product->bullets()->attach($data['product_bullet_id']);
                return back()->with('success', 'data added successfully');
            }catch(\Exception $e){
                return back()->with('error', $e->getMessage());
            }
        }else{
            return back()->with('success', 'Whoops! Something went wrong');
        }
    }

    public function delete_product_bullet_id(Request $request){
        $product = Product::find($request->product_id);
        $productBullet = ProductBullet::find($request->bullet_id);
        if(!empty($product) || !empty($productBullet)){
            $product->bullets()->detach($productBullet->id);
            return back()->with('success','data deleted successfully');
        }
    }
}