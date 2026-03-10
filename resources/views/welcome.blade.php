<!DOCTYPE html>
<html lang="ca" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Institut Carles Vallbona</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary-blue: #2563eb;    /* Blue-600 */
            --secondary-blue: #3b82f6;  /* Blue-500 */
            --accent-blue: #60a5fa;     /* Blue-400 */
            --dark-blue: #1e40af;       /* Blue-700 */
            --light-gray: #f8fafc;      /* Gray-50 */
            --card-gray: #f1f5f9;       /* Gray-100 */
            --text-dark: #1e293b;       /* Gray-800 */
            --text-medium: #64748b;     /* Gray-500 */
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, var(--dark-blue) 0%, var(--primary-blue) 100%);
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.1);
            border-color: var(--accent-blue);
        }
        
        .module-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
            height: 100%;
        }
        
        .module-card:hover {
            border-color: var(--primary-blue);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }
        
        .icon-container {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }
        
        .btn-primary {
            background-color: var(--primary-blue);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            text-decoration: none;
        }
        
        .btn-primary:hover {
            background-color: var(--dark-blue);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        }
        
        .btn-outline {
            background-color: white;
            color: var(--primary-blue);
            border: 1px solid var(--primary-blue);
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            text-decoration: none;
        }
        
        .btn-outline:hover {
            background-color: #f8fafc;
            border-color: var(--dark-blue);
            color: var(--dark-blue);
        }
        
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .badge-info {
            background-color: #dbeafe;
            color: var(--dark-blue);
        }
        
        .badge-warning {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .focus-ring:focus {
            outline: 2px solid var(--primary-blue);
            outline-offset: 2px;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">
    <!-- Navigation -->
    @include('layouts.navigation')
    
    <!-- Main Content -->
    <main>
        <!-- Hero Section -->
        <section class="hero-gradient text-white pt-20 pb-24">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <!-- Logo -->
                    <div class="mb-8">
                        <div class="inline-block p-4 bg-white/10 backdrop-blur-sm rounded-xl border border-white/20">
                            <img src="{{ asset('logos/logo_CarlesVallbona.png') }}" 
                                 alt="Institut Carles Vallbona" 
                                 class="h-20 w-auto">
                        </div>
                    </div>
                    
                    <h1 class="text-4xl font-bold mb-4">
                        Sistema de Gestió Acadèmica
                    </h1>
                    
                    <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                        Plataforma per a la gestió del CFGS de Desenvolupament d'Aplicacions Web
                    </p>
                    
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="{{ route('alumnes.index') }}" class="btn-primary focus-ring">
                            <span class="mr-2">👨‍🎓</span>
                            Accedir a Alumnes
                        </a>
                        <a href="{{ route('moduls.index') }}" class="btn-outline focus-ring border-white/50 text-white hover:bg-white/10">
                            <span class="mr-2">📚</span>
                            Consultar Mòduls
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-16 bg-white">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">
                    Estadístiques del Sistema
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Alumnes -->
                    <div class="stat-card">
                        <div class="icon-container bg-blue-50 text-blue-600">
                            👨‍🎓
                        </div>
                        <div class="text-3xl font-bold text-gray-900 mb-2">
                            {{ \App\Models\Alumne::count() }}
                        </div>
                        <p class="text-gray-600 font-medium">Alumnes</p>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <p class="text-sm text-gray-500">
                                {{ \App\Models\Alumne::has('moduls')->count() }} amb matrícula activa
                            </p>
                        </div>
                    </div>
                    
                    <!-- Professors -->
                    <div class="stat-card">
                        <div class="icon-container bg-green-50 text-green-600">
                            👨‍🏫
                        </div>
                        <div class="text-3xl font-bold text-gray-900 mb-2">
                            {{ \App\Models\Professor::count() }}
                        </div>
                        <p class="text-gray-600 font-medium">Professors</p>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <p class="text-sm text-gray-500">
                                Equip docent
                            </p>
                        </div>
                    </div>
                    
                    <!-- Mòduls -->
                    <div class="stat-card">
                        <div class="icon-container bg-purple-50 text-purple-600">
                            📚
                        </div>
                        <div class="text-3xl font-bold text-gray-900 mb-2">
                            {{ \App\Models\Modul::count() }}
                        </div>
                        <p class="text-gray-600 font-medium">Mòduls</p>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <p class="text-sm text-gray-500">
                                {{ \App\Models\Modul::has('alumnes')->count() }} amb alumnes
                            </p>
                        </div>
                    </div>
                    
                    <!-- Grups -->
                    <div class="stat-card">
                        <div class="icon-container bg-amber-50 text-amber-600">
                            👥
                        </div>
                        <div class="text-3xl font-bold text-gray-900 mb-2">
                            {{ \App\Models\Grup::count() }}
                        </div>
                        <p class="text-gray-600 font-medium">Grups</p>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <p class="text-sm text-gray-500">
                                {{ \App\Models\Grup::has('alumnes')->count() }} actius
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modules Section -->
        <section class="py-16 bg-gray-50">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">
                    Mòduls Disponibles
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <a href="{{ route('alumnes.index') }}" class="module-card focus-ring group">
                        <div class="flex items-start">
                            <div class="icon-container bg-blue-50 text-blue-600 group-hover:bg-blue-100 transition-colors">
                                👨‍🎓
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">Alumnes</h3>
                                <p class="text-gray-600 mb-4">
                                    Gestiona la informació dels alumnes, matrícules i notes.
                                </p>
                                <div class="flex items-center text-blue-600 font-medium">
                                    <span>Accedir al llistat</span>
                                    <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                    
                    <a href="{{ route('professors.index') }}" class="module-card focus-ring group">
                        <div class="flex items-start">
                            <div class="icon-container bg-green-50 text-green-600 group-hover:bg-green-100 transition-colors">
                                👨‍🏫
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">Professors</h3>
                                <p class="text-gray-600 mb-4">
                                    Informació del professorat i assignacions de mòduls.
                                </p>
                                <div class="flex items-center text-green-600 font-medium">
                                    <span>Accedir al llistat</span>
                                    <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                    
                    <a href="{{ route('moduls.index') }}" class="module-card focus-ring group">
                        <div class="flex items-start">
                            <div class="icon-container bg-purple-50 text-purple-600 group-hover:bg-purple-100 transition-colors">
                                📚
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">Mòduls</h3>
                                <p class="text-gray-600 mb-4">
                                    Assignatures, continguts i alumnes matriculats.
                                </p>
                                <div class="flex items-center text-purple-600 font-medium">
                                    <span>Accedir al llistat</span>
                                    <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                    
                    <a href="{{ route('grups.index') }}" class="module-card focus-ring group">
                        <div class="flex items-start">
                            <div class="icon-container bg-amber-50 text-amber-600 group-hover:bg-amber-100 transition-colors">
                                👥
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">Grups</h3>
                                <p class="text-gray-600 mb-4">
                                    Grups classe, tutors i alumnes assignats.
                                </p>
                                <div class="flex items-center text-amber-600 font-medium">
                                    <span>Accedir al llistat</span>
                                    <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <!-- Guest Mode Info -->
        <section class="py-16 bg-white border-t border-gray-200">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-50 text-blue-600 rounded-full mb-6">
                        <span class="text-2xl">🔍</span>
                    </div>
                    
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">
                        Mode d'Accés: <span class="text-blue-600">Guest</span>
                    </h3>
                    
                    <div class="mb-8">
                        <span class="badge badge-info">Només lectura</span>
                        <span class="badge badge-warning ml-2">Accés limitat</span>
                    </div>
                    
                    <div class="bg-gray-50 rounded-xl p-6 mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                                    <span class="w-6 h-6 bg-green-100 text-green-600 rounded-full flex items-center justify-center mr-2 text-sm">✓</span>
                                    Permès
                                </h4>
                                <ul class="text-gray-600 space-y-2">
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Consultar llistats
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Veure informació
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Exportar dades
                                    </li>
                                </ul>
                            </div>
                            
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                                    <span class="w-6 h-6 bg-red-100 text-red-600 rounded-full flex items-center justify-center mr-2 text-sm">✗</span>
                                    No permès
                                </h4>
                                <ul class="text-gray-600 space-y-2">
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Crear registres
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Modificar dades
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Eliminar informació
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <a href="/" class="btn-primary focus-ring">
                        <span class="mr-2">←</span>
                        Tornar a la pàgina d'inici
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <div class="flex items-center">
                        <img src="{{ asset('logos/logo_CarlesVallbona.png') }}" 
                             alt="Institut Carles Vallbona" 
                             class="h-10 w-auto mr-4">
                    </div>
                </div>
                
                <div class="text-center md:text-right">
                    <div class="text-gray-400 mb-2 text-sm">
                        Sistema de Gestió Acadèmica • Mode Guest
                    </div>
                    <div class="text-gray-500 text-xs">
                        © {{ date('Y') }} • CFGS DAW • Desenvolupat amb Laravel
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>