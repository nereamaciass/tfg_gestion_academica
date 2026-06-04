<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro Educativo — Gestión Académica</title>

    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Merriweather:wght@300;400;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body{
            margin: 0;
            background: #f7f9fc;
            color: #1a1a1a;
            font-family: 'Inter', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header{
            background: #0a3a66;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        header h1{
            font-family: 'Merriweather', serif;
            margin: 0;
        }

        header p{
            margin: 5px 0 0;
        }

        .main-container{
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;  
            justify-content: center; 
            text-align: center;
            padding: 20px;
            max-width: 1200px;
            margin: auto;
            gap: 25px;
        }

        .main-container h2{
            font-family: 'Merriweather', serif;
            font-size: 1.8rem;
            color: #0a3a66;
        }

        .main-container p{
            max-width: 750px;
            color: #333;
        }

        .btn-login{
            padding: 12px 28px;
            background: #0a3a66;
            color: white;
            font-weight: 600;
            border-radius: 6px;
            text-decoration: none;
            transition: 0.2s;
        }

        .btn-login:hover{
            background: #05233f;
        }

        .cards{
            display: flex;
            justify-content: center;
            gap: 20px;
            width: 100%;
            max-width: 1100px;
            flex-wrap: wrap;
        }

        .card{
            background: white;
            border-radius: 10px;
            padding: 20px;
            width: 30%;
            min-width: 250px;
            border: 1px solid #dfe6ee;
            box-shadow: 0 2px 6px rgba(0,0,0,0.06);
        }

        .card h3{
            font-family: 'Merriweather', serif;
            margin-bottom: 10px;
            color: #0a3a66;
        }

        footer{
            background: #0a3a66;
            color: white;
            text-align: center;
            padding: 12px 0;
            font-size: 0.85rem;
        }

        @media (max-width: 768px){
            .card{
                width: 100%;
            }

            .main-container h2{
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <header>
        <h1>Gestión Académica</h1>
        <p>¡Bienvenido al Portal de Gestión Académica de tu Centro Educativo!</p>
    </header>

    <div class="main-container">
        <h2>Plataforma de Gestión Académica</h2>

        <p>
            Sistema destinado a la administración del personal docente, asignaturas y procesos académicos
            del centro educativo. Una solución segura, moderna y adaptada a estándares de administración profesional.
        </p>

        <a href="{{ route('login') }}" class="btn-login">Iniciar Sesión</a>

        <div class="cards">
            <div class="card">
                <h3>Profesores</h3>
                <p>
                    Administración completa del personal docente, asignación de materias
                    y gestión de perfiles profesionales. 
                </p>
                <p>
                    Acceso controlado y trazabilidad completa.
                </p>
            </div>

            <div class="card">
                <h3>Asignaturas</h3>
                <p>
                    Organización estructurada de materias, planificación académica
                    y optimización de recursos educativos del centro.
                </p>
            </div>

            <div class="card">
                <h3>Administración</h3>
                <p>
                    Panel exclusivo para administradores. Supervisión completa del sistema,
                    seguridad reforzada y gestión centralizada.
                </p>
            </div>
        </div>
    </div>

    <footer>
        © 2026 Plataforma de Gestión Académica
    </footer>
</body>
</html>