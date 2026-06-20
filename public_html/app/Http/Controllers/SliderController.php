<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Traits\DefaultTrait;
use File;

class SliderController extends Controller
{
    use DefaultTrait;
    function __construct()
    {
        $this->middleware(['permission:slider-list'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:slider-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:slider-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:slider-delete'], ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $sliders = Slider::all();
            return view('admin.sliders.index', compact('sliders'));
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
            $statuses = array('Active','InActive');
            return view('admin.sliders.create',compact('statuses'));
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
            'title' => ['required','max:80','string'],
            'image' => ['required','string','max:255'],
            'status' => ['required','in:Active,InActive'],
            'banner_url' => ['required','string','max:255'],
        ]);
        $data = $request->only('title','image','status','banner_url');
        try{
            $data['created_by'] = auth()->user()->name;
            Slider::create($data);
            return to_route('sliders.index')->with('success', 'Data added successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        try{
            $statuses = array('Active','InActive');
            return view('admin.sliders.create',compact('statuses','slider'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'title' => ['required','max:80','string'],
            'image' => ['required','string','max:255'],
            'status' => ['required','in:Active,InActive'],
            'banner_url' => ['nullable','string','max:255'],
        ]);
        $data = $request->only('title','image','status','banner_url');
        try{
            $data['created_by'] = auth()->user()->name;
            /*if($request->hasFile('image')){
                $imageFile = Slider::whereId($slider->id)->value('image');
                File::delete($imageFile);
                $data['image'] = $this->ImageResizer($request, 'image', 'uploads/banners/',1920,860)??null;
            }else{
                $data['image'] = Slider::whereId($slider->id)->value('image');
            }*/
            Slider::whereId($slider->id)->update($data);
            return to_route('sliders.index')->with('success', 'Data added successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        //
    }
}
