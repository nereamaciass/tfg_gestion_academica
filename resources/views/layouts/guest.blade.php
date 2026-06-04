<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config('app.name', 'Gestión Académica') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background: #f5f7fa;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col">
    <main class="flex-grow">
        {{ $slot }}
    </main>
</body>
</html>