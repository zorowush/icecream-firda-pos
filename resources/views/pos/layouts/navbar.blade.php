<nav class="navbar navbar-expand-lg bg-white shadow-sm px-4">

    <div class="container-fluid">

        <div class="d-flex align-items-center">

            <button
                id="toggleSidebar"
                class="btn btn-outline-primary me-3">

                <i class="fas fa-bars"></i>

            </button>

            <h3>
                @yield('title')
            </h3>

        </div>

        <div>

            {{ now()->locale('id')->translatedFormat('l, d F Y') }}

        </div>

    </div>

</nav>