<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión Académica — Iniciar Sesión</title>

    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background: #f5f7fa;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between">
    <header class="bg-[#0B3C63] text-white py-6 shadow-md">
        <h1 class="text-3xl font-bold text-center">Iniciar Sesión</h1>
        <p class="text-center text-sm opacity-90 mt-1">
            Acceda con su correo y contraseña institucional para continuar.
        </p>
    </header>

    <main class="flex justify-center items-center flex-1 px-4">
        <div class="bg-white shadow-xl rounded-lg p-10 w-full max-w-lg">
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Email Institucional
                    </label>
                    <input type="email" name="email" required autofocus class="w-full border border-gray-300 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#0B3C63]">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Contraseña
                    </label>
                    <input type="password" name="password" required class="w-full border border-gray-300 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#0B3C63]">
                </div>

                <div class="flex justify-between items-center text-sm">
                    <label class="flex items-center text-gray-700">
                        <input type="checkbox" name="remember"
                            class="rounded border-gray-300 text-[#0B3C63] focus:ring-[#0B3C63]">
                        <span class="ml-2">Recuérdame</span>
                    </label>

                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-[#0B3C63] hover:underline">
                        ¿Olvidaste tu contraseña?
                    </a>
                    @endif
                </div>

                <button type="submit" class="w-full bg-[#0B3C63] text-white py-3 rounded-md font-semibold hover:bg-[#092F4A] transition">
                    Iniciar Sesión
                </button>
            </form>
        </div>
    </main>

    <footer class="bg-[#0B3C63] text-white py-3 text-center text-sm">
        © 2026 Plataforma de Gestión Académica
    </footer>

</body>
</html>