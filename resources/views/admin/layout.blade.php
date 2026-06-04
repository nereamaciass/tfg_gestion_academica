<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Administración')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    
    <style>
        body { background: #f5f7fa; }
    </style>
</head>

<body class="min-h-screen flex">
    @include('admin.partials.sidebar')

    <main class="flex-1 p-10">
        @yield('content')
    </main>
</body>
</html>