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
        <a href="{{ route('staff.dashboard') }}" class="nav-link {{ request()->is('staff/dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>
            Dashboard
            @if (Auth::user()->branch_id == 2)
                <span class="right badge badge-danger">New</span>
            @endif

          </p>
        </a>
      </li>
      {{-- <li class="nav-item">
        <a href="{{ route('admin.branches') }}" class="nav-link {{ request()->is('staff/branches') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>Branches</p>
        </a>
      </li> --}}
       <li class="nav-item">
        <a href="{{ route('staff.customers') }}" class="nav-link {{ request()->is('staff/customers') ? 'active' : '' }}">
            <i class="nav-icon fas fa-users"></i>
          <p>Customers</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('staff.brands') }}" class="nav-link {{ request()->is('staff/brands') ? 'active' : '' }}">
            <i class="nav-icon fas fa-cogs"></i>
          <p>Brands</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('staff.categories') }}" class="nav-link {{ request()->is('staff/categories') ? 'active' : '' }}">
            <i class="nav-icon fas fa-cogs"></i>
          <p>Categories</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('staff.suppliers') }}" class="nav-link {{ request()->is('staff/suppliers') ? 'active' : '' }}">
            <i class="nav-icon fas fa-users"></i>
          <p>Suppliers</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('staff.products') }}" class="nav-link {{ request()->is('staff/products') ? 'active' : '' }}">
            <i class="nav-icon fas fa-cogs"></i>
          <p>Products</p>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('staff.truckinventories') }}" class="nav-link {{ request()->is('staff/truckinventories') ? 'active' : '' }}">
            <i class="nav-icon fas fa-truck"></i>
          <p>Truck Inventory</p>
        </a>
      </li>
      {{-- <li class="nav-item {{ strpos(Request::url(), 'stocks') == true ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ strpos(Request::url(), 'stocks') == true ? 'active' : '' }}">
          <i class="nav-icon fas fa-boxes"></i>
          <p>
            Stocks
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
             <a href="{{ route('staff.stocks') }}" class="nav-link {{ request()->is('staff/stocks/list') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Stocks List</p>
             </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('staff.stocks.productin') }}" class="nav-link {{ request()->is('staff/stocks/productin') ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Product In</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('staff.stocks.productout') }}" class="nav-link {{ request()->is('staff/stocks/productout') ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Truck Loading/Return</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('staff.stock.return') }}" class="nav-link {{ request()->is('staff/stocks/return') ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Stock Return</p>
            </a>
          </li>
        </ul>
      </li> --}}

      <li class="nav-item {{ strpos(Request::url(), 'reports') == true ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ strpos(Request::url(), 'reports') == true ? 'active' : '' }}">
          <i class="nav-icon fas fa-boxes"></i>
          <p>
            Reports
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
             <a href="#" class="nav-link {{ request()->is('staff/reports/sales') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Sales Report</p>
             </a>
          </li>

        </ul>
      </li>

      <li class="nav-item">
        <a href="{{ route('staff.employees') }}" class="nav-link {{ request()->is('staff/employees') ? 'active' : '' }}">
            <i class="nav-icon fas fa-users"></i>
          <p>Employees</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('staff.receipts') }}" class="nav-link {{ request()->is('staff/receipts') ? 'active' : '' }}">
            <i class="nav-icon fas fa-money-check"></i>
          <p>Receipts</p>
        </a>
      </li>
      {{-- <li class="nav-item">
        <a href="{{ route('staff.users') }}" class="nav-link {{ request()->is('staff/users') ? 'active' : '' }}">
            <i class="nav-icon fas fa-users"></i>
          <p>Users</p>
        </a>
      </li> --}}
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
