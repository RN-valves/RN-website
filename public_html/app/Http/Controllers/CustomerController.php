<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Pincode,
    User,
    UserType,
    Remark,
    RemarkLog,
    ImportedFileLog,
    Order,
    Category,
    Subcategory,
    Product,
    UserAddress,
    OrderItem,
    OrderLog
};
use App\Imports\CustomerImport;
use App\Exports\CustomerExport;
use Spatie\Permission\Models\Role;
use App\Repositories\Interfaces\UserInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\Rule;
use Cart;
use Auth;

class CustomerController extends Controller
{
    use ValidatesRequests;
    private $userRep;

    function __construct(UserInterface $userRep)
    {
        $this->middleware(['permission:customer-list'], ['only' => ['index','show']]);
        $this->middleware(['permission:customer-create'], ['only' => ['create', 'store','LoginAsCustomer']]);
        $this->middleware(['permission:customer-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:customer-delete'], ['only' => ['destroy']]);
        $this->middleware(['permission:customer-excel-upload'], ['only' => ['customer_import']]);
        $this->userRep = $userRep;
    }

    public function create()
    {
        try{
            $professions = User::professions();
            $employees = User::select('id','name','mobile','email')->where(['user_type'=>'Employee'])->get();
            return view('admin.customers.create',compact('employees','professions'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required','email','string','unique:users,email'],
            'mobile' => ['required','digits:10','unique:users,mobile'],
            'zipcode' => ['required','exists:pincodes,code'],
            'address' => ['required','max:255','string'],
            'user_code' => ['required','max:25','min:3','unique:users,user_code'],
            'reporting_ids' => ['required','exists:users,id'],
            'profession' => ['required',Rule::in(User::professions())],
            'gst_number' => ['required_if:profession,Distributor,Dealer,Architect,Contractor','unique:users,gst_number'],
            'sales_user_id' => ['required','exists:users,id'],
        ]);
        
        try{
            $input = $request->all();

            $pincode = Pincode::where(['code'=>$input['zipcode']])->first();
            if(empty($pincode)){
                return back()->with('error', 'Pincode is not valid or not match our records!!');
            }

            $checkUser = User::where(['mobile'=>$input['mobile']])->first();
            if(!empty($checkUser)){
                return back()->with('error', 'Customer Mobile Number already Registered');
            }

            $input['user_type'] = "Customer";
            $input['created_by'] = auth()->user()->name;
            $roles = Role::where('id',2)->first();

            $user = $this->userRep->store($input);
            $user->assignRole($roles);

            return redirect()->route('customers.show', ['customer'=>$user])
                            ->with('success','User created successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(User $customer){
        try{
            $user = User::find($customer->id);
            $remarks = Remark::where(['type'=>'User'])->get();
            $employees = User::select('id','name','mobile','email')->whereNotIn('id',[$user->id])->where(['user_type'=>'Employee'])->get();
            return view('admin.customers.show',compact('user','remarks','employees'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit(User $customer)
    {
        try{
            $user = $customer;
            $professions = User::professions();
            $employees = User::select('id','name','mobile','email')->where(['user_type'=>'Employee'])->get();
            $userTypes = UserType::get();
            return view('admin.customers.edit',compact('employees','user','userTypes','professions'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, User $customer)
    {
        $user = $customer;
        $request->validate([
            'name' => ['required'],
            'email' => ['required','email','string','unique:users,email,'.$user->id],
            'mobile' => ['required','digits:10','unique:users,mobile,'.$user->id],
            'zipcode' => ['required','exists:pincodes,code'],
            'address' => ['required','max:255','string'],
            'profession' => ['required',Rule::in(User::professions())],
            'gst_number' => ['nullable','required_if:profession,Distributor,Dealer,Architect,Contractor','unique:users,gst_number,'.$user->id],
            'user_type' => ['required','exists:user_types,name'],
            'sales_user_id' => ['required','exists:users,id'],
        ]);
    
        try{
            $input = $request->all();
            $input['user_type'] = $input['user_type'];
            $roles = Role::where('id',2)->first();

            $user = $this->userRep->update($user->id, $input);
            $user->assignRole($roles);
        
            return redirect()->route('customers.show', ['customer'=>$user])
                            ->with('success','User updated successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function import_customers(Request $request){
        try{
            if($request->isMethod('post')){
                $request->validate([
                    'import_file' => ['required','mimes:xlsx'],
                ]);

                if($request->hasFile('import_file')){
                    try{
                        $import = new CustomerImport;
                        $import->import($request->file('import_file'));
                    }catch(\Maatwebsite\Excel\Validators\ValidationException $e){
                        $failures = $e->failures();
                        return back()->with('failures', $failures);
                    }
                }

                //upload history for public path
                common_import_store($request, 'import_file', 'user');
                return back()->with('success', 'file uploaded successfully');
            }
            
            if($request->export=="export"){
                $customers = User::select('id','name','email','mobile','zipcode','address','user_code','created_at')->limit(1)->get();
                return export_fast_excel($customers, now().'_customers.xlsx');
            }
            if($request->update=="update"){
                return (new CustomerExport)->download(now().'_customers.xlsx', \Maatwebsite\Excel\Excel::XLSX);
            }
            
            $imports = ImportedFileLog::where(['model_name'=>'user'])->get();
            return view('admin.customers.import',compact('imports'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function customer_order_list(User $user){
        try{
            $orders = Order::where(['user_id'=>$user->id])->get();
            return view('admin.customers.orders', compact('orders','user'));
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function orderAddToCart(Request $request){
        if($request->isMethod("post")){
            $request->validate([
                'product_id' => ['required','exists:products,id'],
                'quantity' => ['required','numeric'],
                'price' => ['required','numeric'],
            ]);
            try{
                $data = $request->only('product_id','quantity','price');
                $getSingleProId = Product::getSingleProId($data['product_id']);
                if(!empty($getSingleProId)){
                    $cart = Cart::add(
                        [
                            'id' => $getSingleProId->id, 
                            'name' => $getSingleProId->name, 
                            'qty' => $data['quantity'], 
                            'price' => $data['price'], 
                            'weight' => $getSingleProId['productAttribute']['product_lbh_weight_gm']??0, 
                            'options' => [
                                'size' => $getSingleProId->size,
                                'color' => $getSingleProId->color_name,
                                'product_code' => $getSingleProId->sku_code,
                            ]
                        ]
                    );
                    return response()->json([
                        'status' => true,
                        'success' => view('admin.customers.orders.cart_items')->render(),
                    ], 200);
                }else{
                    abort(404);
                }
            }catch(\Exception $e){
                return back()->with('error', $e->getMessage());
            }
        }
    }

    public function ordercartRemoveItem(Request $request){
        if($request->isMethod("post")){
            Cart::remove($request->cartid);

            return response()->json([
                'status' => true,
                'totalCartItems' => Cart::content()->count(),
                'success' => view('admin.customers.orders.cart_items', [
                    'CartItems' => Cart::content(),
                ])->render(),
            ], 200);
        }
    }

    public function customerCartUpdate(Request $request){
        if($request->isMethod("post")){
            $cart = Cart::update($request->cartid, [
                'qty' => $request['new_qty'], 
            ]);

            return response()->json([
                'status' => true,
                'success' => view('admin.customers.orders.cart_items', [
                    'CartItems' => \Cart::content(),
                ])->render(),
            ], 200);
        }
    }

    public function orderCreate(Request $request, User $user){
        if($request->isMethod("post")){
            $request->validate([
                'shipping_charge_id' => ['required', 'exists:user_addresses,id'],
                'note' => ['nullable','max:255','string'],
                'payment_term' => ['required',Rule::in(['100% Advanced', 'Credit'])],
                'discount_amount' => ['nullable','numeric'],
                'shipping_amount' => ['required','numeric'],
            ]);
            $data = $request->only('shipping_charge_id', 'note', 'payment_term','discount_amount','shipping_amount');
            $order = new Order;
            $userAddress = UserAddress::whereId($data['shipping_charge_id'])->first();
            if(!empty($user)){
                $order->user_id = trim($user->id);
                $order->shipping_charge_id = $data['shipping_charge_id'];
                $order->name = $user->name;
                $order->mobile = $user->mobile;
                $order->email = $user->email;
                $order->country = $user->country->name??'';
                $order->state = $user->state->name??'';
                $order->city = $user->city->name??'';
                $order->zipcode = $user->zipcode??'';

                if(!empty($user->pincode_id)){
                    $order->pincode_id = $user->pincode_id??0;
                }
            }

            $order->uuid = str()->uuid()->toString();
            $order->booking_address =  $userAddress->address. ' ' .$userAddress->state->name. '-' .$userAddress->zipcode;
            $order->note =  $data['note']??null;

            $subtotal = Cart::subtotal(2, '.', '');
            $shipping_amount = number_format($data['shipping_amount'],2, '.', '');
            $total_amount = round($shipping_amount+$subtotal,2);

            if(!empty($data['discount_amount'])){
                $discount_amount = number_format($data['discount_amount'],2, '.', '');
                $order->discount_code =  "Admin";
                $order->discount_amount =  $discount_amount;
                $total_amount = round($total_amount-$discount_amount,2);
            }

            $order->shipping_amount =  $shipping_amount??0;
            $order->total_amount =  $total_amount??0;
            $order->payment_term =  $data['payment_term']??null;
            $order->save();

            foreach(Cart::content() as $key => $item){
                OrderItem::updateOrCreate( 
                    [
                        'order_id' => $order->id,
                        'cart_id' => $item->rowId,
                    ],
                    [
                        'order_id' => $order->id,
                        'product_id' => $item->id,
                        'product_code' => $item->options->product_code,
                        'cart_id' => $item->rowId,
                        'product_color' => $item->options->color,
                        'product_size' => $item->options->size,
                        'price' => $item->price,
                        'product_lbh_weight_gm' => $item->weight??0,
                        'total_qty' => $item->qty,
                        'total_amount' => round($item->price*$item->qty,2),
                    ]
                );

            }

            OrderLog::create(
                [
                    'order_id' => $order->id,
                    'user_id' => auth()->user()->id,
                    'user_name' => auth()->user()->name,
                    'change_value' => "Pending",
                    'change_type' => "order_create",
                ],
            );
            Cart::destroy();
            return redirect(route('orders.show', $order))->with('success', 'order created successfully!!');
        }
        //if method GET
        else
        {
            if(!empty(request('url_key') || !empty(request('q')))){
                $getSingleSubCategory = Subcategory::getSingleSubCategory(request('url_key'));
                if(!empty($getSingleSubCategory))
                {
                    $productsList = Product::getProducts($getSingleSubCategory->id);
                    return view('admin.customers.orders.create', compact('getSingleSubCategory','productsList','user'));
                }
                elseif(!empty(request('q'))){
                $productsList = Product::getProducts();
                return view('admin.customers.orders.create', compact('productsList','user'));
                }
                else
                {
                    abort(404);
                }
            }
            return view('admin.customers.orders.create', compact('user'));
        }
    }

    public function LoginAsCustomer(User $user)
    {
        Auth::login($user);
        return redirect()->intended(route('dashboard', absolute: false));
    }
}
