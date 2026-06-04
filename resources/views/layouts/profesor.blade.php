<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Centro Educativo')</title>

    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>

    <style>
        body {
            background: #f5f7fa;
        }
    </style>
</head>

<body class="h-screen overflow-hidden flex">

    @include('profesor.partials.sidebar')

    <main class="flex-1 p-6 overflow-hidden">
        @yield('content')
    </main>

    @stack('scripts')

</body>
</html>