<nav class="navbar navbar-expand-lg bg-white shadow-sm px-4 py-3">

    <div class="container-fluid">

        <!-- Tombol Sidebar -->
        <button class="btn btn-light me-3" id="toggleSidebar">
            <i class="fa-solid fa-bars"></i>
        </button>

        <!-- Judul Halaman -->
        <h4 class="mb-0 fw-bold flex-grow-1">
            @yield('title', 'Dashboard')
        </h4>

        <!-- Tanggal -->
        <div class="text-muted fw-semibold" id="currentDate">
            Loading...
        </div>

    </div>

</nav>