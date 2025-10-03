<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ url('admin/dashboard') }}" class="brand-link">
        <span class="brand-text">Admin</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column">
                <li class="nav-item">
                    <a href="{{ url('admin/dashboard') }}"
                        class="nav-link {{ request()->segment(2) == 'dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p> Dashboard </p>
                    </a>
                </li>

                <li class="nav-item {{ request()->type == 'Seller' || request()->type == 'Buyer' ? 'menu-open active' : '' }}">
                    <a href="#" class="nav-link {{ request()->type == 'Seller' || request()->type == 'Buyer' ? 'active' : '' }}">
                     <i class="nav-icon fas fa-users"></i>
                        <p>User Management<i class="fas fa-angle-left right"></i> </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('admin/users?type=Seller') }}" class="nav-link {{ request()->type == 'Seller' ? 'active' : '' }} ">
                               <i class="far fa-circle nav-icon"></i>
                               <p>Seller</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/users?type=Buyer') }}" class="nav-link {{ request()->type == 'Buyer' ? 'active' : '' }} ">
                               <i class="far fa-circle nav-icon"></i>
                               <p>Buyer</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ url('admin/products') }}"
                        class="nav-link {{ request()->segment(2) == 'products' || request()->segment(2) == 'add-product' || request()->segment(2) == 'edit-product' || request()->segment(2) == 'view-product' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-store"></i>
                        <p>Product Management</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('admin/logout') }}" class="nav-link"> <i class="nav-icon fas fa-sign-out"></i>
                        <p> Logout </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
