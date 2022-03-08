<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
      {{-- <li class="nav-item menu-open">
        <a href="#" class="nav-link active">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>
            Starter Pages
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="far fa-circle nav-icon"></i>
              <p>Active Page</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Inactive Page</p>
            </a>
          </li>
        </ul>
      </li> --}}
      <li class="nav-item">
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>
            Dashboard
            <span class="right badge badge-danger">New</span>
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.branches') }}" class="nav-link {{ request()->is('admin/branches') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>Branches</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.brands') }}" class="nav-link {{ request()->is('admin/brands') ? 'active' : '' }}">
            <i class="nav-icon fas fa-cogs"></i>
          <p>Brands</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.categories') }}" class="nav-link {{ request()->is('admin/categories') ? 'active' : '' }}">
            <i class="nav-icon fas fa-cogs"></i>
          <p>Categories</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.suppliers') }}" class="nav-link {{ request()->is('admin/suppliers') ? 'active' : '' }}">
            <i class="nav-icon fas fa-users"></i>
          <p>Suppliers</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.products') }}" class="nav-link {{ request()->is('admin/products') ? 'active' : '' }}">
            <i class="nav-icon fas fa-cogs"></i>
          <p>Products</p>
        </a>
      </li>
      <li class="nav-item {{ strpos(Request::url(), 'stocks') == true ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ strpos(Request::url(), 'stocks') == true ? 'active' : '' }}">
          <i class="nav-icon fas fa-boxes"></i>
          <p>
            Stocks
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
             <a href="{{ route('admin.stocks') }}" class="nav-link {{ request()->is('admin/stocks/list') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Stocks List</p>
             </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.stocks.productin') }}" class="nav-link {{ request()->is('admin/stocks/productin') ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Product In</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link {{ request()->is('admin/stocks/productout') ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Product Out</p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.users') }}" class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}">
            <i class="nav-icon fas fa-users"></i>
          <p>Users</p>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>{{ __('Logout') }}</p>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
      </li>
    </ul>
  </nav>
