<aside id="sidebar" class="sidebar">

    <!-- Logo -->
    <div class="sidebar-header">
        <div class="logo">
            🍦
        </div>

        <div>
            <h4>Ice Cream Firda</h4>
            <small>Point of Sale</small>
        </div>
    </div>

    <!-- Menu -->
    <ul class="sidebar-menu">

        <li>
            <a href="{{ route('dashboard') }}"
               class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-pie"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li>
            <a href="{{ route('cashier') }}"
               class="{{ request()->routeIs('cashier') ? 'active' : '' }}">
                <i class="fas fa-cash-register"></i>
                <span>Kasir</span>
            </a>
        </li>

        <li>
            <a href="{{ route('products') }}"
               class="{{ request()->routeIs('products') ? 'active' : '' }}">
                <i class="fas fa-ice-cream"></i>
                <span>Produk</span>
            </a>
        </li>

        <li>
            <a href="{{ route('partners') }}"
               class="{{ request()->routeIs('partners') ? 'active' : '' }}">
                <i class="fas fa-store"></i>
                <span>Mitra Warung</span>
            </a>
        </li>

        <li>
            <a href="{{ route('stocks') }}"
               class="{{ request()->routeIs('stocks') ? 'active' : '' }}">
                <i class="fas fa-box"></i>
                <span>Stok</span>
            </a>
        </li>

        <li>
            <a href="{{ route('transactions') }}"
               class="{{ request()->routeIs('transactions') ? 'active' : '' }}">
                <i class="fas fa-receipt"></i>
                <span>Transaksi</span>
            </a>
        </li>

        @if(Auth::user()->role == 'admin')

        <li>
            <a href="{{ route('bookkeeping') }}"
               class="{{ request()->routeIs('bookkeeping') ? 'active' : '' }}">
                <i class="fas fa-wallet"></i>
                <span>Pembukuan</span>
            </a>
        </li>

        <li>
            <a href="{{ route('reports') }}"
               class="{{ request()->routeIs('reports') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                <span>Laporan</span>
            </a>
        </li>

        <li>
            <a href="{{ route('settings') }}"
               class="{{ request()->routeIs('settings') ? 'active' : '' }}">
                <i class="fas fa-cog"></i>
                <span>Pengaturan</span>
            </a>
        </li>

        @endif

    </ul>

    <!-- Footer Sidebar -->
    <div class="sidebar-footer">

        <a href="{{ route('profile.edit') }}"
        class="user-info text-decoration-none text-white">

            <div class="avatar">
                <i class="fas fa-user"></i>
            </div>

            <div>
                <strong>{{ Auth::user()->name }}</strong>
                <small>{{ ucfirst(Auth::user()->role) }}</small>
            </div>

        </a>

        

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button class="logout-btn">

                <i class="fas fa-sign-out-alt"></i>

                <span class="ms-2">
                    Logout
                </span>

            </button>

        </form>

    </div>

</aside>