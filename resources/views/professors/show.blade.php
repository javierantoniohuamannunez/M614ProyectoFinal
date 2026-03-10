<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $professor->nom }} - Institut Carles Vallbona</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Header -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <h2 class="font-semibold text-xl text-gray-800">
                        Detalls del Professor
                    </h2>
                    <a href="{{ route('professors.index') }}" 
                       class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                        ← Tornar al llistat
                    </a>
                </div>
            </div>
        </header>

        <main class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Mensajes -->
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Tarjeta principal del profesor -->
                <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
                    <div class="p-6">
                        <!-- Perfil -->
                        <div class="flex flex-col md:flex-row items-start md:items-center gap-6 mb-8">
                            <!-- Foto -->
                            <div class="flex-shrink-0">
                                @if($professor->foto)
                                    <img src="{{ asset('uploads/fotos/' . $professor->foto) }}"
                                         alt="Foto de {{ $professor->nom }}"
                                         class="w-32 h-32 rounded-full object-cover border-4 border-gray-200">
                                @else
                                    <div class="w-32 h-32 bg-gray-200 rounded-full flex items-center justify-center">
                                        <span class="text-4xl">👨‍🏫</span>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Información básica -->
                            <div class="flex-1">
                                <h1 class="text-2xl font-bold text-gray-900 mb-2">
                                    {{ $professor->nom }} {{ $professor->cognoms }}
                                </h1>
                                <div class="space-y-2">
                                    <p class="text-gray-600">
                                        <span class="font-medium">Email:</span> {{ $professor->email }}
                                    </p>
                                    <p class="text-gray-600">
                                        <span class="font-medium">ID:</span> {{ $professor->id }}
                                    </p>
                                    <p class="text-gray-600">
                                        <span class="font-medium">Data registre:</span> 
                                        {{ $professor->created_at->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Información adicional en grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <!-- Grupo que tutela -->
                            @if($professor->grup)
                            <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                                <h3 class="font-bold text-lg text-blue-900 mb-3">👥 Grup que tutela</h3>
                                <div class="flex items-center gap-4">
                                    <div class="bg-blue-600 text-white px-4 py-2 rounded-lg font-bold">
                                        {{ $professor->grup->nom }}
                                    </div>
                                    <div>
                                        <p class="font-medium">{{ $professor->grup->nom }}</p>
                                        <p class="text-gray-600 text-sm">Aula: {{ $professor->grup->aula }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Estadísticas -->
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <h3 class="font-bold text-lg text-gray-900 mb-3">📊 Estadístiques</h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="text-center">
                                        <p class="text-2xl font-bold text-purple-600">
                                            {{ $professor->moduls->count() }}
                                        </p>
                                        <p class="text-sm text-gray-600">Mòduls</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-2xl font-bold text-green-600">
                                            {{ $professor->moduls->sum('hores') }}
                                        </p>
                                        <p class="text-sm text-gray-600">Hores totals</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Módulos que imparte -->
                        <div class="mb-8">
                            <h3 class="font-bold text-xl text-gray-900 mb-4">📚 Mòduls que imparteix</h3>
                            
                            @if($professor->moduls->count() > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($professor->moduls as $modul)
                                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 hover:bg-gray-100 transition">
                                            <div class="flex justify-between items-start mb-2">
                                                <h4 class="font-bold text-gray-900">{{ $modul->nom }}</h4>
                                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded">
                                                    {{ $modul->hores }} h
                                                </span>
                                            </div>
                                            <p class="text-gray-600 text-sm mb-3">
                                                ID: {{ $modul->id }}
                                            </p>
                                            <div class="flex items-center text-sm text-gray-500">
                                                <span class="mr-4">
                                                    👥 {{ $modul->alumnes->count() }} alumnes
                                                </span>
                                                <span>
                                                    📅 {{ $modul->created_at->format('m/Y') }}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8 bg-gray-50 rounded-lg">
                                    <p class="text-gray-500">Encara no té mòduls assignats.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Botones de acción - COLORES MEJORADOS -->
                         @auth
                         @if(auth()->user()->rol === 'admin' || auth()->user()->rol === 'professor')
                        <div class="pt-6 border-t border-gray-200 flex gap-4">
                            <a href="{{ route('professors.edit', $professor) }}" 
                               class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 font-medium shadow-sm">
                                ✏️ Editar
                            </a>
                        @endif
                        @if(auth()->user()->rol === 'admin')   
                            <form action="{{ route('professors.destroy', $professor) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Estàs segur que vols eliminar aquest professor?')"
                                        class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700 font-medium shadow-sm">
                                    🗑️ Eliminar
                                </button>
                            </form>
                        @endif
                        </div>
                        @endauth
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>