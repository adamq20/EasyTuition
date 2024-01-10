<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
        <img src="{{ asset('template/dist/img/Logo.png') }}" alt="Logo" class="brand-image img-circle">
        <span class="brand-text font-weight-heavy">EasyTuition</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('img/avatar/'.auth()->user()->avatar) }}" class="img-circle" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ url('/profile') }}" class="d-block">{{ auth()->user()->role == 'admin' ? auth()->user()->admin->nama : auth()->user()->siswa->nama }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link {{ Request::is('/') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/tagihan') }}" class="nav-link {{ Request::is('tagihan') || Request::is('tagihan/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-sticky-note"></i>
                        <p>Tagihan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/pembayaran') }}" class="nav-link {{ Request::is('pembayaran') || Request::is('pembayaran/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-money-check"></i>
                        <p>Pembayaran</p>
                    </a>
                </li>
                @if(auth()->user()->role == 'admin')
                    <li class="nav-item">
                        <a href="{{ url('/siswa') }}" class="nav-link {{ Request::is('siswa') || Request::is('siswa/*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Siswa</p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>