<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Centro Educativo')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>

        html {
            overflow-y: scroll;
        }

        body {
            background: #f5f7fa;
            overflow-y: scroll;
        }

        .swal2-container {
            z-index: 9999 !important;
        }

        body.swal2-shown {
            padding-right: 0 !important;
        }

    </style>

</head>

<body class="h-screen overflow-hidden flex">

    @include('admin.partials.sidebar')

    <main class="flex-1 overflow-hidden">

        <div class="p-10 h-full">

            @yield('content')

        </div>

    </main>

    @stack('scripts')

</body>
</html>