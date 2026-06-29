<?php

namespace App\Http\Controllers;

use App\Models\FrontPage;
use App\Models\Page;
use App\Models\AboutUs;
use App\Models\Certificate;
use App\Models\ExhibitionImage;
use Illuminate\Http\Request;
use App\Traits\DefaultTrait;

class FrontPageController extends Controller
{
    use DefaultTrait;
    function __construct()
    {
        $this->middleware(['permission:frontPage-edit'], ['only' => ['edit', 'update']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $frontPage = FrontPage::get();
            return view('admin.fronts.index', compact('frontPage'));
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
            return view('admin.fronts.create');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            return back()->with('error', 'Whoops!! Something went wrong');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FrontPage $frontPage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FrontPage $frontPage)
    {
        try{
            return view('admin.fronts.create', compact('frontPage'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FrontPage $frontPage)
    {
        $request->validate([
            'name' => ['required','string','max:55'],
            'title' => ['required','string','max:500'],
            'keywords' => ['required','string','max:500'],
            'description' => ['required','string','max:500'],
            'logo' => ['nullable','file','mimes:png,svg','max:2048'],
            'mobile' => ['required','string','max:15'],
            'whatsapp' => ['required','digits:10'],
            'email' => ['required','string','max:100','email'],
            'address' => ['nullable','string','max:255'],
            'fb_link' => ['nullable','string','max:255'],
            'insta_link' => ['nullable','string','max:255'],
            'twitter_link' => ['nullable','string','max:255'],
            'linkedin_link' => ['nullable','string','max:255'],
            'youtube_link' => ['nullable','string','max:255'],
            'pinterest_link' => ['nullable','string','max:255'],
            'goole_app_link' => ['nullable','string','max:255'],
            'ios_app_link' => ['nullable','string','max:255'],
        ]);
        try{
            $data= $request->only('name','title','keywords','description','logo','mobile','whatsapp','email','address','fb_link','insta_link','twitter_link','linkedin_link','youtube_link','pinterest_link','goole_app_link','ios_app_link');
            if($request->hasFile('logo')){
                $logoExtension = strtolower($request->file('logo')->getClientOriginalExtension());
                if ($logoExtension === 'svg') {
                    $data['logo'] = $this->verifyAndUpload($request, 'logo', 'uploads/logo/') ?? null;
                } else {
                    $data['logo'] = $this->ImageResizer($request, 'logo', 'uploads/logo/',1000,1000) ?? null;
                }
            }
            FrontPage::whereId(1)->update($data);
            return back()->with('success', 'data updated successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FrontPage $frontPage)
    {
        //
    }

    public function pages(Request $request)
    {
        return view('admin.fronts.pages.index');
    }
    public function page_edit(Request $request)
    {
        $url_key = $request->url_key;
        $data = Page::where('url_key',$url_key)->first();
        $certis = Certificate::get();
        $eximages = ExhibitionImage::get();
        return view('admin.fronts.pages.edit',compact('data','certis','eximages'));
    }
    public function page_update(Request $request)
    {
        if($request->hasFile('image')){    
            $filepath = new ExhibitionImage();
            $imgsfile = $this->ImageResizer($request, 'image', 'uploads/exhibition/',529,353)??null;
            if($request->form == 1){
                $filepath = ExhibitionImage::find($request->id);
                if(!$filepath){
                    return back()->with('error', 'Exhibition image record not found!');
                }
                if ($filepath->file && file_exists(public_path($filepath->file))) {
                    unlink(public_path($filepath->file));
                }
                $imgsfile = $this->ImageResizer($request, 'image', 'uploads/exhibition/',529,353)??null;
            }
            $filepath->name = $request->name;
            $filepath->file = $imgsfile;
            $filepath->save();
            return back()->with('success', 'Data updated successfully');
        }
        if($request->has('form_type') && $request->form_type == '0'){
            $filepath = ExhibitionImage::find($request->id);
            if(!$filepath){
                return back()->with('error', 'Exhibition image record not found!');
            }
            if ($filepath->file && file_exists(public_path($filepath->file))) {
                unlink(public_path($filepath->file));
            }
            $filepath->delete();
            return back()->with('success', 'Data deleted successfully');
        }
        $request->validate([
            'title' => ['required','string','max:100'],
            'description' => ['required'],
            'url_key' => ['required'],
        ]);
        try{
            $url_key = $request->url_key;
            $title = $request->title;
            $description = $request->description;
            $page = Page::where('url_key',$url_key)->first();
            if($page){
                $data = Page::find($page->id);
                $data->name = $title;
                $data->title = $title;
                $data->description = $description;
                $data->save();
                return back()->with('success', 'data updated successfully');
            }
            return back()->with('error', 'No page found!');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
       
    }

    public function about_us(Request $request)
    {
        if($request->method() == 'POST'){
            $validated = $request->validate([
                'fields' => 'required|array',
                'fields.*.year' => 'required|numeric|min:1900|max:' . date('Y'),
                'fields.*.title' => 'required|string|max:255',
                'fields.*.description' => 'required|string',
            ]);
            $data = AboutUs::find(1);
            $data->milestone = json_encode($validated['fields']);
            $data->name = $request->name;
            $data->youtube_link = $request->youtube;
            $data->desc1 = $request->desc1;
            $data->desc2 = $request->desc2;
            $data->desc3 = $request->desc3;
            $data->vision = $request->vision;
            $data->mission = $request->mission;
            $data->values = $request->values;
            if($request->hasFile('img1')){
                if ($data->img1 && file_exists(public_path($data->img1))) {
                    unlink(public_path($data->img1));
                }
                $img1 = $this->ImageResizer($request, 'img1', 'uploads/aboutus/',378,430)??null;
                
                $data->img1 = $img1;
            }
            if($request->hasFile('img2')){
                if ($data->img2 && file_exists(public_path($data->img2))) {
                    unlink(public_path($data->img2));
                }
                $img2 = $this->ImageResizer($request, 'img2', 'uploads/aboutus/',378,430)??null;
                $data->img2 = $img2;
            }
            if($request->hasFile('catalogue')){
                $catalog = $this->verifyAndUpload($request, 'catalogue', 'uploads/aboutus/')??null;
                $data->catalogue = $catalog;
            }
            $data->save();
            return back()->with('success', 'Data updated successfully');
        }
        $data = AboutUs::find(1);
        $milestones = json_decode($data->milestone,true);
        return view('admin.fronts.pages.about_us',compact('data','milestones'));
    }
}
