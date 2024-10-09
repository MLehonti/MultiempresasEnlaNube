<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/build/assets/welcome.css">
</head>
<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <!-- Navbar -->
    <header>
        <nav class="navbar">
            <ul class="navbar-menu">
                <li><a href="/inicio" class="navbar-link">Inicio</a></li>
                <li><a href="/precio" class="navbar-link">Precio</a></li>
                <li><a href="#funcionalidades" class="navbar-link">Funcionalidades</a></li>
            </ul>
            <div class="auth-buttons">
                @if (Route::has('login'))
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="navbar-link"
                        >
                            Dashboard
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="navbar-link"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="navbar-link"
                            >
                                Register
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <div class="content">
        <h1>Bienvenido a NimbusBooks</h1>
    </div>
</body>
</html>
