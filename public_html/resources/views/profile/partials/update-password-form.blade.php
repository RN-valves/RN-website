<div class="col-md-6 col-lg-6">
   <div class="card">
      <div class="card-body">
         <div class="acc_page_title">Update Password</div>
         <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
         </p>
         <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('put')
            <div class="">
               <div class="row">
                  <div class="col-sm-12">
                     <div class="form-group">
                        <x-input-label for="update_password_current_password" :value="__('Current Password')" />
                        <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full form-control" autocomplete="current-password" />
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-danger" />
                     </div>
                  </div>
                  <div class="col-sm-12">
                     <div class="form-group">
                        <x-input-label for="update_password_password" :value="__('New Password')" />
                        <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full form-control" autocomplete="new-password" />
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-danger" />
                     </div>
                  </div>
                  <div class="col-sm-12">
                     <div class="form-group">
                        <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full form-control" autocomplete="new-password" />
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-danger" />
                     </div>
                  </div>
               </div>
               <div class="flex items-center gap-4">
                  <x-primary-button style="background: black;">{{ __('Update Password') }}</x-primary-button>
                  @if (session('status') === 'password-updated')
                  <p
                     x-data="{ show: true }"
                     x-show="show"
                     x-transition
                     x-init="setTimeout(() => show = false, 2000)"
                     class="text-sm text-gray-600 dark:text-gray-400"
                     >{{ __('Saved.') }}
                  </p>
                  @endif
               </div>
            </div>
         </form>
      </div>
   </div>
</div>