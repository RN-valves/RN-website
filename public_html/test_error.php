<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();
$user = \App\Models\User::has('addresses')->first();
if(!$user) {
    $user = \App\Models\User::first();
    $address = new \App\Models\UserAddress(['user_id' => $user->id, 'mobile' => '9999999999', 'name' => 'test', 'zipcode' => '110001', 'address' => 'test', 'type' => 'Home']);
    $address->save();
} else {
    $address = $user->addresses()->first();
}
\Illuminate\Support\Facades\Auth::login($user);
$request = Illuminate\Http\Request::create('/checkout/place-order', 'POST', [
    'shipping_charge_id' => $address->id,
    'payment_term' => 'Prepaid',
    'total_amount' => '2529',
]);
$response = $kernel->handle($request);
echo "Status: " . $response->getStatusCode() . "\n";
echo $response->getContent();
