@php
  $frontPage = frontPage();
@endphp
 <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link @if(request()->routeIs('dashboard') ) active @else collapsed @endif" href="{{ route('dashboard') }}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      @canany(['country-list' , 'state-list' , 'city-list' , 'pincode-list', 'brand-list', 'shipping_charge-list','frontPage-edit'])
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#settings" data-bs-toggle="collapse" href="#">
          <i class="bx bxs-key"></i><span class="left-menu">Settings</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="settings" class="nav-content collapse 
          @if(
            request()->routeIs('countries.index') ||
            request()->routeIs('countries.edit') ||
            request()->routeIs('countries.create') ||

            request()->routeIs('states.index') ||
            request()->routeIs('states.edit') ||
            request()->routeIs('states.create') ||

            request()->routeIs('cities.index') ||
            request()->routeIs('cities.edit') ||
            request()->routeIs('cities.create') ||
            request()->routeIs('cities.import_cities') ||

            request()->routeIs('pincodes.index') ||
            request()->routeIs('pincodes.edit') ||
            request()->routeIs('pincodes.show') ||
            request()->routeIs('pincodes.create')||
            request()->routeIs('pincodes.import_pincodes') ||
            
            request()->routeIs('brands.index') ||
            request()->routeIs('brands.show') ||
            
            request()->routeIs('frontPages.edit') ||

            request()->routeIs('shippingCharges.index') ||
            request()->routeIs('shippingCharges.edit') ||
            request()->routeIs('shippingCharges.create')
            ) show @endif
          " data-bs-parent="#sidebar-nav">
          @can('country-list')
          <li>
            <a href="{{ route('countries.index') }}" class="@if(request()->routeIs('countries.index') || request()->routeIs('countries.create') || request()->routeIs('countries.edit')) active @endif">
              <i class="bi bi-circle"></i><span class="left-menu">Countries</span>
              <span class="right-menu">{{ App\Models\Country::count() }}</span>
            </a>
          </li>
          @endcan

          @can('state-list')
          <li>
            <a href="{{ route('states.index') }}" class="@if(request()->routeIs('states.index') || request()->routeIs('states.create') || request()->routeIs('states.edit')) active @endif">
              <i class="bi bi-circle"></i><span class="left-menu">States</span>
              <span class="right-menu">{{ App\Models\State::count() }}</span>
            </a>
          </li>
          @endcan

          @can('city-list')
          <li>
            <a href="{{ route('cities.index') }}" class="@if(request()->routeIs('cities.index') || request()->routeIs('cities.create') || request()->routeIs('cities.edit') || request()->routeIs('cities.import_cities')) active @endif">
              <i class="bi bi-circle"></i><span class="left-menu">Cities</span>
              <span class="right-menu">{{ App\Models\City::count() }}</span>
            </a>
          </li>
          @endcan

          @can('pincode-list')
          <li>
            <a href="{{ route('pincodes.index') }}" class="@if(request()->routeIs('pincodes.index') || request()->routeIs('pincodes.create') || request()->routeIs('pincodes.edit') || request()->routeIs('pincodes.show') || request()->routeIs('pincodes.import_pincodes')) active @endif">
              <i class="bi bi-circle"></i>
              <span class="left-menu">Pincodes</span>
              <span class="right-menu">{{ App\Models\Pincode::count() }}</span>
            </a>
          </li>
          @endcan

          @can('brand-list')
          <li>
            <a href="{{ route('brands.index') }}" class="@if(request()->routeIs('brands.index') || request()->routeIs('brands.show') ) active @endif">
              <i class="bi bi-circle"></i>
              <span class="left-menu">Brands</span>
              <span class="right-menu">{{ App\Models\Brand::count() }}</span>
            </a>
          </li>
          @endcan


          @can('shipping_charge-list')
          <li>
            <a href="{{ route('shippingCharges.index') }}" class="@if(request()->routeIs('shippingCharges.index') || request()->routeIs('shippingCharges.show') || request()->routeIs('shippingCharges.edit') ) active @endif">
              <i class="bi bi-circle"></i>
              <span class="left-menu">Shipping Weight Charges</span>
              <span class="right-menu">{{ App\Models\ShippingCharge::count() }}</span>
            </a>
          </li>
          @endcan
        </ul>
      </li><!-- End Components Nav -->
      @endcan


      @canany(['user-list' , 'permission-list' , 'role-list' , 'remark-list', 'material-list'])
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bx bxl-mastercard"></i><span class="left-menu">Master</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse 
          @if(
            request()->routeIs('users.index') ||
            request()->routeIs('users.create') ||
            request()->routeIs('users.edit') || 
            request()->routeIs('users.show') || 

            request()->routeIs('permissions.index') ||
            request()->routeIs('permissions.create') ||
            request()->routeIs('permissions.edit') ||

            request()->routeIs('roles.index') ||
            request()->routeIs('roles.create') ||
            request()->routeIs('roles.edit')||

            request()->routeIs('remarks.index') ||
            request()->routeIs('remarks.edit') ||
            request()->routeIs('remarks.create') ||
            request()->routeIs('remarks.show') ||
            
            request()->routeIs('materials.index') ||
            request()->routeIs('materials.create')  ||
            request()->routeIs('materials.edit')  ||
            request()->routeIs('materials.show') ||
            
            request()->routeIs('sliders.index') ||
            request()->routeIs('sliders.create')  ||
            request()->routeIs('sliders.edit') ||
            
            request()->routeIs('discounts.index') ||
            request()->routeIs('discounts.create')  ||
            request()->routeIs('discounts.edit')  ||
            request()->routeIs('discounts.show')
          ) show @endif
          " data-bs-parent="#sidebar-nav">

          @can('user-list')
          <li>
            <a href="{{ route('users.index') }}" class="@if(request()->routeIs('users.index') || request()->routeIs('users.create') || request()->routeIs('users.edit') || request()->routeIs('users.show')) active @endif">
              <i class="bi bi-circle"></i><span class="left-menu">Users</span>
              <span class="right-menu">{{ App\Models\User::where('user_type','Employee')->whereNotIn('id',[1])->count() }}</span>
            </a>
          </li>
          @endcan

          @can('permissions-list')
          <li>
            <a href="{{ route('permissions.index') }}" class="@if(request()->routeIs('permissions.index') || request()->routeIs('permissions.create') || request()->routeIs('permissions.edit')) active @endif">
              <i class="bi bi-circle"></i><span class="left-menu">Permissions</span>
            </a>
          </li>
          @endcan

          @can('role-list')
          <li>
            <a href="{{ route('roles.index') }}" class="@if(request()->routeIs('roles.index') || request()->routeIs('roles.create') || request()->routeIs('roles.edit')) active @endif">
              <i class="bi bi-circle"></i><span class="left-menu">User Roles</span>
            </a>
          </li>
          @endcan

          @can('remark-list')
          <li>
            <a href="{{ route('remarks.index') }}" class="@if(request()->routeIs('remarks.index') || request()->routeIs('remarks.create') || request()->routeIs('remarks.edit') || request()->routeIs('remarks.show') ) active @endif">
              <i class="bi bi-circle"></i>
              <span class="left-menu">Remarks</span>
              <span class="right-menu">{{ App\Models\Remark::count() }}</span>
            </a>
          </li>
          @endcan

          @can('material-list')
          <li>
            <a href="{{ route('materials.index') }}" class="@if(request()->routeIs('materials.index') || request()->routeIs('materials.create') || request()->routeIs('materials.edit') || request()->routeIs('materials.show') ) active @endif">
              <i class="bi bi-circle"></i>
              <span class="left-menu">Materials</span>
              <span class="right-menu">{{ App\Models\Material::count() }}</span>
            </a>
          </li>
          @endcan

          @can('slider-list')
          <li>
            <a href="{{ route('sliders.index') }}" class="@if(request()->routeIs('sliders.index') || request()->routeIs('sliders.create') || request()->routeIs('sliders.edit') || request()->routeIs('sliders.show') ) active @endif">
              <i class="bi bi-circle"></i>
              <span class="left-menu">Website Banner</span>
              <span class="right-menu">{{ App\Models\Slider::count() }}</span>
            </a>
          </li>
          @endcan

          @can('discount-list')
          <li>
            <a href="{{ route('discounts.index') }}" class="@if(request()->routeIs('discounts.index') || request()->routeIs('discounts.create') || request()->routeIs('discounts.edit') || request()->routeIs('discounts.show') ) active @endif">
              <i class="bi bi-circle"></i>
              <span class="left-menu">Discount Code</span>
              <span class="right-menu">{{ App\Models\Discount::count() }}</span>
            </a>
          </li>
          @endcan
        </ul>
      </li><!-- End Components Nav -->
      @endcan

      @canany(['content-list','category-list','subcategory-list','size-list','color-list','product-list','create-new-product-color','create-new-product-size','product-excel-upload','product-bullet-point-list'])
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#catalogue" data-bs-toggle="collapse" href="#">
          <i class="bx bx-folder-plus"></i><span class="left-menu">Catalogue</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="catalogue" class="nav-content collapse 
          @if(
            request()->routeIs('contents.index') ||
            request()->routeIs('contents.edit') ||
            request()->routeIs('contents.create') ||
            request()->routeIs('contents.show') ||

            request()->routeIs('categories.index') ||
            request()->routeIs('categories.edit') ||
            request()->routeIs('categories.show') ||
            request()->routeIs('categories.create') ||

            request()->routeIs('subcategories.index') ||
            request()->routeIs('subcategories.edit') ||
            request()->routeIs('subcategories.show') ||
            request()->routeIs('subcategories.create') ||

            request()->routeIs('sizes.index') ||
            request()->routeIs('sizes.edit') ||
            request()->routeIs('sizes.show') ||
            request()->routeIs('sizes.create') ||

            request()->routeIs('colors.index') ||
            request()->routeIs('colors.edit') ||
            request()->routeIs('colors.show') ||
            request()->routeIs('colors.create') ||

            request()->routeIs('products.index') ||
            request()->routeIs('products.edit') ||
            request()->routeIs('products.show') ||
            request()->routeIs('products.create') ||

            request()->routeIs('products.addNewColor') ||
            request()->routeIs('products.addNewSize') ||

            request()->routeIs('products.import_products') ||

            request()->routeIs('productImages.index') ||
            request()->routeIs('productImages.edit') ||
            request()->routeIs('productImages.show') ||
            request()->routeIs('productImages.create') ||
            request()->routeIs('productImages.import_productImages') ||

            request()->routeIs('productBullets.index') ||
            request()->routeIs('productBullets.edit') ||
            request()->routeIs('productBullets.show') ||
            request()->routeIs('productBullets.create')||

            request()->routeIs('catalogue.index') ||
            request()->routeIs('catalogue.edit') ||
            request()->routeIs('catalogue.show') ||
            request()->routeIs('catalogue.create')
            ) show @endif
          " data-bs-parent="#sidebar-nav">

          @can('content-list')
          <li>
            <a href="{{ route('contents.index') }}" class="@if(request()->routeIs('contents.index') || request()->routeIs('contents.show') || request()->routeIs('contents.create') || request()->routeIs('contents.edit')) active @endif">
              <i class="bi bi-circle"></i><span class="left-menu">Content Master</span>
              <span class="right-menu">{{ App\Models\Content::count() }}</span>
            </a>
          </li>
          @endcan
          @if(auth()->user()->hasAnyRole(['Super_Admin','Admin']))
          <li>
            <a href="{{ route('catalogue.index') }}" class="@if(request()->routeIs('catalogue.index') || request()->routeIs('catalogue.show') || request()->routeIs('catalogue.create') || request()->routeIs('catalogue.edit')) active @endif">
              <i class="bi bi-circle"></i><span class="left-menu">Catalogue</span>
              <span class="right-menu">{{ App\Models\Catalogue::count() }}</span>
            </a>
          </li>
          @endif
          @can('catalogue.index')
          <li>
            <a href="{{ route('catalogue.index') }}" class="@if(request()->routeIs('catalogue.index') || request()->routeIs('catalogue.show') || request()->routeIs('catalogue.create') || request()->routeIs('catalogue.edit')) active @endif">
              <i class="bi bi-circle"></i><span class="left-menu">Catalogue</span>
              <span class="right-menu">{{ App\Models\Catalogue::count() }}</span>
            </a>
          </li>
          @endcan

          @can('size-list')
          <li>
            <a href="{{ route('sizes.index') }}" class="@if(request()->routeIs('sizes.index') || request()->routeIs('sizes.show') || request()->routeIs('sizes.create') || request()->routeIs('sizes.edit')) active @endif">
              <i class="bi bi-circle"></i><span class="left-menu">Size Master</span>
              <span class="right-menu">{{ App\Models\Size::count() }}</span>
            </a>
          </li>
          @endcan

          @can('color-list')
          <li>
            <a href="{{ route('colors.index') }}" class="@if(request()->routeIs('colors.index') || request()->routeIs('colors.show') || request()->routeIs('colors.create') || request()->routeIs('colors.edit')) active @endif">
              <i class="bi bi-circle"></i><span class="left-menu">Color Master</span>
              <span class="right-menu">{{ App\Models\Color::count() }}</span>
            </a>
          </li>
          @endcan

          @can('product-bullet-point-list')
          <li>
            <a href="{{ route('productBullets.index') }}" class="@if(request()->routeIs('productBullets.index') || request()->routeIs('productBullets.show') || request()->routeIs('productBullets.create') || request()->routeIs('productBullets.edit')) active @endif">
              <i class="bi bi-circle"></i><span class="left-menu">Product Bullet Points</span>
              <span class="right-menu">{{ App\Models\ProductBullet::count() }}</span>
            </a>
          </li>
          @endcan

          @can('category-list')
          <li>
            <a href="{{ route('categories.index') }}" class="@if(request()->routeIs('categories.index') || request()->routeIs('categories.show') || request()->routeIs('categories.create') || request()->routeIs('categories.edit')) active @endif">
              <i class="bi bi-circle"></i><span class="left-menu">Category</span>
              <span class="right-menu">{{ App\Models\Category::count() }}</span>
            </a>
          </li>
          @endcan

          @can('subcategory-list')
          <li>
            <a href="{{ route('subcategories.index') }}" class="@if(request()->routeIs('subcategories.index') || request()->routeIs('subcategories.show') || request()->routeIs('subcategories.create') || request()->routeIs('subcategories.edit')) active @endif">
              <i class="bi bi-circle"></i><span class="left-menu">SubCategory</span>
              <span class="right-menu">{{ App\Models\Subcategory::count() }}</span>
            </a>
          </li>
          @endcan

          @can('product-list')
          <li>
            <a href="{{ route('products.index') }}" class="@if(request()->routeIs('products.index') || request()->routeIs('products.show') || request()->routeIs('products.create') || request()->routeIs('products.edit') || request()->routeIs('products.addNewColor') || request()->routeIs('products.addNewSize') || request()->routeIs('products.import_products')) active @endif">
              <i class="bi bi-circle"></i><span class="left-menu">Products</span>
              <span class="right-menu">{{ App\Models\Product::count() }}</span>
            </a>
          </li>
          @endcan

          @can('productImage-list')
          <li>
            <a href="{{ route('productImages.index') }}" class="@if(request()->routeIs('productImages.index') || request()->routeIs('productImages.show') || request()->routeIs('productImages.create') || request()->routeIs('productImages.edit') || request()->routeIs('productImages.import_productImages') ) active @endif">
              <i class="bi bi-circle"></i><span class="left-menu">Product Images</span>
              <span class="right-menu">{{ App\Models\ProductImage::count() }}</span>
            </a>
          </li>
          @endcan

        </ul>
      </li><!-- End Components Nav -->
      @endcan


      {{-- Report Center Start --}}
      @canany(['remark-log-list','order-cancel-log-list'])
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#report" data-bs-toggle="collapse" href="#">
          <i class="bx bxs-report"></i><span class="left-menu">Reports</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="report" class="nav-content collapse 
          @if(
            request()->routeIs('remarkLogs.index') ||
            request()->routeIs('order_cancel_log_list') ||
            request()->routeIs('order.reports')
          ) show @endif
          " data-bs-parent="#sidebar-nav">

          @can('remark-log-list')
          <li>
            <a href="{{ route('remarkLogs.index') }}" class="@if(request()->routeIs('remarkLogs.index') ) active @endif">
              <i class="bi bi-circle"></i><span class="left-menu">Remark Logs</span>
              <span class="right-menu">
          
                {{ App\Models\RemarkLog::count() }}
              
              </span>
            </a>
          </li>
          @endcan

          @can('order-cancel-log-list')
          <!-- <li>
            <a href="{{ route('order_cancel_log_list') }}" class="@if(request()->routeIs('order_cancel_log_list') ) active @endif">
              <i class="bi bi-circle"></i><span class="left-menu">Order Cancel Logs</span>
              <span class="right-menu">
                {{ App\Models\OrderCancelLog::count() }}
              </span>
            </a>
          </li> -->
          <li>
            <a href="{{ route('order.reports') }}" class="@if(request()->routeIs('order.reports') ) active @endif">
              <i class="bi bi-circle"></i><span class="left-menu">Orders</span>
            </a>
          </li>
          <li>
            <a href="{{ route('product.reports') }}" class="@if(request()->routeIs('product.reports') ) active @endif">
              <i class="bi bi-circle"></i><span class="left-menu">Product Report</span>
            
            </a>
          </li>
          @endcan
        </ul>
      </li>
      @endcan
      {{-- Report Center End --}}

      <li class="nav-heading">Others</li>

      @can('customer-index')
      <li class="nav-item">
        <a class="nav-link @if(request()->routeIs('users.customer_network') || request()->routeIs('customers.index') || request()->routeIs('customers.create') || request()->routeIs('customers.edit') || request()->routeIs('customers.show') ) active @else collapsed @endif" href="{{ route('users.customer_network') }}">
          <i class="bx bxs-user-detail"></i>
          <span class="left-menu">Customer Network</span>
          @if(auth()->user()->hasAnyRole(['Super_Admin','Admin','Estimater','Digital Marketer']))
            <span class="right-menu">{{ App\Models\User::where(['user_type'=>'Customer'])->whereNotIn('id',[1])->count() }}</span>
          @else
            <span class="right-menu">{{ App\Models\User::where(['user_type'=>'Customer', 'sales_user_id'=>auth()->user()->id])->whereNotIn('id',[1])->count() }}</span>
          @endif
        </a>
      </li>
      <!-- End Profile Page Nav -->
      @endcan

      @can('enquiry-list')
      <li class="nav-item">
        <a class="nav-link @if(request()->routeIs('enquiries.index') || request()->routeIs('enquiries.create') || request()->routeIs('enquiries.edit') || request()->routeIs('enquiries.show') ) active @else collapsed @endif" href="{{ route('enquiries.index') }}">
          <i class="bx bx-list-ol"></i>
          <span class="left-menu">Enquiries</span>
          <span class="right-menu">
            @if(auth()->user()->hasAnyRole(['Super_Admin','Admin','Digital Marketer']))
            {{ App\Models\Enquiry::count() }}
            @else
            {{ App\Models\Enquiry::where(['salesmen_id'=>auth()->user()->id])->count() }}
            @endif
          </span>
        </a>
      </li>
      @endcan

      @can('order-list')
      <li class="nav-item">
        <a class="nav-link @if(request()->routeIs('orders.index') || request()->routeIs('orders.create') || request()->routeIs('orders.edit') || request()->routeIs('orders.show') ) active @else collapsed @endif" href="{{ route('orders.index') }}">
          <i class="bx bx-cart-alt"></i>
          <span class="left-menu">Orders</span>
          <span class="right-menu">
            {{ App\Models\Order::count() }}
          </span>
        </a>
      </li>
      @endcan

      @can('payment-list')
      <li class="nav-item">
        <a class="nav-link @if(request()->routeIs('payments.index') || request()->routeIs('payments.create') || request()->routeIs('payments.edit') || request()->routeIs('payments.show') ) active @else collapsed @endif" href="{{ route('payments.index') }}">
          <i class="bx bx-credit-card"></i>
          <span class="left-menu">Payments</span>
          <span class="right-menu">
            {{ App\Models\Payment::count() }}
          </span>
        </a>
      </li>
      @endcan

      @can('career-list')
      <li class="nav-item">
        <a class="nav-link @if(request()->routeIs('careers.index') || request()->routeIs('careers.create') || request()->routeIs('careers.edit') || request()->routeIs('careers.show') ) active @else collapsed @endif" href="{{ route('careers.index') }}">
          <i class="bx bx-group"></i>
          <span class="left-menu">Jobs/Careers</span>
          <span class="right-menu">
            {{ App\Models\Career::count() }}
          </span>
        </a>
      </li>
      @endcan

      @can('blog-list')
      <li class="nav-item">
        <a class="nav-link @if(request()->routeIs('blogs.index') || request()->routeIs('blogs.create') || request()->routeIs('blogs.edit') || request()->routeIs('blogs.show') ) active @else collapsed @endif" href="{{ route('blogs.index') }}">
          <i class="bx bx-group"></i>
          <span class="left-menu">Blogs</span>
          <span class="right-menu">
            {{ App\Models\Blog::count() }}
          </span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link @if(request()->routeIs('news.index') || request()->routeIs('news.create') || request()->routeIs('news.edit') || request()->routeIs('news.show') ) active @else collapsed @endif" href="{{ route('news.index') }}">
          <i class="bx bx-group"></i>
          <span class="left-menu">News</span>
          <span class="right-menu">
            {{ App\Models\News::count() }}
          </span>
        </a>
      </li>
      @endcan

      @can('bullet-point-list')
      <li class="nav-item">
        <a class="nav-link @if(request()->routeIs('bPoints.index') || request()->routeIs('bPoints.create') || request()->routeIs('bPoints.edit') || request()->routeIs('bPoints.show') ) active @else collapsed @endif" href="{{ route('bPoints.index') }}">
          <i class="bx bx-group"></i>
          <span class="left-menu">Bullet Points</span>
          <span class="right-menu">
            {{ App\Models\BPoint::count() }}
          </span>
        </a>
      </li>
      @endcan

      <li class="nav-heading">Content Settings</li>

      @canany(['frontPage-edit'])
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#pagesettings" data-bs-toggle="collapse" href="#">
          <i class="bx bxs-key"></i><span class="left-menu">Content Settings</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="pagesettings" class="nav-content collapse 
          @if(
            request()->routeIs('page.index') ||
            request()->routeIs('frontPages.edit') ||
            request()->routeIs('page.about_us') ||
            request()->routeIs('faq.index')

          
            ) show @endif
          " data-bs-parent="#sidebar-nav">
       
          @can('frontPage-edit')
          <li>
            <a href="{{ route('frontPages.edit',['frontPage'=>$frontPage]) }}" class="@if(request()->routeIs('frontPages.edit')  ) active @endif">
              <i class="bi bi-circle"></i>
              <span class="left-menu">Website Home Setting</span>
            </a>
          </li>
          <li>
            <a href="{{ route('page.index') }}" class="@if(request()->routeIs('page.index')  ) active @endif">
              <i class="bi bi-circle"></i>
              <span class="left-menu">Pages</span>
            </a>
          </li>
          <li>
            <a href="{{ route('page.about_us') }}" class="@if(request()->routeIs('page.about_us')  ) active @endif">
              <i class="bi bi-circle"></i>
              <span class="left-menu">About Us</span>
            </a>
          </li>
          <li>
            <a href="{{ route('faq.index') }}" class="@if(request()->routeIs('faq.index')  ) active @endif">
              <i class="bi bi-circle"></i>
              <span class="left-menu">FAQs</span>
            </a>
          </li>
          @endcan
        </ul>
      </li><!-- End Components Nav -->
      @endcan

      <!-- End Blank Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->
