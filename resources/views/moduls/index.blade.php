<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mòduls - Institut Carles Vallbona</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Header -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h2 class="font-semibold text-xl text-gray-800">
                    Llistat de Mòduls
                </h2>
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

                <!-- Botón crear destacado -->
                <div class="mb-6">
                    @auth
                    @if(auth()->user()->rol === 'admin' || auth()->user()->rol === 'professor')
                    <a href="{{ route('moduls.create') }}" 
                    class="px-4 py-2 rounded-lg font-medium shadow hover:opacity-90"
                    style="background: #1e40af; color: white;">
                        + Nou Mòdul
                    </a>
                    @endif
                    @endauth
                </div>

                <!-- Tabla de módulos -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    @if($moduls->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Nom</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Hores</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Professor</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Alumnes</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Accions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($moduls as $modul)
                                        <tr class="hover:bg-gray-50">
                                            <!-- Nombre -->
                                            <td class="px-4 py-3">
                                                <div class="font-medium">{{ $modul->nom }}</div>
                                                <div class="text-sm text-gray-500">
                                                    ID: {{ $modul->id }}
                                                </div>
                                            </td>
                                            
                                            <!-- Horas -->
                                            <td class="px-4 py-3">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm
                                                    @if($modul->hores <= 64) bg-blue-100 text-blue-800
                                                    @elseif($modul->hores <= 128) bg-yellow-100 text-yellow-800
                                                    @else bg-red-100 text-red-800
                                                    @endif">
                                                    {{ $modul->hores }} h
                                                </span>
                                            </td>
                                            
                                            <!-- Professor -->
                                            <td class="px-4 py-3">
                                                @if($modul->professor)
                                                    <div class="text-sm">
                                                        <span class="font-medium">{{ $modul->professor->nom }}</span>
                                                        <div class="text-gray-600">
                                                            {{ $modul->professor->cognoms }}
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            
                                            <!-- Alumnos -->
                                            <td class="px-4 py-3">
                                                @if($modul->alumnes && $modul->alumnes->count() > 0)
                                                    <div class="text-sm">
                                                        <span class="font-medium">{{ $modul->alumnes->count() }} alumnes</span>
                                                        @php
                                                            $mitjana = $modul->alumnes->avg('pivot.nota');
                                                        @endphp
                                                        @if(!is_null($mitjana))
                                                            <div class="text-gray-600">
                                                                Mitjana: {{ number_format($mitjana, 2) }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="text-gray-400">Cap</span>
                                                @endif
                                            </td>
                                            
                                            <!-- Acciones -->
                                            <td class="px-4 py-3">
                                                <div class="flex gap-2">
                                                    <!-- VEURE -->
                                                    <a href="{{ route('moduls.show', $modul) }}" 
                                                       class="text-blue-600 hover:text-blue-800">
                                                        Veure
                                                    </a>
                                                    
                                                    <!-- EDITAR Y ELIMINAR -->
                                                    @auth
                                                    @if(auth()->user()->rol === 'admin' || auth()->user()->rol === 'professor')
                                                    <a href="{{ route('moduls.edit', $modul) }}" 
                                                       class="text-green-600 hover:text-green-800">
                                                        Editar
                                                    </a>
                                                    @endif
                                                    @if(auth()->user()->rol === 'admin')
                                                    <form action="{{ route('moduls.destroy', $modul) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                onclick="return confirm('Eliminar {{ $modul->nom }}?')"
                                                                class="text-red-600 hover:text-red-800">
                                                            Eliminar
                                                        </button>
                                                    </form>
                                                    @endif
                                                    @endauth
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Estadísticas simples -->
                        <div class="p-4 bg-gray-50 border-t border-gray-200">
                            <h4 class="font-bold mb-2">Resum</h4>
                            <div class="grid grid-cols-4 gap-4 text-center">
                                <div>
                                    <p class="text-xl font-bold">{{ $moduls->count() }}</p>
                                    <p class="text-sm text-gray-600">Total</p>
                                </div>
                                <div>
                                    <p class="text-xl font-bold text-green-600">
                                        {{ $moduls->whereNotNull('professor_id')->count() }}
                                    </p>
                                    <p class="text-sm text-gray-600">Assignats</p>
                                </div>
                                <div>
                                    <p class="text-xl font-bold text-blue-600">
                                        {{ $moduls->whereNull('professor_id')->count() }}
                                    </p>
                                    <p class="text-sm text-gray-600">Sense assignar</p>
                                </div>
                                <div>
                                    @php
                                        $totalAlumnes = 0;
                                        foreach($moduls as $modul) {
                                            if ($modul->alumnes) {
                                                $totalAlumnes += $modul->alumnes->count();
                                            }
                                        }
                                    @endphp
                                    <p class="text-xl font-bold text-purple-600">
                                        {{ $totalAlumnes }}
                                    </p>
                                    <p class="text-sm text-gray-600">Matricules</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500 mb-4">No s'han trobat mòduls.</p>
                            @auth
                            @if(auth()->user()->rol === 'admin' || auth()->user()->rol === 'professor')
                            <a href="{{ route('moduls.create') }}" 
                               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                + Crear primer mòdul
                            </a>
                            @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</body>
</html>