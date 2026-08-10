<div id="sidebar" class="sidebar bg-primary text-white d-flex flex-column shadow">
        <!-- Logo -->
        <div class="logo text-center py-4 border-bottom">
            <div style="font-size:45px">🍦</div>
            <div class="logo-text">
                <h5 class="text-white">Ice Cream Firda</h5>
                <small class="text-white-50">Point of Sale</small>
            </div>
        </div>

        <!-- Menu -->
        <div class="flex-grow-1 p-3">
            <a href="{{ route('dashboard') }}"
                class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-pie"></i>
                <span>Dashboard</span>
            </a>

            <a href="#" class="menu-link">
                <i class="fas fa-cash-register"></i>
                <span>Kasir</span>
            </a>

            <a href="#" class="menu-link">
                <i class="fas fa-ice-cream"></i>
                <span>Produk</span>
            </a>

            <a href="#" class="menu-link">
                <i class="fas fa-store"></i>
                <span>Mitra Warung</span>
            </a>

            <a href="#" class="menu-link">
                <i class="fas fa-box"></i>
                <span>Stok</span>
            </a>

            <a href="#" class="menu-link">
                <i class="fas fa-receipt"></i>
                <span>Transaksi</span>
            </a>

            @if(Auth::user()->role == 'admin')
            <a href="#" class="menu-link">
                <i class="fas fa-wallet"></i>
                <span>Pembukuan</span>
            </a>

            <a href="#" class="menu-link">
                <i class="fas fa-chart-line"></i>
                <span>Laporan</span>
            </a>

            <a href="#" class="menu-link">
                <i class="fas fa-cog"></i>
                <span>Pengaturan</span>
            </a>

            <a href="#" class="menu-link">
                <i class="fas fa-users"></i>
                <span>Kelola User</span>
            </a>
            @endif
        </div>

    <!-- User -->
    <div class="border-top p-3 user-info">
        <div class="d-flex align-items-center">
            <div class="user-avatar me-3"><i class="fas fa-user-circle fa-2x text-white"></i></div>
            <div class="user-text">
                <div class="user-name fw-bold text-white">{{ Auth::user()->name }}</div>
                <small class="user-role text-white-50">{{ ucfirst(Auth::user()->role) }}</small>
            </div>
        </div>

        <form action="{{ route('logout') }}" method="POST" class="mt-3">
            @csrf

            <button class="logout-btn">

                <i class="fas fa-sign-out-alt"></i>

                <span class="ms-2">

                    Logout

                </span>

            </button>
        </form>
    </div>
    
    
</div>