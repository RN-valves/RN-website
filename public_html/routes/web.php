<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');
Route::get('/home2', function () {
    return view('welcome2');
})->name('welcome2');
Route::get('/whatsapp', function () {
    return redirect()->away('https://api.whatsapp.com/send?phone=919811103377&text=Hello,%20I%20am%20a%20visitor%20from%20your%20website%20and%20would%20like%20to%20chat%20with%20you');
})->name('enquiry.whatsapp');
Route::get('/plumber-enquiry', function () {
    return redirect()->away('https://api.whatsapp.com/send?phone=919319888435');
})->name('enquiry.plumber.whatsapp');


Route::get('/testurl', function () {
    $templateId = '6801d99dd6fc053724610852';
    $params = [
        'mobiles' => '918445983311',
        'name' => 'Rituraj',
        'orderid' => 'RNOD1235',
        'trackid' => '14396450195722',
        'trackurl' => 'https://rnvalves.shipway.com/track',
    ];
    $response = SendSMS($templateId,$params);
    dd($response);
});

Route::namespace('App\Http\Controllers')->group(function () { 
Route::controller(CatalogueController::class)->group(function(){
    Route::get('generate/vcard','vcard')->name('vcard.generate');
});
});



Route::get('/dashboard', function () {

    if(auth()->user()->user_type=="Customer"){
        return view('auth.dashboard');
    }else{
        return view('dashboard');
    }
    
})->middleware(['auth', 'verified'])->name('dashboard');

