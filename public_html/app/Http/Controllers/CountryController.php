<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;

class CountryController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:country-list'], ['only' => ['index']]);
        $this->middleware(['permission:country-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:country-edit'], ['only' => ['edit', 'update']]);
    }

    public function index(){
        try{
            $countries = Country::all();
            return view('admin.countries.index', compact('countries'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function create(){
        try{
            $title = "Add New Country";
            return view('admin.countries.create', compact('title'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function store(Request $request){
        $request->validate([
            'name' => ['required','max:55','unique:countries,name'],
            'code' => ['required','max:10'],
        ]);
        $data = $request->only('name','code');
        try{
            Country::create($data);
            return back()->with('success', 'Country created successfully.');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(){

    }

    public function edit(Country $country){
        try{
            $title = "Edit New Country ". $country->name;
            return view('admin.countries.edit', compact('title','country'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, Country $country){
        $request->validate([
            'name' => ['required','max:55','unique:countries,name,'.$country->id],
            'code' => ['required','max:10'],
        ]);
        $data = $request->only('name','code');
        try{
            Country::whereId($country->id)->update($data);
            return redirect()->route('countries.index')->with('success', 'Country updated successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }
}
