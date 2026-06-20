<?php

namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{
    Pincode,
    User,
    UserType,
    Remark,
    RemarkLog
};
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Repositories\Interfaces\UserInterface;

class UserController extends Controller
{
    use ValidatesRequests;

    private $userRep;

    function __construct(UserInterface $userRep)
    {
        $this->middleware(['permission:user-list'], ['only' => ['index','show']]);
        $this->middleware(['permission:user-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:user-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:user-delete'], ['only' => ['destroy']]);
        $this->middleware(['permission:customer-index'], ['only' => ['customer_network']]);
        $this->middleware(['permission:user-log-remark-index'], ['only' => ['userRemarkLog']]);
        $this->userRep = $userRep;
    }

    public function index(Request $request)
    {
        $data = User::whereNotIn('id', [1])->latest()->get();
        return view('admin.users.index',compact('data'));
    }

    public function create()
    {
        try{
            if(auth()->user()->user_type=="Customer"){
                $user_types = UserType::where('name','Customer')->get();
            }else{
                $user_types = UserType::get();
            }
            $employees = User::select('id','name','mobile','email')->where(['user_type'=>'Employee'])->get();
            $roles = Role::whereNotIn('id',[1])->pluck('name','name')->all();
            return view('admin.users.create',compact('roles','user_types','employees'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'roles' => 'required',
            'mobile' => 'required|digits:10|unique:users,mobile',
            'zipcode' => 'required|exists:pincodes,code',
            'address' => 'required|max:255',
            'user_code' => 'nullable|max:25|min:3|unique:users,user_code',
            'reporting_ids' => 'required|exists:users,id',
        ]);
        
        try{
            $input = $request->all();

            $pincode = Pincode::where(['code'=>$input['zipcode']])->first();
            if(empty($pincode)){
                return back()->with('error', 'Pincode is not valid or not match our records!!');
            }

            $checkUser = User::where(['mobile'=>$input['mobile']])->first();
            if(!empty($checkUser)){
                return back()->with('error', 'User Mobile Number already Registered');
            }

            $input['user_type'] = "Employee";
            $input['created_by'] = auth()->user()->name;

            $user = $this->userRep->store($input);
            $user->assignRole($request->input('roles'));

            return redirect()->route('users.index')
                            ->with('success','User created successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }
    
    public function show(User $user)
    {
        try{
            $user = User::find($user->id);
            $remarks = Remark::where(['type'=>'User'])->get();
            $employees = User::select('id','name','mobile','email')->whereNotIn('id',[$user->id])->where(['user_type'=>'Employee'])->get();
            return view('admin.users.show',compact('user','remarks','employees'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }
    
    public function edit(User $user)
    {
        if(auth()->user()->user_type=="Customer"){
            $user_types = UserType::where('name','Customer')->get();
        }else{
            $user_types = UserType::get();
        }

        $employees = User::select('id','name','mobile','email')->whereNotIn('id',[$user->id])->where(['user_type'=>'Employee'])->get();
        $user = User::find($user->id);
        $roles = Role::whereNotIn('id',[1])->pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        
        return view('admin.users.edit',compact('user','roles','userRole','user_types','employees'));
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'roles' => 'required',
            'mobile' => 'required|digits:10|unique:users,mobile,'.$user->id,
            'zipcode' => 'required|exists:pincodes,code',
            'address' => 'required|max:255',
            'user_code' => 'required|max:25|min:3|unique:users,user_code,'.$user->id,
        ]);
    
        try{
            $input = $request->all();

            $pincode = Pincode::where(['code'=>$input['zipcode']])->first();
            if(empty($pincode)){
                return back()->with('error', 'Pincode is not valid or not match our records!!');
            }

            $input['user_type'] = "Employee";
            $user = $this->userRep->update($user->id, $input);
            $user->assignRole($request->input('roles'));
        
            return redirect()->route('users.index')
                            ->with('success','User updated successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }
    
    public function destroy($id)
    {
        try{
            User::find($id)->delete();
            return redirect()->route('users.index')->with('success','User deleted successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function customer_network(Request $request){
        try{
            return view('admin.users.customers');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function userRemarkLog(Request $request){
        try{
            $user = User::where(['uuid'=>$request->user])->first();
            if(empty($user)){
                return back()->with('error', 'Whoops!, Something went wrong');
            }
            $userRemarkLogs = $user->logables()->orderByDesc('id')->paginate(25)->withQueryString();
            return view('admin.users.log_report', compact('userRemarkLogs','user'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }
}