Route::namespace('App\Http\Controllers\Auth')->group(function () { 
    Route::controller(AuthenticatedSessionController::class)->group(function(){
        Route::post('send-login-otp', 'SendLoginOtp')->name('send.login.otp');
        Route::post('verify-login-otp', 'VerifyLoginOtp')->name('verify.login.otp');
        Route::post('resend-login-otp', 'ResendLoginOtp')->name('resend.login.otp');
    });

});
Route::namespace('App\Http\Controllers')->group(function () { 

    Route::view('corporate-social-responsibility', 'users.websites.csr')->name('ourCsr');
    Route::view('catalogue', 'users.websites.catalogue')->name('catalogue');
    Route::view('direct-payment', 'users.websites.direct_payment')->name('direct_payment');
    Route::view('career', 'users.websites.career')->name('career');

    Route::controller(Payments\PaymentController::class)->group(function(){
        Route::get('cart','cart')->name('cart');
        Route::post('add-to-cart', 'addToCart')->name('addToCart');
        Route::post('update-to-cart/', 'cartUpdate')->name('cartUpdate');
        Route::post('cart-remove-item', 'cartRemoveItem')->name('cartRemoveItem');
        Route::get('cart-empty', 'cartEmpty')->name('cartEmpty');
        Route::post('direct-payment-razopay', 'direct_payment_razorypay')->name('direct_payment_razorypay');
        Route::get('razorypay/success-direct-payment', 'razorpay_direct_success_payment')->name('razorpay_direct_success_payment');
        Route::post('apply-cart-discount-ajax', 'cartApplyDiscount')->name('cartApplyDiscount');
    }); 

    Route::controller(WebsiteController::class)->group(function(){
        Route::post('filter-products-list', 'filterProductList')->name('filterProductList');
        Route::get('about-us', 'aboutUs')->name('aboutUs');
        Route::match(['get','post'],'contact-us', 'contactUs')->name('contactUs');
        Route::get('search', 'getProductSearch')->name('search');
        Route::get('product/{category}/{subcategory}/{url_key}', 'productList')->name('productList.view');
        Route::get('/{url_key}', 'productList')->name('productList');
        Route::get('product/{category}/{url_key}', 'productList')->name('productList.list');
        // Route::get('/ptmt-taps-or-faucets', 'productList');
        Route::get('posts/{url_key}', 'blogs')->name('blogs');
        Route::get('news/{url_key}', 'news')->name('news');
        Route::post('check-pincode-ajax', 'check_pincode')->name('check_pincode');
        Route::get('career/{career}', 'career_detail')->name('career_detail');
        Route::post('store-popup-form-response', 'store_popup_form_enquiry')->name('store_popup_form_enquiry');
        Route::get('contact/{url_key?}', 'policies')->name('policy');
        Route::get('sitemap/sitemap.xml', 'sitemap')->name('sitemap');
        Route::get('vcard/rnvalves','vCardShow')->name('catalogue.vcard');
    });

    Route::controller(AuthController::class)->group(function(){
        Route::get('activate/{id}','activate_email')->name('activate_email');
    });
    Route::controller(AIController::class)->group(function(){
        Route::post('/upload-pdf','uploadPDF')->name('pdf.upload');
        Route::get('/chat/ai/question/all', 'chat')->name('chat.index');
        Route::post('/all/ask/ask-question/{pdf_id}','askQuestion');
    });

    Route::controller(PincodeController::class)->group(function(){
        Route::post('get-pincode-city-state','get_pincode_city_state')->name('pincodes.get_pincode_city_state');
    });
    
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::namespace('App\Http\Controllers')->group(function () { 

        Route::controller(Payments\PaymentController::class)->group(function(){
            Route::get('usr/cart-checkout', 'CartCheckout')->name('CartCheckout');
            Route::post('usr/get-shipping-charge', 'getShippingCharges')->name('getShippingCharges');
            Route::post('checkout/place-order', 'place_order')->name('place_order');
            Route::get('checkout/payment', 'checkout_payment')->name('checkout_payment');
            Route::get('razorypay/success-order-payment', 'razorypay_success_payment')->name('razorypay_success_payment');
            Route::get('order/successfully-placed', 'order_placed_success')->name('order_placed_success');
           // Route::post('apply-cart-discount-ajax', 'cartApplyDiscount')->name('cartApplyDiscount');
        });

        Route::controller(AuthController::class)->group(function(){
            Route::get('usr/addresses','addressesUpdate')->name('addressesUpdate');
            Route::get('usr/edit-eddress/{userAddress}', 'customer_address_edit')->name('customer_address_edit');
            Route::post('usr/store-address', 'addressStore')->name('addressesStore');
            Route::get('usr/orders', 'customer_order_list')->name('customer_order_list');
            Route::get('usr/orders/{order}', 'customer_order_detail')->name('customer_order_detail');
            Route::post('usr/order-cancel/{order}', 'cancel_order')->name('cancel_order');
        });
        
        Route::controller(ProfileController::class)->group(function(){
            Route::get('pf/profile', 'edit')->name('profile.edit');
            Route::patch('pf/profile', 'update')->name('profile.update');
            Route::delete('pf/profile', 'destroy')->name('profile.destroy');
        });

        Route::controller(StateController::class)->group(function(){
            Route::post('get-country-states', 'getCountryStates')->name('states.getCountryStates');
            Route::post('get-state-cities', 'get_json_state_city')->name('states.get_json_state_city');
        }); 

        Route::controller(PincodeController::class)->group(function(){
            Route::match(['get','post'], 'import/export-pincodes','import_pincodes')->name('pincodes.import_pincodes');
        });

        Route::controller(CityController::class)->group(function(){
            Route::match(['get','post'], 'import/export-cities','import_cities')->name('cities.import_cities');
        });

        Route::controller(CommonActionController::class)->group(function(){
            Route::get('delete-common-excel/{importedFileLog}','delete_imported_excels')->name('commons.delete_imported_excels');
        });

        Route::controller(UserController::class)->group(function(){
            Route::get('uc/user-customers-network','customer_network')->name('users.customer_network');
            Route::get('report/user-remark-log', 'userRemarkLog')->name('users.userRemarkLog');
        });

        Route::controller(EnquiryController::class)->group(function(){
            Route::match(['get','post'], 'import/export-enquiries','import_enquiries')->name('enquiries.import_enquiries');
        });

        Route::controller(CustomerController::class)->group(function(){
            Route::match(['get','post'], 'import/export-customers','import_customers')->name('customers.import_customers');
            Route::get('customer-order-list/{user}', 'customer_order_list')->name('customers.orders.index');
            Route::match(['get','post'], 'customer-order-create/{user}', 'orderCreate')->name('customers.orderCreate');
            Route::post('customer-order-cart-items-remove', 'ordercartRemoveItem')->name('customers.ordercartRemoveItem');
            Route::post('customer-cart-update', 'customerCartUpdate')->name('customers.customerCartUpdate');
            Route::post('add-to-cart-items', 'orderAddToCart')->name('customers.orderAddToCart');
            Route::get('login-as-customer/{user}', 'LoginAsCustomer')->name('login.as.customer');
        });

        Route::controller(ProductImagesController::class)->group(function(){
            Route::match(['get','post'], 'import/export-productImages','import_productImages')->name('productImages.import_productImages');
        });

        Route::controller(ProductController::class)->group(function(){
            Route::match(['get','post'],'add-product-color/{product}', 'addNewColor')->name('products.addNewColor');
            Route::match(['get','post'],'add-product-size/{product}', 'addNewSize')->name('products.addNewSize');
            Route::match(['get','post'], 'import/export-products','import_products')->name('products.import_products');
            Route::match(['get','post'], 'import/products-qty','import_products_qty')->name('products.import.qty');
            Route::match(['get','post'], 'update-product-status/{product}', 'statusProduct')->name('products.statusProduct');
            Route::post('store-product-bullet-points/{product}','product_bullet_product')->name('products.product_bullet_product');
            Route::get('delete/product-bullet-point', 'delete_product_bullet_id')->name('products.delete_product_bullet_id');
        });

        Route::controller(ReportController::class)->group(function(){
            Route::get('report/all/logs/order-cancel-log-list','order_cancel_log_list')->name('order_cancel_log_list');
            Route::get('report/orders','orderReports')->name('order.reports');
            Route::get('report/orders/export','orderReportsExport')->name('order.reports.export');
            Route::get('report/product','productReport')->name('product.reports');
            Route::post('report/product/export','productExportReports')->name('product.reports.export');
            Route::post('report/product/getSubcategory','ajaxSubcategory')->name('product.reports.subcategory');
        });

        Route::controller(OrderController::class)->group(function(){
            Route::get('ord/generate-order-pdf/{order}', 'generate_order_pdf')->name('generate_order_pdf');
            Route::post('ord/admin-order-update/{order}', 'AdminorderUpdate')->name('orders.AdminorderUpdate');
            Route::get('ord/generate-order-payment-link/{order}', 'generatePaymentLink')->name('orders.generatePaymentLink');
            Route::get('ord/admin/get/carrier/rates', 'getCarrierRate')->name('orders.carrier.rate');
            Route::post('ord/admin/get/carrier/assign', 'AssignCarrier')->name('orders.carrier.assign');
            Route::post('ord/admin/get/generate/manifest', 'GenerateManifest')->name('orders.generate.manifest');
            Route::post('ord/admin/mark-payment-received/{order}', 'markPaymentReceived')->name('orders.markPaymentReceived');
            Route::post('ord/admin/set-store-pickup/{order}', 'setStorePickup')->name('orders.setStorePickup');
            Route::post('ord/admin/complete-store-pickup/{order}', 'completeStorePickup')->name('orders.completeStorePickup');
            Route::post('ord/admin/complete-without-shipway/{order}', 'completeWithoutShipway')->name('orders.completeWithoutShipway');
            Route::post('ord/admin/update-order-status/{order}', 'updateOrderStatus')->name('orders.updateOrderStatus');
        });

        Route::controller(ProductBulletsController::class)->group(function(){
            Route::get('pb/productBullets-delete/{productBullet}', 'delete')->name('productBullets.delete');
            Route::match(['get','post'], 'pb/import-export-product-bullet-point', 'import_pro_bullet')->name('productBullets.import_pro_bullet');
        });

        Route::resource('all/edit/cn/countries', CountryController::class);
        Route::resource('all/edit/st/states', StateController::class);
        Route::resource('all/edit/ct/cities', CityController::class);
        Route::resource('all/edit/pi/pincodes', PincodeController::class);
        Route::resource('all/edit/ro/roles', RoleController::class);
        Route::resource('all/edit/us/users', UserController::class);
        Route::resource('all/edit/pe/permissions', PermissionController::class);
        Route::resource('all/edit/ua/userAddresses',UserAddressController::class);
        Route::resource('all/edit/en/enquiries',EnquiryController::class);
        Route::resource('all/edit/re/remarks', RemarksController::class);
        Route::resource('all/edit/rl/remarkLogs', RemarkLogsController::class);
        Route::resource('all/edit/cu/customers', CustomerController::class);
        Route::resource('all/edit/ed/editLogs', EditLogController::class);
        Route::resource('all/edit/br/brands', BrandController::class);
        Route::resource('all/edit/co/contents', ContentController::class);
        Route::resource('all/edit/ca/categories', CategoryController::class);
        Route::resource('all/edit/su/subcategories', SubcategoryController::class);
        Route::resource('all/edit/si/sizes', SizeController::class);
        Route::resource('all/edit/co/colors', ColorController::class);
        Route::resource('all/edit/mt/materials', MaterialController::class);
        Route::resource('all/edit/pt/products', ProductController::class);
        Route::resource('all/edit/fr/frontPages', FrontPageController::class);
        Route::resource('all/edit/sl/sliders', SliderController::class);
        Route::resource('all/edit/pt/productImages', ProductImagesController::class);
        Route::resource('all/edit/ds/discounts', DiscountController::class);
        Route::resource('all/edit/sp/shippingCharges', ShippingChargesController::class);
        Route::resource('all/edit/od/orders', OrderController::class);
        Route::resource('all/edit/ot/orderTransports', OrderTransportController::class);
        Route::resource('all/edit/py/payments', PaymentsController::class);
        Route::resource('all/edit/cr/careers', CareerController::class);
        Route::resource('all/edit/bl/blogs', BlogController::class);
        Route::resource('all/edit/nw/news', NewsController::class);
        Route::resource('all/edit/bp/bPoints', BulletPointsController::class);
        Route::resource('all/edit/pb/productBullets', ProductBulletsController::class);
        Route::resource('all/edit/crt/certificates', CertificateController::class);
        Route::resource('all/logs/fq/faq', FaqController::class);
        Route::resource('all/cg/gen/catalogue', CatalogueController::class);

        Route::controller(CatalogueController::class)->group(function(){
            Route::get('all/catalogue/{id}/download-qr', 'downloadQrCode')->name('catalogue.downloadQrCode');
        });

        Route::controller(FrontPageController::class)->group(function(){
            Route::get('pages/index', 'pages')->name('page.index');
            Route::get('pages/edit', 'page_edit')->name('page.edit');
            Route::post('pages/update', 'page_update')->name('page.update');
            Route::match(['GET','POST'],'pages/about-us', 'about_us')->name('page.about_us');
        });
    });
});

require __DIR__.'/auth.php';
