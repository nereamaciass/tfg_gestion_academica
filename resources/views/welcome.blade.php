<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro Educativo — Gestión Académica</title>

    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Merriweather:wght@300;400;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body{
            margin: 0;
            background: #f7f9fc;
            color: #1a1a1a;
            font-family: 'Inter', sans-serif;
            height: 100vh;
            overflow: hidden;
        }

        header,
        footer{
            background: #0a3a66;
            color: white;
            text-align: center;
        }

        header{
            height: 54px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        header h1{
            display: none;
        }

        header p{
            margin: 0;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .hero{
            height: calc(100vh - 90px);
            background-image:
                linear-gradient(
                    rgba(255,255,255,0.55),
                    rgba(255,255,255,0.55)
                ),
                url("{{ asset('images/fondo_tfg.png') }}");

            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 0 20px;
            box-sizing: border-box;
        }

        .hero h2{
            font-family: 'Merriweather', serif;
            font-size: 2.3rem;
            color: #0a3a66;
            margin: 80px 0 30px;
        }

        .cards{
            display: flex;
            justify-content: center;
            align-items: stretch;
            gap: 22px;
            width: 100%;
            max-width: 1200px;
            flex-wrap: nowrap;
        }

        .card{
            flex: 1;
            min-width: 0;
            background: rgba(255,255,255,0.95);
            border-radius: 14px;
            padding: 22px 20px;
            border: 1px solid #dfe6ee;
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
            transition: transform .2s ease;
        }

        .card:hover{
            transform: translateY(-4px);
        }

        .icono{
            width: 58px;
            height: 58px;
            margin: 0 auto 15px;
            border-radius: 50%;
            background: #0a3a66;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.7rem;
        }

        .card h3{
            font-family: 'Merriweather', serif;
            color: #0a3a66;
            margin-bottom: 12px;
        }

        .card p{
            color: #333;
            line-height: 1.5;
            margin: 0;
        }

        .btn-login{
            margin-top: 25px;
            padding: 13px 32px;
            background: #0a3a66;
            color: white;
            font-weight: 700;
            border-radius: 8px;
            text-decoration: none;
            transition: .2s;
            box-shadow: 0 4px 12px rgba(0,0,0,0.18);
        }

        .btn-login:hover{
            background: #05233f;
            transform: translateY(-2px);
        }

        footer{
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
        }

        @media (max-width: 900px){

            body{
                overflow: auto;
            }

            .hero{
                height: auto;
                min-height: calc(100vh - 90px);
                padding: 30px 20px;
            }

            .hero h2{
                margin-top: 20px;
                font-size: 1.8rem;
            }

            .cards{
                flex-wrap: wrap;
            }

            .card{
                width: 100%;
            }
        }
    </style>
</head>

<body>

<header>
    <p>¡Bienvenido al Portal de Gestión Académica de tu Centro Educativo!</p>
</header>

<main class="hero">

    <h2>Plataforma de Gestión Académica</h2>

    <div class="cards">
        <div class="card">
            <div class="icono">👨‍🏫</div>

            <h3>Profesores</h3>

            <p>
                Administración completa del personal docente,
                asignación de materias y gestión de perfiles
                profesionales.
                <br><br>
                Acceso controlado y trazabilidad completa.
            </p>
        </div>

        <div class="card">
            <div class="icono">📚</div>

            <h3>Asignaturas</h3>

            <p>
                Organización estructurada de materias,
                planificación académica y optimización
                de recursos educativos del centro.
            </p>
        </div>

        <div class="card">
            <div class="icono">🛡️</div>

            <h3>Administración</h3>

            <p>
                Panel exclusivo para administradores.
                Supervisión completa del sistema,
                seguridad reforzada y gestión centralizada.
            </p>
        </div>

    </div>

    <a href="{{ route('login') }}" class="btn-login">
        Iniciar Sesión
    </a>

</main>

<footer>
    © 2026 Plataforma de Gestión Académica
</footer>

</body>
</html>