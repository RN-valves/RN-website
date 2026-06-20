<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    State,
    Category,
    Subcategory,
    Product,
    Pincode,
    Career,
    RemarkLog,
    Enquiry,
    User,
    Blog,
    Page,
    AboutUs,
    Certificate,
    Discount,
    News
};
use App\Rules\GoogleReCaptcha;
use Illuminate\Validation\Rule;
use DB;
use App\Repositories\Interfaces\EnquiryInterface;
use Auth;
use Validator;
use Mail;
use Cart;
use App\Mail\ContactEmail;
use Stevebauman\Location\Facades\Location;

class WebsiteController extends Controller
{
    function __construct(EnquiryInterface $enquiryRep)
    {
        $this->enquiryRep = $enquiryRep;
    }
    /**
     * Display a listing of the resource.
     */
    public function aboutUs()
    {
        try{
            $data = AboutUs::find(1);
            $milestones = json_decode($data->milestone,true);   
            $milestones = $milestones ?? [];

            usort($milestones, function($a, $b) {
                return $b['year'] <=> $a['year'];
            });  
            return view('users.websites.about_us',compact('data','milestones'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function contactUs(Request $request)
    {
        if($request->isMethod("post")){
      
            $request->validate([
                // 'g-recaptcha-response' => ['required', new GoogleReCaptcha],
                'name' => ['required','string','max:55'],
                'email' => ['nullable','string','max:100','email'],
                'company_name' => ['required','string','max:55'],
                'mobile' => ['required','digits:10'],
                'zipcode' => ['required','exists:pincodes,code'],
                'enquiry_type' => ['required',Rule::in(['Distributor','Retailer','Dealer', 'Architect', 'Interier Designer', 'Consultant', 'Contractor', 'Plumber', 'Consumer', 'Other'])],
                'address' => ['nullable','string','max:255'],
                'purpose' => ['required','string','max:255'],
            ]);
            $data = $request->only('name','email','company_name','mobile','zipcode','enquiry_type','address','purpose');

            $data['published_at'] = now();
            $data['page_url'] = url()->full();
            $data['scource_type'] = "Website";
            $data['ip_address'] = $request->ip();

            $enquiry = $this->enquiryRep->store($data);

            if(Auth::check()){
                $log['user_name'] = auth()->user()->name;
                $log['user_id'] = auth()->user()->id;
            }else{
                $log['user_name'] = $data['name'].','.$data['mobile'];
                $log['user_id'] = 0;
            }

            try{
                $log['customer_mobile'] = $enquiry->mobile;
                $log['customer_name'] = $enquiry->name;
                $log['remark'] = "Pending";
                $log['message'] = $data['purpose'];
                $enquiry->logables()->create($log);
                Mail::to(frontPage()->email)->send(new ContactEmail($enquiry));
                return back()->with('success', 'Thank you for contacting us, our sales expert will contact you soon!!');
            }catch(\Exception $e){
                return back()->with('error', $e->getMessage());
            }
        }
        try{
            $types = Enquiry::enquiryTypes();
            $states = State::where(['country_id'=>1])->get();
            return view('users.websites.contact_us',compact('states','types'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /*public function categoryList(Category $category){
        try{
            return view('users.websites.subcategories', compact('category'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }*/

    public function getProductSearch(Request $request){
        if(!empty(request('q')) || !empty(request('product_name'))){
            $productsList = Product::getProducts();
            $page = 0;
            if(!empty($productsList->nextPageUrl())){
                $parse_url = parse_url($productsList->nextPageUrl());
                if(!empty($parse_url['query'])){
                    parse_str($parse_url['query'], $get_array);
                    $page = !empty($get_array['page']) ? $get_array['page'] : 0;
                }
            }
            return view('users.websites.product_listing', compact('productsList','page'));
        }else{
            return back();
        }
    }

    // public function productList($url_key){
    //     $url = request('url_key');
    //     if($url_key == 'ptmt-faucets'){
    //        return redirect()->route('productList','ptmt-taps-or-faucets');
    //     }
    //     // if($url_key == 'ptmt-taps-or-faucets'){
    //     //    $url = 'ptmt-faucets';
    //     // }
    //     if($url_key == 'asiabet'){
    //         return redirect('/');
    //     }
    //     $getSingleCategory = Category::getSingleCategory($url);
    //     $getSingleSubCategory = Subcategory::getSingleSubCategory($url);
    //     $getSingleProduct = Product::getSingleProduct($url);
    //     if(!empty($getSingleCategory))
    //     {
    //         $category = $getSingleCategory;
    //         return view('users.websites.subcategories', compact('category'));
    //     }
    //     elseif(!empty($getSingleProduct))
    //     {
    //         $discounts = Discount::getActiveDiscountList();
    //         $colorGroups = Product::colorGroups($getSingleProduct->color_group_id,$getSingleProduct->id);
    //         $packagingGroups = Product::packagingGroups($getSingleProduct->packaging_group_id,$getSingleProduct->id);
    //         $sizeGroups = Product::sizeGroups($getSingleProduct->product_size_id,$getSingleProduct->id);
    //         $similarProducts = Product::getSimilarProducts($getSingleProduct->id, $getSingleProduct->subcategory_id);
    //         return view('users.websites.product_detail', compact('getSingleProduct','similarProducts','colorGroups','sizeGroups','discounts','getSingleCategory','packagingGroups'));
    //     }
    //     elseif(!empty($getSingleSubCategory))
    //     {
    //         $productsList = Product::getProducts($getSingleSubCategory->id);
    //         $categoryColors = Product::getSubcategoryColors($getSingleSubCategory->id);
    //         $categorySizes = Product::getSubcategorySizes($getSingleSubCategory->id);
    //         $similarCategories = Product::getSimilarSubcategories($getSingleSubCategory->category_id, $getSingleSubCategory->id);
    //         $page = 0;
    //         if(!empty($productsList->nextPageUrl())){
    //             $parse_url = parse_url($productsList->nextPageUrl());
    //             if(!empty($parse_url['query'])){
    //                 parse_str($parse_url['query'], $get_array);
    //                 $page = !empty($get_array['page']) ? $get_array['page'] : 0;
    //             }
    //         }
    //         return view('users.websites.product_listing', compact('getSingleSubCategory','categoryColors','similarCategories','productsList','categorySizes','page'));
    //     }
    //     else
    //     {
    //         abort(404);
      
    //     }
    // }

    public function productList($url_key) {
        $url = request('url_key');
    
        // Handle specific redirects
        if ($url_key == 'ptmt-faucets') {
            return redirect()->route('productList', 'ptmt-taps-or-faucets');
        }
        if ($url_key == 'asiabet') {
            return redirect('/');
        }
    
        // Fetch category, subcategory, and product data
        $getSingleCategory = Category::getSingleCategory($url);
        $getSingleSubCategory = Subcategory::getSingleSubCategory($url);
        $getSingleProduct = Product::getSingleProduct($url);
    
        // Check for category view
        if (!empty($getSingleCategory)) {
            $category = $getSingleCategory;
            return view('users.websites.subcategories', compact('category'));
        }
    
        // Check for product details
        if (!empty($getSingleProduct)) {
            $discounts = Discount::getActiveDiscountList();
            $colorGroups = Product::colorGroups($getSingleProduct->color_group_id, $getSingleProduct->id);
            $packagingGroups = Product::packagingGroups($getSingleProduct->packaging_group_id, $getSingleProduct->id);
            $sizeGroups = Product::sizeGroups($getSingleProduct->product_size_id, $getSingleProduct->id);
            $similarProducts = Product::getSimilarProducts($getSingleProduct->id, $getSingleProduct->subcategory_id);

            $totalPrice = 0;
            $nextDiscount = '';
            if(Cart::content()->count() > 0){
                $totalPrice = (float) str_replace(',', '', Cart::priceTotal());
                $currentDiscount = Discount::where('start_value', '<=', $totalPrice)
                    ->where('end_value', '>=', $totalPrice)
                    ->first();
                   
                $nextDiscount = $currentDiscount ? Discount::find($currentDiscount->id + 1) : null;
    
                $firstDiscount = Discount::find(1);
                if($firstDiscount->start_value > $totalPrice){
                  $nextDiscount = $firstDiscount;
                }
            }
             
            $ip = request()->ip();
            $location = Location::get($ip);
            
            if ($location) {
                $stateName = $location->regionName;
            } else {
                $stateName = "";
            }
            return view('users.websites.product_detail', compact(
                'getSingleProduct',
                'similarProducts',
                'colorGroups',
                'sizeGroups',
                'discounts',
                'getSingleCategory',
                'packagingGroups',
                'totalPrice',
                'nextDiscount',
                'stateName'
            ));
        }
    
        // Check for subcategory view with paginated products
        if (!empty($getSingleSubCategory)) {
            $productsList = Product::getProducts($getSingleSubCategory->id);
            $categoryColors = Product::getSubcategoryColors($getSingleSubCategory->id);
            $categorySizes = Product::getSubcategorySizes($getSingleSubCategory->id);
            $similarCategories = Product::getSimilarSubcategories($getSingleSubCategory->category_id, $getSingleSubCategory->id);
            $productBullets= Product::where('status','Active')->where('is_visible_website',1)->where('subcategory_id', $getSingleSubCategory->id)
            ->groupBy('name')
            ->pluck('name');
            $page = $productsList->currentPage() < $productsList->lastPage() 
                ? $productsList->currentPage() + 1 
                : 0;
           
            return view('users.websites.product_listing', compact(
                'getSingleSubCategory',
                'categoryColors',
                'similarCategories',
                'productsList',
                'categorySizes',
                'productBullets',
                'page'
            ));
        }
    
        // If no match found, return 404
        abort(404);
    }
    

    // public function filterProductList(Request $request){
    //     $productsList = Product::getProducts();
    //     $page = 0;
    //     if(!empty($productsList->nextPageUrl())){
    //         $parse_url = parse_url($productsList->nextPageUrl());
    //         if(!empty($parse_url['query'])){
    //             parse_str($parse_url['query'], $get_array);
    //             $page = !empty($get_array['page']) ? $get_array['page'] : 0;
    //         }
    //     }
    //     return response()->json([
    //         'status' => true,
    //         'page' => $page,
    //         'success' => view('users.websites.listings.product_listing', [
    //             'productsList' => $productsList,
    //         ])->render(),
    //     ], 200);
    // }

    public function filterProductList(Request $request)
    {
        // Get the paginated products from the existing getProducts() method
        $productsList = Product::getProducts(); // Already paginated
    
        $isCodeSearch = !empty($request->q) && preg_match('/^[A-Za-z0-9-]+$/', $request->q);
    
        return response()->json([
            'status' => true,
            // Calculate the next page correctly or return 0 if no more pages
            'page' => $productsList->hasMorePages() ? $productsList->currentPage() + 1 : 0,
            'productCount' => $productsList->count(),
            'success' => $productsList->isNotEmpty() ? view('users.websites.listings.product_listing', [
                'productsList' => $productsList,
            ])->render() : '',
        ], 200);
    }
    
    
    
    

    public function check_pincode(Request $request){
        $checkPincode = Pincode::checkPincode($request->pincode);
        if(!empty($checkPincode)){
            $json['status'] = true;
            $json['pincode'] = $checkPincode->code;
            $json['message'] = $checkPincode->code." Pincode is Deliverable";
            $json['expected_date'] = now()->addDays(5);
        }else{
            $json['status'] = false;
            $json['pincode'] = "";
            $json['message'] = "Pincode is not Deliverable";
            $json['expected_date'] = "";
        }
        echo json_encode($json);
    }

    public function career_detail(Request $request, $career){
        try{
            $getSingleCareer = Career::getSingleCareer($career);

            if(!empty($getSingleCareer)){
                return view('users.websites.career_detail', compact('getSingleCareer'));
            }else{
                abort(404);
            }

        }catch(\Exception $e){
            abort(404);
        }
    }


    public function store_popup_form_enquiry(Request $request){
        $validator = Validator::make( $request->all(), [
            // 'g-recaptcha-response' => ['nullable', new GoogleReCaptcha],
            'name' => ['required','string','max:55'],
            'email' => ['nullable','string','max:100','email'],
            'mobile' => ['required','digits:10'],
            'zipcode' => ['required','exists:pincodes,code'],
            'enquiry_type' => ['required',Rule::in(['Distributor','Retailer','Dealer', 'Architect', 'Interier Designer', 'Consultant', 'Contractor', 'Plumber', 'Consumer', 'Other'])],
            'address' => ['nullable','string','max:255'],
            'purpose' => ['required','string','max:255'],
            'page_url' => ['required','string','max:255'],
        ] );

        if ( $validator->fails() ) {
            return response()->json( [ 'errors' => $validator->errors() ] );
        }

        $data = $request->only('name','email','mobile','zipcode','enquiry_type','address','purpose','page_url');

        $data['company_name'] = $data['name'];
        $data['published_at'] = now();
        $data['page_url'] = $data['page_url'];
        $data['scource_type'] = "Website";
        $data['ip_address'] = $request->ip();

        $enquiry = $this->enquiryRep->store($data);

        if(Auth::check()){
            $log['user_name'] = auth()->user()->name;
            $log['user_id'] = auth()->user()->id;
        }else{
            $log['user_name'] = $data['name'].','.$data['mobile'];
            $log['user_id'] = 0;
        }
        
        $log['customer_mobile'] = $enquiry->mobile;
        $log['customer_name'] = $enquiry->name;
        $log['remark'] = "Pending";
        $log['message'] = $data['purpose'];
        $enquiry->logables()->create($log);
        Mail::to(frontPage()->email)->send(new ContactEmail($enquiry));
        return response()->json( [ 'success' => 'Customer registered successfully!' ] );
    }

    public function blogs($url_key=''){

        if(!empty(request('url_key'))){
            $categories = Category::where(['status' => 'Active', 'is_visible_website' => 1])->get();
            $getSingleCategory = Category::getSingleCategory(request('url_key'));
            $getSingleBlogUrl = Blog::getSingleBlogUrl(request('url_key'));

            if(!empty($getSingleCategory)){
                $getBlogList = Blog::getBlogList($getSingleCategory->id);
                return view('users.websites.blogs', compact('getBlogList','categories'));
            }elseif(request('url_key')=="blogs"){
                $getBlogList = Blog::getBlogList();
                return view('users.websites.blogs', compact('getBlogList','categories'));
            }elseif(!empty($getSingleBlogUrl)){
                $getBlogList = Blog::getBlogList($getSingleBlogUrl->category_id);
                return view('users.websites.blog_details', compact('getSingleBlogUrl','categories','getBlogList'));
            }else{
                abort(404);
            }

        }else{
            abort(404);
        }
    }

    public function news($url_key=''){

        if(!empty(request('url_key'))){
            $getSingleBlogUrl = News::getSingleNewsUrl(request('url_key'));
            $getNewsList = News::getNewsList();

            if(request('url_key')=="news"){
                return view('users.websites.news', compact('getNewsList'));
            }elseif(!empty($getSingleBlogUrl)){
                return view('users.websites.news_details', compact('getSingleBlogUrl','getNewsList'));
            }else{
                abort(404);
            }

        }else{
            abort(404);
        }
    }

    public function policies($url_key){
        if(!empty($url_key)){
            $data = Page::where('url_key',$url_key)->first();
            if($url_key=="return"){
                return view('users.websites.return_policy',compact('data')); 
            }elseif($url_key=="privacy"){
                return view('users.websites.privacy_policy',compact('data'));
            }elseif($url_key=="certificates"){
                $certs = Certificate::get();
                return view('users.websites.certifications',compact('data','certs'));
            }elseif($url_key=="terms-conditions"){     
                return view('users.websites.terms_condition',compact('data'));
            }else{
                abort(404);
            }
        }else{
            abort(404);
        }
    }

    public function sitemap(){
        try{
            $blogs = Blog::latest()->get();
            $categories = Category::where(['status'=>'Active', 'is_visible_website'=>1])->latest()->get();
            $subcategories = Subcategory::where(['status'=>'Active', 'is_visible_website'=>1])->latest()->get();
            $products = Product::where(['status'=>'Active', 'is_visible_website'=>1])->latest()->get();
            return response()->view('users.websites.sitemap', [
                'blogs' => $blogs,
                'products' => $products,
                'categories' => $categories,
                'subcategories' => $subcategories,
            ])->header('Content-Type', 'text/xml');
        }catch(\Exception $e){
            return redirect(route('welcome'))->with('error', 'Whoops!, Something went wrong');
        }
    }
    public function vCardShow()
    {
        $name = 'RN Valves & Faucets';
        $mobile1 = '+91 9315160881';
        $mobile2 = '+91 9319888435';
        $email = 'sales3@rnvalves.co.in';
        $address = 'B-68, Site-IV, Sahibabad Industrial Area;Ghaziabad;Uttar Pradesh;201010;India';
    
        $vcard = <<<EOT
           BEGIN:VCARD
           VERSION:3.0
           FN:$name
           ORG:$name
           TEL;TYPE=WORK,VOICE:$mobile1
           TEL;TYPE=WORK,VOICE:$mobile2
           EMAIL:$email
           ADR;TYPE=WORK:;;$address
           URL:https://www.rnvalves.com
           END:VCARD
           EOT;
    
           return response($vcard, 200, [
            'Content-Type' => 'text/vcard; charset=utf-8',
            'Content-Disposition' => 'attachment; filename=rnvalves.vcf',
        ]);
    }
}
