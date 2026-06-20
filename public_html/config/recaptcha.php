<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Google reCAPTCHA Keys
    |--------------------------------------------------------------------------
    |
    | These are your Google reCAPTCHA site key and secret key.
    | You can obtain these from the Google reCAPTCHA Admin Console:
    | https://www.google.com/recaptcha/admin
    |
    */
    'site_key' => env('GOOGLE_RECAPTCHA_KEY', ''),
    'secret_key' => env('GOOGLE_RECAPTCHA_SECRET', ''),

    /*
    |--------------------------------------------------------------------------
    | Default reCAPTCHA Version
    |--------------------------------------------------------------------------
    |
    | Specify which version of reCAPTCHA you want to use:
    | - "v2": Checkbox or Invisible reCAPTCHA (default)
    | - "v3": Invisible reCAPTCHA with score-based verification
    |
    */
   

    /*
    |--------------------------------------------------------------------------
    | reCAPTCHA Language (Optional)
    |--------------------------------------------------------------------------
    |
    | You can set the language for the reCAPTCHA widget. By default, Google
    | will automatically detect the user's language.
    |
    */
    

    /*
    |--------------------------------------------------------------------------
    | reCAPTCHA Score Threshold (For v3 Only)
    |--------------------------------------------------------------------------
    |
    | If you're using reCAPTCHA v3, this sets the minimum score threshold
    | for considering a request "valid." Scores range from 0.0 to 1.0,
    | where 1.0 is most likely a valid request.
    |
    */
    

    /*
    |--------------------------------------------------------------------------
    | Enable/Disable reCAPTCHA
    |--------------------------------------------------------------------------
    |
    | This option allows you to enable or disable reCAPTCHA entirely.
    | This can be useful for testing purposes or development environments.
    |
    */
    

];
