<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\{
    User,
    UserAddress
};
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Repositories\Interfaces\UserInterface;
use Spatie\Permission\Models\Role;
use App\Rules\GoogleReCaptcha;
use App\Mail\RegisterMail;
use App\Mail\RegisterContactMail;
use Mail;
use Illuminate\Validation\Rule;

class RegisteredUserController extends Controller
{
    function __construct(UserInterface $userRep)
    {
        $this->userRep = $userRep;
    }
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'digits:10', 'unique:'.User::class],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'zipcode' => ['required','exists:pincodes,code'],
            'address' => ['required', 'string', 'max:255'],
            'profession' => ['required',Rule::in(User::professions())],
            'gst_number' => ['nullable','required_if:profession,Distributor,Dealer,Architect,Contractor','unique:users,gst_number'],
            'g-recaptcha-response' => ['required', new GoogleReCaptcha],
        ]);

        $input = $request->all();
        $input['user_type'] = "Customer";
        $input['created_by'] = "Self";
        $input['reporting_ids'] = [2];
        $input['sales_user_id'] = 2;
        $roles = Role::where('id',3)->first();

        $user = $this->userRep->store($input);
        $user->assignRole($roles);

        UserAddress::updateOrCreate(
            [
                'mobile' => $input['mobile'],
            ],
            [
                'user_id' => $user->id,
                'mobile' => $input['mobile'],
                'name' => $input['name'],
                'city_id' => $user->city_id,
                'state_id' => $user->state_id,
                'country_id' => $user->country_id,
                'zipcode' => $input['zipcode'],
                'address' => $input['address'],
                'type' => "Home",
            ],
        );

        Mail::to($user->email)->cc('web@rnvalves.com')->send(new RegisterMail($user));
        if($request->profession != 'Consumer'){
            Mail::to(frontPage()->email)->send(new RegisterContactMail($user));
        }
        return back()->with('status', 'verification-link-sent');

        /*event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));*/
    }
}
