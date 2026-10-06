<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - Perpustakaan Digital</title>

    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.26.25/sweetalert2.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/4.0.0/jquery.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.26.25/sweetalert2.all.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @stack('style')
</head>
<body class="@auth sb-nav-fixed @else bg-light @endauth">

    @auth
        @include('layouts.inc.navbar')

        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                @include('layouts.inc.sidebar')
            </div>

            <div id="layoutSidenav_content">
                <main>
                    @yield('content')
                </main>
                @include('layouts.inc.footer')
            </div>
        </div>
    @else
        {{-- Tamu (belum login): tanpa sidebar --}}
        <main class="min-vh-100 d-flex align-items-center">
            <div class="container">
                @yield('content')
            </div>
        </main>
    @endauth

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>

    @stack('script')
</body>
</html>
