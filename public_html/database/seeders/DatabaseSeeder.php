<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\{Country, State, City, Pincode, User, UserType, Enquiry, Brand, Color, Size, Material, Subcategory, Category, Content, FrontPage, ShippingCharge, OrderCancel};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * List of applications to add.
     */
    private $permissions = [
        "role-list",
        "role-create",
        "role-edit",
        "role-delete",
        "product-list",
        "product-create",
        "product-edit",
        "product-delete",
        "permissions-list",
        "permissions-create",
        "permissions-edit",
        "permissions-delete",
        "country-list",
        "country-create",
        "country-edit",
        "state-list",
        "state-create",
        "state-edit",
        "city-list",
        "city-create",
        "city-edit",
        "city-excel-upload",
        "pincode-list",
        "pincode-create",
        "pincode-edit",
        "pincode-delete",
        "pincode-excel-upload",
        "delete-uploaded-excel-file",
        "user-list",
        "user-create",
        "user-edit",
        "user-delete",
        "user-address-list",
        "user-address-create",
        "user-address-edit",
        "user-address-delete",
        "user-log-remark-index",
        "enquiry-list",
        "enquiry-create",
        "enquiry-edit",
        "enquiry-delete",
        "enquiry-excel-upload",
        "remark-list",
        "remark-create",
        "remark-edit",
        "remark-delete",
        "customer-list",
        "customer-index",
        "customer-create",
        "customer-edit",
        "customer-delete",
        "remark-log-list",
        "customer-excel-upload",
        "brand-list",
        "content-list",
        "content-create",
        "content-edit",
        "content-delete",
        "category-list",
        "category-create",
        "category-edit",
        "category-delete",
        "subcategory-list",
        "subcategory-create",
        "subcategory-edit",
        "subcategory-delete",
        "size-list",
        "size-create",
        "size-edit",
        "size-delete",
        "color-list",
        "color-create",
        "color-edit",
        "color-delete",
        "material-list",
        "material-create",
        "material-edit",
        "material-delete",
        "create-new-product-color",
        "create-new-product-size",
        "product-excel-upload",
        "frontPage-edit",
        "change-product-status",
        "slider-list",
        "slider-create",
        "slider-edit",
        "slider-delete",
        "productImage-list",
        "productImage-create",
        "productImage-edit",
        "productImage-delete",
        "productImage-excel-upload",
        "discount-list",
        "discount-create",
        "discount-edit",
        "discount-delete",
        "shipping_charge-list",
        "shipping_charge-create",
        "shipping_charge-edit",
        "shipping_charge-delete",
        "order-list",
        "order-create",
        "order-edit",
        "order-delete",
        "orderTransport-list",
        "orderTransport-create",
        "orderTransport-edit",
        "orderTransport-delete",
        "order-cancel-log-list",
        "payment-list",
        "payment-create",
        "payment-edit",
        "payment-delete",
        "career-list",
        "career-create",
        "career-edit",
        "career-delete",
        "blog-list",
        "blog-create",
        "blog-edit",
        "blog-delete",
        "bullet-point-list",
        "bullet-point-create",
        "bullet-point-edit",
        "bullet-point-delete",
        "product-bullet-point-list",
        "product-bullet-point-create",
        "product-bullet-point-edit",
        "product-bullet-point-delete",
        "product-bullet-point-excel",
    ];



    private $sizes = [
        '8mm(1/4")', 
            '10mm(3/8")', 
            '15mm(1/2")', 
            '20mm(3/4")', 
            '25mm(1")',
            '32mm(1-1/4")',
            '40mm(1-1/2")', 
            '46mm', 
            '50mm(2")', 
            '65mm(2-1/2")', 
            '80mm(3")', 
            '100mm(4")', 
            '4"',
            '6"',
            '8"',
            '10"',
            '12"',
            '16"',
            '20"',
            '24"',
            '9"',
            '3"',
            '2"',
            '15"',
            '18"',
            '21"',
            '48"',
            '60"',
            '20"*8"',
            '5"*8"',
            '7"*10"',
            '9"*14"',
            '4"*6"',
            '6"*10"',
            '8"*12"',
            '6"*8"',
            '1/2"*10"',
            '3/4"*10"',
            '11.5"*8.5"',
            '5"*5"',
            '220mm',
            '300*200mm',
            '280*180mm',
            '250*170mm',
            '250*190mm',
            '500*550mm',
            '400*450mm',
            '150*150mm',
            '85mm',
            '8.9mm',
            '8.5mm',
            '8*14mm',
            '170*80mm',
            '125*200mm',
            '21mm',
            '24*1mm',
            '20*1mm',
            '22*1mm',
            '150ml',
            '1500ml',
            '600ml',
            '330ml',
            '250ml',
            '2200ml',
            '3/4"*10mtr',
            '1/2"*10mtr',
            '5/8"*15mtr',
            '30"',
            '36"',
            '17"',
            '23"',
            '29"',
            '35"',
            '1.1mtr',
            '1.6mtr',
            '1mtr',
            '1.5mtr',
    ];

    private $materials = [
        'BRASS',
        'IMPORT',
        'PTMT',
        'SS',
        'ZINC',
        'ABS',
        'PVC',
        'PLASTIC',
        'UPVC',
        'OTHER',
    ];


    private $ordercancel_reasons = [
        'Order Created by Mistake',
        'Item(s) Would Not Arrive on Time',
        'Shipping Cost Too High',
        'Found Cheaper Somewhere Else',  
        'Need to Change Shipping Address',
        'Need to Change Shipping Speed',
        'Need to Change Billing Address',
        'Need to Change Payment Method',
    ];

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach($this->ordercancel_reasons as $cancel){
            OrderCancel::create(["name"=>$cancel]);
        }

        foreach ($this->materials as $material) {
            Material::create(["name" => $material]);
        }

        foreach ($this->permissions as $permission) {
            Permission::create(["name" => $permission]);
        }

        $country = Country::create([
            "name" => "India",
            "code" => "+91",
        ]);

        State::create([
            "id" => 1,
            "country_id" => $country->id,
            "name" => "Andaman & Nicobar Islands",
            "code" => "35",
        ]);

        State::create([
            "id" => 2,
            "country_id" => $country->id,
            "name" => "Andhra Pradesh",
            "code" => "37",
        ]);

        State::create([
            "id" => 3,
            "country_id" => $country->id,
            "name" => "Arunachal Pradesh",
            "code" => "12",
        ]);

        State::create([
            "id" => 4,
            "country_id" => $country->id,
            "name" => "Assam",
            "code" => "18",
        ]);

        State::create([
            "id" => 5,
            "country_id" => $country->id,
            "name" => "Bihar",
            "code" => "10",
        ]);

        State::create([
            "id" => 6,
            "country_id" => $country->id,
            "name" => "Chandigarh",
            "code" => "04",
        ]);

        State::create([
            "id" => 7,
            "country_id" => $country->id,
            "name" => "Chhattisgarh",
            "code" => "22",
        ]);

        State::create([
            "id" => 8,
            "country_id" => $country->id,
            "name" => "Dadra & Nagar Haveli",
            "code" => "26",
        ]);

        State::create([
            "id" => 9,
            "country_id" => $country->id,
            "name" => "Daman & Diu",
            "code" => "26",
        ]);

        $state = State::create([
            "id" => 10,
            "country_id" => $country->id,
            "name" => "Delhi",
            "code" => "07",
        ]);

        State::create([
            "id" => 11,
            "country_id" => $country->id,
            "name" => "Goa",
            "code" => "30",
        ]);

        State::create([
            "id" => 12,
            "country_id" => $country->id,
            "name" => "Gujarat",
            "code" => "24",
        ]);

        State::create([
            "id" => 13,
            "country_id" => $country->id,
            "name" => "Haryana",
            "code" => "06",
        ]);

        State::create([
            "id" => 14,
            "country_id" => $country->id,
            "name" => "Himachal Pradesh",
            "code" => "02",
        ]);

        State::create([
            "id" => 15,
            "country_id" => $country->id,
            "name" => "Jammu and Kashmir",
            "code" => "01",
        ]);

        State::create([
            "id" => 16,
            "country_id" => $country->id,
            "name" => "Jharkhand",
            "code" => "20",
        ]);

        State::create([
            "id" => 17,
            "country_id" => $country->id,
            "name" => "Karnataka",
            "code" => "29",
        ]);

        State::create([
            "id" => 18,
            "country_id" => $country->id,
            "name" => "Kerala",
            "code" => "KL",
        ]);

        State::create([
            "id" => 19,
            "country_id" => $country->id,
            "name" => "Lakshadweep",
            "code" => "31",
        ]);

        State::create([
            "id" => 20,
            "country_id" => $country->id,
            "name" => "Madhya Pradesh",
            "code" => "23",
        ]);

        State::create([
            "id" => 21,
            "country_id" => $country->id,
            "name" => "Maharashtra",
            "code" => "27",
        ]);

        State::create([
            "id" => 22,
            "country_id" => $country->id,
            "name" => "Manipur",
            "code" => "14",
        ]);

        State::create([
            "id" => 23,
            "country_id" => $country->id,
            "name" => "Meghalaya",
            "code" => "17",
        ]);

        State::create([
            "id" => 24,
            "country_id" => $country->id,
            "name" => "Mizoram",
            "code" => "15",
        ]);

        State::create([
            "id" => 25,
            "country_id" => $country->id,
            "name" => "Nagaland",
            "code" => "13",
        ]);

        State::create([
            "id" => 26,
            "country_id" => $country->id,
            "name" => "Odisha",
            "code" => "21",
        ]);

        State::create([
            "id" => 27,
            "country_id" => $country->id,
            "name" => "Pondicherry",
            "code" => "34",
        ]);

        State::create([
            "id" => 28,
            "country_id" => $country->id,
            "name" => "Punjab",
            "code" => "03",
        ]);

        State::create([
            "id" => 29,
            "country_id" => $country->id,
            "name" => "Rajasthan",
            "code" => "08",
        ]);

        State::create([
            "id" => 30,
            "country_id" => $country->id,
            "name" => "Sikkim",
            "code" => "SK",
        ]);

        State::create([
            "id" => 31,
            "country_id" => $country->id,
            "name" => "Tamil Nadu",
            "code" => "33",
        ]);

        State::create([
            "id" => 32,
            "country_id" => $country->id,
            "name" => "Telangana",
            "code" => "36",
        ]);

        State::create([
            "id" => 33,
            "country_id" => $country->id,
            "name" => "Tripura",
            "code" => "16",
        ]);

        State::create([
            "id" => 34,
            "country_id" => $country->id,
            "name" => "Uttar Pradesh",
            "code" => "09",
        ]);

        State::create([
            "id" => 35,
            "country_id" => $country->id,
            "name" => "Uttarakhand",
            "code" => "05",
        ]);

        State::create([
            "id" => 36,
            "country_id" => $country->id,
            "name" => "West Bengal",
            "code" => "19",
        ]);

        /*State::create([
                    'id'    => 38,
                    'country_id' => $country->id,
                    'name' => 'Leh',
                    'code' => '38',
                ]);*/

        State::create([
            "id" => 37,
            "country_id" => $country->id,
            "name" => "Ladakh",
            "code" => "38",
        ]);

        $city = City::create([
            "country_id" => $country->id,
            "state_id" => $state->id,
            "name" => "New Delhi",
            "code" => "110001",
        ]);

        $pincode = Pincode::create([
            "country_id" => $country->id,
            "state_id" => $state->id,
            "city_id" => $city->id,
            "name" => "New Ashok Nagar",
            "code" => "110096",
        ]);

        $usertype = UserType::create([
            'name' => 'Employee',
        ]);

        UserType::create([
            'name' => 'Customer',
        ]);

        /*UserType::create([
            'name' => 'Direct-Dealer',
        ]);

        UserType::create([
            'name' => 'Retailer',
        ]);

        UserType::create([
            'name' => 'Distributor',
        ]);*/

        // Create admin User and assign the role to him.
        $user = User::create([
            "country_id" => 1,
            "state_id" => 1,
            "city_id" => 1,
            "pincode_id" => 1,
            "zipcode" => 110096,
            "user_code" => "SDFDF344",
            "address" => "skjhdbksd",
            "name" => "Prevail Ejimadu",
            "mobile" => "7500752436",
            "email" => "admin@gmail.com",
            'user_type' => "Admin",
            'email_verified_at' => now(),
            "uuid" => str()
                ->uuid()
                ->toString(),
            "password" => Hash::make("password"),
            'local_password' => "password",
        ]);

        $role = Role::create(["name" => "Super_Admin"]);

        $permissions = Permission::pluck("id", "id")->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
        
        Role::create(["name" => "User"]);
        Role::create(["name" => "Customer"]);
        Role::create(["name" => "Admin"]);

        Enquiry::create([
            "country_id" => 1,
            "state_id" => 1,
            "city_id" => 1,
            "pincode_id" => 1,
            'salesmen_id' => 1,
            "zipcode" => 110096,
            "ip_address" => "SDFDF344",
            "company_name" => "company name",
            "address" => "skjhdbksd",
            "name" => "Prevail Ejimadu",
            "mobile" => "7500752436",
            "email" => "admin@gmail.com",
            "uuid" => str()
                ->uuid()
                ->toString(),
            "purpose" => 'test customer',
            "published_at" => now(),
        ]);
        $emp = User::create([
            "country_id" => 1,
            "state_id" => 1,
            "city_id" => 1,
            "pincode_id" => 1,
            "zipcode" => 110096,
            "user_code" => "2387238",
            "address" => "test address",
            "name" => "Test User",
            "mobile" => "7500752434",
            "email" => "test@gmail.com",
            "user_type" => "Employee",
            'email_verified_at' => now(),
            "uuid" => str()
                ->uuid()
                ->toString(),
            "password" => Hash::make("password"),
            'local_password' => "password",
        ]);
        $emp->assignRole(["User"]);
        $customer = User::create([
            "country_id" => 1,
            "state_id" => 1,
            "city_id" => 1,
            "pincode_id" => 1,
            "zipcode" => 110096,
            "user_code" => "QW23232",
            "address" => "test DADSASDASDAX DFDSF",
            "name" => "Test CUSTOMER",
            "mobile" => "7500752432",
            "email" => "testCUSTOMER@gmail.com",
            "user_type" => "Customer",
            'email_verified_at' => now(),
            "uuid" => str()
                ->uuid()
                ->toString(),
            "password" => Hash::make("password"),
            'local_password' => "password",
        ]);
        $customer->assignRole(["Customer"]);

        Brand::create([
            'name' => 'RN',
            'logo' => 'RN',
        ]);

        Brand::create([
            'name' => 'Ornate',
            'logo' => 'Ornate',
        ]);

        Brand::create([
            'name' => 'Precious',
            'logo' => 'Precious',
        ]);

        Brand::create([
            'name' => 'Straina',
            'logo' => 'Straina',
        ]);

        /*Colors Seeder Start*/

        Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Silver.jpg',
            'name' => 'Silver',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Black.jpg',
            'name' => 'Black',
        ]);  

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Golden.jpg',
            'name' => 'Golden',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Copper.jpg',
            'name' => 'Copper',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/White.jpg',
            'name' => 'White',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/CP.jpg',
            'name' => 'CP',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Orange.jpg',
            'name' => 'Orange',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Blue.jpg',
            'name' => 'Blue',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Yellow.jpg',
            'name' => 'Yellow',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Red.jpg',
            'name' => 'Red',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Purple.jpg',
            'name' => 'Purple',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Green.jpg',
            'name' => 'Green',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Ivory.jpg',
            'name' => 'Ivory',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Ivory-Blue-Dual.jpg',
            'name' => 'Ivory-Blue-Dual',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Ivory-Bright-Gold-Dual.jpg',
            'name' => 'Ivory-Bright-Gold-Dual',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/White-Rose-Gold-Dual.jpg',
            'name' => 'White-Rose-Gold-Dual',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/White-Metallic-Blue-Dual.jpg',
            'name' => 'White-Metallic-Blue-Dual',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Brown-Pearl.jpg',
            'name' => 'Brown-Pearl',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Pearl-Gold.jpg',
            'name' => 'Pearl-Gold',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Special-Gold.jpg',
            'name' => 'Special-Gold',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Bright-Gold.jpg',
            'name' => 'Bright-Gold',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Metallic-Grey-Black-Dual.jpg',
            'name' => 'Metallic-Grey-Black-Dual',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Metallic-Grey.jpg',
            'name' => 'Metallic-Grey',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Royal-Blue-Metallic.jpg',
            'name' => 'Royal-Blue-Metallic',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Bright-Copper.jpg',
            'name' => 'Bright-Copper',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Navy-Blue-Metallic.jpg',
            'name' => 'Navy-Blue-Metallic',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Marble-C.jpg',
            'name' => 'Marble-C',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Regal.jpg',
            'name' => 'Regal',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Grand.jpg',
            'name' => 'Grand',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/White-Blue-Dual.jpg',
            'name' => 'White-Blue-Dual',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Magenta.jpg',
            'name' => 'Magenta',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Pink.jpg',
            'name' => 'Pink',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Marble.jpg',
            'name' => 'Marble',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/White-Hash-Brown-Dual.jpg',
            'name' => 'White-Hash-Brown-Dual',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/White-Charcoal-Dual.jpg',
            'name' => 'White-Charcoal-Dual',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Ivory-Hash-Brown-Dual.jpg',
            'name' => 'Ivory-Hash-Brown-Dual',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Ivory-Charcoal-Dual.jpg',
            'name' => 'Ivory-Charcoal-Dual',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Default.jpg',
            'name' => 'Default',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Chrome.jpg',
            'name' => 'Chrome',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Chrome Brushed.jpg',
            'name' => 'Chrome Brushed',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Brushed Golden.jpg',
            'name' => 'Brushed Golden',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Gun Metal.jpg',
            'name' => 'Gun Metal',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/White Rose Gold.jpg',
            'name' => 'White Rose Gold',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Rose-Gold-Chrome-Dual.jpg',
            'name' => 'Rose-Gold-Chrome-Dual',
        ]);

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Black-Chrome-Dual.jpg',
            'name' => 'Black-Chrome-Dual',
        ]); 

