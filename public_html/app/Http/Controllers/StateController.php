<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Country,
    State,
    City
};

class StateController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:state-list'], ['only' => ['index']]);
        $this->middleware(['permission:state-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:state-edit'], ['only' => ['edit', 'update']]);
    }

    public function index(){
        try{
            $states = State::get();
            return view('admin.states.index', compact('states'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function create(){
        try{
            $title = "Add New State";
            $countries = Country::select('id','name')->get();
            return view('admin.states.create', compact('title','countries'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function store(Request $request){
        $request->validate([
            'country_id' => ['required','exists:countries,id'],
            'name' => ['required','max:55','unique:states,name'],
            'code' => ['required','max:10','unique:states,code'],
        ]);
        $data = $request->only('name','code','country_id');
        try{
            State::updateOrCreate(
                [
                    'country_id' => $data['country_id'],
                    'name' => $data['name'],
                ],
                $data,
            );
            return back()->with('success', 'State created successfully.');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(){

    }

    public function edit(State $state){
        try{
            $countries = Country::select('id','name')->get();
            $title = "Edit New State ". $state->name;
            return view('admin.states.edit', compact('title','countries','state'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, State $state){
        $request->validate([
            'country_id' => ['required','exists:countries,id'],
            'name' => ['required','max:55','unique:states,name,'.$state->id],
            'code' => ['required','max:10','unique:states,code,'.$state->id],
        ]);
        $data = $request->only('name','code','country_id');
        try{
            State::whereId($state->id)->update($data);
            return redirect()->route('states.index')->with('success', 'State updated successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function getCountryStates(Request $request){
        if($request->ajax()){
            $data = $request->only('countryId');
            $data['state'] = State::where(['country_id'=>$request->countryId])->get(['id','name','code']);
            return response()->json($data);
        }
    }

    public function get_json_state_city(Request $request){
        if($request->ajax()){
            $data = $request->only('stateId');
            $data['cities'] = City::where(['state_id'=>$request->stateId])->get(['id','name','code']);
            return response()->json($data);
        }
    }
}
