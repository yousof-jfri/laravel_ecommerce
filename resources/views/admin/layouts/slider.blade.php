<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
      <img src="{{ asset('dist/img/AdminLTELogo.png') }} " alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">پنل مدیریت</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="direction: ltr">
      <div style="direction: rtl">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{ auth()->user()->image ? Storage::url(auth()->user()->image) : asset('assets/images/user/1.png') }}" class="img-circle elevation-2" alt="User Image" style="width: 40px; height: 40px;">
          </div>
          <div class="info">
            <a href="#" class="d-block">{{ auth()->user()->name }}</a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <li class="nav-item has-treeview">
              <a href="{{ route('admin.profile') }}" class="nav-link {{ isActive('admin.profile') }}">
                <i class="nav-icon fa fa-user-circle"></i>
                <p>
                  پروفایل
                </p>
              </a>
            </li>
            @can('show-dashboard')
              <li class="nav-item has-treeview">
                <a href="{{ route('admin.') }}" class="nav-link {{ isActive('admin.') }}">
                  <i class="nav-icon fa fa-dashboard"></i>
                  <p>
                    پنل مدیریتی
                  </p>
                </a>
              </li>
            @endcan
           
            @can('show-users')
              <li class="nav-item has-treeview">
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ isActive(['admin.users.index', 'admin.users.create', 'admin.users.edit']) }}">
                  <i class="nav-icon fa fa-user"></i>
                  <p>
                    کاربران
                  </p>
                </a>
              </li>
            @endcan
            
            @can('show-categories')
              <li class="nav-item has-treeview">
                <a href="{{ route('admin.categories.index') }}" class="nav-link {{ isActive(['admin.categories.index', 'admin.categories.edit', 'admin.categories.create', 'admin.categories.addChild']) }}">
                  <i class="nav-icon fa fa-book"></i>
                  <p>
                    دسته بندی ها
                  </p>
                </a>
              </li>
            @endcan
            @can('show-products')
              <li class="nav-item has-treeview">
                <a href="{{ route('admin.products.index') }}" class="nav-link {{ isActive(['admin.products.index', 'admin.products.edit', 'admin.products.create']) }}">
                  <i class="nav-icon fa fa-shopping-bag"></i>
                  <p>
                    محصولات
                  </p>
                </a>
              </li>
            @endcan
            @can('show-comments')
              <li class="nav-item has-treeview">
                <a href="{{ route('admin.discounts.index') }}" class="nav-link {{ isActive(['admin.discounts.index', 'admin.discounts.create', 'admin.discounts.edit']) }}">
                  <i class="nav-icon fa fa-gift"></i>
                  <p>
                    <span>کدهای تخفیف</span>
                  </p>
                </a>
              </li>
            @endcan
            @can('show-comments')
              <li class="nav-item has-treeview">
                <a href="{{ route('admin.comments.index') }}" class="nav-link {{ isActive('admin.comments.index') }}">
                  <i class="nav-icon fa fa-comments"></i>
                  <p>
                    نظرات
                  </p>
                </a>
              </li>
            @endcan
            @can('show-attributes')
              <li class="nav-item has-treeview">
                <a href="{{ route('admin.attributes.index') }}" class="nav-link {{ isActive(['admin.attributes.index', 'admin.attributes.create']) }}">
                  <i class="nav-icon fa fa-comments"></i>
                  <p>
                    ویژه گی ها
                  </p>
                </a>
              </li>
            @endcan

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link {{ isActive(['admin.orders.index', 'admin.orders.show']) }}">
                <i class="nav-icon fa fa-shopping-basket"></i>
                <p>
                  سفارشات
                  <i class="right fa fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview" style="{{ isOpen(['admin.orders.index', 'admin.orders.show']) }}">
                <li class="nav-item">
                  <a href="{{ route('admin.orders.index', 'status=paid') }}" class="nav-link {{ isUrl(route('admin.orders.index', ['status' => 'paid'])) }}">
                    <i class="fa fa-circle-o nav-icon text-info"></i>
                    <p>پرداخت شده</p>
                    <span class="badge badge-info">{{ App\Models\Order::whereStatus('paid')->count() }}</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('admin.orders.index', 'status=unpaid') }}" class="nav-link {{ isUrl(route('admin.orders.index', ['status' => 'unpaid'])) }}">
                    <i class="fa fa-circle-o nav-icon text-warning"></i>
                    <p>پرداخت نشده</p>
                    <span class="badge badge-warning">{{ App\Models\Order::whereStatus('unpaid')->count() }}</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('admin.orders.index', 'status=preparation') }}" class="nav-link {{ isUrl(route('admin.orders.index', ['status' => 'preparation'])) }}">
                    <i class="fa fa-circle-o nav-icon text-primary"></i>
                    <p>در حال اماده سازی</p>
                    <span class="badge badge-primary">{{ App\Models\Order::whereStatus('preparation')->count() }}</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('admin.orders.index', 'status=posted') }}" class="nav-link {{ isUrl(route('admin.orders.index', ['status' => 'posted'])) }}">
                    <i class="fa fa-circle-o nav-icon text-success text-light"></i>
                    <p>ارسال شده</p>
                    <span class="badge badge-light">{{ App\Models\Order::whereStatus('posted')->count() }}</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('admin.orders.index', 'status=recieved') }}" class="nav-link {{ isUrl(route('admin.orders.index', ['status' => 'recieved'])) }}">
                    <i class="fa fa-circle-o nav-icon text-success"></i>
                    <p>دریافت شده</p>
                    <span class="badge badge-success">{{ App\Models\Order::whereStatus('recieved')->count() }}</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('admin.orders.index', 'status=canceled') }}" class="nav-link {{ isUrl(route('admin.orders.index', ['status' => 'canceled'])) }}">
                    <i class="fa fa-circle-o nav-icon text-danger"></i>
                    <p>متوقف شده</p>
                    <span class="badge badge-danger">{{ App\Models\Order::whereStatus('canceled')->count() }}</span>
                  </a>
                </li>
              </ul>
            </li>
            
            @can('acl-control')
               <li class="nav-item has-treeview">
                  <a href="#" class="nav-link {{ isActive(['admin.permissions.index', 'admin.permissions.edit', 'admin.permissions.create', 'admin.roles.index', 'admin.roles.create', 'admin.roles.edit']) }}">
                    <i class="nav-icon fa fa-pie-chart"></i>
                    <p>
                      سیستم کنترل دسترسی
                      <i class="right fa fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview" style="{{ isOpen(['admin.permissions.index', 'admin.permissions.edit', 'admin.permissions.create', 'admin.roles.index', 'admin.roles.create', 'admin.roles.edit']) }}">
                    <li class="nav-item">
                      <a href="{{ route('admin.permissions.index') }}" class="nav-link {{ isActive(['admin.permissions.index', 'admin.permissions.edit', 'admin.permissions.create']) }}">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>دسترسی ها</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ route('admin.roles.index') }}" class="nav-link {{ isActive(['admin.roles.index', 'admin.roles.create', 'admin.roles.edit']) }}">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>مقام ها</p>
                      </a>
                    </li>
                  </ul>
                </li>
            @endcan            
           
            <li class="nav-item has-treeview">
              <form action="{{ route('logout') }}" id="logout" method="POST"> @csrf </form>
                <a class="nav-link" onclick="$('#logout').submit()">
                  <i class="nav-icon fa fa-sign-out"></i>
                  <p>
                    خروج
                  </p>
                </a>
              </form>
              
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
    </div>
    <!-- /.sidebar -->
</aside>