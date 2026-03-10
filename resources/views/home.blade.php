<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Institut Carles Vallbona - Gestió Acadèmica</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .feature-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #e5e7eb;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background: #3b82f6;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: background 0.3s ease;
        }
        .btn-primary:hover {
            background: #2563eb;
        }
        .btn-secondary {
            background: #6b7280;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: background 0.3s ease;
        }
        .btn-secondary:hover {
            background: #4b5563;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <!-- Navigation -->
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span class="ml-2 text-xl font-bold text-gray-800">Institut Carles Vallbona</span>
                    </div>
                </div>
                <div class="flex items-center">
                    @if(Auth::check())
                        <a href="{{ route('dashboard') }}" class="btn-primary mr-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Tauler Principal
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn-secondary">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Tancar Sessió
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary mr-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Iniciar Sessió
                        </a>
                        @if(Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-secondary">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                                Registrar-se
                            </a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero">
        <div class="max-w-7xl mx-auto py-24 px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-6">
                    Sistema de Gestió Acadèmica
                </h1>
                <p class="text-xl mb-10 max-w-3xl mx-auto">
                    Plataforma integral per a la gestió de professors, grups, mòduls i alumnes de l'Institut Carles Vallbona
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @if(Auth::check())
                        <a href="{{ route('dashboard') }}" class="btn-primary bg-white text-blue-600 hover:bg-gray-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Accedir al Tauler
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary bg-white text-blue-600 hover:bg-gray-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Iniciar Sessió
                        </a>
                        <a href="#features" class="btn-secondary">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Veure Funcionalitats
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- Features Section -->
    <section id="features" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">
                Funcionalitats Principals
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Profesores -->
                <div class="feature-card bg-white rounded-xl p-6">
                    <div class="text-blue-600 mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Gestió de Professors</h3>
                    <p class="text-gray-600 mb-4">
                        Administra la informació del professorat, assigna mòduls i gestiona els perfils amb fotografia.
                    </p>
                    @if(Auth::check())
                        <a href="{{ route('professors.index') }}" class="text-blue-600 font-medium inline-flex items-center">
                            Accedir
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    @endif
                </div>

                <!-- Grupos -->
                <div class="feature-card bg-white rounded-xl p-6">
                    <div class="text-green-600 mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Gestió de Grups</h3>
                    <p class="text-gray-600 mb-4">
                        Crea i administra grups d'estudi, assigna tutors i gestiona les aules.
                    </p>
                    @if(Auth::check())
                        <a href="{{ route('grups.index') }}" class="text-green-600 font-medium inline-flex items-center">
                            Accedir
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    @endif
                </div>

                <!-- Módulos -->
                <div class="feature-card bg-white rounded-xl p-6">
                    <div class="text-purple-600 mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Gestió de Mòduls</h3>
                    <p class="text-gray-600 mb-4">
                        Administra els mòduls del cicle, assigna hores i professors responsables.
                    </p>
                    @if(Auth::check())
                        <a href="{{ route('moduls.index') }}" class="text-purple-600 font-medium inline-flex items-center">
                            Accedir
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    @endif
                </div>

                <!-- Alumnos -->
                <div class="feature-card bg-white rounded-xl p-6">
                    <div class="text-red-600 mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-5.197a6 6 0 00-9-5.197M13.5 9.5a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Gestió d'Alumnes</h3>
                    <p class="text-gray-600 mb-4">
                        Matricula alumnes, assigna grups, gestiona mòduls i registra notes acadèmiques.
                    </p>
                    @if(Auth::check())
                        <a href="{{ route('alumnes.index') }}" class="text-red-600 font-medium inline-flex items-center">
                            Accedir
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Dashboard Access (for authenticated users) -->
    @if(Auth::check())
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-8 md:p-12">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="mb-8 md:mb-0 md:mr-8">
                        <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">
                            Tauler de Control Principal
                        </h2>
                        <p class="text-blue-100 max-w-2xl">
                            Accedeix a totes les funcionalitats del sistema des d'un sol lloc. Gestiona professors, grups, mòduls i alumnes de manera integrada.
                        </p>
                    </div>
                    <a href="{{ route('dashboard') }}" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-bold text-lg hover:bg-gray-100 transition-colors duration-300 inline-flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Anar al Tauler
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <div class="flex items-center">
                        <svg class="h-8 w-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span class="ml-2 text-xl font-bold">Institut Carles Vallbona</span>
                    </div>
                    <p class="text-gray-400 mt-2">CFGS Desenvolupament d'Aplicacions Web</p>
                </div>
                <div class="text-gray-400 text-center md:text-right">
                    <p>&copy; {{ date('Y') }} Institut Carles Vallbona. Tots els drets reservats.</p>
                    <p class="mt-1">Proyecte Laravel - Gestió Acadèmica</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>