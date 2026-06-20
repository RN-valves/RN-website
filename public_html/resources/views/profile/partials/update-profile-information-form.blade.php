<div class="col-md-6 col-lg-6">
   <div class="card">
      <div class="card-body">
         <div class="acc_page_title">My Profile</div>
         <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
         </p>
         <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
         </form>
         <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('patch')
            @if (count($errors) > 0)
            <div class="alert alert-danger">
               <strong>Whoops! </strong> There were some problems with your input.<br><br>
               <ul>
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
               </ul>
            </div>
            @endif
            <div class="">
               <div class="row">
                  <div class="col-sm-6">
                     <div class="form-group">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full form-control" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                        <x-input-error class="mt-2 text-danger" :messages="$errors->get('name')" />
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full form-control" :value="old('email', $user->email)" required autocomplete="username" />
                        <x-input-error class="mt-2 text-danger" :messages="$errors->get('email')" />
                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail() || empty($user->email_verified_at))
                        <div>
                           <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                              {{ __('Your email address is unverified.') }}
                              <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                              {{ __('Click here to re-send the verification email.') }}
                              </button>
                           </p>
                           @if (session('status') === 'verification-link-sent')
                           <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                              {{ __('A new verification link has been sent to your email address.') }}
                           </p>
                           @endif
                        </div>
                        @endif
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">
                        <x-input-label for="mobile" :value="__('10 Digits Mobile Number')" />
                        <x-text-input id="mobile" name="mobile" type="text" class="mt-1 block w-full form-control" :value="old('mobile', $user->mobile)" required autofocus autocomplete="mobile" disabled />
                        <x-input-error class="mt-2 text-danger" :messages="$errors->get('mobile')" />
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">
                        <x-input-label for="zipcode" :value="__('Pincode')" />
                        <x-text-input id="zipcode" name="zipcode" type="number" class="mt-1 block w-full form-control" :value="old('zipcode', $user->zipcode)" required autofocus autocomplete="zipcode" />
                        <x-input-error class="mt-2 text-danger" :messages="$errors->get('zipcode')" />
                     </div>
                  </div>
                  <div class="col-sm-12">
                     <div class="form-group">
                        <x-input-label for="address" :value="__('Address')" />
                        <textarea rows="3" id="address" name="address" class="mt-1 block w-full form-control shadow-none border" required autofocus autocomplete="address" >{{ old('address', @$user->address) }}</textarea>
                        <x-input-error class="mt-2 text-danger" :messages="$errors->get('address')" />
                     </div>
                  </div>
               </div>
               <div class="mt-3 mb-5">
                  <div class="flex items-center gap-4">
                     <x-primary-button style="background: black!important">{{ __('Save') }}</x-primary-button>
                     @if (session('status') === 'profile-updated')
                     <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600 dark:text-gray-400"
                        >{{ __('Saved.') }}</p>
                     @endif
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>