Color::create([
            'icon' => 'https://rnvalves.media/Catalogue/colors/Transparent.jpg',
            'name' => 'Transparent',
        ]);

        /*Size Seeder Start*/

        foreach ($this->sizes as $size) {
            Size::create(["name" => $size]);
        }


        $content = Content::create([
            'title' => "Test Content",
            'uuid' => str()->uuid()->toString(),
            'content' => "Test Content only",
        ]);

        $category = Category::create([
            'discount' => 50,
            'tax' => 18,
            'content_id' => $content->id,
            'name' => "Test Main Category",
            'uuid' => str()->uuid()->toString(),
            'url_key'=> 'test-main-category',
            'title' => "Test Title",
            'keywords' => "shjbsj skh",
            'description' => "akjhg agyatguyatfauri g uiy",
        ]);

        Subcategory::create([
            'content_id' => $content->id,
            'category_id' => $category->id,
            'name' => "Test Category",
            'uuid' => str()->uuid()->toString(),
            'url_key'=> 'test-category',
            'title' => "Test Title",
            'keywords' => "shjbsj skh",
            'description' => "akjhg agyatguyatfauri g uiy",
        ]);


        FrontPage::create([
            'name' => "RN Valves & Faucets",
            'title' => "Perfect Bathroom Solutions and Bathroom Fittings Manufacturer | RN",
            'keywords' => "Bath Accessories, Diverter & Spouts, Eco Faucets, Health & Hygiene, Hoses & Connections, Luxury Faucets, Sensor Faucets, Showers, Single Lever Mixer, Valves",
            'logo' => "RN Valves & Faucets",
            'description' => "RN Valves is a leading manufacturing brand in Bathroom Fittings, Bathroom Accessories, Faucets, Showers. Examine the beautiful collections to know more",
            'mobile' => "1800 12340 0400",
            'email' => "enquiry@rnvalves.com",
            'address' => "B-68 SITE-4 SAHIBABAD Ghaziabad Uttar Pradesh 201010, India",
            'fb_link' => "https://www.facebook.com/rnvalvesandfaucets/",
            'insta_link' => "https://www.instagram.com/rnvalvesandfaucets/",
            'twitter_link' => "https://twitter.com/RNValves",
            'linkedin_link' => "https://www.linkedin.com/company/rn-valves-faucets/",
            'youtube_link' => "https://www.youtube.com/channel/UCpUUF6ZFL88S85IuSsHDRSQ/?sub_confirmation=1",
            'pinterest_link' => "https://www.pinterest.com/infornvalves/",
        ]);

        ShippingCharge::create([
            'w_0_100gm' => 100,
            'w_101_200gm' => 100,
            'w_201_400gm' => 100,
            'w_401_600gm' => 100,
            'w_601_1000gm' => 100,
            'w_1001_1500gm' => 100,
            'w_1501_2000gm' => 100,
            'w_2001_2500gm' => 100,
            'w_2501_3000gm' => 100,
            'w_3001_4000gm' => 100,
            'w_4001_5000gm' => 100,
            'w_5001_10000gm' => 100,
            'w_10001_20000gm' => 100,
            'w_20001_40000gm' => 100,
        ]);
    }
}
