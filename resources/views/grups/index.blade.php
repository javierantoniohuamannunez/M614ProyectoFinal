<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grups - Institut Carles Vallbona</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Header -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h2 class="font-semibold text-xl text-gray-800">
                    Llistat de Grups
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
                    <a href="{{ route('grups.create') }}" 
                    class="px-4 py-2 rounded-lg font-medium shadow hover:opacity-90"
                    style="background: #1e40af; color: white;">
                        + Nou Grup
                    </a>
                    @endif
                    @endauth
                </div>

                <!-- Tabla de grupos -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    @if($grups->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Nom</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Aula</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Tutor</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Alumnes</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Accions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($grups as $grup)
                                        <tr class="hover:bg-gray-50">
                                            <!-- Nombre -->
                                            <td class="px-4 py-3">
                                                <div class="font-medium">{{ $grup->nom }}</div>
                                                <div class="text-sm text-gray-500">
                                                    ID: {{ $grup->id }}
                                                </div>
                                            </td>
                                            
                                            <!-- Aula -->
                                            <td class="px-4 py-3">
                                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">
                                                    🏫 {{ $grup->aula }}
                                                </span>
                                            </td>
                                            
                                            <!-- Tutor -->
                                            <td class="px-4 py-3">
                                                @if($grup->professor)
                                                    <div class="text-sm">
                                                        <span class="font-medium">{{ $grup->professor->nom }}</span>
                                                        <div class="text-gray-600">
                                                            {{ $grup->professor->cognoms }}
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            
                                            <!-- Alumnos -->
                                            <td class="px-4 py-3">
                                                @if($grup->alumnes && $grup->alumnes->count() > 0)
                                                    <div class="text-sm">
                                                        <span class="font-medium">{{ $grup->alumnes->count() }} alumnes</span>
                                                        <div class="text-gray-600">
                                                            @php
                                                                $mitjanaEdat = 0;
                                                                $comptador = 0;
                                                                foreach($grup->alumnes as $alumne) {
                                                                    if ($alumne->data_naixement) {
                                                                        $edat = now()->diffInYears($alumne->data_naixement);
                                                                        $mitjanaEdat += $edat;
                                                                        $comptador++;
                                                                    }
                                                                }
                                                                if ($comptador > 0) {
                                                                    $mitjanaEdat = $mitjanaEdat / $comptador;
                                                                }
                                                            @endphp
                                                            @if($comptador > 0)
                                                                Mitjana edat: {{ number_format($mitjanaEdat, 1) }} anys
                                                            @endif
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-gray-400">Cap</span>
                                                @endif
                                            </td>
                                            
                                            <!-- Acciones -->
                                            <td class="px-4 py-3">
                                                <div class="flex gap-2">
                                                    <!-- VEURE -->
                                                    <a href="{{ route('grups.show', $grup) }}" 
                                                       class="text-blue-600 hover:text-blue-800">
                                                        Veure
                                                    </a>
                                                    
                                                    <!-- EDITAR Y ELIMINAR -->
                                                    @auth
                                                    @if(auth()->user()->rol === 'admin' || auth()->user()->rol === 'professor')
                                                    <a href="{{ route('grups.edit', $grup) }}" 
                                                       class="text-green-600 hover:text-green-800">
                                                        Editar
                                                    </a>
                                                    @endif
                                                    @if(auth()->user()->rol === 'admin')
                                                    <form action="{{ route('grups.destroy', $grup) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                onclick="return confirm('Eliminar {{ $grup->nom }}?')"
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
                                    <p class="text-xl font-bold">{{ $grups->count() }}</p>
                                    <p class="text-sm text-gray-600">Total</p>
                                </div>
                                <div>
                                    <p class="text-xl font-bold text-green-600">
                                        {{ $grups->whereNotNull('professor_id')->count() }}
                                    </p>
                                    <p class="text-sm text-gray-600">Amb tutor</p>
                                </div>
                                <div>
                                    @php
                                        $totalAlumnes = 0;
                                        foreach($grups as $grup) {
                                            if ($grup->alumnes) {
                                                $totalAlumnes += $grup->alumnes->count();
                                            }
                                        }
                                    @endphp
                                    <p class="text-xl font-bold text-blue-600">
                                        {{ $totalAlumnes }}
                                    </p>
                                    <p class="text-sm text-gray-600">Alumnes totals</p>
                                </div>
                                <div>
                                    @php
                                        $grupsAmbAlumnes = $grups->filter(fn($g) => $g->alumnes && $g->alumnes->count() > 0)->count();
                                    @endphp
                                    <p class="text-xl font-bold text-purple-600">
                                        {{ $grupsAmbAlumnes }}
                                    </p>
                                    <p class="text-sm text-gray-600">Amb alumnes</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500 mb-4">No s'han trobat grups.</p>
                            @auth
                            <a href="{{ route('grups.create') }}" 
                               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                + Crear primer grup
                            </a>
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</body>
</html>