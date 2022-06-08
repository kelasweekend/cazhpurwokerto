<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the  -->
        <li class="nav-item">
            <a href="{{ route('index') }}" class="nav-link text-light {{ Route::is('index') ? 'active' : '' }}">
                <i class="nav-icon fas fa-home"></i>
                <p>
                    Dashboard
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('company.index') }}" class="nav-link text-light {{ Route::is('company.index') ? 'active' : '' }}">
                <i class="nav-icon fas fa-building"></i>
                <p>
                    Companies
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('employee.index') }}" class="nav-link text-light {{ Route::is('employee.index') ? 'active' : '' }}">
                <i class="nav-icon fas fa-users"></i>
                <p>
                    Employee
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('history') }}" class="nav-link text-light {{ Route::is('history') ? 'active' : '' }}">
                <i class="nav-icon fas fa-money-bill-wave-alt"></i>
                <p>
                    Transaksi
                </p>
            </a>
        </li>

    </ul>
</nav>
<!-- /.sidebar-menu -->
