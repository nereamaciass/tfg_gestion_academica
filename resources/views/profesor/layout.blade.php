<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Profesor</title>

    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background: #f5f7fa;
        }
    </style>
</head>

<body class="min-h-screen flex">

    @include('profesor.partials.sidebar')

    <main class="flex-1 p-10">
        @yield('content')
    </main>

    @stack('scripts')

</body>
</html>